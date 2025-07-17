<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\RawMaterial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PurchaseOrderController extends Controller
{
    // Admin: Create PO
    public function create()
    {
        $suppliers = User::where('role', 'supplier')->get(); // Use 'role' column
        $rawMaterials = RawMaterial::all();
        return view('purchase_orders.create', compact('suppliers', 'rawMaterials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:users,id',
            'raw_material_id' => 'required|exists:raw_materials,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);
        $po = PurchaseOrder::create([
            'supplier_id' => $request->supplier_id,
            'raw_material_id' => $request->raw_material_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'status' => 'pending',
            'created_by' => Auth::id(),
        ]);
        return redirect()->route('admin.purchase_orders.index')->with('success', 'Purchase order created.');
    }

    // Supplier: View POs
    public function supplierIndex()
    {
        $orders = PurchaseOrder::where('supplier_id', Auth::id())->get();
        return view('purchase_orders.supplier_index', compact('orders'));
    }

    // Supplier: Mark delivered & upload invoice
    public function markDelivered(Request $request, $id)
    {
        $po = PurchaseOrder::where('id', $id)->where('supplier_id', Auth::id())->firstOrFail();
        $request->validate([
            'invoice' => 'required|file|mimes:pdf,jpg,jpeg,png',
        ]);
        $path = $request->file('invoice')->store('invoices', 'public');
        $po->update([
            'status' => 'delivered',
            'invoice_path' => $path,
            'delivered_at' => now(),
        ]);
        return back()->with('success', 'Delivery marked and invoice uploaded.');
    }

    // Admin: Verify and complete
    public function verify($id)
    {
        $po = PurchaseOrder::findOrFail($id);
        if ($po->status !== 'delivered') {
            return back()->with('error', 'PO must be delivered before verification.');
        }
        $rawMaterial = $po->rawMaterial;
        $quantityBefore = $rawMaterial->quantity;
        $rawMaterial->quantity += $po->quantity;
        $rawMaterial->save();

        // Update Inventory table for this raw material (single-batch logic)
        $inventory = \App\Models\Inventory::firstOrNew([
            'raw_material_id' => $rawMaterial->id,
            'batch_id' => 'PO-'.$po->id,
        ]);
        $inventoryBefore = $inventory->exists ? $inventory->quantity : 0;
        $inventory->quantity += $po->quantity;
        $inventory->save();

        // Log in StockHistory (raw material context)
        \App\Models\StockHistory::create([
            'inventory_id' => $inventory->id,
            'user_id' => Auth::id(),
            'action' => 'add_from_po',
            'quantity_before' => $inventoryBefore,
            'quantity_after' => $inventory->quantity,
            'note' => 'PO #'.$po->id.' verified, stock added for raw material: '.$rawMaterial->name,
        ]);
        $po->update([
            'status' => 'complete',
            'completed_at' => now(),
        ]);
        return back()->with('success', 'Delivery verified and stock updated.');
    }

    // Admin: Mark as paid
    public function markPaid($id)
    {
        $po = PurchaseOrder::findOrFail($id);
        $po->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
        return back()->with('success', 'PO marked as paid.');
    }

    // Admin: View all POs
    public function adminIndex()
    {
        $orders = PurchaseOrder::with(['rawMaterial', 'supplier'])->orderByDesc('created_at')->get();
        return view('purchase_orders.admin_index', compact('orders'));
    }

    // Show a single PO (admin or supplier)
    public function show($id)
    {
        $order = PurchaseOrder::with(['rawMaterial', 'supplier', 'creator'])->findOrFail($id);
        // You can customize which view to use based on user role if needed
        return view('purchase_orders.show', compact('order'));
    }

    // Supplier dashboard data for widgets
    public static function supplierDashboardData($userId)
    {
        $supplierPOs = PurchaseOrder::with(['rawMaterial'])
            ->where('supplier_id', $userId)
            ->orderByDesc('created_at')->take(10)->get();
        $supplierPayments = PurchaseOrder::where('supplier_id', $userId)
            ->whereIn('status', ['complete', 'paid'])
            ->get()
            ->map(function($po) {
                return [
                    'po_id' => $po->id,
                    'amount' => $po->price,
                    'status' => $po->status,
                ];
            });
        $deliveryHistory = PurchaseOrder::where('supplier_id', $userId)
            ->whereIn('status', ['complete', 'paid'])
            ->get();
        $invoiceFeedback = PurchaseOrder::where('supplier_id', $userId)
            ->whereNotNull('invoice_path')
            ->get()
            ->map(function($po) {
                return (object)[
                    'po_id' => $po->id,
                    'invoice_path' => $po->invoice_path,
                    'status' => $po->status,
                    'feedback' => null, // Placeholder for future feedback
                ];
            });
        return compact('supplierPOs', 'supplierPayments', 'deliveryHistory', 'invoiceFeedback');
    }
}

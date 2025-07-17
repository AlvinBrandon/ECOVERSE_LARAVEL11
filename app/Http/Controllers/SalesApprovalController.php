<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class SalesApprovalController extends Controller
{
    public function index()
    {
        $sales = Order::with(['user', 'product'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.verify', compact('sales'));
    }

    public function verify($id)
    {
        $sale = Order::findOrFail($id);
        $product = $sale->product;

        // Save delivery/dispatch fields if present
        $sale->delivery_status = request('delivery_status', $sale->delivery_status);
        $sale->tracking_code = request('tracking_code', $sale->tracking_code);
        $sale->dispatch_log = request('dispatch_log', $sale->dispatch_log);

        // If the buyer is a wholesaler, update seller_role and inventory for retailer visibility
        if ($sale->user && (isset($sale->user->role_as) ? $sale->user->role_as == 5 : $sale->user->role === 'wholesaler')) {
            $product->seller_role = 'wholesaler';
            $product->save();
            // Deduct from available inventory
            $inventory = $product->inventories()->first();
            if ($inventory) {
                $inventory->quantity = max(0, $inventory->quantity - $sale->quantity);
                $inventory->save();
            } else {
                // If no inventory exists, create with zero (should not happen in normal flow)
                $product->inventories()->create([
                    'quantity' => 0,
                ]);
            }
            // Add/Update inventory for retailer visibility (retailer gets the ordered quantity)
            $retailerInventory = $product->inventories()->where('id', '!=', $inventory ? $inventory->id : 0)->first();
            if ($retailerInventory) {
                $retailerInventory->quantity = $sale->quantity;
                $retailerInventory->save();
            } else {
                $product->inventories()->create([
                    'quantity' => $sale->quantity,
                ]);
            }
        }
        // If the buyer is a retailer, update seller_role and inventory for customer visibility
        elseif ($sale->user && (isset($sale->user->role_as) ? $sale->user->role_as == 2 : $sale->user->role === 'retailer')) {
            $product->seller_role = 'retailer';
            $product->save();
            $inventory = $product->inventories()->first();
            if ($inventory) {
                $inventory->quantity = $sale->quantity;
                $inventory->save();
            } else {
                $product->inventories()->create([
                    'quantity' => $sale->quantity,
                ]);
            }
        }

        $sale->status = 'approved';
        $sale->save();

        $currentUser = Auth::user();
        if (($currentUser && isset($currentUser->role) && $currentUser->role === 'wholesaler') || ($currentUser && isset($currentUser->role_as) && $currentUser->role_as == 5)) {
            return redirect()->route('wholesaler.reports')->with('success', 'Order verified, product now available to customers.');
        }
        if (($currentUser && isset($currentUser->role) && $currentUser->role === 'retailer') || ($currentUser && isset($currentUser->role_as) && $currentUser->role_as == 2)) {
            return redirect()->route('retailer.reports')->with('success', 'Order verified, product now available to customers.');
        }
        return redirect()->route('admin.sales.report')->with('success', 'Order verified, product now available to retailers.');
    }

    public function reject($id)
    {
        $sale = Order::findOrFail($id);
        $sale->status = 'rejected';
        $sale->save();

        $currentUser = Auth::user();
        if (($currentUser && isset($currentUser->role) && $currentUser->role === 'wholesaler') || ($currentUser && isset($currentUser->role_as) && $currentUser->role_as == 5)) {
            return redirect()->route('wholesaler.reports')->with('success', 'Order rejected.');
        }
        if (($currentUser && isset($currentUser->role) && $currentUser->role === 'retailer') || ($currentUser && isset($currentUser->role_as) && $currentUser->role_as == 2)) {
            return redirect()->route('retailer.reports')->with('success', 'Order rejected.');
        }
        return back()->with('success', 'Order rejected.');
    }
}

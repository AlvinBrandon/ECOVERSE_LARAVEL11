<?php

namespace App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\RetailerInventory;
use App\Models\InventoryMovement;
use App\Services\EcoPointService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CustomerOrderController extends Controller
{
    /**
     * Display pending customer orders for retailer verification
     */
    public function index()
    {
        $retailer = Auth::user();
        
        // Retailers should only see orders for products they have in inventory
        $customerOrders = Order::with(['user', 'product'])
            ->where('status', 'pending')
            ->whereHas('user', function($query) {
                $query->where('role', 'customer')
                      ->orWhere('role_as', 0);
            })
            ->whereHas('product', function($query) use ($retailer) {
                // Only show orders for products that this retailer has in inventory
                $query->whereIn('id', function($subQuery) use ($retailer) {
                    $subQuery->select('product_id')
                        ->from('inventories')
                        ->where('owner_id', $retailer->id)
                        ->where('quantity', '>', 0);
                });
            })
            ->latest()
            ->paginate(15); // Add pagination with 15 items per page

        // Also provide non-paginated collection for compatibility
        $orders = $customerOrders->getCollection();

        return view('retailer.customer-orders', compact('orders', 'customerOrders'));
    }

    /**
     * Verify a customer order
     */
    public function verify($id)
    {
        $retailer = Auth::user();
        $order = Order::findOrFail($id);
        
        // Ensure this is a customer order
        if (!$order->user || ($order->user->role !== 'customer' && $order->user->role_as !== 0)) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'You can only verify customer orders.'], 400);
            }
            return back()->with('error', 'You can only verify customer orders.');
        }

        // Check if retailer has inventory for this product
        $retailerInventory = \App\Models\Inventory::where('owner_id', $retailer->id)
            ->where('product_id', $order->product_id)
            ->first();
            
        if (!$retailerInventory) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'You do not have inventory for this product.'], 400);
            }
            return back()->with('error', 'You do not have inventory for this product.');
        }

        $product = $order->product;

        // Save delivery/dispatch fields if present
        $order->delivery_status = request('delivery_status', $order->delivery_status);
        $order->tracking_code = request('tracking_code', $order->tracking_code);
        $order->dispatch_log = request('dispatch_log', $order->dispatch_log);

        // Check if sufficient stock is available
        if ($retailerInventory->quantity >= $order->quantity) {
            $quantityBefore = $retailerInventory->quantity;
            $retailerInventory->quantity = max(0, $retailerInventory->quantity - $order->quantity);
            $retailerInventory->save();
            
            // Create stock history record for the deduction
            \App\Models\StockHistory::create([
                'inventory_id' => $retailerInventory->id,
                'user_id' => Auth::id(),
                'action' => 'deduct',
                'quantity_before' => $quantityBefore,
                'quantity_after' => $retailerInventory->quantity,
                'note' => 'Stock deducted for customer order #' . $order->id . ' approval by retailer',
            ]);
        } else {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Insufficient stock available. Only ' . $retailerInventory->quantity . ' units in stock, but order requires ' . $order->quantity . ' units.'], 400);
            }
            return back()->with('error', 'Insufficient stock available. Only ' . $retailerInventory->quantity . ' units in stock, but order requires ' . $order->quantity . ' units.');
        }

        $order->status = 'approved';
        $order->save();

        // Award eco points to the customer for completed order
        try {
            $ecoPointService = new EcoPointService();
            $ecoPointService->awardOrderPoints($order);
        } catch (\Exception $e) {
            // Log the error but don't fail the order approval
            Log::error('Failed to award eco points for order ' . $order->id . ': ' . $e->getMessage());
        }

        // Handle AJAX requests
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Customer order verified and product delivered. Eco points awarded!'
            ]);
        }

        return back()->with('success', 'Customer order verified and product delivered. Eco points awarded!');
    }

    /**
     * Reject a customer order
     */
    public function reject($id)
    {
        $order = Order::findOrFail($id);
        
        // Ensure this is a customer order
        if (!$order->user || ($order->user->role !== 'customer' && $order->user->role_as !== 0)) {
            return back()->with('error', 'You can only reject customer orders.');
        }

        $order->status = 'rejected';
        $order->save();

        return back()->with('success', 'Customer order rejected.');
    }

    /**
     * Bulk verify customer orders
     */
    public function bulkVerify(Request $request)
    {
        $request->validate([
            'selected_orders' => 'required|string',
            'bulk_delivery_status' => 'required|in:pending,dispatched,delivered,pickup_arranged',
            'bulk_tracking_prefix' => 'nullable|string|max:20',
            'bulk_dispatch_log' => 'nullable|string|max:255',
        ]);

        $selectedIds = explode(',', $request->selected_orders);
        $selectedIds = array_filter($selectedIds, 'is_numeric');

        if (empty($selectedIds)) {
            return back()->with('error', 'No valid orders selected.');
        }

        $orders = Order::whereIn('id', $selectedIds)
            ->where('status', 'pending')
            ->whereHas('user', function($query) {
                $query->where('role', 'customer')
                      ->orWhere('role_as', 0);
            })
            ->get();

        $verifiedCount = 0;
        foreach ($orders as $order) {
            $product = $order->product;
            $inventory = $product->inventories()->first();
            
            if ($inventory && $inventory->quantity >= $order->quantity) {
                // Deduct inventory
                $quantityBefore = $inventory->quantity;
                $inventory->quantity = max(0, $inventory->quantity - $order->quantity);
                $inventory->save();

                // Create stock history
                \App\Models\StockHistory::create([
                    'inventory_id' => $inventory->id,
                    'user_id' => Auth::id(),
                    'action' => 'deduct',
                    'quantity_before' => $quantityBefore,
                    'quantity_after' => $inventory->quantity,
                    'note' => 'Bulk verification - Stock deducted for customer order #' . $order->id,
                ]);

                // Update order
                $order->status = 'approved';
                $order->delivery_status = $request->bulk_delivery_status;
                if ($request->bulk_tracking_prefix) {
                    $order->tracking_code = $request->bulk_tracking_prefix . str_pad($order->id, 6, '0', STR_PAD_LEFT);
                }
                $order->dispatch_log = $request->bulk_dispatch_log;
                $order->save();

                $verifiedCount++;
            }
        }

        return back()->with('success', "Successfully verified {$verifiedCount} customer orders.");
    }
}

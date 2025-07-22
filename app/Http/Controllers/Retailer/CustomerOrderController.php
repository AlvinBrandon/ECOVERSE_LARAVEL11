<?php

namespace App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    /**
     * Display pending customer orders for retailer verification
     */
    public function index()
    {
        // Retailers should only verify orders from customers
        $orders = Order::with(['user', 'product'])
            ->where('status', 'pending')
            ->whereHas('user', function($query) {
                $query->where('role', 'customer')
                      ->orWhere('role_as', 0);
            })
            ->whereHas('product', function($query) {
                $query->where('seller_role', 'retailer');
            })
            ->latest()
            ->get();

        return view('retailer.customer-orders', compact('orders'));
    }

    /**
     * Verify a customer order
     */
    public function verify($id)
    {
        $order = Order::findOrFail($id);
        
        // Ensure this is a customer order
        if (!$order->user || ($order->user->role !== 'customer' && $order->user->role_as !== 0)) {
            return back()->with('error', 'You can only verify customer orders.');
        }

        // Ensure this is for a retailer product
        if ($order->product->seller_role !== 'retailer') {
            return back()->with('error', 'You can only verify orders for your own products.');
        }

        $product = $order->product;

        // Save delivery/dispatch fields if present
        $order->delivery_status = request('delivery_status', $order->delivery_status);
        $order->tracking_code = request('tracking_code', $order->tracking_code);
        $order->dispatch_log = request('dispatch_log', $order->dispatch_log);

        // Deduct from retailer inventory
        $inventory = $product->inventories()->first();
        if ($inventory) {
            $quantityBefore = $inventory->quantity;
            
            // Check if sufficient stock is available
            if ($inventory->quantity >= $order->quantity) {
                $inventory->quantity = max(0, $inventory->quantity - $order->quantity);
                $inventory->save();
                
                // Create stock history record for the deduction
                \App\Models\StockHistory::create([
                    'inventory_id' => $inventory->id,
                    'user_id' => Auth::id(),
                    'action' => 'deduct',
                    'quantity_before' => $quantityBefore,
                    'quantity_after' => $inventory->quantity,
                    'note' => 'Stock deducted for customer order #' . $order->id . ' approval by retailer',
                ]);
            } else {
                return back()->with('error', 'Insufficient stock available. Only ' . $inventory->quantity . ' units in stock, but order requires ' . $order->quantity . ' units.');
            }
        } else {
            return back()->with('error', 'No inventory record found for this product. Please contact administrator.');
        }

        $order->status = 'approved';
        $order->save();

        return back()->with('success', 'Customer order verified and product delivered.');
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

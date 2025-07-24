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
     * Display customer orders for retailer management
     */
    public function index()
    {
        $retailer = Auth::user();
        
        // Get filter status from request
        $statusFilter = request('status', 'all');
        
        // Retailers should see orders for products they have in inventory
        $query = Order::with(['user', 'product'])
            ->whereHas('user', function($query) {
                $query->where('role', 'customer')
                      ->orWhere('role_as', 0);
            })
            ->whereHas('product', function($query) use ($retailer) {
                // Only show orders for products that this retailer has in inventory
                $query->whereIn('id', function($subQuery) use ($retailer) {
                    $subQuery->select('product_id')
                        ->from('inventories')
                        ->where('owner_id', $retailer->id);
                });
            });

        // Apply status filter
        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        $customerOrders = $query->latest()->paginate(15); // Add pagination with 15 items per page

        // Also provide non-paginated collection for compatibility
        $orders = $customerOrders->getCollection();

        return view('retailer.customer-orders', compact('orders', 'customerOrders', 'statusFilter'));
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

    /**
     * Mark order as dispatched
     */
    public function dispatch($id)
    {
        $retailer = Auth::user();
        $order = Order::findOrFail($id);
        
        // Ensure this is an approved customer order
        if (!$order->user || ($order->user->role !== 'customer' && $order->user->role_as !== 0)) {
            return back()->with('error', 'You can only dispatch customer orders.');
        }
        
        if ($order->status !== 'approved') {
            return back()->with('error', 'Order must be approved before it can be dispatched.');
        }

        $order->status = 'dispatched';
        $order->delivery_status = 'dispatched';
        $order->tracking_code = request('tracking_code');
        $order->dispatch_log = request('dispatch_log', 'Order dispatched by retailer');
        $order->dispatched_at = now();
        $order->save();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Order marked as dispatched successfully!'
            ]);
        }

        return back()->with('success', 'Order marked as dispatched successfully!');
    }

    /**
     * Mark order as delivered
     */
    public function markDelivered($id)
    {
        $retailer = Auth::user();
        $order = Order::findOrFail($id);
        
        // Ensure this is a dispatched customer order
        if (!$order->user || ($order->user->role !== 'customer' && $order->user->role_as !== 0)) {
            return back()->with('error', 'You can only mark customer orders as delivered.');
        }
        
        if (!in_array($order->status, ['approved', 'dispatched'])) {
            return back()->with('error', 'Order must be approved or dispatched before it can be marked as delivered.');
        }

        $order->status = 'delivered';
        $order->delivery_status = 'delivered';
        $order->delivered_at = now();
        $order->delivery_notes = request('delivery_notes', 'Order delivered to customer');
        $order->save();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Order marked as delivered successfully!'
            ]);
        }

        return back()->with('success', 'Order marked as delivered successfully!');
    }
}

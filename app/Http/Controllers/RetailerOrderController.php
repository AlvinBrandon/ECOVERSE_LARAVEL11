<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class RetailerOrderController extends Controller
{
    /**
     * Show customer orders that need to be fulfilled by the retailer
     */
    public function customerOrders()
    {
        // For retailers, show orders from customers that they need to fulfill
        // We need to find orders for products that this retailer has in inventory
        // Or orders that are placed through this retailer
        
        $customerOrders = Order::with(['product', 'user'])
            ->whereHas('user', function($query) {
                // Orders from customers (role_as = 0)
                $query->where('role_as', 0);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('retailer.customer-orders', compact('customerOrders'));
    }

    /**
     * Approve a customer order
     */
    public function approveOrder(Request $request, Order $order)
    {
        $order->update([
            'status' => 'approved',
            'verified_at' => now(),
            'verified_by' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order approved successfully'
        ]);
    }

    /**
     * Reject a customer order
     */
    public function rejectOrder(Request $request, Order $order)
    {
        $order->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'rejected_by' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order rejected successfully'
        ]);
    }

    /**
     * Show retailer's inventory (products purchased from wholesalers)
     */
    public function inventory()
    {
        // Get products with their inventory levels for this retailer
        $products = Product::with(['inventories' => function($query) {
            // Filter inventory for this retailer if needed
            // For now, showing all products with their stock levels
        }])->get();

        $inventory = $products->map(function($product) {
            $totalQuantity = $product->inventories->sum('quantity');
            $lowStockThreshold = 50; // Define minimum stock level
            
            return [
                'product' => $product,
                'quantity' => $totalQuantity,
                'low_stock' => $totalQuantity < $lowStockThreshold,
                'critical_stock' => $totalQuantity < 10,
                'status' => $totalQuantity < 10 ? 'critical' : ($totalQuantity < $lowStockThreshold ? 'low' : 'good'),
                'price' => $product->price ?? 0,
            ];
        });

        return view('retailer.inventory', compact('inventory'));
    }
}

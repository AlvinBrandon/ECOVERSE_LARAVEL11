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
     * Show retailer's inventory (based on their actual purchases from wholesalers)
     */
    public function inventory()
    {
        $user = Auth::user();
        
        // Get only products that retailers should see:
        // 1. Products they sell (seller_role = 'retailer') 
        // 2. Products they can buy from wholesalers (seller_role = 'wholesaler')
        $products = Product::whereIn('seller_role', ['retailer', 'wholesaler'])->get();

        $inventory = $products->map(function($product) use ($user) {
            // Different logic based on product type:
            // For wholesaler products: show what retailer purchased from wholesalers
            // For retailer products: show what customers bought from this retailer
            
            $purchased = 0;
            $sold = 0;
            $currentInventory = 0;
            
            if ($product->seller_role === 'wholesaler') {
                // For wholesaler products: calculate what this retailer purchased
                $purchased = Order::where('user_id', $user->id)
                    ->where('product_id', $product->id)
                    ->where('status', 'approved')
                    ->sum('quantity');
                
                // For wholesaler products: calculate what customers bought from this retailer
                $sold = Order::where('product_id', $product->id)
                    ->where('status', 'approved')
                    ->whereHas('user', function($query) {
                        $query->where('role', 'customer')
                              ->orWhere('role_as', 0);
                    })
                    ->sum('quantity');
                
                $currentInventory = $purchased - $sold;
                
            } else if ($product->seller_role === 'retailer') {
                // For retailer products: only show what customers bought (no purchased quantity)
                $purchased = 0; // Retailers don't "purchase" their own products
                $sold = Order::where('product_id', $product->id)
                    ->where('status', 'approved')
                    ->whereHas('user', function($query) {
                        $query->where('role', 'customer')
                              ->orWhere('role_as', 0);
                    })
                    ->sum('quantity');
                
                // For retailer products, current inventory should be from the global inventory system
                // since they manage their own stock
                $currentInventory = $product->stock ?? 0;
            }
            
            $lowStockThreshold = 50;
            
            return [
                'product' => $product,
                'quantity' => max(0, $currentInventory), // Don't show negative inventory
                'purchased' => $purchased,
                'sold' => $sold,
                'low_stock' => $currentInventory < $lowStockThreshold,
                'critical_stock' => $currentInventory < 10,
                'status' => $currentInventory < 10 ? 'critical' : ($currentInventory < $lowStockThreshold ? 'low' : 'good'),
                'price' => $product->price ?? 0,
            ];
        });

        return view('retailer.inventory', compact('inventory'));
    }
}

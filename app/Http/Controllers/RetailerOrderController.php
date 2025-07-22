<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RetailerOrderController extends Controller
{
    /**
     * Show customer orders that need to be fulfilled by the retailer
     */
    public function customerOrders()
    {
        $retailer = Auth::user();
        
        // For retailers, show orders from customers for products that this retailer has in inventory
        $customerOrders = Order::with(['product', 'user'])
            ->whereHas('user', function($query) {
                // Orders from customers (role_as = 0)
                $query->where('role_as', 0);
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
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('retailer.customer-orders', compact('customerOrders'));
    }

    /**
     * Approve a customer order
     */
    public function approveOrder(Request $request, Order $order)
    {
        $retailer = Auth::user();
        
        // Check if retailer has enough inventory
        $retailerInventory = \App\Models\Inventory::where('owner_id', $retailer->id)
            ->where('product_id', $order->product_id)
            ->first();
            
        if (!$retailerInventory || $retailerInventory->quantity < $order->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient inventory to fulfill this order'
            ], 400);
        }
        
        // Deduct inventory
        $retailerInventory->quantity -= $order->quantity;
        $retailerInventory->save();
        
        // Update order status
        $order->update([
            'status' => 'approved',
            'verified_at' => now(),
            'verified_by' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order approved successfully and inventory updated'
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
        
        // Get ALL products (no duplication needed!) - only factory/wholesaler products
        $products = Product::whereIn('seller_role', ['wholesaler', 'admin', 'factory'])
            ->orWhereNull('seller_role')
            ->get();
        
        $inventory = $products->map(function($product) use ($user) {
            // Calculate purchases from wholesalers (what this retailer bought)
            $purchased = Order::where('product_id', $product->id)
                ->where('user_id', $user->id)
                ->where('status', 'approved')
                ->sum('quantity');
                
            // For now, let's use the actual retailer inventory as current stock
            // since customer-to-retailer tracking might not be fully implemented
            $retailerInventoryRecord = $product->inventories()
                ->where('owner_id', $user->id)
                ->where('owner_type', 'retailer')
                ->first();
                
            $currentInventory = $retailerInventoryRecord ? $retailerInventoryRecord->quantity : 0;
            
            // Calculate what was sold (for display purposes, but not used in current stock calc)
            $sold = Order::where('product_id', $product->id)
                ->whereHas('user', function($query) {
                    $query->where('role_as', 0); // customers
                })
                ->where('status', 'approved')
                ->sum('quantity');
                
            // If we have purchases but no inventory record, calculate as purchased - sold
            if ($purchased > 0 && !$retailerInventoryRecord) {
                $currentInventory = max(0, $purchased - $sold);
            }
            
            $retailerMarkup = $retailerInventoryRecord->retail_markup ?? 0.20; // Default 20% markup
            $retailPrice = $product->price * (1 + $retailerMarkup);
            
            // Stock status logic
            $lowStockThreshold = 50;
            $criticalStockThreshold = 10;
            
            if ($currentInventory <= $criticalStockThreshold) {
                $status = 'critical';
            } elseif ($currentInventory <= $lowStockThreshold) {
                $status = 'low';
            } else {
                $status = 'good';
            }
            
            return [
                'product' => $product,
                'purchased' => $purchased,
                'sold' => $sold,
                'quantity' => $currentInventory,
                'price' => $retailPrice, // Retail price with markup
                'status' => $status,
                'low_stock' => $currentInventory < $lowStockThreshold,
            ];
        })->filter(function($item) {
            // Only show products where retailer has inventory or has made purchases
            return $item['purchased'] > 0 || $item['quantity'] > 0;
        });
        
        return view('retailer.inventory', compact('inventory'));
    }
}

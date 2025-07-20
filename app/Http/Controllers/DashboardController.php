<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        // $role = Auth::user()->role;

        
        // return match($role) {
        //     'admin' => redirect()->route('admin.dashboard'),
        //     'staff' => redirect()->route('staff.dashboard'),
        //     'supplier' => redirect()->route('supplier.dashboard'),
        //     'retailer' => redirect()->route('retailer.dashboard'),
        //     'wholesaler' => redirect()->route('wholesaler.dashboard'),
        //     'customer' => redirect()->route('customer.dashboard'),
        //     default => abort(403, 'Unauthorized action.'),
        // };
        $user = Auth::user();
        // Allow admin to view customer dashboard with ?as=customer
        if ($user->role_as == 1 && request('as') === 'customer') {
            return $this->customerDashboard();
        }
        if ($user->role_as == 1) {
            // Use AdminController's dashboard method to ensure all variables are passed
            return app(\App\Http\Controllers\AdminController::class)->dashboard();
        } elseif ($user->role_as == 2) {
            return view('vendor.admin');
        } else {
            return $this->customerDashboard();
        }
    }

    public function customerDashboard()
    {
        $user = Auth::user();
        
        // Force clear any cache
        Cache::flush();
        
        // Get customer orders data
        $orders = Order::where('user_id', $user->id)->with('product')->get();
        $totalOrders = $orders->count();
        
        // Add debugging info directly to the view for now
        $debugInfo = [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'orders_count' => $orders->count(),
            'orders_statuses' => $orders->pluck('status')->toArray()
        ];
        
        // Calculate statistics based on delivery status (case-insensitive)
        // - Completed: delivered orders
        // - Processing: dispatched orders (approved, processing, shipped, dispatched)  
        // - Pending: unverified orders (unverified, pending)
        $activeOrders = 0;
        $completedOrders = 0; 
        $pendingOrders = 0;
        $processingOrders = 0;
        $totalSpent = 0;
        
        foreach ($orders as $order) {
            $status = strtolower(trim($order->status));
            
            // Count active orders (all non-delivered/completed orders)
            if (!in_array($status, ['delivered', 'completed', 'cancelled', 'rejected'])) {
                $activeOrders++;
            }
            
            // Count completed orders (delivered orders)
            if (in_array($status, ['delivered', 'completed'])) {
                $completedOrders++;
            }
            
            // Calculate total spent for all confirmed orders (excluding unverified/pending)
            if (!in_array($status, ['unverified', 'pending', 'cancelled', 'rejected'])) {
                $totalSpent += $order->total_price;
            }
            
            // Count pending orders (unverified orders)
            if (in_array($status, ['unverified', 'pending'])) {
                $pendingOrders++;
            }
            
            // Count processing orders (dispatched, approved, processing, shipped)
            // Approved orders are considered as dispatched/processing stage
            if (in_array($status, ['dispatched', 'approved', 'processing', 'shipped', 'shipping', 'confirmed'])) {
                $processingOrders++;
            }
        }
        
        // Get recent orders (last 5)
        $recentOrders = $orders->sortByDesc('created_at')->take(5)->map(function($order) {
            $order->product_name = $order->product ? $order->product->name : 'Product Order';
            $order->total_amount = $order->total_price;
            $order->order_number = $order->order_number ?? '#' . str_pad($order->id, 6, '0', STR_PAD_LEFT);
            return $order;
        });
        
        // Get favorite products (most ordered products from completed orders)
        $favoriteProductsQuery = Order::where('user_id', $user->id)
            ->with('product')
            ->selectRaw('product_id, COUNT(*) as order_count')
            ->groupBy('product_id')
            ->orderBy('order_count', 'desc')
            ->take(5)
            ->get();
            
        $favoriteProducts = $favoriteProductsQuery->map(function($item) {
            return (object)[
                'name' => $item->product ? $item->product->name : 'Product',
                'category' => $item->product ? $item->product->type : 'Category',
                'order_count' => $item->order_count
            ];
        });

        // If no data exists, provide empty collections
        if ($totalOrders === 0) {
            $recentOrders = collect();
            $favoriteProducts = collect();
        }

        return view('dashboards.customer', compact(
            'totalOrders',
            'activeOrders', 
            'totalSpent',
            'recentOrders',
            'favoriteProducts',
            'completedOrders',
            'pendingOrders',
            'processingOrders',
            'debugInfo'
        ));
    }
}

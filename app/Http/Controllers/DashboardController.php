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
        $user = Auth::user();
        
        // Clear any cached data to ensure fresh role-based content
        Cache::flush();
        
        // Refresh user data from database to get latest role changes
        $user = $user->fresh();
        
        // Allow admin to view specific dashboard with ?as= parameter
        if ($user->role_as == 1 && request('as')) {
            return $this->viewDashboardAs(request('as'));
        }
        
        // Route to appropriate dashboard based on role_as
        return match($user->role_as) {
            1 => $this->adminDashboard(),
            2 => $this->retailerDashboard(),
            3 => $this->staffDashboard(),
            4 => $this->supplierDashboard(),
            5 => $this->wholesalerDashboard(),
            0 => $this->customerDashboard(),
            default => abort(403, 'Invalid user role.'),
        };
    }
    
    /**
     * Allow admin to view other dashboards for testing/support
     */
    private function viewDashboardAs($role)
    {
        return match($role) {
            'customer' => $this->customerDashboard(),
            'retailer' => $this->retailerDashboard(),
            'wholesaler' => $this->wholesalerDashboard(),
            'supplier' => $this->supplierDashboard(),
            'staff' => $this->staffDashboard(),
            default => $this->adminDashboard(),
        };
    }
    
    /**
     * Admin Dashboard
     */
    private function adminDashboard()
    {
        // Use AdminController's dashboard method to ensure all variables are passed
        return app(\App\Http\Controllers\AdminController::class)->dashboard();
    }
    
    /**
     * Retailer Dashboard
     */
    private function retailerDashboard()
    {
        $user = Auth::user();
        
        // Get today's sales count (orders placed today)
        $salesToday = Order::whereDate('created_at', today())
            ->count();
        
        // Get total customers (users with role_as = 0)
        $totalCustomers = User::where('role_as', 0)->count();
        
        // Get low stock items (products with less than 10 in any related inventory)
        // Since there's no stock column, we'll count products with low order activity
        $lowStockItems = Product::whereNotIn('id', function($query) {
            $query->select('product_id')
                  ->from('orders')
                  ->where('created_at', '>=', now()->subDays(30))
                  ->groupBy('product_id')
                  ->havingRaw('COUNT(*) > 5');
        })->count();
        
        // Get today's revenue (approved orders total from today)
        $revenueToday = Order::whereDate('created_at', today())
            ->where('status', 'approved')
            ->sum('total_price');
        
        // Get total orders for retailer context
        $totalOrders = Order::count();
        
        // Get recent customer orders (last 10)
        $recentOrders = Order::with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // Get orders pending verification
        $pendingOrders = Order::where('status', 'pending')->count();
        
        // Get approved orders
        $approvedOrders = Order::where('status', 'approved')->count();
        
        // Calculate monthly metrics
        $monthlyRevenue = Order::where('status', 'approved')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_price');
        
        $monthlyOrders = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        return view('dashboards.retailer', compact(
            'salesToday', 'totalCustomers', 'lowStockItems', 'revenueToday',
            'totalOrders', 'recentOrders', 'pendingOrders', 'approvedOrders',
            'monthlyRevenue', 'monthlyOrders'
        ));
    }
    
    /**
     * Staff Dashboard
     */
    private function staffDashboard()
    {
        return view('dashboards.staff');
    }
    
    /**
     * Supplier Dashboard
     */
    private function supplierDashboard()
    {
        return view('dashboards.supplier');
    }
    
    /**
     * Wholesaler Dashboard
     */
    private function wholesalerDashboard()
    {
        // Get wholesaler-specific data
        $user = Auth::user();
        
        // Calculate bulk orders (orders from retailers for wholesaler products)
        $bulkOrders = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where(function($q) {
                $q->where('users.role', 'retailer')
                  ->orWhere('users.role_as', 2);
            })
            ->where('products.seller_role', 'wholesaler')
            ->count();
        
        // Calculate active retailers (unique retailers who have ordered from wholesaler)
        $activeRetailers = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where(function($q) {
                $q->where('users.role', 'retailer')
                  ->orWhere('users.role_as', 2);
            })
            ->where('products.seller_role', 'wholesaler')
            ->distinct('orders.user_id')
            ->count('orders.user_id');
        
        // Calculate pending verifications (pending orders from retailers)
        $pendingVerifications = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where(function($q) {
                $q->where('users.role', 'retailer')
                  ->orWhere('users.role_as', 2);
            })
            ->where('products.seller_role', 'wholesaler')
            ->where('orders.status', 'pending')
            ->count();
        
        // Calculate monthly revenue from approved orders
        $monthlyRevenue = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where(function($q) {
                $q->where('users.role', 'retailer')
                  ->orWhere('users.role_as', 2);
            })
            ->where('products.seller_role', 'wholesaler')
            ->where('orders.status', 'approved')
            ->whereMonth('orders.created_at', now()->month)
            ->whereYear('orders.created_at', now()->year)
            ->sum('orders.total_price');
        
        // Calculate growth percentages (compare with previous month)
        $previousMonth = now()->subMonth();
        $previousBulkOrders = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where(function($q) {
                $q->where('users.role', 'retailer')
                  ->orWhere('users.role_as', 2);
            })
            ->where('products.seller_role', 'wholesaler')
            ->whereMonth('orders.created_at', $previousMonth->month)
            ->whereYear('orders.created_at', $previousMonth->year)
            ->count();
        
        $previousRetailers = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where(function($q) {
                $q->where('users.role', 'retailer')
                  ->orWhere('users.role_as', 2);
            })
            ->where('products.seller_role', 'wholesaler')
            ->whereMonth('orders.created_at', $previousMonth->month)
            ->whereYear('orders.created_at', $previousMonth->year)
            ->distinct('orders.user_id')
            ->count('orders.user_id');
        
        $previousRevenue = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where(function($q) {
                $q->where('users.role', 'retailer')
                  ->orWhere('users.role_as', 2);
            })
            ->where('products.seller_role', 'wholesaler')
            ->where('orders.status', 'approved')
            ->whereMonth('orders.created_at', $previousMonth->month)
            ->whereYear('orders.created_at', $previousMonth->year)
            ->sum('orders.total_price');
        
        // Calculate growth percentages
        $bulkOrdersGrowth = $previousBulkOrders > 0 ? 
            round((($bulkOrders - $previousBulkOrders) / $previousBulkOrders) * 100, 1) : 0;
        $retailersGrowth = $previousRetailers > 0 ? 
            round((($activeRetailers - $previousRetailers) / $previousRetailers) * 100, 1) : 0;
        $revenueGrowth = $previousRevenue > 0 ? 
            round((($monthlyRevenue - $previousRevenue) / $previousRevenue) * 100, 1) : 0;
        
        // Get total generated reports count (placeholder - you can implement actual report tracking)
        $generatedReports = 24; // This can be replaced with actual report count from database
        
        return view('dashboards.wholesaler', compact(
            'bulkOrders', 'activeRetailers', 'pendingVerifications', 'monthlyRevenue',
            'bulkOrdersGrowth', 'retailersGrowth', 'revenueGrowth', 'generatedReports'
        ));
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

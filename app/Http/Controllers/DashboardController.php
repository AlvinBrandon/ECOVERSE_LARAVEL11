<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Clear any cached data to ensure fresh role-based content
        Cache::flush();
        
        // Refresh user data from database to get latest role changes
        $user = User::find($user->id);
        
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
    public function retailerDashboard()
    {
        $user = Auth::user();
        
        // Get products that this retailer has inventory for
        $retailerProductIds = \App\Models\Inventory::where('owner_id', $user->id)
            ->where(function($query) {
                $query->where('owner_type', 'App\Models\User')
                      ->orWhere('owner_type', 'retailer');
            })
            ->pluck('product_id')
            ->toArray();
        
        // Get recent sales count (customer orders for retailer products placed in last 7 days)
        $salesToday = Order::where('created_at', '>=', now()->subDays(7))
            ->whereHas('user', function($query) {
                $query->where('role', 'customer')
                      ->orWhere('role_as', 0);
            })
            ->whereIn('product_id', $retailerProductIds)
            ->count();
        
        // Get total customers (users with role_as = 0 or role = customer)
        $totalCustomers = User::where(function($query) {
            $query->where('role_as', 0)
                  ->orWhere('role', 'customer');
        })->count();
        
        // Get low stock items for retailer products
        $lowStockItems = \App\Models\Inventory::where('owner_id', $user->id)
            ->where(function($query) {
                $query->where('owner_type', 'App\Models\User')
                      ->orWhere('owner_type', 'retailer');
            })
            ->where('quantity', '<', 10)
            ->count();
        
        // Get recent revenue (approved customer orders for retailer products from last 7 days)
        $revenueToday = Order::where('created_at', '>=', now()->subDays(7))
            ->where('status', 'approved')
            ->whereHas('user', function($query) {
                $query->where('role', 'customer')
                      ->orWhere('role_as', 0);
            })
            ->whereIn('product_id', $retailerProductIds)
            ->with('product')
            ->get()
            ->sum(function($order) {
                return $order->product->price * $order->quantity;
            });
        
        // Get total customer orders for retailer products
        $totalOrders = Order::whereHas('user', function($query) {
                $query->where('role', 'customer')
                      ->orWhere('role_as', 0);
            })
            ->whereIn('product_id', $retailerProductIds)
            ->count();
        
        // Get recent customer orders for retailer products (last 10)
        $recentOrders = Order::with(['user', 'product'])
            ->whereHas('user', function($query) {
                $query->where('role', 'customer')
                      ->orWhere('role_as', 0);
            })
            ->whereIn('product_id', $retailerProductIds)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // Get customer orders pending retailer verification
        $pendingOrders = Order::where('status', 'pending')
            ->whereHas('user', function($query) {
                $query->where('role', 'customer')
                      ->orWhere('role_as', 0);
            })
            ->whereIn('product_id', $retailerProductIds)
            ->count();
        
        // Get approved customer orders for retailer products
        $approvedOrders = Order::where('status', 'approved')
            ->whereHas('user', function($query) {
                $query->where('role', 'customer')
                      ->orWhere('role_as', 0);
            })
            ->whereIn('product_id', $retailerProductIds)
            ->count();
        
        // Calculate monthly metrics for customer orders to retailer products
        $monthlyRevenue = Order::where('status', 'approved')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereHas('user', function($query) {
                $query->where('role', 'customer')
                      ->orWhere('role_as', 0);
            })
            ->whereIn('product_id', $retailerProductIds)
            ->with('product')
            ->get()
            ->sum(function($order) {
                return $order->product->price * $order->quantity;
            });
        
        $monthlyOrders = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereHas('user', function($query) {
                $query->where('role', 'customer')
                      ->orWhere('role_as', 0);
            })
            ->whereIn('product_id', $retailerProductIds)
            ->count();

        return view('dashboards.retailer', compact(
            'salesToday', 'totalCustomers', 'lowStockItems', 'revenueToday',
            'totalOrders', 'recentOrders', 'pendingOrders', 'approvedOrders',
            'monthlyRevenue', 'monthlyOrders'
        ));
    }    /**
     * Staff Dashboard - Only handles wholesaler purchase orders and factory operations
     */
    private function staffDashboard()
    {
        // Staff should only see wholesaler purchase orders from factories
        $wholesalerOrders = Order::whereHas('user', function($query) {
            $query->where('role', 'wholesaler')
                  ->orWhere('role_as', 5);
        })
        ->whereHas('product', function($query) {
            $query->where('seller_role', 'factory');
        })
        ->count();
        
        $pendingWholesalerOrders = Order::whereHas('user', function($query) {
            $query->where('role', 'wholesaler')
                  ->orWhere('role_as', 5);
        })
        ->whereHas('product', function($query) {
            $query->where('seller_role', 'factory');
        })
        ->where('status', 'pending')
        ->count();
        
        // Purchase orders from suppliers
        $totalPurchaseOrders = \App\Models\PurchaseOrder::count();
        $pendingPurchaseOrders = \App\Models\PurchaseOrder::where('status', 'pending')->count();
        
        // Recent wholesaler orders
        $recentWholesalerOrders = Order::with(['user', 'product'])
            ->whereHas('user', function($query) {
                $query->where('role', 'wholesaler')
                      ->orWhere('role_as', 5);
            })
            ->whereHas('product', function($query) {
                $query->where('seller_role', 'factory');
            })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        return view('dashboards.staff', compact(
            'wholesalerOrders', 'pendingWholesalerOrders', 
            'totalPurchaseOrders', 'pendingPurchaseOrders',
            'recentWholesalerOrders'
        ));
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
    public function wholesalerDashboard()
    {
        // Get wholesaler-specific data
        $user = Auth::user();
        
        try {
            // Calculate bulk orders (orders from retailers - wholesalers can sell any product to retailers)
            $bulkOrders = Order::join('users', 'orders.user_id', '=', 'users.id')
                ->where(function($q) {
                    $q->where('users.role', 'retailer')
                      ->orWhere('users.role_as', 2);
                })
                ->count();
            
            // Calculate active retailers (unique retailers who have placed orders)
            $activeRetailers = Order::join('users', 'orders.user_id', '=', 'users.id')
                ->where(function($q) {
                    $q->where('users.role', 'retailer')
                      ->orWhere('users.role_as', 2);
                })
                ->distinct('orders.user_id')
                ->count('orders.user_id');
            
            // Calculate pending verifications (pending orders from retailers)
            $pendingVerifications = Order::join('users', 'orders.user_id', '=', 'users.id')
                ->where(function($q) {
                    $q->where('users.role', 'retailer')
                      ->orWhere('users.role_as', 2);
                })
                ->where('orders.status', 'pending')
                ->count();
            
            // Calculate monthly revenue from approved retailer orders
            $monthlyRevenue = Order::join('users', 'orders.user_id', '=', 'users.id')
                ->where(function($q) {
                    $q->where('users.role', 'retailer')
                      ->orWhere('users.role_as', 2);
                })
                ->where('orders.status', 'approved')
                ->whereMonth('orders.created_at', now()->month)
                ->whereYear('orders.created_at', now()->year)
                ->sum('orders.total_price');
            
            // Calculate growth percentages (compare with previous month)
            $previousMonth = now()->subMonth();
            $previousBulkOrders = Order::join('users', 'orders.user_id', '=', 'users.id')
                ->where(function($q) {
                    $q->where('users.role', 'retailer')
                      ->orWhere('users.role_as', 2);
                })
                ->whereMonth('orders.created_at', $previousMonth->month)
                ->whereYear('orders.created_at', $previousMonth->year)
                ->count();
            
            $previousRetailers = Order::join('users', 'orders.user_id', '=', 'users.id')
                ->where(function($q) {
                    $q->where('users.role', 'retailer')
                      ->orWhere('users.role_as', 2);
                })
                ->whereMonth('orders.created_at', $previousMonth->month)
                ->whereYear('orders.created_at', $previousMonth->year)
                ->distinct('orders.user_id')
                ->count('orders.user_id');
            
            $previousRevenue = Order::join('users', 'orders.user_id', '=', 'users.id')
                ->where(function($q) {
                    $q->where('users.role', 'retailer')
                      ->orWhere('users.role_as', 2);
                })
                ->where('orders.status', 'approved')
                ->whereMonth('orders.created_at', $previousMonth->month)
                ->whereYear('orders.created_at', $previousMonth->year)
                ->sum('orders.total_price');
            
            $previousPendingVerifications = Order::join('users', 'orders.user_id', '=', 'users.id')
                ->where(function($q) {
                    $q->where('users.role', 'retailer')
                      ->orWhere('users.role_as', 2);
                })
                ->where('orders.status', 'pending')
                ->whereMonth('orders.created_at', $previousMonth->month)
                ->whereYear('orders.created_at', $previousMonth->year)
                ->count();
            
            // Calculate growth percentages
            $bulkOrdersGrowth = $previousBulkOrders > 0 ? 
                round((($bulkOrders - $previousBulkOrders) / $previousBulkOrders) * 100, 1) : 0;
            $retailersGrowth = $previousRetailers > 0 ? 
                round((($activeRetailers - $previousRetailers) / $previousRetailers) * 100, 1) : 0;
            $revenueGrowth = $previousRevenue > 0 ? 
                round((($monthlyRevenue - $previousRevenue) / $previousRevenue) * 100, 1) : 0;
            $pendingGrowth = $previousPendingVerifications > 0 ? 
                round((($pendingVerifications - $previousPendingVerifications) / $previousPendingVerifications) * 100, 1) : 0;
            
            // Get total generated reports count (placeholder - you can implement actual report tracking)
            $generatedReports = 24;
            
            // Log the calculated values for debugging
            Log::info('Wholesaler Dashboard Metrics', [
                'bulkOrders' => $bulkOrders,
                'activeRetailers' => $activeRetailers,
                'pendingVerifications' => $pendingVerifications,
                'monthlyRevenue' => $monthlyRevenue,
                'bulkOrdersGrowth' => $bulkOrdersGrowth,
                'retailersGrowth' => $retailersGrowth,
                'revenueGrowth' => $revenueGrowth,
                'pendingGrowth' => $pendingGrowth
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error calculating wholesaler metrics: ' . $e->getMessage());
            $bulkOrders = 0;
            $activeRetailers = 0;
            $pendingVerifications = 0;
            $monthlyRevenue = 0;
            $bulkOrdersGrowth = 0;
            $retailersGrowth = 0;
            $revenueGrowth = 0;
            $pendingGrowth = 0;
            $generatedReports = 24;
        }
        
        return view('dashboards.wholesaler', compact(
            'bulkOrders', 'activeRetailers', 'pendingVerifications', 'monthlyRevenue',
            'bulkOrdersGrowth', 'retailersGrowth', 'revenueGrowth', 'pendingGrowth', 'generatedReports'
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

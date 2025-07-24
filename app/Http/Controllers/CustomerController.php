<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     * Since customers should buy from retailers, this is a retailer-only feature.
     * Currently showing all customers as potential customers for retailers.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ensure only retailers can access customer management
        if ($user->role !== 'retailer' && $user->role_as != 2) {
            abort(403, 'Customer management is only available for retailers.');
        }
        
        // Base query for customers
        $customersQuery = User::where('role', 'customer')->orWhere('role_as', 0);
        
        $customers = $customersQuery
            ->with(['orders' => function($query) {
                $query->latest()->take(5);
            }])
            ->withCount(['orders', 'orders as approved_orders_count' => function($query) {
                $query->where('status', 'approved');
            }])
            ->withSum(['orders as total_spent' => function($query) {
                $query->where('status', 'approved');
            }], 'total_price')
            ->latest()
            ->paginate(15);

        // Calculate stats for all customers (retailers can see all customers as potential customers)
        $stats = [
            'total_customers' => User::where('role', 'customer')->orWhere('role_as', 0)->count(),
            'active_customers' => User::where('role', 'customer')->orWhere('role_as', 0)
                ->whereHas('orders', function($query) {
                    $query->where('created_at', '>=', now()->subMonth());
                })->count(),
            'total_orders' => Order::whereHas('user', function($query) {
                $query->where('role', 'customer')->orWhere('role_as', 0);
            })->count(),
            'total_revenue' => Order::whereHas('user', function($query) {
                $query->where('role', 'customer')->orWhere('role_as', 0);
            })->where('status', 'approved')->sum('total_price'),
        ];

        return view('customers.index', compact('customers', 'stats'));
    }

    /**
     * Display the specified customer.
     * Only retailers can view customer details.
     */
    public function show(User $customer)
    {
        $user = Auth::user();
        
        // Ensure only retailers can access customer details
        if ($user->role !== 'retailer' && $user->role_as != 2) {
            abort(403, 'Customer management is only available for retailers.');
        }
        
        // Ensure this is actually a customer
        if (!$customer->isCustomer()) {
            abort(404);
        }

        $customer->load(['orders' => function($query) {
            $query->latest();
        }]);

        $customerStats = [
            'total_orders' => $customer->orders->count(),
            'approved_orders' => $customer->orders->where('status', 'approved')->count(),
            'pending_orders' => $customer->orders->where('status', 'pending')->count(),
            'rejected_orders' => $customer->orders->where('status', 'rejected')->count(),
            'total_spent' => $customer->orders->where('status', 'approved')->sum('total_price'),
            'eco_points' => $customer->eco_points ?? 0,
            'last_order' => $customer->orders->first()?->created_at,
            'avg_order_value' => $customer->orders->where('status', 'approved')->count() > 0 
                ? $customer->orders->where('status', 'approved')->avg('total_price') 
                : 0,
        ];

        return view('customers.show', compact('customer', 'customerStats'));
    }

    /**
     * Show customer analytics dashboard
     * Only retailers can view customer analytics.
     */
    public function analytics()
    {
        $user = Auth::user();
        
        // Ensure only retailers can access customer analytics
        if ($user->role !== 'retailer' && $user->role_as != 2) {
            abort(403, 'Customer analytics is only available for retailers.');
        }
        
        $monthlyData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            
            $monthlyData[] = [
                'month' => $date->format('M Y'),
                'new_customers' => User::where('role', 'customer')->orWhere('role_as', 0)
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'orders' => Order::whereHas('user', function($query) {
                    $query->where('role', 'customer')->orWhere('role_as', 0);
                })
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count(),
                'revenue' => Order::whereHas('user', function($query) {
                    $query->where('role', 'customer')->orWhere('role_as', 0);
                })
                ->where('status', 'approved')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total_price'),
            ];
        }
        
        $topCustomers = User::where('role', 'customer')->orWhere('role_as', 0)
            ->withSum(['orders as total_spent' => function($query) {
                $query->where('status', 'approved');
            }], 'total_price')
            ->withCount('orders')
            ->orderBy('total_spent', 'desc')
            ->take(10)
            ->get();

        return view('customers.analytics', compact('monthlyData', 'topCustomers'));
    }
}

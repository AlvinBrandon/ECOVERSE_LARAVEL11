<?php

namespace App\Http\Controllers\Wholesaler;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RetailerNetworkController extends Controller
{
    public function index(Request $request)
    {
        $currentWholesaler = Auth::user();
        
        // Get filter parameters
        $status = $request->get('status', 'all');
        $retailer = $request->get('retailer', 'all');
        $dateRange = $request->get('date_range', '30');
        
        // Calculate date range
        $startDate = Carbon::now()->subDays($dateRange);
        $endDate = Carbon::now();
        
        // Base query for retailer orders from wholesaler's products
        $query = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where(function($q) {
                $q->where('users.role', 'retailer')
                  ->orWhere('users.role_as', 2);
            })
            ->where('products.seller_role', 'wholesaler')
            ->where('orders.created_at', '>=', $startDate)
            ->where('orders.created_at', '<=', $endDate);
        
        // Apply status filter
        if ($status !== 'all') {
            $query->where('orders.status', $status);
        }
        
        // Apply retailer filter
        if ($retailer !== 'all') {
            $query->where('orders.user_id', $retailer);
        }
        
        // Get orders with relationships
        $retailerOrders = $query->select([
                'orders.*',
                'users.name as retailer_name',
                'users.email as retailer_email',
                'users.phone as retailer_phone',
                'products.name as product_name',
                'products.price',
                'products.wholesale_price'
            ])
            ->orderBy('orders.created_at', 'desc')
            ->paginate(15);
        
        // Get summary statistics
        $totalOrders = $query->count();
        $totalRevenue = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where(function($q) {
                $q->where('users.role', 'retailer')
                  ->orWhere('users.role_as', 2);
            })
            ->where('products.seller_role', 'wholesaler')
            ->where('orders.status', 'approved')
            ->where('orders.created_at', '>=', $startDate)
            ->sum('orders.total_price');
        
        $pendingOrders = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where(function($q) {
                $q->where('users.role', 'retailer')
                  ->orWhere('users.role_as', 2);
            })
            ->where('products.seller_role', 'wholesaler')
            ->where('orders.status', 'pending')
            ->where('orders.created_at', '>=', $startDate)
            ->count();
        
        $approvedOrders = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where(function($q) {
                $q->where('users.role', 'retailer')
                  ->orWhere('users.role_as', 2);
            })
            ->where('products.seller_role', 'wholesaler')
            ->where('orders.status', 'approved')
            ->where('orders.created_at', '>=', $startDate)
            ->count();
        
        // Get list of retailers for filter dropdown
        $retailers = User::where(function($q) {
                $q->where('role', 'retailer')
                  ->orWhere('role_as', 2);
            })
            ->whereHas('orders', function($query) {
                $query->join('products', 'orders.product_id', '=', 'products.id')
                    ->where('products.seller_role', 'wholesaler');
            })
            ->select('id', 'name', 'email')
            ->get();
        
        // Top retailers by volume
        $topRetailers = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where(function($q) {
                $q->where('users.role', 'retailer')
                  ->orWhere('users.role_as', 2);
            })
            ->where('products.seller_role', 'wholesaler')
            ->where('orders.status', 'approved')
            ->where('orders.created_at', '>=', $startDate)
            ->select([
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COUNT(orders.id) as total_orders'),
                DB::raw('SUM(orders.quantity) as total_quantity'),
                DB::raw('SUM(orders.total_price) as total_revenue')
            ])
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->get();
        
        // Monthly trend data
        $monthlyData = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where(function($q) {
                $q->where('users.role', 'retailer')
                  ->orWhere('users.role_as', 2);
            })
            ->where('products.seller_role', 'wholesaler')
            ->where('orders.status', 'approved')
            ->where('orders.created_at', '>=', Carbon::now()->subMonths(6))
            ->select([
                DB::raw('YEAR(orders.created_at) as year'),
                DB::raw('MONTH(orders.created_at) as month'),
                DB::raw('COUNT(orders.id) as order_count'),
                DB::raw('SUM(orders.total_price) as revenue')
            ])
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
        
        return view('wholesaler.retailer-network', compact(
            'retailerOrders', 'totalOrders', 'totalRevenue', 'pendingOrders', 
            'approvedOrders', 'retailers', 'topRetailers', 'monthlyData',
            'status', 'retailer', 'dateRange'
        ));
    }
    
    public function verifyOrder(Request $request, $orderId)
    {
        $order = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where('orders.id', $orderId)
            ->where(function($q) {
                $q->where('users.role', 'retailer')
                  ->orWhere('users.role_as', 2);
            })
            ->where('products.seller_role', 'wholesaler')
            ->select('orders.*')
            ->first();
        
        if (!$order) {
            return back()->with('error', 'Order not found or you do not have permission to verify this order.');
        }
        
        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be verified.');
        }
        
        $request->validate([
            'verification_notes' => 'nullable|string|max:500',
            'delivery_status' => 'required|in:pending,dispatched,delivered,pickup_arranged',
            'tracking_code' => 'nullable|string|max:100',
        ]);
        
        $order->update([
            'status' => 'approved',
            'delivery_status' => $request->delivery_status,
            'tracking_code' => $request->tracking_code ?: 'WH-' . date('Ymd') . '-' . $order->id,
            'dispatch_log' => $request->verification_notes ?: 'Verified by wholesaler on ' . now()->format('Y-m-d H:i:s'),
            'verified_at' => now(),
            'verified_by' => Auth::id()
        ]);
        
        return back()->with('success', 'Order verified successfully. Retailer will be notified.');
    }
    
    public function rejectOrder(Request $request, $orderId)
    {
        $order = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where('orders.id', $orderId)
            ->where(function($q) {
                $q->where('users.role', 'retailer')
                  ->orWhere('users.role_as', 2);
            })
            ->where('products.seller_role', 'wholesaler')
            ->select('orders.*')
            ->first();
        
        if (!$order) {
            return back()->with('error', 'Order not found or you do not have permission to reject this order.');
        }
        
        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be rejected.');
        }
        
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);
        
        $order->update([
            'status' => 'rejected',
            'dispatch_log' => 'Rejected: ' . $request->rejection_reason,
            'verified_at' => now(),
            'verified_by' => Auth::id()
        ]);
        
        return back()->with('success', 'Order rejected. Retailer will be notified.');
    }
    
    public function bulkVerify(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
            'bulk_delivery_status' => 'required|in:pending,dispatched,delivered,pickup_arranged',
            'bulk_notes' => 'nullable|string|max:500'
        ]);
        
        $orders = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->whereIn('orders.id', $request->order_ids)
            ->where(function($q) {
                $q->where('users.role', 'retailer')
                  ->orWhere('users.role_as', 2);
            })
            ->where('products.seller_role', 'wholesaler')
            ->where('orders.status', 'pending')
            ->select('orders.*')
            ->get();
        
        $verifiedCount = 0;
        
        foreach ($orders as $order) {
            $order->update([
                'status' => 'approved',
                'delivery_status' => $request->bulk_delivery_status,
                'tracking_code' => 'WH-BULK-' . date('Ymd') . '-' . $order->id,
                'dispatch_log' => $request->bulk_notes ?: 'Bulk verified by wholesaler on ' . now()->format('Y-m-d H:i:s'),
                'verified_at' => now(),
                'verified_by' => Auth::id()
            ]);
            $verifiedCount++;
        }
        
        return back()->with('success', "Successfully verified {$verifiedCount} orders.");
    }
}

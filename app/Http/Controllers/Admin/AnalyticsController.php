<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $dateRange = $request->get('range', '30'); // Default 30 days
        $startDate = Carbon::now()->subDays($dateRange);
        $endDate = Carbon::now();

        // Sales Overview Statistics
        $totalSales = Order::where('created_at', '>=', $startDate)
            ->where('status', 'approved')
            ->with('product')
            ->get()
            ->sum(function($order) {
                return ($order->product ? $order->product->price : 0) * $order->quantity;
            });

        $totalOrders = Order::where('created_at', '>=', $startDate)->count();
        $approvedOrders = Order::where('created_at', '>=', $startDate)->where('status', 'approved')->count();
        $pendingOrders = Order::where('created_at', '>=', $startDate)->where('status', 'pending')->count();
        $rejectedOrders = Order::where('created_at', '>=', $startDate)->where('status', 'rejected')->count();

        // Revenue by User Roles
        $revenueByRole = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where('orders.created_at', '>=', $startDate)
            ->where('orders.status', 'approved')
            ->select(
                'users.role',
                DB::raw('SUM(products.price * orders.quantity) as total_revenue'),
                DB::raw('COUNT(orders.id) as order_count')
            )
            ->groupBy('users.role')
            ->get();

        // Top Performing Products
        $topProducts = Order::join('products', 'orders.product_id', '=', 'products.id')
            ->where('orders.created_at', '>=', $startDate)
            ->where('orders.status', 'approved')
            ->select(
                'products.name',
                'products.price',
                DB::raw('SUM(orders.quantity) as total_quantity'),
                DB::raw('SUM(products.price * orders.quantity) as total_revenue'),
                DB::raw('COUNT(orders.id) as order_count')
            )
            ->groupBy('products.id', 'products.name', 'products.price')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->get();

        // Sales by User Type (Detailed)
        $salesByUserType = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where('orders.created_at', '>=', $startDate)
            ->where('orders.status', 'approved')
            ->select(
                DB::raw('CASE 
                    WHEN users.role_as = 1 THEN "Admin"
                    WHEN users.role_as = 2 THEN "Retailer" 
                    WHEN users.role_as = 5 THEN "Wholesaler"
                    WHEN users.role_as = 0 THEN "Customer"
                    ELSE users.role 
                END as user_type'),
                DB::raw('SUM(products.price * orders.quantity) as revenue'),
                DB::raw('COUNT(orders.id) as orders'),
                DB::raw('AVG(products.price * orders.quantity) as avg_order_value')
            )
            ->groupBy('user_type')
            ->orderByDesc('revenue')
            ->get();

        // Daily Sales Trend
        $dailySales = Order::join('products', 'orders.product_id', '=', 'products.id')
            ->where('orders.created_at', '>=', $startDate)
            ->where('orders.status', 'approved')
            ->select(
                DB::raw('DATE(orders.created_at) as date'),
                DB::raw('SUM(products.price * orders.quantity) as daily_revenue'),
                DB::raw('COUNT(orders.id) as daily_orders')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Monthly Comparison (if range > 30 days)
        $monthlyComparison = [];
        if ($dateRange >= 60) {
            $monthlyComparison = Order::join('products', 'orders.product_id', '=', 'products.id')
                ->where('orders.created_at', '>=', Carbon::now()->subDays(120))
                ->where('orders.status', 'approved')
                ->select(
                    DB::raw('YEAR(orders.created_at) as year'),
                    DB::raw('MONTH(orders.created_at) as month'),
                    DB::raw('SUM(products.price * orders.quantity) as monthly_revenue'),
                    DB::raw('COUNT(orders.id) as monthly_orders')
                )
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->limit(6)
                ->get();
        }

        // Order Status Distribution
        $orderStatusStats = Order::where('created_at', '>=', $startDate)
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // Average Order Value by Period
        $avgOrderValue = Order::join('products', 'orders.product_id', '=', 'products.id')
            ->where('orders.created_at', '>=', $startDate)
            ->where('orders.status', 'approved')
            ->selectRaw('AVG(products.price * orders.quantity) as avg_value')
            ->first();

        // Growth Metrics (compare with previous period)
        $previousPeriodStart = Carbon::now()->subDays($dateRange * 2);
        $previousPeriodEnd = Carbon::now()->subDays($dateRange);
        
        $previousSales = Order::where('created_at', '>=', $previousPeriodStart)
            ->where('created_at', '<', $previousPeriodEnd)
            ->where('status', 'approved')
            ->with('product')
            ->get()
            ->sum(function($order) {
                return ($order->product ? $order->product->price : 0) * $order->quantity;
            });

        $previousOrders = Order::where('created_at', '>=', $previousPeriodStart)
            ->where('created_at', '<', $previousPeriodEnd)
            ->count();

        $salesGrowth = $previousSales > 0 ? (($totalSales - $previousSales) / $previousSales) * 100 : 0;
        $ordersGrowth = $previousOrders > 0 ? (($totalOrders - $previousOrders) / $previousOrders) * 100 : 0;

        // Inventory Impact (Products with low stock vs high sales)
        $inventoryAlert = Product::with('batches')
            ->get()
            ->map(function($product) use ($startDate) {
                $totalStock = $product->batches->sum('quantity');
                $salesCount = Order::where('product_id', $product->id)
                    ->where('created_at', '>=', $startDate)
                    ->where('status', 'approved')
                    ->sum('quantity');
                
                return [
                    'product' => $product->name,
                    'stock' => $totalStock,
                    'sales' => $salesCount,
                    'stock_to_sales_ratio' => $salesCount > 0 ? $totalStock / $salesCount : null,
                    'needs_restock' => $totalStock < 50 && $salesCount > 10
                ];
            })
            ->filter(function($item) {
                return $item['needs_restock'];
            })
            ->sortBy('stock_to_sales_ratio')
            ->take(5);

        return view('admin.analytics.dashboard', compact(
            'totalSales', 'totalOrders', 'approvedOrders', 'pendingOrders', 'rejectedOrders',
            'revenueByRole', 'topProducts', 'salesByUserType', 'dailySales', 'monthlyComparison',
            'orderStatusStats', 'avgOrderValue', 'salesGrowth', 'ordersGrowth', 'inventoryAlert',
            'dateRange', 'startDate', 'endDate'
        ));
    }

    public function export(Request $request)
    {
        $dateRange = $request->get('range', '30');
        $startDate = Carbon::now()->subDays($dateRange);
        
        $data = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where('orders.created_at', '>=', $startDate)
            ->select(
                'orders.id',
                'orders.created_at',
                'users.name as customer_name',
                'users.email as customer_email',
                'users.role as customer_role',
                'products.name as product_name',
                'orders.quantity',
                'products.price as unit_price',
                DB::raw('(products.price * orders.quantity) as total_amount'),
                'orders.status',
                'orders.delivery_status',
                'orders.tracking_code'
            )
            ->orderBy('orders.created_at', 'desc')
            ->get();

        $filename = 'sales_analytics_' . now()->format('Y_m_d_H_i_s') . '.csv';
        
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'Order ID', 'Date', 'Customer Name', 'Customer Email', 'Customer Role',
                'Product Name', 'Quantity', 'Unit Price (UGX)', 'Total Amount (UGX)',
                'Order Status', 'Delivery Status', 'Tracking Code'
            ]);

            // CSV Data
            foreach ($data as $row) {
                fputcsv($file, [
                    $row->id,
                    $row->created_at->format('Y-m-d H:i:s'),
                    $row->customer_name,
                    $row->customer_email,
                    $row->customer_role,
                    $row->product_name,
                    $row->quantity,
                    number_format($row->unit_price, 2),
                    number_format($row->total_amount, 2),
                    $row->status,
                    $row->delivery_status ?? 'N/A',
                    $row->tracking_code ?? 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

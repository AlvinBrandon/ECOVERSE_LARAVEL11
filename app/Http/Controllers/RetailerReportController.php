<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class RetailerReportController extends Controller
{
    public function index()
    {
        // Customer orders for products with seller_role = 'retailer'
        $orders = Order::with(['user', 'product'])
            ->whereHas('user', function($q) { $q->where('role_as', 0); })
            ->whereHas('product', function($q) { $q->where('seller_role', 'retailer'); })
            ->orderByDesc('created_at')
            ->get();
        return view('reports.retailer', compact('orders'));
    }
}

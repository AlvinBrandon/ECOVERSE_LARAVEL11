<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class WholesalerReportController extends Controller
{
    public function index()
    {
        // Retailer orders for products with seller_role = 'wholesaler'
        $orders = Order::with(['user', 'product'])
            ->whereHas('user', function($q) { $q->where('role_as', 2); })
            ->whereHas('product', function($q) { $q->where('seller_role', 'wholesaler'); })
            ->orderByDesc('created_at')
            ->get();
        return view('reports.wholesaler', compact('orders'));
    }
}

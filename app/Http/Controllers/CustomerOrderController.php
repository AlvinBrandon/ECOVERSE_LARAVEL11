<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class CustomerOrderController extends Controller
{
    public function index()
    {
        // Get orders for the authenticated user using 'user_id' column
        $orders = Order::with(['product', 'user'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('customer.orders', compact('orders'));
    }
}
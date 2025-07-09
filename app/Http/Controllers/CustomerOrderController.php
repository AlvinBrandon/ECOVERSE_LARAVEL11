<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class CustomerOrderController extends Controller
{
    public function index()
    {
        // Assuming 'customer_id' is the foreign key in orders table
        $orders = Order::where('customer_id', auth()->id())->get();
        return view('customer.orders', compact('orders'));
    }
}
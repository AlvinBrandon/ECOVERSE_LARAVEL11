<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class StaffOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user','product')->get();
        return view('staff.orders',compact('orders'));
    }
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'status' => 'required|string'
        ]);
        $order->status = $request->input('status');
        $order->save();
        return redirect()->back()->with('success','Order status updated');
    }
}

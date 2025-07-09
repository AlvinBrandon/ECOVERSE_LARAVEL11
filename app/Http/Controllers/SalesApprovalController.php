<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class SalesApprovalController extends Controller
{
    public function index()
    {
        $sales = Order::with(['user', 'product'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.verify', compact('sales'));
    }

    public function verify($id)
    {
        $sale = Order::findOrFail($id);
        $sale->status = 'verified';
        $sale->save();

        return back()->with('success', 'Order verified.');
    }

    public function reject($id)
    {
        $sale = Order::findOrFail($id);
        $sale->status = 'rejected';
        $sale->save();

        return back()->with('success', 'Order rejected.');
    }
}

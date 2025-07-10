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
        $product = $sale->product;
        $inventory = $product->inventory;
        if ($inventory && $inventory->quantity >= $sale->quantity) {
            $inventory->quantity -= $sale->quantity;
            $inventory->save();
            $sale->status = 'verified';
            $sale->save();
            return redirect()->route('admin.sales.report')->with('success', 'Order verified and inventory updated.');
        } else {
            return back()->with('error', 'Insufficient stock to verify this order.');
        }
    }

    public function reject($id)
    {
        $sale = Order::findOrFail($id);
        $sale->status = 'rejected';
        $sale->save();

        return back()->with('success', 'Order rejected.');
    }
}

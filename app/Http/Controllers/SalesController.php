<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function index()
    {
        $products = Product::with('inventory')->get();
        return view('sales.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $inventory = $product->inventory;

        if (!$inventory || $inventory->quantity < $request->quantity) {
            return back()->with('error', 'Insufficient stock for ' . $product->name);
        }

        Order::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'status' => 'pending',
        ]);

        $inventory->quantity -= $request->quantity;
        $inventory->save();

        return back()->with('success', 'Order placed successfully for ' . $product->name);
    }

    public function history()
    {
        $orders = Order::with('product')
            ->where('user_id', Auth::id())
            ->latest()->get();

        return view('sales.history', compact('orders'));
    }

    public function status()
    {
        $orders = Order::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('sales.status', compact('orders'));
    }

    public function report()
    {
        $sales = Order::with('product', 'user')->get();
        $totalRevenue = $sales->sum(fn($o) => $o->product->price * $o->quantity);

        return view('admin.report', compact('sales', 'totalRevenue'));
    }
}

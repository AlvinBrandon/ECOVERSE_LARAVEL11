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
            'quantity' => 'required|integer|min:1',
            'address' => 'required|string|max:255' // ✅ Step 1: Validate address
        ]);
        $user = Auth::user();
        if (!$user) {
            return back()->with('error', 'You must be logged in to place an order.');
        }

        $product = Product::findOrFail($request->product_id);
        $inventory = $product->inventory;

        if (!$inventory || $inventory->quantity < $request->quantity) {
            return back()->with('error', 'Insufficient stock for ' . $product->name);
        }
         $total_price = $product->price * $request->quantity;

        Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
             'total_price' => $total_price,
             'address' => $request->address, // ✅ Step 2: Save the address
            'status' => 'pending',
        ]);

        // Do NOT deduct inventory here. Deduct only after admin verification.

        return back()->with('success', 'Order placed successfully for ' . $product->name . '. Awaiting admin verification.');
    }

    public function history(Request $request)
    {
        $query = Order::with('product')->where('user_id', Auth::id());
        if ($request->filled('product')) {
            $query->whereHas('product', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->product . '%');
            });
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        $orders = $query->orderByDesc('created_at')->get();
        return view('sales.history', compact('orders'));
    }

    public function status(Request $request)
    {
        $query = Order::with('product')->where('user_id', Auth::id());
        if ($request->filled('product')) {
            $query->whereHas('product', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->product . '%');
            });
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        $orders = $query->orderByDesc('created_at')->get();
        return view('sales.status', compact('orders'));
    }

    public function report(Request $request)
    {
        $query = Order::with('product', 'user'); // Removed user_id filter
        if ($request->filled('product')) {
            $query->whereHas('product', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->product . '%');
            });
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        $sales = $query->orderByDesc('created_at')->get();
        $totalRevenue = $sales->sum(fn($o) => $o->product->price * $o->quantity);

        return view('admin.report', compact('sales', 'totalRevenue'));
    }

    public function analytics()
    {
        $totalSales = Order::with('product')->where('user_id', Auth::id())->get()->sum(function($o) {
            return $o->product ? $o->product->price * $o->quantity : 0;
        });
        $totalOrders = Order::where('user_id', Auth::id())->count();
        $topProduct = Order::selectRaw('product_id, SUM(quantity) as total_qty')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product')
            ->where('user_id', Auth::id())
            ->first();
        $topProductName = $topProduct && $topProduct->product ? $topProduct->product->name : 'N/A';
        $dates = collect(range(0,29))->map(function($i) {
            return now()->subDays(29-$i)->format('Y-m-d');
        });
        $salesData = $dates->map(function($date) {
            return Order::with('product')->where('user_id', Auth::id())->whereDate('created_at', $date)->get()->sum(function($o) {
                return $o->product ? $o->product->price * $o->quantity : 0;
            });
        });
        return view('sales.analytics', [
            'totalSales' => $totalSales,
            'totalOrders' => $totalOrders,
            'topProduct' => $topProductName,
            'dates' => $dates,
            'salesData' => $salesData,
        ]);
    }

    public function invoice($id)
    {
        $sale = \App\Models\Sale::with(['product', 'user'])->findOrFail($id);
        return view('sales.invoice', compact('sale'));
    }
    public function showOrderForm($productId)
    {
        $product = Product::findOrFail($productId);
        return view('orderform', compact('product'));
            }
    public function placeOrder(Request $request)
    {
        $request->validate([
            'product_id'=>'required| exists:products,id',
            'quantity'=>'required|integer|min:1',
            'address'=>'required|string|max:255',
        ]);
        Order::create([
            'user_id'=>Auth::id(),
            'product_id'=>$request->product_id,
            'quantity'=>$request->quantity,
            'address'=>$request->address,
            'status'=>'pending',
        ]);
        return redirect()->route('dashboard')->with('success','Order placed successfully!');
    }
        }

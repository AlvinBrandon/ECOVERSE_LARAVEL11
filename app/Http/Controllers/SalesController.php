<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    // Helper: Get min/max order quantity for a role
    protected function getOrderQuantityLimits($role)
    {
        switch ($role) {
            case 'wholesaler':
                return ['min' => 10, 'max' => 1000];
            case 'retailer':
                return ['min' => 2, 'max' => 100];
            case 'customer':
                return ['min' => 1, 'max' => 10];
            default:
                return ['min' => 1, 'max' => 10];
        }
    }

    public function index()
    {
        $user = Auth::user();
        if ($user && $user->role === 'wholesaler') {
            // Wholesalers see all products
            $products = Product::with('inventory')->get();
        } else {
            $query = Product::with('inventory');
            if ($user) {
                if ($user->role === 'retailer') {
                    $query->where('seller_role', 'wholesaler');
                } elseif ($user->role === 'customer') {
                    $query->where('seller_role', 'retailer');
                }
            }
            if (request()->filled('type')) {
                $query->where('seller_role', request('type'));
            }
            $products = $query->get();
        }
        return view('sales.index', compact('products'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return back()->with('error', 'You must be logged in to place an order.');
        }

        $product = Product::findOrFail($request->product_id);

        // Enforce sales hierarchy
        $buyerRole = $user->role;
        $sellerRole = $product->seller_role ?? null; // You may need to set this field in your products table

        if ($sellerRole === 'factory' && $buyerRole !== 'wholesaler') {
            return back()->with('error', 'Factory can only sell to wholesalers.');
        }
        if ($sellerRole === 'wholesaler' && $buyerRole !== 'retailer') {
            return back()->with('error', 'Wholesalers can only sell to retailers.');
        }
        if ($sellerRole === 'retailer' && $buyerRole !== 'customer') {
            return back()->with('error', 'Retailers can only sell to end-customers.');
        }

        $limits = $this->getOrderQuantityLimits($user->role);
        $rules = [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:' . $limits['min'] . '|max:' . $limits['max'],
        ];
        $deliveryRequired = false;
        $deliveryOptional = false;
        if ($user) {
            if ($user->role === 'wholesaler' && $product->seller_role === 'factory') {
                $deliveryRequired = true;
            } elseif ($user->role === 'retailer' && $product->seller_role === 'wholesaler') {
                $deliveryOptional = true;
            } elseif ($user->role === 'customer' && $product->seller_role === 'retailer') {
                $deliveryRequired = true;
            }
        }
        if ($deliveryRequired) {
            $rules['delivery_method'] = 'required|in:delivery';
        } elseif ($deliveryOptional) {
            $rules['delivery_method'] = 'required|in:delivery,pickup';
        }
        $request->validate($rules, [
            'quantity.min' => 'Minimum order quantity for your role is ' . $limits['min'] . '.',
            'quantity.max' => 'Maximum order quantity for your role is ' . $limits['max'] . '.',
            'delivery_method.required' => 'Please select a delivery method.',
            'delivery_method.in' => 'Invalid delivery method selected.',
        ]);

        // Sum all inventory quantities for this product
        $totalAvailable = $product->inventories()->sum('quantity');
        if ($totalAvailable < $request->quantity) {
            return back()->with('error', 'Insufficient stock for ' . $product->name . '. Available: ' . $totalAvailable);
        }
         $total_price = $product->price * $request->quantity;

        // Generate unique order number
        $order_number = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(uniqid());

        Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'unit_price' => $product->price,
            'total_price' => $total_price,
            'address' => $request->address,
            'status' => 'pending',
            'delivery_method' => $request->delivery_method ?? null,
            'order_number' => $order_number,
        ]);

        // Do NOT deduct inventory here. Deduct only after verification by the next role in the sales chain.

        $role = $user->role ?? ($user->role_as == 5 ? 'wholesaler' : ($user->role_as == 2 ? 'retailer' : ($user->role_as == 0 ? 'customer' : 'other')));
        $message = 'Order placed successfully for ' . $product->name . '. ';
        if ($role === 'wholesaler') {
            $message .= 'Awaiting admin verification. Your order will remain pending until approved by an admin.';
        } elseif ($role === 'retailer') {
            $message .= 'Awaiting wholesaler verification. Your order will remain pending until approved by a wholesaler.';
        } elseif ($role === 'customer') {
            $message .= 'Awaiting retailer verification. Your order will remain pending until approved by a retailer.';
        } else {
            $message .= 'Awaiting verification.';
        }
        return back()->with('success', $message);
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
        $query = Order::with('product', 'user')
            ->whereHas('user', function($q) {
                $q->where('role', 'wholesaler');
            });
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
        
        // Generate unique order number
        $order_number = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(uniqid());
        
        // Get product to calculate prices
        $product = \App\Models\Product::findOrFail($request->product_id);
        $total_price = $product->price * $request->quantity;
        
        Order::create([
            'user_id'=>Auth::id(),
            'product_id'=>$request->product_id,
            'quantity'=>$request->quantity,
            'unit_price' => $product->price,
            'total_price' => $total_price,
            'address'=>$request->address,
            'status'=>'pending',
            'delivery_method' => null, // Default for simple orders
            'order_number' => $order_number,
        ]);
        return redirect()->route('dashboard')->with('success','Order placed successfully!');
        
    }
        }

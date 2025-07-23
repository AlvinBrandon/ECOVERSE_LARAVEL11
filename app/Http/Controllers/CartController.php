<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Add product to cart (AJAX)
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $cart = session()->get('cart', []);
        $productId = $request->product_id;
        $quantity = $request->quantity;
        $product = Product::findOrFail($productId);
        $stock = $product->inventory ? $product->inventory->quantity : 0;
        // Calculate new quantity if already in cart
        $newQuantity = isset($cart[$productId]) ? $cart[$productId]['quantity'] + $quantity : $quantity;
        // Ensure quantity does not exceed 100
        if ($newQuantity > 100) {
            $newQuantity = 100;
        }
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $newQuantity;
            $cart[$productId]['stock'] = $stock;
        } else {
            $cart[$productId] = [
                'product_id' => $productId,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => $newQuantity,
                'stock' => $stock,
            ];
        }
        session(['cart' => $cart]);
        return response()->json(['success' => true, 'message' => 'Product added to cart successfully!']);
    }

    // Remove product from cart
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
        $cart = session()->get('cart', []);
        unset($cart[$request->product_id]);
        session(['cart' => $cart]);
        return back()->with('success', 'Product removed from cart.');
    }

    // View cart page (index method for route compatibility)
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    // View cart page
    public function view()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    // Checkout (show modal for confirmation)
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        // Calculate subtotal
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $discount = 0;
        $voucherCode = null;
        $redemption = null;

        // Handle voucher if provided
        if ($request->voucher_code) {
            $user = Auth::user();
            $redemption = \App\Models\EcoPointRedemption::with('reward')
                ->where('user_id', $user->id)
                ->where('voucher_code', $request->voucher_code)
                ->where('status', 'active')
                ->first();

            if ($redemption && $redemption->isUsable()) {
                $reward = $redemption->reward;
                
                // Calculate discount based on reward type
                switch($reward->type) {
                    case 'discount_percentage':
                        $discount = $subtotal * ($reward->value / 100);
                        break;
                    case 'discount_fixed':
                        $discount = min($reward->value, $subtotal);
                        break;
                    case 'product_voucher':
                        $discount = min($reward->value, $subtotal);
                        break;
                    case 'free_shipping':
                        $discount = 5000; // Assume shipping cost
                        break;
                    default:
                        $discount = $reward->value ?? 0;
                }
                
                $voucherCode = $request->voucher_code;
            }
        }

        $finalTotal = $subtotal - $discount;

        $paymentMethod = $request->payment_method;
        $paymentDetails = null;
        if ($paymentMethod === 'mobile_money') {
            $request->validate([
                'mm_provider' => 'required|in:mtn,airtel',
                'mm_phone' => [
                    'required',
                    $request->mm_provider === 'airtel'
                        ? 'regex:/^(070|074)\\d{7}$/i'
                        : 'regex:/^(078|076|079)\\d{7}$/i',
                ],
            ]);
            $paymentDetails = [
                'provider' => $request->mm_provider,
                'phone' => $request->mm_phone,
            ];
        } elseif ($paymentMethod === 'visa_card') {
            $request->validate([
                'card_number' => 'required|digits:20',
            ]);
            $paymentDetails = [
                'card_number' => $request->card_number,
            ];
        }

        // Save each cart item as an Order in the database
        $user = Auth::user();
        $orderIds = [];
        
        foreach ($cart as $item) {
            $order = \App\Models\Order::create([
                'user_id' => $user->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'total_price' => $item['price'] * $item['quantity'],
                'address' => $request->address,
                'status' => 'pending',
                'payment_method' => $paymentMethod,
                'order_number' => 'ORD-' . strtoupper(substr(md5(uniqid()), 0, 8)),
                'voucher_code' => $voucherCode,
                'discount_amount' => $discount > 0 ? $discount : null,
            ]);
            $orderIds[] = $order->id;
        }

        // Mark voucher as used if applied
        if ($redemption && $discount > 0) {
            $redemption->markAsUsed($orderIds[0]); // Associate with first order
        }

        // Clear the cart after order is placed
        session()->forget('cart');

        session(['last_order' => $order]);
        // Redirect to order status page after placing order
        return redirect()->route('sales.status')->with('success', 'Order placed successfully! You can track your order status below.');
    }

    // Order confirmation page after checkout
    public function confirmation(Request $request)
    {
        $order = session('last_order'); // Should be set after checkout
        if (!$order) {
            return redirect()->route('sales.index')->with('error', 'No recent order found.');
        }
        session()->forget('cart'); // Clear cart after order
        session()->forget('last_order');
        return view('order_confirmation', compact('order'));
    }

    // TEMP: Clear cart session for development
    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared!');
    }
} 
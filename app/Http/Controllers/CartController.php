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
        $order = [
            'items' => $cart,
            'payment_method' => $paymentMethod,
            'payment_details' => $paymentDetails,
            'address' => $request->address,
            'total' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            'created_at' => now()->toDateTimeString(),
        ];

        // Save each cart item as an Order in the database
        $user = Auth::user();
        foreach ($cart as $item) {
            \App\Models\Order::create([
                'user_id' => $user->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'total_price' => $item['price'] * $item['quantity'],
                'address' => $request->address,
                'status' => 'order placed',
                'payment_method' => $paymentMethod,
            ]);
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
@php
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

// Only show orders for the correct buyer role for each dashboard
$orders = collect();
if ($role === 'admin') {
    // Admin verifies wholesaler orders (role_as = 5)
    $orders = Order::with(['user', 'product'])
        ->whereHas('user', function($q) { $q->where('role_as', 5); })
        ->where('status', 'pending')
        ->orderByDesc('created_at')
        ->get();
} elseif ($role === 'wholesaler') {
    // Wholesaler verifies retailer orders (role_as = 2) for products with seller_role = 'wholesaler'
    $orders = Order::with(['user', 'product'])
        ->whereHas('user', function($q) { $q->where('role_as', 2); })
        ->whereHas('product', function($q) { $q->where('seller_role', 'wholesaler'); })
        ->where('status', 'pending')
        ->orderByDesc('created_at')
        ->get();
} elseif ($role === 'retailer') {
    // Retailer verifies customer orders (role_as = 0) for products with seller_role = 'retailer'
    $orders = Order::with(['user', 'product'])
        ->whereHas('user', function($q) { $q->where('role_as', 0); })
        ->whereHas('product', function($q) { $q->where('seller_role', 'retailer'); })
        ->where('status', 'pending')
        ->orderByDesc('created_at')
        ->get();
}
@endphp
@if($orders->count())
<table class="table table-bordered table-hover">
    <thead class="bg-light">
        <tr>
            <th>Order ID</th>
            <th>Product</th>
            <th>Buyer</th>
            <th>Quantity</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->product->name ?? '-' }}</td>
            <td>{{ $order->user->name ?? '-' }}</td>
            <td>{{ $order->quantity }}</td>
            <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
            <td>
                <form action="{{ route('orders.verify', $order->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check-circle"></i> Verify</button>
                </form>
                <form action="{{ route('orders.reject', $order->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-x-circle"></i> Reject</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-info mb-0">No pending orders to verify at this time.</div>
@endif

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Staff - Manage Orders</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @foreach($orders as $order)
        <div class="card my-2 p-3">
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Customer:</strong> {{ $order->user->name }}</p>
            <p><strong>Product:</strong> {{ $order->product->name ?? 'N/A' }}</p>
            <p><strong>Status:</strong> {{ $order->status }}</p>

            <form action="{{ route('staff.orders.updateStatus', $order->id) }}" method="POST">
                @csrf
                <select name="status" class="form-select my-2">
                    <option value="Order Placed" {{ $order->status == 'Order Placed' ? 'selected' : '' }}>Order Placed</option>
                    <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                    <option value="Out for Delivery" {{ $order->status == 'Out for Delivery' ? 'selected' : '' }}>Out for Delivery</option>
                    <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                </select>
                <button class="btn btn-primary">Update Status</button>
            </form>
        </div>
    @endforeach
</div>
@endsection
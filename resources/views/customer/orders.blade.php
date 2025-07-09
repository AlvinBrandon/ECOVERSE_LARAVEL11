@extends('layouts.app')

@section('content')
<div class="container">
    <h2>My Orders</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Created At</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>{{ $order->created_at->format('Y-m-d') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3">No orders found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
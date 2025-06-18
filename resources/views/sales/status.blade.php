@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
  <h4 class="mb-4">Current Order Status</h4>
  <div class="card">
    <div class="card-body px-0 pt-0 pb-2">
      <div class="table-responsive p-3">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th>Product</th>
              <th>Quantity</th>
              <th>Status</th>
              <th>Updated</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($orders as $order)
              <tr>
                <td>{{ $order->product->name }}</td>
                <td>{{ $order->quantity }}</td>
                <td><span class="badge bg-gradient-{{ $order->status == 'pending' ? 'warning' : 'success' }}">{{ ucfirst($order->status) }}</span></td>
                <td>{{ $order->updated_at->format('Y-m-d H:i') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
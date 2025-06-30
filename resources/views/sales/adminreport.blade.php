@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
  <div class="row mb-4">
    <div class="col-12">
      <h4 class="text-dark">Sales Report</h4>
      <p>Total Revenue: <strong>UGX {{ number_format($totalRevenue) }}</strong></p>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-3">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Customer</th>
                  <th>Quantity</th>
                  <th>Status</th>
                  <th>Ordered At</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($sales as $order)
                <tr>
                  <td>{{ $order->product->name }}</td>
                  <td>{{ $order->user->name ?? 'Unknown' }}</td>
                  <td>{{ $order->quantity }}</td>
                  <td><span class="badge bg-gradient-info">{{ ucfirst($order->status) }}</span></td>
                  <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<style>
  body, .main-content, .container-fluid, .container {
    background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%) !important;
  }
  .dashboard-card, .po-card {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    box-shadow: 0 4px 24px rgba(16, 185, 129, 0.08);
    padding: 2rem 1.5rem;
    margin-bottom: 2rem;
    transition: box-shadow 0.2s, transform 0.2s;
  }
  .dashboard-card:hover, .po-card:hover {
    box-shadow: 0 8px 32px rgba(99,102,241,0.18), 0 2px 8px rgba(16,185,129,0.10);
    transform: translateY(-4px) scale(1.025);
    z-index: 2;
    cursor: pointer;
  }
  .po-header {
    background: linear-gradient(90deg, #6366f1 0%, #10b981 100%) !important;
    color: #fff !important;
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
    padding: 1.5rem 1.5rem 1rem 1.5rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
  }
  .po-icon {
    font-size: 2.5rem;
    margin-right: 1rem;
    vertical-align: middle;
  }
</style>
<div class="container py-4">
  <div class="po-header">
    <i class="bi bi-truck po-icon"></i>
    <div>
      <h2 class="mb-0">My Purchase Orders</h2>
      <p class="mb-0" style="font-size:1.1rem;">View and deliver your assigned purchase orders.</p>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="po-card">
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered table-hover">
          <thead class="bg-light">
            <tr>
              <th>ID</th>
              <th>Material</th>
              <th>Quantity</th>
              <th>Price (UGX)</th>
              <th>Status</th>
              <th>Invoice</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
              <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->rawMaterial->name ?? 'N/A' }}</td>
                <td>{{ $order->quantity }}</td>
                <td>UGX {{ number_format($order->price) }}</td>
                <td><span class="badge bg-{{ $order->status == 'pending' ? 'secondary' : ($order->status == 'delivered' ? 'info' : ($order->status == 'complete' ? 'success' : 'dark')) }}">{{ ucfirst($order->status) }}</span></td>
                <td>
                  @if($order->invoice_path)
                    <a href="{{ asset('storage/' . $order->invoice_path) }}" target="_blank">View</a>
                  @else
                    -
                  @endif
                </td>
                <td>
                  @if($order->status == 'pending')
                    <form action="{{ route('supplier.purchase_orders.markDelivered', $order->id) }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                      @csrf
                      <input type="file" name="invoice" class="form-control form-control-sm me-2" required>
                      <button type="submit" class="btn btn-success btn-sm">Mark Delivered</button>
                    </form>
                  @else
                    -
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

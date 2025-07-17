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
    <i class="bi bi-file-earmark-text po-icon"></i>
    <div>
      <h2 class="mb-0">Purchase Order #{{ $order->id }}</h2>
      <p class="mb-0" style="font-size:1.1rem;">Details for this purchase order.</p>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="po-card">
        <table class="table table-bordered">
          <tr><th>Supplier</th><td>{{ $order->supplier->name ?? 'N/A' }}</td></tr>
          <tr><th>Raw Material</th><td>{{ $order->rawMaterial->name ?? 'N/A' }}</td></tr>
          <tr><th>Quantity</th><td>{{ $order->quantity }}</td></tr>
          <tr><th>Price (UGX)</th><td>UGX {{ number_format($order->price) }}</td></tr>
          <tr><th>Status</th><td><span class="badge bg-{{ $order->status == 'pending' ? 'secondary' : ($order->status == 'delivered' ? 'info' : ($order->status == 'complete' ? 'success' : 'dark')) }}">{{ ucfirst($order->status) }}</span></td></tr>
          <tr><th>Created By</th><td>{{ $order->creator->name ?? 'N/A' }}</td></tr>
          <tr><th>Created At</th><td>{{ $order->created_at }}</td></tr>
          <tr><th>Delivered At</th><td>{{ $order->delivered_at ?? '-' }}</td></tr>
          <tr><th>Completed At</th><td>{{ $order->completed_at ?? '-' }}</td></tr>
          <tr><th>Paid At</th><td>{{ $order->paid_at ?? '-' }}</td></tr>
          <tr><th>Invoice</th><td>
            @if($order->invoice_path)
              <a href="{{ asset('storage/' . $order->invoice_path) }}" target="_blank">View Invoice</a>
            @else
              -
            @endif
          </td></tr>
        </table>
        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3"><i class="bi bi-arrow-return-left"></i> Back</a>
      </div>
    </div>
  </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

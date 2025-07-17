@extends('layouts.app')

@section('content')
<style>
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%) !important;
  }
  .card {
    background: rgba(255,255,255,0.97);
    border-radius: 1.25rem;
    box-shadow: 0 6px 32px rgba(16, 185, 129, 0.10);
    transition: transform 0.18s;
  }
  .card:hover {
    transform: translateY(-6px) scale(1.03);
    box-shadow: 0 12px 40px #10b98133;
  }
  .card-header.bg-gradient-primary {
    background: linear-gradient(90deg, #6366f1 0%, #10b981 100%) !important;
    color: #fff !important;
    border-top-left-radius: 1.25rem;
    border-top-right-radius: 1.25rem;
  }
  .btn-info, .btn-warning, .btn-success, .btn-danger, .btn-primary {
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.08);
  }
  .table thead {
    background: #f0fdfa !important;
  }
  .table th {
    color: #6366f1;
    font-weight: 600;
    letter-spacing: 1px;
    font-size: 1rem;
    border: none;
  }
  .table td {
    font-size: 1.05rem;
    vertical-align: middle;
    border: none;
  }
  .badge.bg-gradient-info {
    background: linear-gradient(90deg, #10b981 0%, #6366f1 100%) !important;
    color: #fff;
    font-weight: 500;
    font-size: 0.95rem;
    border-radius: 0.7rem;
    padding: 0.5em 1.2em;
  }
</style>
<div class="container-fluid py-4">
  <div class="row mb-4">
    <div class="col-12 d-flex align-items-center justify-content-between">
      <h4 class="mb-0 fw-bold text-dark"><i class="bi bi-clock-history me-2"></i>My Order History</h4>
      <a href="{{ route('dashboard') }}" class="btn btn-outline-dark"><i class="bi bi-house-door me-1"></i>Home</a>
    </div>
  </div>
  <form method="GET" class="row g-3 mb-4 align-items-end">
    <div class="col-md-4">
      <label for="product" class="form-label">Product Name</label>
      <input type="text" name="product" id="product" class="form-control" value="{{ request('product') }}" placeholder="Search by product...">
    </div>
    <div class="col-md-3">
      <label for="date_from" class="form-label">From</label>
      <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
    </div>
    <div class="col-md-3">
      <label for="date_to" class="form-label">To</label>
      <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
    </div>
    <div class="col-md-2 d-grid">
      <button type="submit" class="btn btn-info"><i class="bi bi-search me-1"></i>Filter</button>
    </div>
  </form>
  <div class="card">
    <div class="card-body px-0 pt-0 pb-2">
      <div class="table-responsive p-3">
        <table class="table align-items-center mb-0 table-hover">
          <thead>
            <tr>
              <th><i class="bi bi-cube me-1"></i>Product</th>
              <th><i class="bi bi-123 me-1"></i>Quantity</th>
              <th><i class="bi bi-truck me-1"></i>Delivery</th>
              <th><i class="bi bi-geo me-1"></i>Delivery Status</th>
              <th><i class="bi bi-clipboard-check me-1"></i>Status</th>
              <th><i class="bi bi-calendar me-1"></i>Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($orders as $order)
              <tr>
                <td>{{ $order->product->name }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{ ucfirst($order->delivery_method ?? '-') }}</td>
                <td><span class="badge bg-gradient-info">{{ ucfirst($order->delivery_status ?? 'pending') }}</span></td>
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
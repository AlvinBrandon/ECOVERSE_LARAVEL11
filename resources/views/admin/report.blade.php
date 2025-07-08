@extends('layouts.app')

@section('content')
<style>
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%) !important;
  }
  .dashboard-card {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    box-shadow: 0 4px 24px rgba(16, 185, 129, 0.08);
    padding: 2rem 1.5rem;
    margin-bottom: 2rem;
  }
  .dashboard-header {
    background: linear-gradient(90deg, #6366f1 0%, #10b981 100%) !important;
    color: #fff !important;
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
    padding: 1.5rem 1.5rem 1rem 1.5rem;
    margin-bottom: 2rem;
  }
  .dashboard-icon {
    font-size: 2.5rem;
    margin-right: 1rem;
    vertical-align: middle;
  }
  .ecoverse-logo {
    width: 48px;
    height: 48px;
    margin-right: 1rem;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #10b981;
    background: #fff;
  }
  table {
    width: 100%;
    background: white;
    border-collapse: collapse;
    border-radius: 1rem;
    overflow: hidden;
  }
  th, td {
    padding: 1rem;
    text-align: left;
  }
  thead {
    background: #10b981;
    color: white;
  }
  tr:nth-child(even) {
    background: #f9fafb;
  }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="dashboard-card">
  <div class="dashboard-header d-flex align-items-center">
    <i class="bi bi-bar-chart-line dashboard-icon"></i>
    <h2 class="mb-0">Sales Report</h2>
  </div>

  <p class="mb-4">
    <strong>Total Revenue:</strong> UGX {{ number_format($totalRevenue, 0) }}
  </p>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>Product</th>
          <th>User</th>
          <th>Quantity</th>
          <th>Subtotal</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        @forelse($sales as $sale)
          <tr>
            <td>{{ $sale->product->name ?? 'N/A' }}</td>
            <td>{{ $sale->user->name ?? 'Guest' }}</td>
            <td>{{ $sale->quantity }}</td>
            <td>UGX {{ number_format($sale->product->price * $sale->quantity, 0) }}</td>
            <td>{{ $sale->created_at->format('Y-m-d') }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center">No sales found for this period.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection

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
    background: linear-gradient(90deg, #10b981 0%, #6366f1 100%) !important;
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
    background: #6366f1;
    color: white;
  }
  tr:nth-child(even) {
    background: #f9fafb;
  }
  .btn-verify {
    background-color: #10b981;
    color: white;
    border: none;
    padding: 0.4rem 0.8rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    cursor: pointer;
  }
  .btn-verify:hover {
    background-color: #0f9f75;
  }
  .btn-reject {
    background-color: #ef4444;
    color: white;
    border: none;
    padding: 0.4rem 0.8rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    margin-left: 0.5rem;
    cursor: pointer;
  }
  .btn-reject:hover {
    background-color: #dc2626;
  }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="dashboard-card">
  <div class="dashboard-header d-flex align-items-center">
    <i class="bi bi-check-circle dashboard-icon"></i>
    <h2 class="mb-0">Pending Orders for Verification</h2>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Customer</th>
          <th>Product</th>
          <th>Quantity</th>
          <th>Status</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($sales as $sale)
          <tr>
            <td>{{ $sale->id }}</td>
            <td>{{ $sale->user->name ?? 'Guest' }}</td>
            <td>{{ $sale->product->name ?? 'N/A' }}</td>
            <td>{{ $sale->quantity }}</td>
            <td><span class="badge bg-warning">{{ ucfirst($sale->status) }}</span></td>
            <td>{{ $sale->created_at->format('Y-m-d') }}</td>
            <td class="d-flex">
              <form method="POST" action="{{ route('admin.sales.verify', $sale->id) }}">
                @csrf
                <button type="submit" class="btn-verify">Verify</button>
              </form>
              <form method="POST" action="{{ route('admin.sales.reject', $sale->id) }}">
                @csrf
                <button type="submit" class="btn-reject">Reject</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center">No pending orders found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection

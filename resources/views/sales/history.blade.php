@extends('layouts.app')

@section('content')
<style>
  /* Modern Professional Order History Styling */
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
  }

  /* Page Header */
  .page-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    color: white;
  }

  .page-header h4 {
    margin: 0;
    font-weight: 600;
    font-size: 1.5rem;
  }

  .page-header .btn {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    backdrop-filter: blur(10px);
    transition: all 0.2s ease;
  }

  .page-header .btn:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.3);
    color: white;
    transform: translateY(-2px);
  }

  /* Filter Section */
  .filter-section {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
  }

  .filter-section .form-label {
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
  }

  .filter-section .form-control {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
  }

  .filter-section .form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  }

  .filter-section .btn {
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .filter-section .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
  }

  /* Main Table Card */
  .table-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    border: none;
  }

  .table-card .card-body {
    padding: 0;
  }

  /* Table Styling */
  .modern-table {
    margin: 0;
    border-collapse: separate;
    border-spacing: 0;
  }

  .modern-table thead th {
    background: #f8fafc;
    color: #374151;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1.25rem 1.5rem;
    border: none;
    border-bottom: 1px solid #e5e7eb;
    position: sticky;
    top: 0;
    z-index: 10;
  }

  .modern-table thead th i {
    color: #6b7280;
    margin-right: 0.5rem;
  }

  .modern-table tbody tr {
    transition: all 0.2s ease;
  }

  .modern-table tbody tr:hover {
    background: #f9fafb;
  }

  .modern-table tbody td {
    padding: 1.25rem 1.5rem;
    border: none;
    border-bottom: 1px solid #f3f4f6;
    font-size: 0.875rem;
    color: #374151;
    vertical-align: middle;
  }

  .modern-table tbody tr:last-child td {
    border-bottom: none;
  }

  /* Status Badges */
  .status-badge {
    padding: 0.375rem 0.875rem;
    border-radius: 0.5rem;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: capitalize;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
  }

  .status-badge.delivered, .status-badge.completed {
    background: #dcfce7;
    color: #166534;
  }

  .status-badge.pending {
    background: #fef3c7;
    color: #92400e;
  }

  .status-badge.approved, .status-badge.processing {
    background: #dbeafe;
    color: #1e40af;
  }

  .status-badge.dispatched {
    background: #e0e7ff;
    color: #3730a3;
  }

  .status-badge.cancelled, .status-badge.rejected {
    background: #fee2e2;
    color: #991b1b;
  }

  /* Product Name Styling */
  .product-name {
    font-weight: 500;
    color: #1f2937;
  }

  /* Quantity Styling */
  .quantity {
    font-weight: 600;
    color: #374151;
  }

  /* Date Styling */
  .order-date {
    color: #6b7280;
    font-size: 0.8rem;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .page-header {
      padding: 1.5rem;
    }

    .page-header h4 {
      font-size: 1.25rem;
    }

    .filter-section {
      padding: 1rem;
    }

    .modern-table thead th,
    .modern-table tbody td {
      padding: 1rem;
      font-size: 0.8rem;
    }

    .status-badge {
      padding: 0.25rem 0.625rem;
      font-size: 0.7rem;
    }
  }

  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: #6b7280;
  }

  .empty-state i {
    font-size: 4rem;
    color: #a78bfa;
    margin-bottom: 1.5rem;
  }

  .empty-state h5 {
    color: #374151;
    margin-bottom: 0.75rem;
    font-weight: 600;
    font-size: 1.25rem;
  }

  .empty-state p {
    margin: 0;
    font-size: 0.875rem;
    max-width: 400px;
    margin: 0 auto;
    line-height: 1.5;
  }

  /* Action Buttons Enhancement */
  .btn-primary {
    background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
    border: none;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #6d28d9 0%, #7c3aed 100%);
    box-shadow: 0 8px 25px rgba(124, 58, 237, 0.3);
    transform: translateY(-2px);
  }

  /* Total Summary Section */
  .summary-section {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
  }

  .summary-card {
    background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
    border-radius: 0.75rem;
    padding: 1.5rem;
    color: white;
    text-align: center;
    position: relative;
    overflow: hidden;
  }

  .summary-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    border-radius: 50%;
  }

  .summary-card h6 {
    margin: 0;
    font-weight: 500;
    opacity: 0.9;
    position: relative;
    z-index: 2;
  }

  .summary-card .display-6 {
    margin: 0;
    font-weight: 700;
    position: relative;
    z-index: 2;
  }
</style>
<div class="container-fluid py-4">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h4><i class="bi bi-clock-history me-2"></i>My Order History</h4>
        <p class="mb-0 opacity-75">Complete history of all your orders</p>
      </div>
      <a href="{{ route('dashboard') }}" class="btn">
        <i class="bi bi-house-door me-1"></i>Home
      </a>
    </div>
  </div>

  <!-- Filter Section -->
  <div class="filter-section">
    <form method="GET" class="row g-3 align-items-end">
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
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-search me-1"></i>Filter
        </button>
      </div>
    </form>
  </div>

  <!-- Orders Table -->
  <div class="card table-card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table modern-table">
          <thead>
            <tr>
              <th><i class="bi bi-cube"></i>Product</th>
              <th><i class="bi bi-123"></i>Quantity</th>
              <th><i class="bi bi-truck"></i>Delivery</th>
              <th><i class="bi bi-geo-alt"></i>Delivery Status</th>
              <th><i class="bi bi-clipboard-check"></i>Status</th>
              <th><i class="bi bi-calendar"></i>Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($orders as $order)
              <tr>
                <td>
                  <span class="product-name">{{ $order->product->name }}</span>
                </td>
                <td>
                  <span class="quantity">{{ $order->quantity }}</span>
                </td>
                <td>{{ ucfirst($order->delivery_method ?? 'Delivery') }}</td>
                <td>
                  <span class="status-badge {{ strtolower($order->delivery_status ?? 'pending') }}">
                    {{ ucfirst($order->delivery_status ?? 'pending') }}
                  </span>
                </td>
                <td>
                  <span class="status-badge {{ strtolower($order->status) }}">
                    {{ ucfirst($order->status) }}
                  </span>
                </td>
                <td>
                  <span class="order-date">{{ $order->created_at->format('M d, Y H:i') }}</span>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6">
                  <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h5>No Orders Found</h5>
                    <p>You haven't placed any orders yet or no orders match your filter criteria.</p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
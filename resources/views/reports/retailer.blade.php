@extends('layouts.app')

@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
  
  /* Modern Professional Retailer Reports Styling */
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

  .page-header h2 {
    margin: 0;
    font-weight: 600;
    font-size: 1.5rem;
    color: white;
  }

  .page-header p {
    margin: 0.5rem 0 0 0;
    color: rgba(255, 255, 255, 0.8);
  }

  .page-header .btn {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    backdrop-filter: blur(10px);
    transition: all 0.2s ease;
    margin-left: 0.5rem;
  }

  .page-header .btn:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.3);
    color: white;
    transform: translateY(-2px);
  }

  /* Stats Cards */
  .stats-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    transition: all 0.2s ease;
    border: none;
    overflow: hidden;
    position: relative;
  }

  .stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100px;
    height: 100px;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    border-radius: 50%;
    transform: translate(30px, -30px);
  }

  .stats-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
  }

  .stats-card h3 {
    margin: 0;
    font-weight: 700;
    font-size: 2rem;
    position: relative;
    z-index: 2;
  }

  .stats-card small {
    font-weight: 500;
    opacity: 0.9;
    position: relative;
    z-index: 2;
  }

  /* Main Table Card */
  .table-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    border: none;
  }

  .table-card .card-header {
    background: #f8fafc !important;
    border-bottom: 1px solid #e5e7eb !important;
    padding: 1.5rem;
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

  .modern-table tbody tr {
    transition: all 0.2s ease;
  }

  .modern-table tbody tr:hover {
    background: #f9fafb;
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
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

  .status-badge.pending {
    background: #fef3c7;
    color: #92400e;
  }

  .status-badge.approved {
    background: #dcfce7;
    color: #166534;
  }

  .status-badge.rejected {
    background: #fee2e2;
    color: #991b1b;
  }

  /* Order Verification Form */
  .verification-form {
    background: #f8fafc;
    border-radius: 0.5rem;
    padding: 1rem;
    margin-top: 1rem;
    border: 1px solid #e5e7eb;
  }

  .verification-form .form-label {
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.25rem;
    font-size: 0.8rem;
  }

  .verification-form .form-control,
  .verification-form .form-select {
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.8rem;
    transition: all 0.2s ease;
  }

  .verification-form .form-control:focus,
  .verification-form .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
  }

  .verification-form .btn {
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .verification-form .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
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

  /* Responsive Design */
  @media (max-width: 768px) {
    .page-header {
      padding: 1.5rem;
    }

    .page-header h2 {
      font-size: 1.25rem;
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
</style>

<div class="container-fluid py-4">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h2><i class="bi bi-bar-chart me-2"></i>Retailer Analytics & Customer Orders</h2>
        <p>Track customer orders and view your analytics in style</p>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('retailer.customer-orders') }}" class="btn">
          <i class="bi bi-clipboard-check me-1"></i>View All Orders
        </a>
        <a href="{{ route('dashboard') }}" class="btn">
          <i class="bi bi-house-door me-1"></i>Home
        </a>
      </div>
    </div>
  </div>
  <!-- Order Statistics -->
  <div class="row g-4 mb-4">
    <div class="col-md-4">
      <div class="stats-card" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white;">
        <div class="d-flex align-items-center">
          <div class="me-3">
            <i class="bi bi-clock-fill fs-2"></i>
          </div>
          <div>
            <h3 class="mb-0">{{ $orders->count() }}</h3>
            <small>Pending Orders</small>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="stats-card" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white;">
        <div class="d-flex align-items-center">
          <div class="me-3">
            <i class="bi bi-check-circle-fill fs-2"></i>
          </div>
          <div>
            <h3 class="mb-0">{{ $orders->where('status', 'approved')->count() }}</h3>
            <small>Approved Orders</small>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="stats-card" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: white;">
        <div class="d-flex align-items-center">
          <div class="me-3">
            <i class="bi bi-x-circle-fill fs-2"></i>
          </div>
          <div>
            <h3 class="mb-0">{{ $orders->where('status', 'rejected')->count() }}</h3>
            <small>Rejected Orders</small>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Orders Management Table -->
  <div class="table-card">
    <div class="card-header">
      <h5 class="mb-0" style="color: #495057; font-weight: 600;">
        <i class="bi bi-clipboard-check me-2"></i>Customer Orders Pending Verification
      </h5>
    </div>
    <div class="card-body">
      @if($orders->count())
        <div class="table-responsive">
          <table class="table modern-table">
            <thead>
              <tr>
                <th><i class="bi bi-hash me-1"></i>Order ID</th>
                <th><i class="bi bi-box me-1"></i>Product</th>
                <th><i class="bi bi-person me-1"></i>Customer</th>
                <th><i class="bi bi-123 me-1"></i>Quantity</th>
                <th><i class="bi bi-calendar me-1"></i>Date</th>
                <th><i class="bi bi-info-circle me-1"></i>Status & Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($orders as $order)
              <tr>
                <td>
                  <div class="order-id-badge" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; padding: 0.4rem 0.8rem; border-radius: 0.4rem; font-weight: 600; font-size: 0.8rem;">
                    #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                  </div>
                </td>
                <td>
                  <div>
                    <div class="fw-semibold">{{ $order->product->name ?? '-' }}</div>
                    <small class="text-muted">{{ $order->product->sku ?? 'N/A' }}</small>
                  </div>
                </td>
                <td>
                  <div>
                    <div class="fw-semibold">{{ $order->user->name ?? '-' }}</div>
                    <small class="text-muted">{{ $order->user->email ?? 'N/A' }}</small>
                  </div>
                </td>
                <td>
                  <span class="badge bg-light text-dark">{{ $order->quantity }} pcs</span>
                </td>
                <td>
                  <div>{{ $order->created_at->format('M d, Y') }}</div>
                  <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                </td>
                <td>
                  @if($order->status === 'pending')
                    <span class="status-badge pending">
                      <i class="bi bi-clock me-1"></i>Pending
                    </span>
                    <div class="verification-form">
                      <form action="{{ route('orders.verify', $order->id) }}" method="POST">
                        @csrf
                        <div class="mb-2">
                          <label for="delivery_status_{{ $order->id }}" class="form-label">Delivery Status</label>
                          <select name="delivery_status" id="delivery_status_{{ $order->id }}" class="form-select">
                            <option value="pending" {{ $order->delivery_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="dispatched" {{ $order->delivery_status == 'dispatched' ? 'selected' : '' }}>Dispatched</option>
                            <option value="delivered" {{ $order->delivery_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="pickup_arranged" {{ $order->delivery_status == 'pickup_arranged' ? 'selected' : '' }}>Pickup Arranged</option>
                          </select>
                        </div>
                        <div class="mb-2">
                          <label for="tracking_code_{{ $order->id }}" class="form-label">Tracking Code</label>
                          <input type="text" name="tracking_code" id="tracking_code_{{ $order->id }}" class="form-control" value="{{ $order->tracking_code }}" placeholder="Enter tracking code">
                        </div>
                        <div class="mb-3">
                          <label for="dispatch_log_{{ $order->id }}" class="form-label">Dispatch Log</label>
                          <textarea name="dispatch_log" id="dispatch_log_{{ $order->id }}" class="form-control" rows="2" placeholder="Add dispatch notes...">{{ $order->dispatch_log }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success">
                          <i class="bi bi-check-circle me-1"></i>Verify & Update
                        </button>
                      </form>
                    </div>
                  @elseif($order->status === 'approved')
                    <span class="status-badge approved">
                      <i class="bi bi-check-circle me-1"></i>Approved
                    </span>
                  @elseif($order->status === 'rejected')
                    <span class="status-badge rejected">
                      <i class="bi bi-x-circle me-1"></i>Rejected
                    </span>
                  @else
                    <span class="status-badge">{{ ucfirst($order->status) }}</span>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div class="empty-state">
          <i class="bi bi-inbox"></i>
          <h5>No Customer Orders Found</h5>
          <p>Customer orders will appear here when they place orders that need verification.</p>
        </div>
      @endif
    </div>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

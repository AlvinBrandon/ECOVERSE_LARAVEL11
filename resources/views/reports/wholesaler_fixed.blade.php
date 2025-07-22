@extends('layouts.app')

@section('content')
<style>
  /* Modern Professional Wholesaler Reports Styling */
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

  /* Analytics Cards */
  .analytics-section {
    margin-bottom: 2rem;
  }

  .analytics-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    text-align: center;
    transition: all 0.2s ease;
    border: none;
    height: 100%;
  }

  .analytics-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
  }

  .analytics-card.pending {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
  }

  .analytics-card.approved {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    color: #166534;
  }

  .analytics-card.rejected {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
  }

  .analytics-value {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    line-height: 1;
  }

  .analytics-label {
    font-size: 0.875rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    opacity: 0.8;
  }

  .analytics-icon {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    opacity: 0.7;
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

  .table-card .card-header {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 1.25rem 1.5rem;
    border: none;
    margin: 0;
  }

  .table-card .card-header h6 {
    margin: 0;
    font-weight: 600;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
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

  /* Action Forms */
  .action-form {
    background: #f8fafc;
    padding: 1rem;
    border-radius: 0.5rem;
    margin-bottom: 0.5rem;
    border: 1px solid #e5e7eb;
  }

  .action-form .form-label {
    font-weight: 500;
    color: #374151;
    font-size: 0.75rem;
    margin-bottom: 0.25rem;
  }

  .action-form .form-control {
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.75rem;
    transition: all 0.2s ease;
  }

  .action-form .form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  }

  .action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
  }

  .action-buttons .btn {
    border-radius: 0.375rem;
    padding: 0.5rem 1rem;
    font-weight: 500;
    font-size: 0.75rem;
    transition: all 0.2s ease;
  }

  .action-buttons .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
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

  .unit-label {
    color: #3b82f6;
    font-weight: 500;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-left: 0.25rem;
  }

  /* Date Styling */
  .order-date {
    color: #6b7280;
    font-size: 0.8rem;
  }

  /* Retailer Name Styling */
  .retailer-name {
    font-weight: 500;
    color: #1f2937;
  }

  /* Order ID Styling */
  .order-id {
    font-family: 'Monaco', 'Consolas', monospace;
    background: #f3f4f6;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.8rem;
    color: #374151;
    font-weight: 500;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .page-header {
      padding: 1.5rem;
    }

    .page-header h4 {
      font-size: 1.25rem;
    }

    .analytics-card {
      padding: 1rem;
    }

    .analytics-value {
      font-size: 2rem;
    }

    .modern-table thead th,
    .modern-table tbody td {
      padding: 1rem;
      font-size: 0.8rem;
    }

    .action-form {
      padding: 0.75rem;
    }

    .action-buttons {
      flex-direction: column;
    }

    .action-buttons .btn {
      width: 100%;
    }
  }

  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: #6b7280;
  }

  .empty-state i {
    font-size: 3rem;
    color: #d1d5db;
    margin-bottom: 1rem;
  }

  .empty-state h5 {
    color: #374151;
    margin-bottom: 0.5rem;
    font-weight: 600;
  }

  .empty-state p {
    margin: 0;
    font-size: 0.875rem;
  }
</style>

<div class="container-fluid py-4">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h4><i class="bi bi-bar-chart-line me-2"></i>Wholesaler Analytics & Retailer Orders</h4>
        <p class="mb-0 opacity-75">Track retailer orders and view your analytics in style</p>
      </div>
      <a href="{{ route('dashboard') }}" class="btn">
        <i class="bi bi-house-door me-1"></i>Home
      </a>
    </div>
  </div>

  <!-- Analytics Section -->
  <div class="analytics-section">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="analytics-card pending">
          <div class="analytics-icon">
            <i class="bi bi-clock-fill"></i>
          </div>
          <div class="analytics-value">{{ $orders->where('status', 'pending')->count() }}</div>
          <div class="analytics-label">Pending Orders</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="analytics-card approved">
          <div class="analytics-icon">
            <i class="bi bi-check-circle-fill"></i>
          </div>
          <div class="analytics-value">{{ $orders->where('status', 'approved')->count() }}</div>
          <div class="analytics-label">Approved Orders</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="analytics-card rejected">
          <div class="analytics-icon">
            <i class="bi bi-x-circle-fill"></i>
          </div>
          <div class="analytics-value">{{ $orders->where('status', 'rejected')->count() }}</div>
          <div class="analytics-label">Rejected Orders</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Orders Table -->
  <div class="card table-card">
    <div class="card-header">
      <h6><i class="bi bi-clipboard-check"></i>Retailer Orders Pending Verification</h6>
    </div>
    <div class="card-body">
      @if($orders->count())
        <div class="table-responsive">
          <table class="table modern-table">
            <thead>
              <tr>
                <th><i class="bi bi-hash"></i>Order ID</th>
                <th><i class="bi bi-cube"></i>Product</th>
                <th><i class="bi bi-person"></i>Retailer</th>
                <th><i class="bi bi-123"></i>Quantity</th>
                <th><i class="bi bi-calendar"></i>Date</th>
                <th><i class="bi bi-clipboard-check"></i>Status</th>
                <th><i class="bi bi-gear"></i>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($orders as $order)
              <tr>
                <td>
                  <span class="order-id">#{{ $order->id }}</span>
                </td>
                <td>
                  <span class="product-name">{{ $order->product->name ?? '-' }}</span>
                </td>
                <td>
                  <span class="retailer-name">{{ $order->user->name ?? '-' }}</span>
                </td>
                <td>
                  <span class="quantity">{{ $order->quantity }}</span><span class="unit-label">pcs</span>
                </td>
                <td>
                  <span class="order-date">{{ $order->created_at->format('M d, Y H:i') }}</span>
                </td>
                <td>
                  <span class="status-badge {{ strtolower($order->status) }}">
                    {{ ucfirst($order->status) }}
                  </span>
                </td>
                <td>
                  @if($order->status === 'pending')
                    <div class="action-form">
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
                          <textarea name="dispatch_log" id="dispatch_log_{{ $order->id }}" class="form-control" rows="2" placeholder="Enter dispatch notes">{{ $order->dispatch_log }}</textarea>
                        </div>
                        <div class="action-buttons">
                          <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i>Verify & Update
                          </button>
                        </div>
                      </form>
                      <form action="{{ route('orders.reject', $order->id) }}" method="POST" class="mt-2">
                        @csrf
                        <div class="action-buttons">
                          <button type="submit" class="btn btn-danger">
                            <i class="bi bi-x-circle me-1"></i>Reject
                          </button>
                        </div>
                      </form>
                    </div>
                  @else
                    <span class="text-muted">-</span>
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
          <h5>No Retailer Orders Found</h5>
          <p>No retailer orders to show at this time.</p>
        </div>
      @endif
    </div>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

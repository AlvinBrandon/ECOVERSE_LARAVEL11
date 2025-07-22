@extends('layouts.app')

@section('title', 'Retailer Network - Wholesaler Dashboard')

@push('styles')
<style>
  /* Modern Professional Retailer Network Styling */
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

  /* Summary Cards */
  .summary-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    border: none;
    transition: all 0.2s ease;
  }

  .summary-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
  }

  .summary-card .card-body {
    padding: 0;
  }

  .summary-card .bg-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
  }

  .summary-card .bg-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
  }

  .summary-card .bg-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
  }

  .summary-card .bg-info {
    background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
  }

  /* Filter Section */
  .filter-section {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    border: none;
  }

  .filter-section .form-label {
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
  }

  .filter-section .form-control,
  .filter-section .form-select {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
  }

  .filter-section .form-control:focus,
  .filter-section .form-select:focus {
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

  .table-card .card-header {
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
    padding: 1.25rem 1.5rem;
  }

  .table-card .card-body {
    padding: 0;
  }

  .table-card .card-footer {
    background: #f8fafc;
    border-top: 1px solid #e5e7eb;
    padding: 1rem 1.5rem;
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

  .status-badge.delivered, .status-badge.completed, .status-badge.approved {
    background: #dcfce7;
    color: #166534;
  }

  .status-badge.pending {
    background: #fef3c7;
    color: #92400e;
  }

  .status-badge.processing {
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

  /* Action Buttons */
  .btn-group .btn {
    border-radius: 0.375rem;
    font-size: 0.8rem;
    padding: 0.375rem 0.75rem;
    transition: all 0.2s ease;
  }

  .btn-group .btn:hover {
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

  /* Pagination */
  .pagination-wrapper .pagination .page-link {
    font-size: 14px !important;
    padding: 0.375rem 0.75rem !important;
    line-height: 1.5 !important;
    min-height: 38px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    border: 1px solid #e5e7eb;
    color: #6b7280;
    transition: all 0.2s;
    border-radius: 0.375rem;
    margin: 0 0.125rem;
  }

  .pagination-wrapper .pagination .page-link:hover {
    background-color: #f3f4f6;
    border-color: #d1d5db;
    color: #374151;
    transform: translateY(-1px);
  }

  .pagination-wrapper .pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    border-color: #3b82f6;
    color: white;
  }

  .pagination-wrapper .pagination .page-link svg {
    width: 16px !important;
    height: 16px !important;
    max-width: 16px !important;
    max-height: 16px !important;
  }

  /* Modal Enhancements */
  .modal-content {
    border-radius: 1rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    border: none;
  }

  .modal-header {
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
    border-radius: 1rem 1rem 0 0;
    padding: 1.25rem 1.5rem;
  }

  .modal-footer {
    background: #f8fafc;
    border-top: 1px solid #e5e7eb;
    border-radius: 0 0 1rem 1rem;
    padding: 1.25rem 1.5rem;
  }

  /* Form Controls in Modals */
  .modal .form-control,
  .modal .form-select {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    transition: all 0.2s ease;
  }

  .modal .form-control:focus,
  .modal .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  }

  /* Button Enhancements */
  .btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    border: none;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
    transform: translateY(-2px);
  }

  .btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .btn-success:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    transform: translateY(-2px);
  }

  .btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    border: none;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .btn-danger:hover {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
    transform: translateY(-2px);
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .page-header {
      padding: 1.5rem;
    }

    .page-header h2 {
      font-size: 1.25rem;
    }

    .filter-section,
    .summary-card {
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
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h2><i class="bi bi-people me-2"></i>Retailer Network</h2>
                <p class="mb-0 opacity-75">Monitor and verify retailer purchases from your products</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn" data-bs-toggle="modal" data-bs-target="#networkStatsModal">
                    <i class="bi bi-graph-up me-1"></i>View Analytics
                </button>
                <a href="{{ route('dashboard') }}" class="btn">
                    <i class="bi bi-house-door me-1"></i>Home
                </a>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card summary-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="bi bi-cart text-primary fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Orders</h6>
                            <h4 class="mb-0">{{ number_format($totalOrders) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card summary-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="bi bi-currency-dollar text-success fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Revenue</h6>
                            <h4 class="mb-0">UGX {{ number_format($totalRevenue) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card summary-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="bi bi-clock text-warning fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Pending Orders</h6>
                            <h4 class="mb-0">{{ number_format($pendingOrders) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card summary-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="bi bi-check-circle text-info fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Approved Orders</h6>
                            <h4 class="mb-0">{{ number_format($approvedOrders) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" action="{{ route('wholesaler.retailer-network') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="all" {{ $status == 'all' ? 'selected' : '' }}>All Orders</option>
                    <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ $status == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Retailer</label>
                <select name="retailer" class="form-select" onchange="this.form.submit()">
                    <option value="all" {{ $retailer == 'all' ? 'selected' : '' }}>All Retailers</option>
                    @foreach($retailers as $ret)
                        <option value="{{ $ret->id }}" {{ $retailer == $ret->id ? 'selected' : '' }}>
                            {{ $ret->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Date Range</label>
                <select name="date_range" class="form-select" onchange="this.form.submit()">
                    <option value="7" {{ $dateRange == '7' ? 'selected' : '' }}>Last 7 days</option>
                    <option value="30" {{ $dateRange == '30' ? 'selected' : '' }}>Last 30 days</option>
                    <option value="90" {{ $dateRange == '90' ? 'selected' : '' }}>Last 90 days</option>
                    <option value="365" {{ $dateRange == '365' ? 'selected' : '' }}>Last year</option>
                </select>
            </div>
            <div class="col-md-3 d-grid">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bulkVerifyModal">
                    <i class="bi bi-check2-all me-1"></i>Bulk Verify
                </button>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="card table-card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-table me-2"></i>Retailer Purchase Orders</h5>
                <div>
                    <input type="checkbox" id="selectAll" class="form-check-input me-2">
                    <label for="selectAll" class="form-check-label">Select All</label>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($retailerOrders->count() > 0)
                <div class="table-responsive">
                    <table class="table modern-table mb-0">
                        <thead>
                            <tr>
                                <th width="40"><input type="checkbox" id="selectAllTable" class="form-check-input"></th>
                                <th><i class="bi bi-hash me-1"></i>Order ID</th>
                                <th><i class="bi bi-person me-1"></i>Retailer</th>
                                <th><i class="bi bi-box me-1"></i>Product</th>
                                <th><i class="bi bi-123 me-1"></i>Quantity</th>
                                <th><i class="bi bi-currency-dollar me-1"></i>Unit Price</th>
                                <th><i class="bi bi-calculator me-1"></i>Total</th>
                                <th><i class="bi bi-clipboard-check me-1"></i>Status</th>
                                <th><i class="bi bi-calendar me-1"></i>Date</th>
                                <th><i class="bi bi-gear me-1"></i>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($retailerOrders as $order)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input order-checkbox" 
                                               value="{{ $order->id }}" 
                                               {{ $order->status == 'pending' ? '' : 'disabled' }}>
                                    </td>
                                    <td>
                                        <strong>#{{ $order->id }}</strong>
                                        @if($order->tracking_code)
                                            <br><small class="text-muted">{{ $order->tracking_code }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <span class="product-name">{{ $order->retailer_name }}</span>
                                            <br><small class="text-muted">{{ $order->retailer_email }}</small>
                                            @if($order->retailer_phone)
                                                <br><small class="text-muted">{{ $order->retailer_phone }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="product-name">{{ $order->product_name }}</span>
                                    </td>
                                    <td>
                                        <span class="quantity">{{ $order->quantity }}</span>
                                    </td>
                                    <td>
                                        UGX {{ number_format($order->wholesale_price ?? $order->price) }}
                                    </td>
                                    <td>
                                        <strong>UGX {{ number_format($order->quantity * ($order->wholesale_price ?? $order->price)) }}</strong>
                                    </td>
                                    <td>
                                        <span class="status-badge {{ strtolower($order->status) }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                        
                                        @if($order->delivery_status)
                                            <br><small class="text-muted">{{ ucfirst($order->delivery_status) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="order-date">{{ $order->created_at->format('M d, Y H:i') }}</span>
                                    </td>
                                    <td>
                                        @if($order->status == 'pending')
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-success" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#verifyModal{{ $order->id }}">
                                                    <i class="bi bi-check"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#rejectModal{{ $order->id }}">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-sm btn-outline-secondary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#orderDetailsModal{{ $order->id }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $retailerOrders->firstItem() ?? 0 }} to {{ $retailerOrders->lastItem() ?? 0 }} of {{ $retailerOrders->total() }} results
                        </div>
                        <div class="pagination-wrapper">
                            {{ $retailerOrders->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h5>No retailer orders found</h5>
                    <p>Orders from retailers will appear here when they make purchases.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Verify Order Modals -->
@foreach($retailerOrders as $order)
    @if($order->status == 'pending')
        <!-- Verify Modal -->
        <div class="modal fade" id="verifyModal{{ $order->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('wholesaler.retailer-network.verify', $order->id) }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Verify Order #{{ $order->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <strong>Retailer:</strong> {{ $order->retailer_name }}<br>
                                <strong>Product:</strong> {{ $order->product_name }}<br>
                                <strong>Quantity:</strong> {{ $order->quantity }}<br>
                                <strong>Total:</strong> UGX {{ number_format($order->quantity * ($order->wholesale_price ?? $order->price)) }}
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Delivery Status</label>
                                <select name="delivery_status" class="form-select" required>
                                    <option value="pending">Order Confirmed - Preparing</option>
                                    <option value="dispatched">Dispatched for Delivery</option>
                                    <option value="pickup_arranged">Ready for Pickup</option>
                                    <option value="delivered">Delivered</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Tracking Code (Optional)</label>
                                <input type="text" name="tracking_code" class="form-control" 
                                       placeholder="Leave empty for auto-generated">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Verification Notes</label>
                                <textarea name="verification_notes" class="form-control" rows="3" 
                                          placeholder="Add any notes about this order..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Verify Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Reject Modal -->
        <div class="modal fade" id="rejectModal{{ $order->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('wholesaler.retailer-network.reject', $order->id) }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Reject Order #{{ $order->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <strong>Retailer:</strong> {{ $order->retailer_name }}<br>
                                <strong>Product:</strong> {{ $order->product_name }}<br>
                                <strong>Quantity:</strong> {{ $order->quantity }}
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                                <textarea name="rejection_reason" class="form-control" rows="3" 
                                          placeholder="Please provide a reason for rejecting this order..." required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Reject Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Order Details Modal -->
    <div class="modal fade" id="orderDetailsModal{{ $order->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Details #{{ $order->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Order Information</h6>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $order->status == 'approved' ? 'success' : ($order->status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                            <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                            <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
                            <p><strong>Total Amount:</strong> UGX {{ number_format($order->quantity * ($order->wholesale_price ?? $order->price)) }}</p>
                            @if($order->tracking_code)
                                <p><strong>Tracking Code:</strong> {{ $order->tracking_code }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6>Retailer Information</h6>
                            <p><strong>Name:</strong> {{ $order->retailer_name }}</p>
                            <p><strong>Email:</strong> {{ $order->retailer_email }}</p>
                            @if($order->retailer_phone)
                                <p><strong>Phone:</strong> {{ $order->retailer_phone }}</p>
                            @endif
                        </div>
                    </div>
                    @if($order->dispatch_log)
                        <div class="mt-3">
                            <h6>Order Notes</h6>
                            <div class="bg-light p-3 rounded">
                                {{ $order->dispatch_log }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Bulk Verify Modal -->
<div class="modal fade" id="bulkVerifyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('wholesaler.retailer-network.bulk-verify') }}" id="bulkVerifyForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Bulk Verify Orders</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="selectedOrdersList"></div>
                    
                    <div class="mb-3">
                        <label class="form-label">Delivery Status for All</label>
                        <select name="bulk_delivery_status" class="form-select" required>
                            <option value="pending">Order Confirmed - Preparing</option>
                            <option value="dispatched">Dispatched for Delivery</option>
                            <option value="pickup_arranged">Ready for Pickup</option>
                            <option value="delivered">Delivered</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Bulk Notes</label>
                        <textarea name="bulk_notes" class="form-control" rows="3" 
                                  placeholder="Add notes for all selected orders..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="bulkVerifyBtn" disabled>Verify Selected Orders</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Network Analytics Modal -->
<div class="modal fade" id="networkStatsModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Network Analytics</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Top Retailers -->
                    <div class="col-md-6 mb-4">
                        <h6>Top Retailers by Revenue</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Retailer</th>
                                        <th>Orders</th>
                                        <th>Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topRetailers as $retailer)
                                        <tr>
                                            <td>{{ $retailer->name }}</td>
                                            <td>{{ $retailer->total_orders }}</td>
                                            <td>UGX {{ number_format($retailer->total_revenue) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No data available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Monthly Trends Chart -->
                    <div class="col-md-6 mb-4">
                        <h6>Monthly Revenue Trend</h6>
                        <canvas id="monthlyTrendChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all functionality
    const selectAllMain = document.getElementById('selectAll');
    const selectAllTable = document.getElementById('selectAllTable');
    const orderCheckboxes = document.querySelectorAll('.order-checkbox');
    const bulkVerifyBtn = document.getElementById('bulkVerifyBtn');
    
    function updateBulkButton() {
        const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
        bulkVerifyBtn.disabled = checkedBoxes.length === 0;
        
        // Update selected orders list
        const selectedOrdersList = document.getElementById('selectedOrdersList');
        if (checkedBoxes.length > 0) {
            selectedOrdersList.innerHTML = `<div class="alert alert-info">
                <strong>${checkedBoxes.length} orders selected for bulk verification</strong>
            </div>`;
            
            // Add hidden inputs for selected order IDs
            document.querySelectorAll('input[name="order_ids[]"]').forEach(input => input.remove());
            checkedBoxes.forEach(checkbox => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'order_ids[]';
                hiddenInput.value = checkbox.value;
                document.getElementById('bulkVerifyForm').appendChild(hiddenInput);
            });
        } else {
            selectedOrdersList.innerHTML = '<div class="text-muted">No orders selected</div>';
        }
    }
    
    selectAllMain.addEventListener('change', function() {
        orderCheckboxes.forEach(checkbox => {
            if (!checkbox.disabled) {
                checkbox.checked = this.checked;
            }
        });
        selectAllTable.checked = this.checked;
        updateBulkButton();
    });
    
    selectAllTable.addEventListener('change', function() {
        orderCheckboxes.forEach(checkbox => {
            if (!checkbox.disabled) {
                checkbox.checked = this.checked;
            }
        });
        selectAllMain.checked = this.checked;
        updateBulkButton();
    });
    
    orderCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkButton);
    });
    
    // Monthly trend chart
    const monthlyData = @json($monthlyData);
    const ctx = document.getElementById('monthlyTrendChart').getContext('2d');
    
    const labels = monthlyData.map(item => {
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        return months[item.month - 1] + ' ' + item.year;
    });
    
    const revenueData = monthlyData.map(item => item.revenue);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue (UGX)',
                data: revenueData,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'UGX ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

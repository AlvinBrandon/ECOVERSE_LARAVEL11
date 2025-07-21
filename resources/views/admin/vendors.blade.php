@extends('layouts.app')

@section('title', 'Vendor Management - Admin Dashboard')

@section('content')
<style>
  /* Modern Professional Vendor Management Styling */
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

  .status-badge.delivered, .status-badge.completed, .status-badge.success, .status-badge.approved {
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

  .status-badge.dispatched, .status-badge.info {
    background: #e0e7ff;
    color: #3730a3;
  }

  .status-badge.cancelled, .status-badge.rejected, .status-badge.danger {
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

  .btn-success {
    background: #10b981;
    border: none;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .btn-success:hover {
    background: #059669;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
  }

  .btn-danger {
    background: #ef4444;
    border: none;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .btn-danger:hover {
    background: #dc2626;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
  }

  .btn-info {
    background: #3b82f6;
    border: none;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .btn-info:hover {
    background: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
  }

  /* Action buttons in table */
  .vendor-actions {
    display: flex;
    gap: 0.5rem;
  }

  .action-btn {
    padding: 0.375rem 0.75rem;
    border: none;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
  }

  .action-btn.approve {
    background: #10b981;
    color: white;
  }

  .action-btn.reject {
    background: #ef4444;
    color: white;
  }

  .action-btn.view {
    background: #3b82f6;
    color: white;
  }

  .action-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    color: white;
    text-decoration: none;
  }

  /* Stats cards */
  .stats-summary {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
  }

  .stats-item {
    text-align: center;
  }

  .stats-number {
    font-size: 2rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 0.25rem;
  }

  .stats-label {
    font-size: 0.875rem;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 500;
  }
</style>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h4><i class="bi bi-people-fill me-2"></i>Vendor Management</h4>
                <p class="mb-0 opacity-75">Manage vendor applications and approvals for your marketplace</p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn">
                <i class="bi bi-house-door me-1"></i>Home
            </a>
        </div>
    </div>

    <!-- Stats Summary -->
    <div class="stats-summary">
        <div class="row">
            <div class="col-md-4">
                <div class="stats-item">
                    <div class="stats-number text-warning">{{ $aspiringVendors->count() }}</div>
                    <div class="stats-label">Pending Requests</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-item">
                    <div class="stats-number text-success">{{ $approvedVendors->count() }}</div>
                    <div class="stats-label">Approved Vendors</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-item">
                    <div class="stats-number text-primary">{{ $aspiringVendors->count() + $approvedVendors->count() }}</div>
                    <div class="stats-label">Total Applications</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Vendor Requests Table -->
    <div class="card table-card mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3 px-3 pt-3">
                <h5 class="mb-0"><i class="bi bi-clock-history me-2 text-warning"></i>Aspiring Vendor Requests</h5>
            </div>
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th><i class="bi bi-person"></i>Name</th>
                            <th><i class="bi bi-envelope"></i>Email</th>
                            <th><i class="bi bi-tag"></i>Type</th>
                            <th><i class="bi bi-calendar"></i>Applied</th>
                            <th><i class="bi bi-gear"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($aspiringVendors as $vendor)
                            <tr>
                                <td>
                                    <span class="product-name">{{ $vendor->name }}</span>
                                </td>
                                <td>{{ $vendor->email }}</td>
                                <td>
                                    <span class="status-badge pending">{{ ucfirst($vendor->type) }}</span>
                                </td>
                                <td>
                                    <span class="order-date">{{ $vendor->created_at->format('M d, Y H:i') }}</span>
                                </td>
                                <td>
                                    <div class="vendor-actions">
                                        <button class="action-btn approve" onclick="approveVendor({{ $vendor->id }})">
                                            <i class="bi bi-check-lg"></i>Approve
                                        </button>
                                        <button class="action-btn reject" onclick="rejectVendor({{ $vendor->id }})">
                                            <i class="bi bi-x-lg"></i>Reject
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <h5>No Pending Requests</h5>
                                        <p>All vendor applications have been reviewed</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Approved Vendors Table -->
    <div class="card table-card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3 px-3 pt-3">
                <h5 class="mb-0"><i class="bi bi-check-circle me-2 text-success"></i>Approved Vendors</h5>
            </div>
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th><i class="bi bi-person"></i>Name</th>
                            <th><i class="bi bi-envelope"></i>Email</th>
                            <th><i class="bi bi-tag"></i>Type</th>
                            <th><i class="bi bi-calendar"></i>Approved</th>
                            <th><i class="bi bi-gear"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($approvedVendors as $vendor)
                            <tr>
                                <td>
                                    <span class="product-name">{{ $vendor->name }}</span>
                                </td>
                                <td>{{ $vendor->email }}</td>
                                <td>
                                    <span class="status-badge approved">{{ ucfirst($vendor->type) }}</span>
                                </td>
                                <td>
                                    <span class="order-date">{{ $vendor->updated_at->format('M d, Y H:i') }}</span>
                                </td>
                                <td>
                                    <div class="vendor-actions">
                                        <button class="action-btn view" onclick="viewVendor({{ $vendor->id }})">
                                            <i class="bi bi-eye"></i>View
                                        </button>
                                        <button class="action-btn reject" onclick="suspendVendor({{ $vendor->id }})">
                                            <i class="bi bi-pause"></i>Suspend
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="bi bi-shop"></i>
                                        <h5>No Approved Vendors</h5>
                                        <p>Approved vendors will appear here</p>
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

<script>
function approveVendor(vendorId) {
    if (confirm('Are you sure you want to approve this vendor?')) {
        // Add your approval logic here
        console.log('Approving vendor:', vendorId);
        // You can make an AJAX request to approve the vendor
        alert('Vendor approval functionality will be implemented');
    }
}

function rejectVendor(vendorId) {
    if (confirm('Are you sure you want to reject this vendor application?')) {
        // Add your rejection logic here
        console.log('Rejecting vendor:', vendorId);
        // You can make an AJAX request to reject the vendor
        alert('Vendor rejection functionality will be implemented');
    }
}

function viewVendor(vendorId) {
    // Add your view logic here
    console.log('Viewing vendor:', vendorId);
    // You can redirect to a vendor details page
    alert('Vendor view functionality will be implemented');
}

function suspendVendor(vendorId) {
    if (confirm('Are you sure you want to suspend this vendor?')) {
        // Add your suspension logic here
        console.log('Suspending vendor:', vendorId);
        // You can make an AJAX request to suspend the vendor
        alert('Vendor suspension functionality will be implemented');
    }
}
</script>
@endsection 
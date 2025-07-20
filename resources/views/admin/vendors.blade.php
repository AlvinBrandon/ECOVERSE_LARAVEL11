@extends('layouts.app')

@section('title', 'Vendor Management - Admin Dashboard')

@push('styles')
<style>
.vendor-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 30px rgba(102, 126, 234, 0.12);
}

.vendor-header h2 {
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.vendor-header p {
    font-weight: 400;
    opacity: 0.95;
    font-size: 1.1rem;
    margin-bottom: 0;
}

.vendor-card {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    padding: 0;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid rgba(255,255,255,0.3);
    transition: all 0.3s ease;
    height: 100%;
}

.vendor-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.vendor-card-header {
    border-radius: 1rem 1rem 0 0;
    border-bottom: 2px solid rgba(0,0,0,0.05);
    padding: 1.5rem 2rem;
    font-weight: 600;
    font-size: 1.15rem;
}

.vendor-card-header.pending {
    background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
    color: white;
}

.vendor-card-header.approved {
    background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
    color: white;
}

.vendor-card-header.rejected {
    background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    color: white;
}

.vendor-card-body {
    padding: 0;
}

.vendor-table {
    margin-bottom: 0;
}

.vendor-table thead th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    color: #495057;
    padding: 1rem 1.5rem;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.vendor-table tbody td {
    padding: 1rem 1.5rem;
    vertical-align: middle;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    color: #495057;
}

.vendor-table tbody tr:hover {
    background-color: rgba(102, 126, 234, 0.02);
}

.vendor-table tbody tr:last-child td {
    border-bottom: none;
}

.status-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 0.5rem;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge.pending {
    background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
    color: white;
}

.status-badge.approved {
    background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
    color: white;
}

.status-badge.rejected {
    background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    color: white;
}

.vendor-actions {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    padding: 0.4rem 0.8rem;
    border: none;
    border-radius: 0.5rem;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
}

.action-btn.approve {
    background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
    color: white;
}

.action-btn.reject {
    background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    color: white;
}

.action-btn.view {
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    color: white;
}

.action-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    color: white;
    text-decoration: none;
}

.empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: #6c757d;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state h5 {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.empty-state p {
    margin-bottom: 0;
    font-size: 0.95rem;
}

.stats-summary {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    padding: 1.5rem 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid rgba(255,255,255,0.3);
}

.stats-item {
    text-align: center;
}

.stats-number {
    font-size: 2rem;
    font-weight: 700;
    color: #495057;
    margin-bottom: 0.25rem;
}

.stats-label {
    font-size: 0.9rem;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
}

/* Responsive Design */
@media (max-width: 768px) {
    .vendor-header {
        padding: 1.5rem;
        text-align: center;
    }
    
    .vendor-header h2 {
        font-size: 1.5rem;
    }
    
    .vendor-card-header {
        padding: 1rem 1.5rem;
        font-size: 1rem;
    }
    
    .vendor-table thead th,
    .vendor-table tbody td {
        padding: 0.75rem 1rem;
        font-size: 0.85rem;
    }
    
    .vendor-actions {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .action-btn {
        font-size: 0.75rem;
        padding: 0.3rem 0.6rem;
    }
}

/* Bootstrap Icons */
.bi {
    vertical-align: -0.125em;
}
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="vendor-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-2">
                    <i class="bi bi-people-fill me-3"></i>Vendor Management
                </h2>
                <p class="mb-0">Manage vendor applications and approvals for your marketplace</p>
            </div>
            <div class="d-none d-md-block">
                <i class="bi bi-shop" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
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

    <!-- Vendor Management Cards -->
    <div class="row">
        <!-- Pending Vendor Requests -->
        <div class="col-lg-6 mb-4">
            <div class="vendor-card">
                <div class="vendor-card-header pending">
                    <i class="bi bi-clock-history me-2"></i>Aspiring Vendor Requests
                </div>
                <div class="vendor-card-body">
                    @if($aspiringVendors->count() > 0)
                        <div class="table-responsive">
                            <table class="table vendor-table">
                                <thead>
                                    <tr>
                                        <th><i class="bi bi-person me-1"></i>Name</th>
                                        <th><i class="bi bi-envelope me-1"></i>Email</th>
                                        <th><i class="bi bi-tag me-1"></i>Type</th>
                                        <th><i class="bi bi-calendar me-1"></i>Applied</th>
                                        <th><i class="bi bi-gear me-1"></i>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($aspiringVendors as $vendor)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-warning bg-opacity-10 p-2 rounded-circle me-2">
                                                        <i class="bi bi-person text-warning"></i>
                                                    </div>
                                                    <strong>{{ $vendor->name }}</strong>
                                                </div>
                                            </td>
                                            <td>{{ $vendor->email }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ ucfirst($vendor->type) }}</span>
                                            </td>
                                            <td>
                                                <small>{{ $vendor->created_at->format('M d, Y') }}</small>
                                                <br>
                                                <small class="text-muted">{{ $vendor->created_at->format('H:i') }}</small>
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <h5>No Pending Requests</h5>
                            <p>All vendor applications have been reviewed</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Approved Vendors -->
        <div class="col-lg-6 mb-4">
            <div class="vendor-card">
                <div class="vendor-card-header approved">
                    <i class="bi bi-check-circle me-2"></i>Approved Vendors
                </div>
                <div class="vendor-card-body">
                    @if($approvedVendors->count() > 0)
                        <div class="table-responsive">
                            <table class="table vendor-table">
                                <thead>
                                    <tr>
                                        <th><i class="bi bi-person me-1"></i>Name</th>
                                        <th><i class="bi bi-envelope me-1"></i>Email</th>
                                        <th><i class="bi bi-tag me-1"></i>Type</th>
                                        <th><i class="bi bi-calendar me-1"></i>Approved</th>
                                        <th><i class="bi bi-gear me-1"></i>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($approvedVendors as $vendor)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-success bg-opacity-10 p-2 rounded-circle me-2">
                                                        <i class="bi bi-person-check text-success"></i>
                                                    </div>
                                                    <strong>{{ $vendor->name }}</strong>
                                                </div>
                                            </td>
                                            <td>{{ $vendor->email }}</td>
                                            <td>
                                                <span class="badge bg-success">{{ ucfirst($vendor->type) }}</span>
                                            </td>
                                            <td>
                                                <small>{{ $vendor->updated_at->format('M d, Y') }}</small>
                                                <br>
                                                <small class="text-muted">{{ $vendor->updated_at->format('H:i') }}</small>
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-shop"></i>
                            <h5>No Approved Vendors</h5>
                            <p>Approved vendors will appear here</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
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
@endpush
@endsection 
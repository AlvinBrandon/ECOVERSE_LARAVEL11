@extends('layouts.app')

@section('title', 'Customer Orders Management')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h3 mb-0" style="color: #2563eb; font-weight: 700;">Customer Orders Management</h2>
                    <p class="text-muted mb-0">Review and manage customer orders for fulfillment</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; border: none;" onclick="refreshOrders()">
                        <i class="bi bi-arrow-clockwise me-1"></i>Refresh
                    </button>
                    <button class="btn btn-sm" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; border: none;" onclick="bulkApprove()">
                        <i class="bi bi-check-all me-1"></i>Bulk Approve
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Statistics -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-clock-fill fs-2"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $customerOrders->where('status', 'pending')->count() }}</h3>
                            <small>Pending Orders</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-check-circle-fill fs-2"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $customerOrders->where('status', 'approved')->count() }}</h3>
                            <small>Approved Orders</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-currency-dollar fs-2"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">UGX {{ number_format($customerOrders->sum('total_price')) }}</h3>
                            <small>Total Value</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0" style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color: white;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-bag-fill fs-2"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $customerOrders->count() }}</h3>
                            <small>Total Orders</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-sm filter-btn active" data-status="all" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; border: none;">
                                    <i class="bi bi-list-ul me-1"></i>All Orders
                                </button>
                                <button class="btn btn-sm filter-btn" data-status="pending" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white; border: none;">
                                    <i class="bi bi-clock me-1"></i>Pending
                                </button>
                                <button class="btn btn-sm filter-btn" data-status="approved" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; border: none;">
                                    <i class="bi bi-check-circle me-1"></i>Approved
                                </button>
                                <button class="btn btn-sm filter-btn" data-status="rejected" style="border: 1px solid #6c757d; color: #6c757d; background: white;">
                                    <i class="bi bi-x-circle me-1"></i>Rejected
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search orders..." id="orderSearch">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders List -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-bottom: 2px solid #dee2e6;">
                    <h5 class="mb-0" style="color: #495057; font-weight: 600;">Customer Orders</h5>
                </div>
                <div class="card-body p-0">
                    @if($customerOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                    <tr>
                                        <th style="border: none; padding: 15px; font-weight: 600; color: #495057;">
                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                        </th>
                                        <th style="border: none; padding: 15px; font-weight: 600; color: #495057;">Order ID</th>
                                        <th style="border: none; padding: 15px; font-weight: 600; color: #495057;">Customer</th>
                                        <th style="border: none; padding: 15px; font-weight: 600; color: #495057;">Product</th>
                                        <th style="border: none; padding: 15px; font-weight: 600; color: #495057;">Quantity</th>
                                        <th style="border: none; padding: 15px; font-weight: 600; color: #495057;">Total Amount</th>
                                        <th style="border: none; padding: 15px; font-weight: 600; color: #495057;">Status</th>
                                        <th style="border: none; padding: 15px; font-weight: 600; color: #495057;">Date</th>
                                        <th style="border: none; padding: 15px; font-weight: 600; color: #495057;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customerOrders as $order)
                                    <tr class="order-row" data-status="{{ $order->status }}" style="transition: all 0.3s ease;">
                                        <td style="padding: 15px; border: none; border-bottom: 1px solid #f1f3f4;">
                                            <input type="checkbox" class="form-check-input order-checkbox" value="{{ $order->id }}">
                                        </td>
                                        <td style="padding: 15px; border: none; border-bottom: 1px solid #f1f3f4;">
                                            <div class="d-flex align-items-center">
                                                <div class="order-id-badge" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 0.8rem;">
                                                    #{{ $order->order_number ?? 'ORD-' . str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 15px; border: none; border-bottom: 1px solid #f1f3f4;">
                                            <div>
                                                <div class="fw-semibold">{{ $order->user->name }}</div>
                                                <small class="text-muted">{{ $order->user->email }}</small>
                                            </div>
                                        </td>
                                        <td style="padding: 15px; border: none; border-bottom: 1px solid #f1f3f4;">
                                            <div>
                                                <div class="fw-semibold">{{ $order->product->name ?? 'Product not found' }}</div>
                                                <small class="text-muted">SKU: {{ $order->product->sku ?? 'N/A' }}</small>
                                            </div>
                                        </td>
                                        <td style="padding: 15px; border: none; border-bottom: 1px solid #f1f3f4;">
                                            <span class="badge bg-light text-dark">{{ $order->quantity }} units</span>
                                        </td>
                                        <td style="padding: 15px; border: none; border-bottom: 1px solid #f1f3f4;">
                                            <div class="fw-bold" style="color: #16a34a;">UGX {{ number_format($order->total_price) }}</div>
                                            <small class="text-muted">@ UGX {{ number_format($order->unit_price) }} each</small>
                                        </td>
                                        <td style="padding: 15px; border: none; border-bottom: 1px solid #f1f3f4;">
                                            @if($order->status === 'pending')
                                                <span class="badge" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white; padding: 6px 12px;">
                                                    <i class="bi bi-clock me-1"></i>Pending
                                                </span>
                                            @elseif($order->status === 'approved')
                                                <span class="badge" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; padding: 6px 12px;">
                                                    <i class="bi bi-check-circle me-1"></i>Approved
                                                </span>
                                            @elseif($order->status === 'rejected')
                                                <span class="badge bg-secondary">
                                                    <i class="bi bi-x-circle me-1"></i>Rejected
                                                </span>
                                            @else
                                                <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                                            @endif
                                        </td>
                                        <td style="padding: 15px; border: none; border-bottom: 1px solid #f1f3f4;">
                                            <div>{{ $order->created_at->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                        </td>
                                        <td style="padding: 15px; border: none; border-bottom: 1px solid #f1f3f4;">
                                            <div class="btn-group" role="group">
                                                @if($order->status === 'pending')
                                                    <button class="btn btn-sm" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; border: none;" onclick="approveOrder({{ $order->id }})">
                                                        <i class="bi bi-check me-1"></i>Approve
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="rejectOrder({{ $order->id }})">
                                                        <i class="bi bi-x me-1"></i>Reject
                                                    </button>
                                                @endif
                                                <button class="btn btn-sm btn-outline-info" onclick="viewOrderDetails({{ $order->id }})">
                                                    <i class="bi bi-eye me-1"></i>View
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center p-3" style="background: #f8f9fa;">
                            <div>
                                <small class="text-muted">
                                    Showing {{ $customerOrders->firstItem() }} to {{ $customerOrders->lastItem() }} of {{ $customerOrders->total() }} orders
                                </small>
                            </div>
                            <div>
                                {{ $customerOrders->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <h5 class="mt-3 text-muted">No Customer Orders Found</h5>
                            <p class="text-muted">Customer orders will appear here when they place orders.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.order-row:hover {
    background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(248,249,250,1) 100%) !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.filter-btn {
    transition: all 0.3s ease;
}

.filter-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}

.order-id-badge {
    transition: all 0.3s ease;
}

.order-row:hover .order-id-badge {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
}
</style>

<script>
// Filter functionality
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        const status = this.dataset.status;
        filterOrders(status);
    });
});

function filterOrders(status) {
    const rows = document.querySelectorAll('.order-row');
    
    rows.forEach(row => {
        if (status === 'all' || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Order management functions
function approveOrder(orderId) {
    if(confirm('Are you sure you want to approve this order?')) {
        fetch(`/retailer/orders/${orderId}/approve`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert('Error approving order');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error approving order');
        });
    }
}

function rejectOrder(orderId) {
    if(confirm('Are you sure you want to reject this order?')) {
        fetch(`/retailer/orders/${orderId}/reject`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert('Error rejecting order');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error rejecting order');
        });
    }
}

function viewOrderDetails(orderId) {
    // Redirect to order details page
    window.location.href = `/orders/${orderId}`;
}

function refreshOrders() {
    location.reload();
}

// Search functionality
document.getElementById('orderSearch').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('.order-row');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Select all functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.order-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

function bulkApprove() {
    const selected = document.querySelectorAll('.order-checkbox:checked');
    if (selected.length === 0) {
        alert('Please select orders to approve');
        return;
    }
    
    if(confirm(`Are you sure you want to approve ${selected.length} selected orders?`)) {
        const orderIds = Array.from(selected).map(cb => cb.value);
        
        // Implementation for bulk approval
        console.log('Bulk approving orders:', orderIds);
        // Add your bulk approval logic here
    }
}
</script>
@endsection

@extends('layouts.app')

@section('title', 'Retailer Network - Wholesaler Dashboard')

@push('styles')
<style>
/* Fix pagination arrow sizes */
.pagination-wrapper .pagination .page-link {
    font-size: 14px !important;
    padding: 0.375rem 0.75rem !important;
    line-height: 1.5 !important;
    min-height: 38px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}

.pagination-wrapper .pagination .page-link svg {
    width: 16px !important;
    height: 16px !important;
    max-width: 16px !important;
    max-height: 16px !important;
}

/* Ensure pagination is properly sized */
.pagination-wrapper .pagination {
    margin-bottom: 0 !important;
}

.pagination-wrapper .pagination .page-item {
    font-size: 14px !important;
}

/* Override any large arrow styles */
.pagination-wrapper svg,
.pagination-wrapper .page-link svg {
    width: 1rem !important;
    height: 1rem !important;
    stroke-width: 2 !important;
}

/* Custom pagination styling */
.pagination-wrapper .pagination .page-link {
    border: 1px solid #dee2e6;
    color: #6c757d;
    transition: all 0.2s;
}

.pagination-wrapper .pagination .page-link:hover {
    background-color: #e9ecef;
    border-color: #adb5bd;
    color: #495057;
}

.pagination-wrapper .pagination .page-item.active .page-link {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: white;
}
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-0">
                <i class="fas fa-store-alt me-2 text-primary"></i>
                Retailer Network
            </h2>
            <p class="text-muted mb-0">Monitor and verify retailer purchases from your products</p>
        </div>
        <div class="col-md-4 text-end">
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#networkStatsModal">
                <i class="fas fa-chart-bar me-1"></i> Network Analytics
            </button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="fas fa-shopping-cart text-primary fa-lg"></i>
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
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="fas fa-money-bill-wave text-success fa-lg"></i>
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
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="fas fa-clock text-warning fa-lg"></i>
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
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="fas fa-check-circle text-info fa-lg"></i>
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

    <!-- Filters and Bulk Actions -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pb-0">
            <form method="GET" action="{{ route('wholesaler.retailer-network') }}" class="row g-3">
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
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bulkVerifyModal">
                            <i class="fas fa-check-double me-1"></i> Bulk Verify
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Retailer Purchase Orders</h5>
                <div>
                    <input type="checkbox" id="selectAll" class="form-check-input me-2">
                    <label for="selectAll" class="form-check-label">Select All</label>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($retailerOrders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="40"><input type="checkbox" id="selectAllTable" class="form-check-input"></th>
                                <th>Order ID</th>
                                <th>Retailer</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
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
                                            <strong>{{ $order->retailer_name }}</strong>
                                            <br><small class="text-muted">{{ $order->retailer_email }}</small>
                                            @if($order->retailer_phone)
                                                <br><small class="text-muted">{{ $order->retailer_phone }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $order->product_name }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $order->quantity }}</span>
                                    </td>
                                    <td>
                                        UGX {{ number_format($order->wholesale_price ?? $order->price) }}
                                    </td>
                                    <td>
                                        <strong>UGX {{ number_format($order->quantity * ($order->wholesale_price ?? $order->price)) }}</strong>
                                    </td>
                                    <td>
                                        @switch($order->status)
                                            @case('pending')
                                                <span class="badge bg-warning">Pending</span>
                                                @break
                                            @case('approved')
                                                <span class="badge bg-success">Approved</span>
                                                @break
                                            @case('rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                        @endswitch
                                        
                                        @if($order->delivery_status)
                                            <br><small class="text-muted">{{ ucfirst($order->delivery_status) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $order->created_at->format('M d, Y') }}</small>
                                        <br><small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        @if($order->status == 'pending')
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-success" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#verifyModal{{ $order->id }}">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#rejectModal{{ $order->id }}">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-sm btn-outline-secondary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#orderDetailsModal{{ $order->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="card-footer bg-white">
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
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No retailer orders found</h5>
                    <p class="text-muted">Orders from retailers will appear here when they make purchases.</p>
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
@endsection

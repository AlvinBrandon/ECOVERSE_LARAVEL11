@extends('layouts.app')

@section('title', 'Customer Orders Management')

@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
  
  /* Modern Professional Customer Orders Styling */
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

  /* Filter Section */
  .filter-section {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
  }

  .filter-section .btn {
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.2s ease;
    border: none;
  }

  .filter-section .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
  }

  .filter-section .form-control {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    transition: all 0.2s ease;
  }

  .filter-section .form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
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

  /* Order ID Badge */
  .order-id-badge {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 0.8rem;
    transition: all 0.2s ease;
  }

  .order-id-badge:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
  }

  /* Action Buttons */
  .btn-action {
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.2s ease;
    border: none;
  }

  .btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
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
</style>

<div class="container-fluid py-4">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h2><i class="bi bi-clipboard-check me-2"></i>Customer Orders Management</h2>
        <p>Review and manage customer orders for fulfillment</p>
      </div>
      <div class="d-flex gap-2">
        <button class="btn" onclick="refreshOrders()">
          <i class="bi bi-arrow-clockwise me-1"></i>Refresh
        </button>
        <button class="btn" onclick="bulkApprove()">
          <i class="bi bi-check-all me-1"></i>Bulk Approve
        </button>
        <a href="{{ route('dashboard') }}" class="btn">
          <i class="bi bi-house-door me-1"></i>Home
        </a>
      </div>
    </div>
  </div>

  <!-- Order Statistics -->
  <div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
      <div class="stats-card" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white;">
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
    <div class="col-lg-3 col-md-6">
      <div class="stats-card" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white;">
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
    <div class="col-lg-3 col-md-6">
      <div class="stats-card" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">
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
    <div class="col-lg-3 col-md-6">
      <div class="stats-card" style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color: white;">
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

  <!-- Filters and Search -->
  <div class="filter-section">
    <div class="row align-items-center">
      <div class="col-md-8">
        <div class="d-flex flex-wrap gap-2">
          <button class="btn filter-btn active" data-status="all" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">
            <i class="bi bi-list-ul me-1"></i>All Orders
          </button>
          <button class="btn filter-btn" data-status="pending" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white;">
            <i class="bi bi-clock me-1"></i>Pending
          </button>
          <button class="btn filter-btn" data-status="approved" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white;">
            <i class="bi bi-check-circle me-1"></i>Approved
          </button>
          <button class="btn filter-btn" data-status="rejected" style="border: 1px solid #6c757d; color: #6c757d; background: white;">
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

  <!-- Orders Table -->
  <div class="table-card">
    <div class="card-header">
      <h5 class="mb-0" style="color: #495057; font-weight: 600;">Customer Orders</h5>
    </div>
    <div class="card-body">
      @if($customerOrders->count() > 0)
        <div class="table-responsive">
          <table class="table modern-table">
            <thead>
              <tr>
                <th>
                  <input type="checkbox" id="selectAll" class="form-check-input">
                </th>
                <th><i class="bi bi-hash me-1"></i>Order ID</th>
                <th><i class="bi bi-person me-1"></i>Customer</th>
                <th><i class="bi bi-cube me-1"></i>Product</th>
                <th><i class="bi bi-123 me-1"></i>Quantity</th>
                <th><i class="bi bi-currency-dollar me-1"></i>Total Amount</th>
                <th><i class="bi bi-clipboard-check me-1"></i>Status</th>
                <th><i class="bi bi-calendar me-1"></i>Date</th>
                <th><i class="bi bi-gear me-1"></i>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($customerOrders as $order)
              <tr class="order-row" data-status="{{ $order->status }}">
                <td>
                  <input type="checkbox" class="form-check-input order-checkbox" value="{{ $order->id }}">
                </td>
                <td>
                  <div class="order-id-badge">
                    #{{ $order->order_number ?? 'ORD-' . str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                  </div>
                </td>
                <td>
                  <div>
                    <div class="fw-semibold">{{ $order->user->name }}</div>
                    <small class="text-muted">{{ $order->user->email }}</small>
                  </div>
                </td>
                <td>
                  <div>
                    <div class="fw-semibold">{{ $order->product->name ?? 'Product not found' }}</div>
                    <small class="text-muted">SKU: {{ $order->product->sku ?? 'N/A' }}</small>
                  </div>
                </td>
                <td>
                  <span class="badge bg-light text-dark">{{ $order->quantity }} pcs</span>
                </td>
                <td>
                  <div class="fw-bold" style="color: #16a34a;">UGX {{ number_format($order->total_price) }}</div>
                  <small class="text-muted">@ UGX {{ number_format($order->unit_price) }} each</small>
                </td>
                <td>
                  @if($order->status === 'pending')
                    <span class="status-badge pending">
                      <i class="bi bi-clock me-1"></i>Pending
                    </span>
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
                <td>
                  <div>{{ $order->created_at->format('M d, Y') }}</div>
                  <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                </td>
                <td>
                  <div class="btn-group" role="group">
                    @if($order->status === 'pending')
                      <button class="btn btn-action" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white;" onclick="approveOrder({{ $order->id }})">
                        <i class="bi bi-check me-1"></i>Approve
                      </button>
                      <button class="btn btn-action btn-outline-danger" onclick="rejectOrder({{ $order->id }})">
                        <i class="bi bi-x me-1"></i>Reject
                      </button>
                    @endif
                    <button class="btn btn-action btn-outline-info" onclick="viewOrderDetails({{ $order->id }})">
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
        <div class="empty-state">
          <i class="bi bi-inbox"></i>
          <h5>No Customer Orders Found</h5>
          <p>Customer orders will appear here when they place orders.</p>
        </div>
      @endif
    </div>
  </div>
</div>

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
        fetch(`/retailer/customer-orders/verify/${orderId}`, {
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

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

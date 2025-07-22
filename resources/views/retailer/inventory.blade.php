@extends('layouts.app')

@section('title', 'Retailer Inventory Management')

@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
  
  /* Modern Professional Inventory Management Styling */
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

  .status-badge.critical {
    background: #fee2e2;
    color: #991b1b;
  }

  .status-badge.low {
    background: #fef3c7;
    color: #92400e;
  }

  .status-badge.good {
    background: #dcfce7;
    color: #166534;
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
        <h2><i class="bi bi-boxes me-2"></i>Inventory Management</h2>
        <p>Monitor stock levels and manage product availability ({{ $inventory->count() }} products)</p>
      </div>
      <div class="d-flex gap-2">
        <button class="btn" onclick="refreshInventory()">
          <i class="bi bi-arrow-clockwise me-1"></i>Refresh
        </button>
        <a href="{{ route('sales.index') }}" class="btn">
          <i class="bi bi-plus-circle me-1"></i>Order Products
        </a>
        <a href="{{ route('dashboard') }}" class="btn">
          <i class="bi bi-house-door me-1"></i>Home
        </a>
      </div>
    </div>
  </div>

  <!-- Inventory Statistics -->
  <!-- Note: Current Stock shows actual retailer inventory, not purchased-sold calculation -->
  <!-- This is because customer-to-retailer tracking may not be fully implemented -->
  <div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
      <div class="stats-card" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white;">
        <div class="d-flex align-items-center">
          <div class="me-3">
            <i class="bi bi-boxes fs-2"></i>
          </div>
          <div>
            <h3 class="mb-0">{{ $inventory->count() }}</h3>
            <small>Total Products</small>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      <div class="stats-card" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white;">
        <div class="d-flex align-items-center">
          <div class="me-3">
            <i class="bi bi-exclamation-triangle-fill fs-2"></i>
          </div>
          <div>
            <h3 class="mb-0">{{ $inventory->where('status', 'low')->count() }}</h3>
            <small>Low Stock Items</small>
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
            <h3 class="mb-0">UGX {{ number_format($inventory->sum(function($item) { return $item['quantity'] * $item['price']; })) }}</h3>
            <small>Total Value</small>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      <div class="stats-card" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: white;">
        <div class="d-flex align-items-center">
          <div class="me-3">
            <i class="bi bi-exclamation-circle-fill fs-2"></i>
          </div>
          <div>
            <h3 class="mb-0">{{ $inventory->where('status', 'critical')->count() }}</h3>
            <small>Critical Stock</small>
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
          <button class="btn filter-btn active" data-status="all" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white;">
            <i class="bi bi-boxes me-1"></i>All Items
          </button>
          <button class="btn filter-btn" data-status="low" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white;">
            <i class="bi bi-exclamation-triangle me-1"></i>Low Stock
          </button>
          <button class="btn filter-btn" data-status="critical" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: white;">
            <i class="bi bi-exclamation-circle me-1"></i>Critical
          </button>
          <button class="btn filter-btn" data-status="good" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">
            <i class="bi bi-check-circle me-1"></i>Good Stock
          </button>
        </div>
      </div>
      <div class="col-md-4">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search products..." id="inventorySearch">
          <button class="btn btn-outline-secondary" type="button">
            <i class="bi bi-search"></i>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Inventory List -->
  <div class="table-card">
    <div class="card-header">
      <h5 class="mb-0" style="color: #495057; font-weight: 600;">Product Inventory</h5>
    </div>
    <div class="card-body">
      @if($inventory->count() > 0)
        <div class="table-responsive">
          <table class="table modern-table">
            <thead>
              <tr>
                <th><i class="bi bi-cube me-1"></i>Product</th>
                <th><i class="bi bi-tag me-1"></i>SKU</th>
                <th><i class="bi bi-cart-plus me-1"></i>Purchased</th>
                <th><i class="bi bi-cart-dash me-1"></i>Sold</th>
                <th><i class="bi bi-123 me-1"></i>Current Stock</th>
                <th><i class="bi bi-currency-dollar me-1"></i>Unit Price</th>
                <th><i class="bi bi-cash-stack me-1"></i>Total Value</th>
                <th><i class="bi bi-clipboard-check me-1"></i>Status</th>
                <th><i class="bi bi-gear me-1"></i>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($inventory as $item)
              <tr class="inventory-row" data-status="{{ $item['status'] }}">
                <td>
                  <div class="d-flex align-items-center">
                    @if($item['product']->image)
                      <img src="/assets/img/products/{{ $item['product']->image }}" alt="{{ $item['product']->name }}" class="me-3" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                    @else
                      <div class="me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: #f1f3f4; border-radius: 8px;">
                        <i class="bi bi-box text-muted"></i>
                      </div>
                    @endif
                    <div>
                      <div class="fw-semibold">{{ $item['product']->name }}</div>
                      <small class="text-muted">{{ $item['product']->category ?? 'Uncategorized' }}</small>
                      @if($item['quantity'] > 0)
                        <div><span class="badge bg-success mt-1">✓ In Stock</span></div>
                      @else
                        <div><span class="badge bg-warning mt-1">⚡ Available to Order</span></div>
                      @endif
                    </div>
                  </div>
                </td>
                <td>
                  <span class="badge bg-light text-dark">{{ $item['product']->sku ?? 'N/A' }}</span>
                </td>
                <td>
                  <div class="text-primary fw-semibold">
                    <i class="bi bi-arrow-down-circle me-1"></i>{{ $item['purchased'] }} pcs
                  </div>
                  <small class="text-muted">From wholesalers</small>
                </td>
                <td>
                  <div class="text-warning fw-semibold">
                    <i class="bi bi-arrow-up-circle me-1"></i>{{ $item['sold'] }} pcs
                  </div>
                  <small class="text-muted">To customers</small>
                </td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="stock-indicator me-2" style="
                      width: 12px; 
                      height: 12px; 
                      border-radius: 50%;
                      background: {{ $item['status'] === 'critical' ? '#dc2626' : ($item['status'] === 'low' ? '#ea580c' : '#16a34a') }};
                    "></div>
                    <span class="fw-bold {{ $item['status'] === 'critical' ? 'text-danger' : ($item['status'] === 'low' ? 'text-warning' : 'text-success') }}">
                      {{ $item['quantity'] }} pcs
                    </span>
                  </div>
                  @if($item['status'] !== 'good')
                    <small class="text-muted">Min: 50 pcs</small>
                  @endif
                </td>
                <td>
                  <div class="fw-semibold">UGX {{ number_format($item['price']) }}</div>
                </td>
                <td>
                  <div class="fw-bold" style="color: #16a34a;">UGX {{ number_format($item['quantity'] * $item['price']) }}</div>
                </td>
                <td>
                  @if($item['status'] === 'critical')
                    <span class="status-badge critical">
                      <i class="bi bi-exclamation-circle me-1"></i>Critical
                    </span>
                  @elseif($item['status'] === 'low')
                    <span class="status-badge low">
                      <i class="bi bi-exclamation-triangle me-1"></i>Low Stock
                    </span>
                  @else
                    <span class="status-badge good">
                      <i class="bi bi-check-circle me-1"></i>Good Stock
                    </span>
                  @endif
                </td>
                <td>
                  <div>{{ $item['product']->updated_at->format('M d, Y') }}</div>
                  <small class="text-muted">{{ $item['product']->updated_at->format('h:i A') }}</small>
                </td>
                <td>
                  <div class="btn-group" role="group">
                    @if($item['status'] === 'critical')
                      <button class="btn btn-action" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: white;" onclick="urgentReorder('{{ $item['product']->id }}')">
                        <i class="bi bi-exclamation-circle me-1"></i>Urgent
                      </button>
                    @elseif($item['status'] === 'low')
                      <button class="btn btn-action" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white;" onclick="reorderProduct('{{ $item['product']->id }}')">
                        <i class="bi bi-cart-plus me-1"></i>Reorder
                      </button>
                    @else
                      <button class="btn btn-action btn-outline-info" onclick="viewProductDetails('{{ $item['product']->id }}')">
                        <i class="bi bi-eye me-1"></i>View
                      </button>
                    @endif
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
          <h5>No Inventory Items Found</h5>
          <p>Your inventory will appear here when you purchase products from wholesalers.</p>
          <a href="{{ route('sales.index') }}" class="btn btn-action" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; text-decoration: none;">
            <i class="bi bi-plus-circle me-2"></i>Order Products Now
          </a>
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
        filterInventory(status);
    });
});

function filterInventory(status) {
    const rows = document.querySelectorAll('.inventory-row');
    
    rows.forEach(row => {
        if (status === 'all' || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Inventory management functions
function reorderProduct(productId) {
    window.location.href = `/order/${productId}`;
}

function urgentReorder(productId) {
    if(confirm('This will create an urgent reorder request. Continue?')) {
        window.location.href = `/order/${productId}?urgent=true`;
    }
}

function viewProductDetails(productId) {
    window.location.href = `/products/${productId}`;
}

function refreshInventory() {
    location.reload();
}

// Search functionality
document.getElementById('inventorySearch').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('.inventory-row');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

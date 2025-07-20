@extends('layouts.app')

@section('title', 'Retailer Inventory Management')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h3 mb-0" style="color: #16a34a; font-weight: 700;">Inventory Management</h2>
                    <p class="text-muted mb-0">Monitor stock levels and manage product availability</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; border: none;" onclick="refreshInventory()">
                        <i class="bi bi-arrow-clockwise me-1"></i>Refresh
                    </button>
                    <a href="{{ route('sales.index') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; border: none; text-decoration: none;">
                        <i class="bi bi-plus-circle me-1"></i>Reorder Products
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Statistics -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white;">
                <div class="card-body">
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
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white;">
                <div class="card-body">
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
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">
                <div class="card-body">
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
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white;">
                <div class="card-body">
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
    </div>

    <!-- Filters and Search -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-sm filter-btn active" data-status="all" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; border: none;">
                                    <i class="bi bi-boxes me-1"></i>All Items
                                </button>
                                <button class="btn btn-sm filter-btn" data-status="low" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white; border: none;">
                                    <i class="bi bi-exclamation-triangle me-1"></i>Low Stock
                                </button>
                                <button class="btn btn-sm filter-btn" data-status="critical" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: white; border: none;">
                                    <i class="bi bi-exclamation-circle me-1"></i>Critical
                                </button>
                                <button class="btn btn-sm filter-btn" data-status="good" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; border: none;">
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
            </div>
        </div>
    </div>

    <!-- Inventory List -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-bottom: 2px solid #dee2e6;">
                    <h5 class="mb-0" style="color: #495057; font-weight: 600;">Product Inventory</h5>
                </div>
                <div class="card-body p-0">
                    @if($inventory->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                    <tr>
                                        <th style="border: none; padding: 15px; font-weight: 600; color: #495057;">Product</th>
                                        <th style="border: none; padding: 15px; font-weight: 600; color: #495057;">SKU</th>
                                        <th style="border: none; padding: 15px; font-weight: 600; color: #495057;">Current Stock</th>
                                        <th style="border: none; padding: 15px; font-weight: 600; color: #495057;">Unit Price</th>
                                        <th style="border: none; padding: 15px; font-weight: 600; color: #495057;">Total Value</th>
                                        <th style="border: none; padding: 15px; font-weight: 600; color: #495057;">Status</th>
                                        <th style="border: none; padding: 15px; font-weight: 600; color: #495057;">Last Updated</th>
                                        <th style="border: none; padding: 15px; font-weight: 600; color: #495057;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inventory as $item)
                                    <tr class="inventory-row" data-status="{{ $item['status'] }}" style="transition: all 0.3s ease;">
                                        <td style="padding: 15px; border: none; border-bottom: 1px solid #f1f3f4;">
                                            <div class="d-flex align-items-center">
                                                @if($item['product']->image)
                                                    <img src="{{ asset('storage/' . $item['product']->image) }}" alt="{{ $item['product']->name }}" class="me-3" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                                @else
                                                    <div class="me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #f1f3f4 0%, #e9ecef 100%); border-radius: 8px;">
                                                        <i class="bi bi-box text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-semibold">{{ $item['product']->name }}</div>
                                                    <small class="text-muted">{{ $item['product']->category ?? 'Uncategorized' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 15px; border: none; border-bottom: 1px solid #f1f3f4;">
                                            <span class="badge bg-light text-dark">{{ $item['product']->sku ?? 'N/A' }}</span>
                                        </td>
                                        <td style="padding: 15px; border: none; border-bottom: 1px solid #f1f3f4;">
                                            <div class="d-flex align-items-center">
                                                <div class="stock-indicator me-2" style="
                                                    width: 12px; 
                                                    height: 12px; 
                                                    border-radius: 50%;
                                                    background: {{ $item['status'] === 'critical' ? '#dc2626' : ($item['status'] === 'low' ? '#ea580c' : '#16a34a') }};
                                                "></div>
                                                <span class="fw-bold {{ $item['status'] === 'critical' ? 'text-danger' : ($item['status'] === 'low' ? 'text-warning' : 'text-success') }}">
                                                    {{ $item['quantity'] }} units
                                                </span>
                                            </div>
                                            @if($item['status'] !== 'good')
                                                <small class="text-muted">Min: 50 units</small>
                                            @endif
                                        </td>
                                        <td style="padding: 15px; border: none; border-bottom: 1px solid #f1f3f4;">
                                            <div class="fw-semibold">UGX {{ number_format($item['price']) }}</div>
                                        </td>
                                        <td style="padding: 15px; border: none; border-bottom: 1px solid #f1f3f4;">
                                            <div class="fw-bold" style="color: #16a34a;">UGX {{ number_format($item['quantity'] * $item['price']) }}</div>
                                        </td>
                                        <td style="padding: 15px; border: none; border-bottom: 1px solid #f1f3f4;">
                                            @if($item['status'] === 'critical')
                                                <span class="badge" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: white; padding: 6px 12px;">
                                                    <i class="bi bi-exclamation-circle me-1"></i>Critical
                                                </span>
                                            @elseif($item['status'] === 'low')
                                                <span class="badge" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white; padding: 6px 12px;">
                                                    <i class="bi bi-exclamation-triangle me-1"></i>Low Stock
                                                </span>
                                            @else
                                                <span class="badge" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; padding: 6px 12px;">
                                                    <i class="bi bi-check-circle me-1"></i>Good Stock
                                                </span>
                                            @endif
                                        </td>
                                        <td style="padding: 15px; border: none; border-bottom: 1px solid #f1f3f4;">
                                            <div>{{ $item['product']->updated_at->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ $item['product']->updated_at->format('h:i A') }}</small>
                                        </td>
                                        <td style="padding: 15px; border: none; border-bottom: 1px solid #f1f3f4;">
                                            <div class="btn-group" role="group">
                                                @if($item['status'] === 'critical')
                                                    <button class="btn btn-sm" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: white; border: none;" onclick="urgentReorder('{{ $item['product']->id }}')">
                                                        <i class="bi bi-exclamation-circle me-1"></i>Urgent
                                                    </button>
                                                @elseif($item['status'] === 'low')
                                                    <button class="btn btn-sm" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; border: none;" onclick="reorderProduct('{{ $item['product']->id }}')">
                                                        <i class="bi bi-plus-circle me-1"></i>Reorder
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-outline-success" disabled>
                                                        <i class="bi bi-check me-1"></i>Stocked
                                                    </button>
                                                @endif
                                                <button class="btn btn-sm btn-outline-info" onclick="viewProductDetails('{{ $item['product']->id }}')">
                                                    <i class="bi bi-eye me-1"></i>Details
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-boxes display-1 text-muted"></i>
                            <h5 class="mt-3 text-muted">No Inventory Items Found</h5>
                            <p class="text-muted">Your inventory will appear here when you purchase products from wholesalers.</p>
                            <a href="{{ route('sales.index') }}" class="btn" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; border: none; text-decoration: none;">
                                <i class="bi bi-plus-circle me-2"></i>Order Products Now
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.inventory-row:hover {
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

.stock-indicator {
    transition: all 0.3s ease;
}

.inventory-row:hover .stock-indicator {
    transform: scale(1.2);
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
}
</style>

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
    window.location.href = `/sales/create?product_id=${productId}`;
}

function urgentReorder(productId) {
    if(confirm('This will create an urgent reorder request. Continue?')) {
        window.location.href = `/sales/create?product_id=${productId}&urgent=true`;
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
@endsection

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Enhanced SCM Professional Header with Gradient Background -->
    <div class="scm-card mb-4 scm-fade-in" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
        <div class="scm-card-header" style="background: transparent; border: none;">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="scm-icon-wrapper me-3" style="background: rgba(255,255,255,0.2); color: white;">
                        <i class="bi bi-bag-check-fill"></i>
                    </div>
                    <div>
                        <h4 class="scm-card-title mb-1" style="color: white; font-weight: 600;">My Order History</h4>
                        <p class="scm-card-subtitle" style="color: rgba(255,255,255,0.9); margin-bottom: 0;">Track your orders, deliveries, and order status updates</p>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="scm-status-badge me-3" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3);">
                        <i class="bi bi-list-check me-1"></i>
                        {{ $orders->count() }} Total Orders
                    </div>
                    <div class="scm-status-badge" style="background: rgba(46, 204, 113, 0.2); color: white; border: 1px solid rgba(46, 204, 113, 0.5);">
                        <i class="bi bi-check-circle me-1"></i>
                        {{ $orders->where('status', 'verified')->count() }} Verified
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Quick Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="scm-metric-card scm-hover-lift" style="background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); color: white;">
                <div class="d-flex align-items-center">
                    <div class="scm-metric-icon" style="background: rgba(255,255,255,0.2); color: white;">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <h3 class="scm-metric-value" style="color: white;">{{ $orders->where('status', 'verified')->count() }}</h3>
                        <p class="scm-metric-label" style="color: rgba(255,255,255,0.9); margin-bottom: 0;">Verified Orders</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="scm-metric-card scm-hover-lift" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white;">
                <div class="d-flex align-items-center">
                    <div class="scm-metric-icon" style="background: rgba(255,255,255,0.2); color: white;">
                        <i class="bi bi-clock-fill"></i>
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <h3 class="scm-metric-value" style="color: white;">{{ $orders->where('status', 'pending')->count() }}</h3>
                        <p class="scm-metric-label" style="color: rgba(255,255,255,0.9); margin-bottom: 0;">Pending Orders</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="scm-metric-card scm-hover-lift" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white;">
                <div class="d-flex align-items-center">
                    <div class="scm-metric-icon" style="background: rgba(255,255,255,0.2); color: white;">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <h3 class="scm-metric-value" style="color: white;">UGX {{ number_format($orders->sum('total_price')) }}</h3>
                        <p class="scm-metric-label" style="color: rgba(255,255,255,0.9); margin-bottom: 0;">Total Value</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="scm-metric-card scm-hover-lift" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white;">
                <div class="d-flex align-items-center">
                    <div class="scm-metric-icon" style="background: rgba(255,255,255,0.2); color: white;">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <h3 class="scm-metric-value" style="color: white;">{{ $orders->where('status', 'rejected')->count() }}</h3>
                        <p class="scm-metric-label" style="color: rgba(255,255,255,0.9); margin-bottom: 0;">Rejected Orders</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Orders Overview with Better Visual Hierarchy -->
    <div class="scm-card scm-hover-lift" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <div class="scm-card-header" style="background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%); color: white; border-radius: 12px 12px 0 0;">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bi bi-receipt-cutoff me-3 fs-4"></i>
                    <div>
                        <h5 class="scm-card-title mb-0" style="color: white; font-weight: 600;">Detailed Order History</h5>
                        <small style="color: rgba(255,255,255,0.8);">All your orders with complete tracking information</small>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <button class="btn btn-outline-light btn-sm me-2">
                        <i class="bi bi-download me-1"></i>Export
                    </button>
                    <button class="btn btn-outline-light btn-sm">
                        <i class="bi bi-funnel me-1"></i>Filter
                    </button>
                </div>
            </div>
        </div>
        <div class="scm-card-body" style="padding: 0;">
            @forelse($orders as $order)
            <div class="enhanced-order-item p-4 border-bottom" style="
                background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(248,249,250,0.9) 100%);
                border-left: 5px solid 
                @if($order->status === 'verified') #2ecc71
                @elseif($order->status === 'pending') #f39c12
                @elseif($order->status === 'rejected') #e74c3c
                @else #95a5a6 @endif;
                transition: all 0.3s ease;
                margin-bottom: 0;">
                
                <div class="row align-items-center">
                    <!-- Order ID Section with Enhanced Design -->
                    <div class="col-md-2">
                        <div class="text-center order-id-section p-3 rounded-3" style="background: rgba(255,255,255,0.8); border: 2px dashed #e9ecef;">
                            <div class="scm-metric-value text-primary" style="font-size: 1.1rem; font-weight: 700;">#{{ $order->order_number ?? $order->id }}</div>
                            <small class="text-muted" style="font-weight: 500;">Order ID</small>
                        </div>
                    </div>
                    
                    <!-- Product Information with Enhanced Layout -->
                    <div class="col-md-3">
                        <div class="product-info">
                            <h6 class="mb-2" style="color: #2c3e50; font-weight: 600;">
                                <i class="bi bi-box-seam me-2 text-primary"></i>
                                {{ $order->product->name ?? 'Product' }}
                            </h6>
                            <div class="d-flex align-items-center mb-1">
                                <span class="badge bg-light text-dark me-2">
                                    <i class="bi bi-123 me-1"></i>
                                    Qty: {{ $order->quantity }}
                                </span>
                                <small class="text-muted">
                                    <i class="bi bi-currency-dollar me-1"></i>
                                    UGX {{ number_format($order->unit_price ?? 0) }} each
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total Amount with Prominent Display -->
                    <div class="col-md-2">
                        <div class="text-center amount-section p-3 rounded-3" style="background: linear-gradient(135deg, #e8f5e8 0%, #d4edda 100%);">
                            <div class="scm-metric-value text-success" style="font-size: 1.2rem; font-weight: 700;">UGX {{ number_format($order->total_price ?? 0) }}</div>
                            <small class="text-success" style="font-weight: 500;">Total Amount</small>
                            
                            @if($order->voucher_code && $order->discount_amount)
                                <div class="mt-2 pt-2 border-top">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="bi bi-tag-fill text-warning me-1" style="font-size: 0.8rem;"></i>
                                        <small class="text-warning fw-semibold">{{ $order->voucher_code }}</small>
                                    </div>
                                    <small class="text-muted d-block">Saved UGX {{ number_format($order->discount_amount) }}</small>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Enhanced Status Badge -->
                    <div class="col-md-2">
                        <div class="text-center">
                            <span class="status-badge px-4 py-2 rounded-pill fw-semibold text-white d-inline-flex align-items-center" style="
                                background: 
                                @if($order->status === 'verified') linear-gradient(135deg, #2ecc71 0%, #27ae60 100%)
                                @elseif($order->status === 'pending') linear-gradient(135deg, #f39c12 0%, #e67e22 100%)
                                @elseif($order->status === 'rejected') linear-gradient(135deg, #e74c3c 0%, #c0392b 100%)
                                @else linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%) @endif;
                                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                                text-transform: uppercase;
                                letter-spacing: 0.5px;
                                font-size: 0.85rem;">
                                <i class="bi bi-
                                    @if($order->status === 'verified') check-circle-fill
                                    @elseif($order->status === 'pending') clock-fill
                                    @elseif($order->status === 'rejected') x-circle-fill
                                    @else question-circle-fill @endif me-2"></i>
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Date and Time with Better Formatting -->
                    <div class="col-md-2">
                        <div class="text-center date-section">
                            <div class="fw-semibold text-dark" style="font-size: 1rem;">{{ $order->created_at->format('M d, Y') }}</div>
                            <small class="text-muted" style="font-weight: 500;">{{ $order->created_at->format('h:i A') }}</small>
                            <div class="mt-1">
                                <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Enhanced Action Menu -->
                    <div class="col-md-1">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle shadow-sm" type="button" data-bs-toggle="dropdown" style="border-radius: 8px;">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu shadow-lg" style="border: none; border-radius: 12px;">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2 text-primary"></i>View Details</a></li>
                                @if($order->status === 'verified')
                                <li><a class="dropdown-item" href="#"><i class="bi bi-truck me-2 text-success"></i>Track Delivery</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-download me-2 text-info"></i>Download Receipt</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Enhanced Delivery Address Section -->
                @if($order->address)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="delivery-address p-3 rounded-3" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border: 1px solid #dee2e6;">
                            <div class="d-flex align-items-center">
                                <div class="address-icon me-3 p-2 rounded-circle" style="background: #17a2b8; color: white;">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <div>
                                    <strong style="color: #2c3e50; font-weight: 600;">Delivery Address</strong>
                                    <div class="mt-1" style="color: #495057;">{{ $order->address }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @empty
            <!-- Enhanced Empty State -->
            <div class="text-center py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                <div class="empty-state-container">
                    <div class="scm-icon-wrapper mx-auto mb-4" style="width: 120px; height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <i class="bi bi-bag-x" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="text-dark mb-3" style="font-weight: 600;">No Orders Found</h4>
                    <p class="text-muted mb-4" style="font-size: 1.1rem; max-width: 400px; margin: 0 auto;">You haven't placed any orders yet. Start exploring our products and place your first order!</p>
                    <a href="{{ route('sales.index') }}" class="scm-btn scm-btn-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 12px 30px; font-weight: 600;">
                        <i class="bi bi-shop me-2"></i>Browse Products
                    </a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<style>
.enhanced-order-item {
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.enhanced-order-item:hover {
    background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(248,249,250,1) 100%) !important;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    transform: translateY(-3px);
}

.enhanced-order-item:hover::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    pointer-events: none;
}

.order-id-section, .amount-section, .date-section {
    transition: all 0.3s ease;
}

.enhanced-order-item:hover .order-id-section,
.enhanced-order-item:hover .amount-section {
    transform: scale(1.05);
}

.status-badge {
    transition: all 0.3s ease;
}

.enhanced-order-item:hover .status-badge {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(0,0,0,0.3) !important;
}

.delivery-address {
    transition: all 0.3s ease;
}

.enhanced-order-item:hover .delivery-address {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%) !important;
    border-color: #ced4da !important;
}

.scm-metric-card:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
}

.empty-state-container {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.scm-fade-in {
    animation: slideInDown 0.6s ease-out;
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endsection
@extends('layouts.app')

@section('content')
<!-- Customer Dashboard Top Bar -->
<div class="container-fluid py-2 bg-white border-bottom mb-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap">
        <!-- Logo/Brand -->
        <div class="d-flex align-items-center me-3">
            <span class="fw-bold fs-3 text-primary me-2">ECOVERSE</span>
        </div>
        <!-- Search Bar -->
        <form action="{{ route('products.index') }}" method="GET" class="flex-grow-1 mx-3" style="max-width: 500px;">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Search products, brands and categories" aria-label="Search">
                <button class="btn btn-primary px-4" type="submit">Search</button>
            </div>
        </form>
        <!-- User, Help, Cart -->
        <div class="d-flex align-items-center ms-3">
            <span class="me-4"><i class="fas fa-user me-1"></i> Hi, {{ auth()->user()->name ?? 'Customer' }}</span>
            <a href="{{ route('help') }}" class="text-decoration-none text-dark me-4" title="Help"><i class="fas fa-question-circle fa-lg"></i></a>
            <a href="{{ route('cart.index') }}" class="text-decoration-none text-dark position-relative" title="Cart">
                <i class="fas fa-shopping-cart fa-lg"></i>
                @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
                @if($cartCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.8rem;">{{ $cartCount }}</span>
                @endif
                <span class="ms-1">Cart</span>
            </a>
        </div>
    </div>
</div>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;">
                <i class="fas fa-user text-secondary fa-2x"></i>
            </div>
            <div>
                <h3 class="mb-0 fw-bold text-dark">Hello, {{ auth()->user()->name ?? 'Customer' }}</h3>
                <small class="text-muted">Welcome to Ecoverse</small>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="mb-0">
            @csrf
            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-sign-out-alt me-1"></i> Sign Out</button>
        </form>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <a href="{{ route('products.index') }}" class="text-decoration-none">
                <div class="card shadow border-0 h-100 quick-action-card bg-gradient-primary text-white text-center hover-shadow">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                        <i class="fas fa-box-open fa-2x mb-2"></i>
                        <h6 class="fw-bold mb-1">Shop Products</h6>
                        <span class="small">Browse and buy items</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="#" class="text-decoration-none">
                <div class="card shadow border-0 h-100 quick-action-card bg-gradient-info text-white text-center hover-shadow">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                        <i class="fas fa-shopping-bag fa-2x mb-2"></i>
                        <h6 class="fw-bold mb-1">Your Orders</h6>
                        <span class="small">Track, return, or buy again</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="#" class="text-decoration-none">
                <div class="card shadow border-0 h-100 quick-action-card bg-gradient-warning text-dark text-center hover-shadow">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                        <i class="fas fa-star fa-2x mb-2"></i>
                        <h6 class="fw-bold mb-1">Product Reviews</h6>
                        <span class="small">Review your purchases</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('chat.index') }}" class="text-decoration-none">
                <div class="card shadow border-0 h-100 quick-action-card bg-gradient-success text-white text-center hover-shadow">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                        <i class="fas fa-comments fa-2x mb-2"></i>
                        <h6 class="fw-bold mb-1">Chat Support</h6>
                        <span class="small">Get help or ask questions</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <a href="{{ route('vendor.apply') }}" class="text-decoration-none">
                <div class="card shadow border-0 h-100 quick-action-card bg-gradient-secondary text-white text-center hover-shadow">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                        <i class="fas fa-store fa-2x mb-2"></i>
                        <h6 class="fw-bold mb-1">Become a Vendor</h6>
                        <span class="small">Apply to become a vendor for bulk purchase.</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-light fw-bold">
                    <i class="fas fa-box me-2 text-primary"></i>Your Orders
                </div>
                <div class="card-body text-center text-muted">
                    <div class="py-4">
                        <i class="fas fa-box-open fa-3x mb-3"></i>
                        <h5 class="fw-bold">No orders yet</h5>
                        <p class="mb-0">When you place an order, it will appear here for easy tracking and management.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.quick-action-card {
    transition: box-shadow 0.2s, transform 0.2s;
}
.quick-action-card:hover {
    box-shadow: 0 0 24px 0 rgba(0,0,0,0.15) !important;
    transform: translateY(-4px) scale(1.03);
    z-index: 2;
}
</style>
@endsection 
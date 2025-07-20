<div class="customer-dashboard-container scm-container">
    <!-- ECOVERSE Customer Dashboard Title Banner -->
    <div class="alert alert-primary mb-4 d-flex align-items-center ecoverse-fade-in-up" style="background: var(--ecoverse-gradient-sunset); border: none; color: var(--ecoverse-white); font-weight: 700; font-size: 1.2rem; border-radius: var(--ecoverse-radius-xl); padding: 24px; box-shadow: var(--ecoverse-shadow-lg); backdrop-filter: blur(10px);">
      <i class="bi bi-person-circle me-3 fs-3" style="color: var(--ecoverse-white);"></i>
      <div>
        <strong style="text-transform: uppercase; letter-spacing: 1px;">ECOVERSE CUSTOMER DASHBOARD</strong>
        <div style="font-size: 0.9rem; opacity: 0.95; font-weight: 400; color: rgba(255,255,255,0.9);">Sustainable product ordering & eco-conscious account management</div>
      </div>
    </div>

    <!-- ECOVERSE Professional Customer Header -->
    <div class="scm-card mb-4 ecoverse-fade-in-up scm-hover-earth" style="animation-delay: 0.1s;">
        <div class="scm-card-header" style="background: var(--ecoverse-gradient-ocean); color: var(--ecoverse-white);">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="scm-icon-wrapper me-3" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px);">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <div>
                        <h4 class="scm-card-title mb-1" style="color: var(--ecoverse-white); font-weight: 700;">ECOVERSE Customer Portal</h4>
                        <p class="scm-card-subtitle" style="color: rgba(255,255,255,0.9);">Welcome back, {{ Auth::user()->name }} | Shop sustainable products, track eco-orders & manage your green supply chain</p>
                    </div>
                </div>
                <div class="scm-status-badge scm-floating-pulse" style="background: rgba(255,255,255,0.3); color: var(--ecoverse-white); border: 2px solid rgba(255,255,255,0.2); padding: 12px 20px; border-radius: var(--ecoverse-radius-full); backdrop-filter: blur(10px);">
                    <i class="bi bi-check-circle me-2"></i>
                    Eco-Account Active
                </div>
            </div>
        </div>
    </div>

    <!-- Debug Information -->
    @if(config('app.debug'))
        <div class="scm-alert scm-alert-info mb-3" style="animation-delay: 0.2s;">
            <strong>Debug:</strong> User ID: {{ auth()->id() }} | Total Orders: {{ $totalOrders ?? 'NULL' }} | Active Orders: {{ $activeOrders ?? 'NULL' }} | Total Spent: {{ $totalSpent ?? 'NULL' }}
        </div>
    @endif

    <!-- ECOVERSE Performance Metrics -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="scm-metric-card scm-hover-earth ecoverse-fade-in-up" style="background: var(--ecoverse-gradient-primary); color: var(--ecoverse-white); animation-delay: 0.1s;">
                <div class="d-flex align-items-center">
                    <div class="scm-metric-icon" style="background: rgba(255,255,255,0.2); color: var(--ecoverse-white); backdrop-filter: blur(10px);">
                        <i class="bi bi-bag-check-fill"></i>
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <h3 class="scm-metric-value" style="color: var(--ecoverse-white); background: linear-gradient(135deg, var(--ecoverse-white) 0%, var(--ecoverse-fawn-light) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">{{ $totalOrders ?? 0 }}</h3>
                        <p class="scm-metric-label" style="color: rgba(255,255,255,0.9);">Sustainable Orders</p>
                        <div class="scm-metric-trend positive" style="color: var(--ecoverse-fawn-light);">`
                            <i class="bi bi-arrow-up"></i>
                            <span>+12.3% Eco-Growth</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="scm-metric-card scm-hover-earth ecoverse-fade-in-up" style="background: var(--ecoverse-gradient-dark); color: var(--ecoverse-white); animation-delay: 0.2s;">
                <div class="d-flex align-items-center">
                    <div class="scm-metric-icon" style="background: rgba(255,255,255,0.2); color: var(--ecoverse-white); backdrop-filter: blur(10px);">
                        <i class="bi bi-clock-fill"></i>
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <h3 class="scm-metric-value" style="color: var(--ecoverse-white); background: linear-gradient(135deg, var(--ecoverse-white) 0%, var(--ecoverse-fawn-light) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">{{ $activeOrders ?? 0 }}</h3>
                        <p class="scm-metric-label" style="color: rgba(255,255,255,0.9);">Active Eco-Orders</p>
                        <div class="scm-metric-trend positive" style="color: var(--ecoverse-fawn-light);">
                            <i class="bi bi-arrow-up"></i>
                            <span>+5.7% Green Activity</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="scm-metric-card scm-hover-earth ecoverse-fade-in-up" style="background: var(--ecoverse-gradient-secondary); color: var(--ecoverse-white); animation-delay: 0.3s;">
                <div class="d-flex align-items-center">
                    <div class="scm-metric-icon" style="background: rgba(255,255,255,0.2); color: var(--ecoverse-white); backdrop-filter: blur(10px);">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <h3 class="scm-metric-value" style="color: var(--ecoverse-white); background: linear-gradient(135deg, var(--ecoverse-white) 0%, var(--ecoverse-fawn-light) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">UGX {{ number_format($totalSpent ?? 0) }}</h3>
                        <p class="scm-metric-label" style="color: rgba(255,255,255,0.9);">Sustainable Investment</p>
                        <div class="scm-metric-trend positive" style="color: var(--ecoverse-fawn-light);">
                            <i class="bi bi-arrow-up"></i>
                            <span>+18.9% Eco-Impact</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="scm-metric-card scm-hover-earth ecoverse-fade-in-up" style="background: var(--ecoverse-gradient-accent); color: var(--ecoverse-ateneo-blue); animation-delay: 0.4s;">
                <div class="d-flex align-items-center">
                    <div class="scm-metric-icon" style="background: rgba(7, 59, 109, 0.2); color: var(--ecoverse-ateneo-blue); backdrop-filter: blur(10px);">
                        <i class="bi bi-shop"></i>
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <h3 class="scm-metric-value" style="color: var(--ecoverse-ateneo-blue); background: linear-gradient(135deg, var(--ecoverse-ateneo-blue) 0%, var(--ecoverse-bistre) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Apply</h3>
                        <p class="scm-metric-label" style="color: var(--ecoverse-ateneo-blue); font-weight: 600;">Eco-Vendor Status</p>
                        <div class="scm-metric-trend neutral">
                            <i class="bi bi-arrow-right"></i>
                            <span>Available</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCM Main Action Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-lg-6">
            <div class="scm-card scm-hover-lift">
                <div class="scm-card-header bg-gradient-primary">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-cart-check-fill me-3 fs-4"></i>
                        <h5 class="scm-card-title mb-0">Product Catalog</h5>
                    </div>
                </div>
                <div class="scm-card-body">
                    <p class="scm-card-text mb-3">Browse and order recycled products from our comprehensive eco-friendly catalog</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <small class="text-muted">Available Products</small>
                        <span class="badge bg-primary">500+ Items</span>
                    </div>
                    <a href="{{ route('sales.index') }}" class="scm-btn scm-btn-primary w-100">
                        <i class="bi bi-bag-check me-2"></i>Shop Now
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-lg-6">
            <div class="scm-card scm-hover-lift">
                <div class="scm-card-header bg-gradient-success">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-truck me-3 fs-4"></i>
                        <h5 class="scm-card-title mb-0">Order Tracking</h5>
                    </div>
                </div>
                <div class="scm-card-body">
                    <p class="scm-card-text mb-3">Track your orders and delivery status with real-time updates and notifications</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <small class="text-muted">Active Deliveries</small>
                        <span class="badge bg-success">{{ $activeOrders ?? 0 }} Tracking</span>
                    </div>
                    <a href="{{ route('sales.status') }}" class="scm-btn scm-btn-success w-100">
                        <i class="bi bi-geo-alt me-2"></i>Track Orders
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-lg-6">
            <div class="scm-card scm-hover-lift">
                <div class="scm-card-header bg-gradient-info">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-chat-dots-fill me-3 fs-4"></i>
                        <h5 class="scm-card-title mb-0">Support Center</h5>
                    </div>
                </div>
                <div class="scm-card-body">
                    <p class="scm-card-text mb-3">Need help? Chat with our support team for immediate assistance and guidance</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <small class="text-muted">Support Status</small>
                        <span class="badge bg-success">Online</span>
                    </div>
                    <a href="{{ route('chat.index') }}" class="scm-btn scm-btn-info w-100">
                        <i class="bi bi-headset me-2"></i>Start Chat
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6">
            <div class="scm-card scm-hover-lift">
                <div class="scm-card-header bg-gradient-warning">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-shop me-3 fs-4"></i>
                        <h5 class="scm-card-title mb-0">Become a Vendor</h5>
                    </div>
                </div>
                <div class="scm-card-body">
                    <p class="scm-card-text mb-3">Apply to become a vendor for bulk purchases and expand your business opportunities</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <small class="text-muted">Application Status</small>
                        <span class="badge bg-warning">Available</span>
                    </div>
                    <a href="{{ route('vendor.apply') }}" class="scm-btn scm-btn-warning w-100">
                        <i class="bi bi-building me-2"></i>Apply Now
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6">
            <div class="scm-card scm-hover-lift">
                <div class="scm-card-header bg-gradient-secondary">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-clock-history me-3 fs-4"></i>
                        <h5 class="scm-card-title mb-0">Order History</h5>
                    </div>
                </div>
                <div class="scm-card-body">
                    <p class="scm-card-text mb-3">View your complete order history and download invoices for your records</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <small class="text-muted">Total Orders</small>
                        <span class="badge bg-secondary">{{ $totalOrders ?? 0 }} Orders</span>
                    </div>
                    <a href="{{ route('sales.history') }}" class="scm-btn scm-btn-secondary w-100">
                        <i class="bi bi-file-earmark-text me-2"></i>View History
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6">
            <div class="scm-card scm-hover-lift">
                <div class="scm-card-header bg-gradient-primary">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-gear me-3 fs-4"></i>
                        <h5 class="scm-card-title mb-0">Profile Settings</h5>
                    </div>
                </div>
                <div class="scm-card-body">
                    <p class="scm-card-text mb-3">Manage your account settings, preferences, and personal information</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <small class="text-muted">Profile Status</small>
                        <span class="badge bg-success">Complete</span>
                    </div>
                    <a href="{{ route('profile') }}" class="scm-btn scm-btn-primary w-100">
                        <i class="bi bi-gear me-2"></i>Manage Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- SCM Recent Orders Section -->
    <div class="row">
        <div class="col-12">
            <div class="scm-card scm-fade-in">
                <div class="scm-card-header bg-gradient-primary">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="scm-icon-wrapper me-3">
                                <i class="bi bi-bag-check-fill"></i>
                            </div>
                            <div>
                                <h5 class="scm-card-title mb-1">Recent Orders</h5>
                                <p class="scm-card-subtitle mb-0">Track your latest purchases and delivery status</p>
                            </div>
                        </div>
                        <a href="{{ route('sales.history') }}" class="scm-btn scm-btn-outline-light">
                            <i class="bi bi-arrow-right me-1"></i>View All Orders
                        </a>
                    </div>
                </div>
                <div class="scm-card-body">
                    <div class="scm-table-responsive">
                        @forelse($recentOrders ?? [] as $order)
                            <div class="scm-order-item d-flex justify-content-between align-items-center p-3 mb-3 border rounded-3">
                                <div class="d-flex align-items-center">
                                    <div class="scm-order-icon me-3">
                                        <i class="bi bi-box-seam"></i>
                                    </div>
                                    <div>
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="badge bg-secondary me-2">#{{ $order->order_number ?? $order->id }}</span>
                                            <strong class="text-dark">{{ $order->product_name ?? 'Product Order' }}</strong>
                                        </div>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar me-1"></i>
                                            {{ $order->created_at ? $order->created_at->format('M d, Y') : 'Recent' }}
                                        </small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="mb-2">
                                        <span class="badge bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'pending' ? 'warning' : 'info') }} fs-6">
                                            <i class="bi bi-{{ $order->status == 'delivered' ? 'check-circle' : ($order->status == 'pending' ? 'clock' : 'truck') }} me-1"></i>
                                            {{ ucfirst($order->status ?? 'Processing') }}
                                        </span>
                                    </div>
                                    <div class="fw-bold text-success">UGX {{ number_format($order->total_amount ?? 0) }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <div class="scm-empty-state">
                                    <i class="bi bi-bag-x display-1 text-muted"></i>
                                    <h5 class="mt-3 text-muted">No Recent Orders</h5>
                                    <p class="text-muted">Start shopping to see your orders here</p>
                                    <a href="{{ route('sales.index') }}" class="scm-btn scm-btn-primary">
                                        <i class="bi bi-cart-plus me-2"></i>Start Shopping
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCM Customer Analytics & Insights -->
<div class="row g-4 mb-4">
    <!-- Order Statistics -->
    <div class="col-xl-4 col-lg-6">
        <div class="scm-card scm-hover-lift h-100">
            <div class="scm-card-header bg-gradient-success">
                <div class="d-flex align-items-center">
                    <i class="bi bi-graph-up me-3 fs-4"></i>
                    <div>
                        <h5 class="scm-card-title mb-1">Order Statistics</h5>
                        <p class="scm-card-subtitle mb-0">Your activity overview</p>
                    </div>
                </div>
            </div>
            <div class="scm-card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="d-flex align-items-center p-3 bg-light rounded-3">
                            <div class="scm-metric-icon bg-success me-3">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $completedOrders ?? 0 }}</h6>
                                <small class="text-muted">Completed Orders</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex align-items-center p-3 bg-light rounded-3">
                            <div class="scm-metric-icon bg-warning me-3">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $pendingOrders ?? 0 }}</h6>
                                <small class="text-muted">Pending Orders</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex align-items-center p-3 bg-light rounded-3">
                            <div class="scm-metric-icon bg-info me-3">
                                <i class="bi bi-gear"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $processingOrders ?? 0 }}</h6>
                                <small class="text-muted">Processing Orders</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Favorite Products -->
    <div class="col-xl-4 col-lg-6">
        <div class="scm-card scm-hover-lift h-100">
            <div class="scm-card-header bg-gradient-danger">
                <div class="d-flex align-items-center">
                    <i class="bi bi-heart-fill me-3 fs-4"></i>
                    <div>
                        <h5 class="scm-card-title mb-1">Favorite Products</h5>
                        <p class="scm-card-subtitle mb-0">Your most ordered items</p>
                    </div>
                </div>
            </div>
            <div class="scm-card-body">
                @forelse($favoriteProducts ?? [] as $product)
                    <div class="d-flex justify-content-between align-items-center p-3 mb-2 border rounded-3">
                        <div>
                            <h6 class="mb-1">{{ $product->name ?? 'Product Name' }}</h6>
                            <small class="text-muted">{{ $product->category ?? 'Category' }}</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-primary">{{ $product->order_count ?? 0 }} Orders</span>
                            <div class="small text-danger mt-1">
                                <i class="bi bi-heart-fill me-1"></i>Favorite
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="bi bi-heart display-4 text-muted"></i>
                        <h6 class="mt-2 text-muted">No Favorites Yet</h6>
                        <p class="text-muted">Start shopping to add favorites</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Account Summary -->
    <div class="col-xl-4 col-lg-12">
        <div class="scm-card scm-hover-lift h-100">
            <div class="scm-card-header bg-gradient-info">
                <div class="d-flex align-items-center">
                    <i class="bi bi-person-circle me-3 fs-4"></i>
                    <div>
                        <h5 class="scm-card-title mb-1">Account Summary</h5>
                        <p class="scm-card-subtitle mb-0">Your account overview</p>
                    </div>
                </div>
            </div>
            <div class="scm-card-body">
                <div class="d-flex justify-content-between align-items-center p-3 mb-3 bg-light rounded-3">
                    <div>
                        <h6 class="mb-1">Total Spent</h6>
                        <small class="text-muted">Lifetime purchases</small>
                    </div>
                    <div class="text-end">
                        <h5 class="text-success mb-0">UGX {{ number_format($totalSpent ?? 0) }}</h5>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center p-3 mb-3 bg-light rounded-3">
                    <div>
                        <h6 class="mb-1">Member Since</h6>
                        <small class="text-muted">Account created</small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-info">
                            <i class="bi bi-calendar-check me-1"></i>
                            {{ Auth::user()->created_at ? Auth::user()->created_at->format('M Y') : 'Recently' }}
                        </span>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-3">
                    <div>
                        <h6 class="mb-1">Account Status</h6>
                        <small class="text-muted">Current standing</small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-success">
                            <i class="bi bi-shield-check me-1"></i>
                            Active
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

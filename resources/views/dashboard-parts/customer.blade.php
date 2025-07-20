<div class="admin-dashboard-container">
<div class="dashboard-header">
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <div class="dashboard-logo-circle">
                <i class="bi bi-person-check"></i>
            </div>
            <div class="ms-3">
                <h2 class="mb-1 text-white">Customer Dashboard</h2>
                <p class="mb-0 text-white-50">Buy finished recycled products, track orders.</p>
            </div>
        </div>
        <div class="dashboard-stats d-none d-lg-flex">
            <!-- Debug Information -->
            @if(config('app.debug'))
                <div class="alert alert-info mb-3" style="position: absolute; top: -50px; right: 0; z-index: 1000;">
                    Debug: User ID: {{ auth()->id() }} | Total Orders: {{ $totalOrders ?? 'NULL' }} | Active Orders: {{ $activeOrders ?? 'NULL' }} | Total Spent: {{ $totalSpent ?? 'NULL' }}
                </div>
            @endif
            <div class="stat-item me-4">
                <div class="stat-number">{{ $totalOrders ?? 0 }}</div>
                <div class="stat-label">My Orders</div>
            </div>
            <div class="stat-item me-4">
                <div class="stat-number">{{ $activeOrders ?? 0 }}</div>
                <div class="stat-label">Active Orders</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">UGX {{ number_format($totalSpent ?? 0) }}</div>
                <div class="stat-label">Total Spent</div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
      <div class="dashboard-card text-center">
        <i class="bi bi-shop text-warning" style="font-size:2rem;"></i>
        <h5 class="mt-2">Become a Vendor</h5>
        <p>Apply to become a vendor for bulk purchase.</p>
        <a href="{{ route('vendor.apply') }}" class="btn btn-warning mt-2"><i class="bi bi-shop me-1"></i> Apply Now</a>
      </div>
    </div>
</div>

<!-- Main Action Cards -->
<div class="row g-4 mb-5">
    <div class="col-xl-4 col-lg-6 col-md-6">
        <div class="action-card card-primary">
            <div class="card-icon">
                <i class="bi bi-cart-check"></i>
            </div>
            <div class="card-content">
                <h5>Product Catalog</h5>
                <p>Browse and order recycled products</p>
                <a href="{{ route('sales.index') }}" class="btn btn-primary btn-modern">
                    <i class="bi bi-bag-check me-2"></i>Shop Now
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-lg-6 col-md-6">
        <div class="action-card card-success">
            <div class="card-icon">
                <i class="bi bi-truck"></i>
            </div>
            <div class="card-content">
                <h5>Order Tracking</h5>
                <p>Track your orders and delivery status</p>
                <a href="{{ route('sales.status') }}" class="btn btn-success btn-modern">
                    <i class="bi bi-truck me-2"></i>Track Orders
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-lg-6 col-md-6">
        <div class="action-card card-info">
            <div class="card-icon">
                <i class="bi bi-chat-dots"></i>
            </div>
            <div class="card-content">
                <h5>Chat Support</h5>
                <p>Need help? Chat with our support team</p>
                <a href="{{ route('chat.index') }}" class="btn btn-info btn-modern">
                    <i class="bi bi-chat me-2"></i>Start Chat
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions & Order Management -->
<div class="row g-4 mb-5">
    <!-- Quick Actions -->
    <div class="col-xl-4 col-lg-6">
        <div class="info-card">
            <div class="card-header-custom">
                <h6><i class="bi bi-lightning-charge me-2"></i>Quick Actions</h6>
            </div>
            <div class="card-body-custom">
                <div class="action-buttons">
                    <a href="{{ route('sales.history') }}" class="action-btn btn-primary">
                        <i class="bi bi-clock-history me-2"></i>Order History
                    </a>
                    <a href="{{ route('sales.status') }}" class="action-btn btn-info">
                        <i class="bi bi-info-circle me-2"></i>Order Status
                    </a>
                    <a href="{{ route('profile') }}" class="action-btn btn-secondary">
                        <i class="bi bi-person-gear me-2"></i>Profile Settings
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="col-xl-8 col-lg-6">
        <div class="info-card">
            <div class="card-header-custom">
                <h6><i class="bi bi-bag-check me-2"></i>Recent Orders</h6>
                <a href="{{ route('sales.history') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body-custom">
                <div class="list-group list-group-flush">
                    @forelse($recentOrders ?? [] as $order)
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-secondary me-2">#{{ $order->order_number ?? $order->id }}</span>
                                    <strong>{{ $order->product_name ?? 'Product Order' }}</strong>
                                    <small class="text-muted d-block">{{ $order->created_at ? $order->created_at->format('M d, Y') : 'Recent' }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'pending' ? 'warning' : 'info') }}">
                                        {{ ucfirst($order->status ?? 'Processing') }}
                                    </span>
                                    <div class="small text-muted mt-1">UGX {{ number_format($order->total_amount ?? 0) }}</div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-3 text-muted">
                            <i class="bi bi-bag fs-3 d-block mb-2"></i>
                            No orders found
                            <div class="mt-2">
                                <a href="{{ route('sales.index') }}" class="btn btn-sm btn-primary">Start Shopping</a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Customer Insights & Support -->
<div class="row g-4 mb-5">
    <!-- Order Statistics -->
    <div class="col-xl-4 col-lg-6">
        <div class="info-card h-100">
            <div class="card-header-custom">
                <h6><i class="bi bi-graph-up me-2"></i>Order Statistics</h6>
                <small class="text-muted">Your activity overview</small>
            </div>
            <div class="card-body-custom">
                <div class="analytics-metrics">
                    <div class="metric-item metric-success">
                        <div class="metric-icon">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-number">{{ $completedOrders ?? 0 }}</div>
                            <div class="metric-label">Completed Orders</div>
                        </div>
                    </div>

                    <div class="metric-item metric-warning">
                        <div class="metric-icon">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-number">{{ $pendingOrders ?? 0 }}</div>
                            <div class="metric-label">Pending Orders</div>
                        </div>
                    </div>

                    <div class="metric-item metric-info">
                        <div class="metric-icon">
                            <i class="bi bi-gear"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-number">{{ $processingOrders ?? 0 }}</div>
                            <div class="metric-label">Processing</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Favorite Products -->
    <div class="col-xl-4 col-lg-6">
        <div class="info-card h-100">
            <div class="card-header-custom">
                <h6><i class="bi bi-heart me-2"></i>Favorite Products</h6>
                <small class="text-muted">Your most ordered items</small>
            </div>
            <div class="card-body-custom">
                <div class="inventory-list-container">
                    @forelse($favoriteProducts ?? [] as $product)
                        <div class="inventory-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="item-title">{{ $product->name ?? 'Product Name' }}</div>
                                    <div class="item-subtitle">{{ $product->category ?? 'Category' }}</div>
                                </div>
                                <div class="text-end">
                                    <div class="quantity-display">
                                        <span class="quantity-number">{{ $product->order_count ?? 0 }}</span>
                                        <span class="quantity-unit">Orders</span>
                                    </div>
                                    <div class="stock-ok">
                                        <i class="bi bi-heart-fill me-1"></i>Favorite
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="bi bi-heart"></i>
                            <h6>No Favorites Yet</h6>
                            <p>Start shopping to add favorites</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Account Summary -->
    <div class="col-xl-4 col-lg-12">
        <div class="info-card h-100">
            <div class="card-header-custom">
                <h6><i class="bi bi-person-circle me-2"></i>Account Summary</h6>
                <small class="text-muted">Your account overview</small>
            </div>
            <div class="card-body-custom">
                <div class="financial-list-container">
                    <div class="financial-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="item-title">Total Spent</div>
                                <div class="item-subtitle">Lifetime purchases</div>
                            </div>
                            <div class="text-end">
                                <div class="payment-amount">UGX {{ number_format($totalSpent ?? 0) }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="financial-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="item-title">Member Since</div>
                                <div class="item-subtitle">Account created</div>
                            </div>
                            <div class="text-end">
                                <span class="payment-status status-approved">
                                    <i class="bi bi-calendar-check me-1"></i>
                                    {{ Auth::user()->created_at ? Auth::user()->created_at->format('M Y') : 'Recently' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="financial-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="item-title">Account Status</div>
                                <div class="item-subtitle">Current standing</div>
                            </div>
                            <div class="text-end">
                                <span class="payment-status status-approved">
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
</div>

</div>

<style>
/* Modern Professional Dashboard Styling */
body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
}

/* Dashboard Container */
.admin-dashboard-container {
    max-width: 1600px;
    margin: 0 auto;
    padding: 1.5rem;
}

@media (min-width: 1400px) {
    .admin-dashboard-container {
        padding: 2rem 3rem;
    }
}

@media (min-width: 1920px) {
    .admin-dashboard-container {
        padding: 2rem 5rem;
    }
}

/* Dashboard Header */
.dashboard-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.dashboard-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
    border-radius: 50%;
}

.dashboard-logo-circle {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 4px 20px rgba(59, 130, 246, 0.3);
}

.dashboard-stats .stat-item {
    text-align: center;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
}

.stat-label {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.7);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Action Cards */
.action-card {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    height: 100%;
    border: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.action-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--card-color);
}

.action-card.card-primary { --card-color: #3b82f6; }
.action-card.card-success { --card-color: #10b981; }
.action-card.card-info { --card-color: #06b6d4; }
.action-card.card-warning { --card-color: #f59e0b; }
.action-card.card-danger { --card-color: #ef4444; }

.action-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.action-card .card-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, var(--card-color), color-mix(in srgb, var(--card-color) 80%, black));
    color: white;
    box-shadow: 0 8px 25px color-mix(in srgb, var(--card-color) 30%, transparent);
}

.action-card .card-content h5 {
    font-weight: 600;
    margin-bottom: 0.75rem;
    color: #1e293b;
}

.action-card .card-content p {
    color: #64748b;
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
}

.btn-modern {
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    text-transform: none;
    border: none;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

/* Info Cards */
.info-card {
    background: white;
    border-radius: 1rem;
    border: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.card-header-custom {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 1.25rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header-custom h6 {
    margin: 0;
    font-weight: 600;
    color: #1e293b;
    display: flex;
    align-items: center;
}

.card-body-custom {
    padding: 1.5rem;
}

/* Enhanced Inventory & Financial Lists */
.inventory-list-container, .financial-list-container {
    max-height: 320px;
    overflow-y: auto;
    padding: 0.5rem 0;
}

.inventory-item, .financial-item {
    padding: 1rem 0;
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.2s ease;
}

.inventory-item:last-child, .financial-item:last-child {
    border-bottom: none;
}

.inventory-item:hover, .financial-item:hover {
    background: #f8fafc;
    margin: 0 -1rem;
    padding: 1rem;
    border-radius: 0.5rem;
}

.item-title {
    font-weight: 600;
    color: #1e293b;
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
}

.item-subtitle {
    font-size: 0.8rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Quantity Display */
.quantity-display {
    display: flex;
    align-items: baseline;
    gap: 0.25rem;
    margin-bottom: 0.5rem;
}

.quantity-number {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1e293b;
}

.quantity-unit {
    font-size: 0.8rem;
    color: #64748b;
    text-transform: uppercase;
}

/* Stock Status */
.stock-alert, .stock-ok {
    font-size: 0.75rem;
    font-weight: 500;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    display: inline-flex;
    align-items: center;
}

.stock-alert {
    background: #fef2f2;
    color: #dc2626;
}

.stock-ok {
    background: #f0fdf4;
    color: #16a34a;
}

/* Payment Amount */
.payment-amount {
    font-weight: 700;
    color: #059669;
    font-size: 1rem;
    margin-bottom: 0.5rem;
}

/* Status Badges */
.payment-status, .invoice-status {
    font-size: 0.75rem;
    font-weight: 500;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    display: inline-flex;
    align-items: center;
}

.status-paid, .status-approved {
    background: #f0fdf4;
    color: #16a34a;
}

.status-pending {
    background: #fffbeb;
    color: #d97706;
}

.status-rejected {
    background: #fef2f2;
    color: #dc2626;
}

/* Enhanced Analytics Metrics */
.analytics-metrics {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    height: 100%;
}

.metric-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 0.75rem;
    border-left: 4px solid var(--metric-color);
    transition: all 0.2s ease;
}

.metric-item:hover {
    background: #f1f5f9;
    transform: translateX(4px);
}

.metric-success { --metric-color: #10b981; }
.metric-warning { --metric-color: #f59e0b; }
.metric-info { --metric-color: #06b6d4; }
.metric-danger { --metric-color: #ef4444; }

.metric-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--metric-color);
    color: white;
    font-size: 1.1rem;
    margin-right: 1rem;
    flex-shrink: 0;
}

.metric-content {
    flex-grow: 1;
}

.metric-number {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.metric-label {
    font-size: 0.75rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Empty States */
.empty-state {
    text-align: center;
    padding: 2rem 1rem;
    color: #64748b;
}

.empty-state i {
    font-size: 2.5rem;
    color: #cbd5e1;
    margin-bottom: 1rem;
    display: block;
}

.empty-state h6 {
    color: #475569;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.empty-state p {
    font-size: 0.875rem;
    margin: 0;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    padding: 0.5rem 0;
}

.action-btn {
    border-radius: 0.5rem;
    padding: 0.875rem 1rem;
    font-weight: 500;
    text-decoration: none;
    border: none;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    text-decoration: none;
}

/* List Items */
.list-group-item {
    padding: 1rem 0;
    border-bottom: 1px solid #f1f5f9 !important;
}

.list-group-item:last-child {
    border-bottom: none !important;
}

/* Responsive Design */
@media (max-width: 1400px) {
    .dashboard-stats {
        display: none !important;
    }
}

@media (max-width: 1024px) {
    .analytics-metrics {
        gap: 0.75rem;
    }
    
    .metric-item {
        padding: 0.75rem;
    }
}

@media (max-width: 768px) {
    .admin-dashboard-container {
        padding: 1rem;
    }
    
    .dashboard-header {
        padding: 1.5rem;
    }
    
    .action-card {
        padding: 1.5rem;
    }
    
    .card-body-custom {
        padding: 1rem;
    }
    
    .analytics-metrics {
        gap: 0.5rem;
    }
    
    .metric-item {
        padding: 0.75rem;
        flex-direction: column;
        text-align: center;
    }
    
    .metric-icon {
        margin-right: 0;
        margin-bottom: 0.5rem;
    }
}

/* Custom Scrollbars */
.inventory-list-container::-webkit-scrollbar, 
.financial-list-container::-webkit-scrollbar {
    width: 6px;
}

.inventory-list-container::-webkit-scrollbar-track, 
.financial-list-container::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.inventory-list-container::-webkit-scrollbar-thumb, 
.financial-list-container::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.inventory-list-container::-webkit-scrollbar-thumb:hover, 
.financial-list-container::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>

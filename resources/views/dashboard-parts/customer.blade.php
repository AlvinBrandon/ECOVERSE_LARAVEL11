<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
  
  * {
    font-family: 'Poppins', sans-serif;
  }
  
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #10b981 100%) !important;
    font-family: 'Poppins', sans-serif;
    color: #ffffff;
    min-height: 10vh;
  }
  
  /* Customer Dashboard Modern Styling */
  .customer-dashboard-container {
    padding: 2rem;
    max-width: 1400px;
    margin: 0 auto;
  }
  
  /* Dashboard Header */
  .dashboard-header {
    background: rgba(255, 255, 255, 0.1) !important;
    backdrop-filter: blur(20px) !important;
    border: 1px solid rgba(16, 185, 129, 0.2) !important;
    color: #fff !important;
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.15);
  }
  
  .header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
  }
  
  .header-info h1 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 0.5rem;
    line-height: 1.2;
  }
  
  .header-info p {
    color: rgba(255, 255, 255, 0.8);
    margin: 0;
    font-size: 1.1rem;
  }
  
  .status-badge {
    background: rgba(16, 185, 129, 0.2);
    padding: 0.75rem 1.25rem;
    border-radius: 0.75rem;
    border: 1px solid rgba(16, 185, 129, 0.3);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #ffffff;
    font-size: 0.9rem;
    font-weight: 500;
  }
  
  .status-badge i {
    color: #10b981;
  }
  
  /* Metric Cards */
  .scm-metric-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 1rem;
    padding: 2rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }
  
  .scm-metric-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #10b981, #059669);
  }
  
  .scm-metric-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(16, 185, 129, 0.25);
    border-color: rgba(16, 185, 129, 0.4);
  }
  
  .scm-metric-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
  }
  
  .scm-metric-value {
    font-size: 2 rem !important;
    font-weight: 800 !important;
    color: #10b981 !important;
    margin-bottom: 0.5rem !important;
    line-height: 1 !important;
    background: none !important;
    -webkit-text-fill-color: #10b981 !important;
  }
  
  .scm-metric-label {
    color: rgba(255, 255, 255, 0.9) !important;
    font-size: 1rem !important;
    font-weight: 500 !important;
  }
  
  .scm-metric-trend {
    color: #10b981 !important;
    font-size: 0.875rem;
    font-weight: 500;
    margin-top: 0.5rem;
  }
  
  /* Action Cards */
  .scm-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 1rem;
    transition: all 0.3s ease;
    overflow: hidden;
  }
  
  .scm-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.2);
    border-color: rgba(16, 185, 129, 0.4);
  }
  
  .scm-card-header {
    background: rgba(16, 185, 129, 0.2) !important;
    border: none !important;
    padding: 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }
  
  .scm-card-title {
    color: #ffffff !important;
    font-weight: 600;
    margin: 0;
  }
  
  .scm-card-subtitle {
    color: rgba(255, 255, 255, 0.8) !important;
    margin: 0;
  }
  
  .scm-card-body {
    padding: 1.5rem;
    background: rgba(255, 255, 255, 0.1);
  }
  
  .scm-card-text {
    color: rgba(255, 255, 255, 0.8) !important;
    margin-bottom: 1rem;
  }
  
  /* Buttons */
  .scm-btn {
    background: linear-gradient(135deg, #10b981, #059669);
    border: none;
    color: #ffffff;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
  }
  
  .scm-btn:hover {
    color: #ffffff;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
  }
  
  .scm-btn-primary {
    background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
  }
  
  .scm-btn-primary:hover {
    background: linear-gradient(135deg, #6d28d9 0%, #7c3aed 100%);
    box-shadow: 0 8px 25px rgba(124, 58, 237, 0.3);
  }
  
  .scm-btn-success {
    background: linear-gradient(135deg, #10b981, #059669);
  }
  
  .scm-btn-info {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
  }
  
  .scm-btn-warning {
    background: linear-gradient(135deg, #f59e0b, #d97706);
  }
  
  .scm-btn-secondary {
    background: linear-gradient(135deg, #6b7280, #4b5563);
  }
  
  .scm-btn-outline-light {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: #ffffff;
  }
  
  .scm-btn-outline-light:hover {
    background: rgba(255, 255, 255, 0.2);
    color: #ffffff;
  }
  
  /* Badges */
  .badge {
    background: rgba(16, 185, 129, 0.2) !important;
    color: #10b981 !important;
    border: 1px solid rgba(16, 185, 129, 0.3);
    padding: 0.5rem 0.75rem;
    border-radius: 0.375rem;
  }
  
  .bg-primary {
    background: rgba(124, 58, 237, 0.2) !important;
    color: #a855f7 !important;
    border: 1px solid rgba(124, 58, 237, 0.3) !important;
  }
  
  .bg-success {
    background: rgba(16, 185, 129, 0.2) !important;
    color: #10b981 !important;
    border: 1px solid rgba(16, 185, 129, 0.3) !important;
  }
  
  .bg-warning {
    background: rgba(245, 158, 11, 0.2) !important;
    color: #f59e0b !important;
    border: 1px solid rgba(245, 158, 11, 0.3) !important;
  }
  
  .bg-info {
    background: rgba(59, 130, 246, 0.2) !important;
    color: #3b82f6 !important;
    border: 1px solid rgba(59, 130, 246, 0.3) !important;
  }
  
  .bg-secondary {
    background: rgba(107, 114, 128, 0.2) !important;
    color: #9ca3af !important;
    border: 1px solid rgba(107, 114, 128, 0.3) !important;
  }
  
  /* Order Items */
  .scm-order-item {
    background: rgba(255, 255, 255, 0.05) !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    border-radius: 0.75rem !important;
    transition: all 0.2s ease;
  }
  
  .scm-order-item:hover {
    background: rgba(255, 255, 255, 0.1) !important;
    border-color: rgba(16, 185, 129, 0.3) !important;
  }
  
  .scm-order-icon {
    width: 40px;
    height: 40px;
    background: rgba(16, 185, 129, 0.2);
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #10b981;
  }
  
  /* Text Colors */
  .text-dark {
    color: rgba(255, 255, 255, 0.9) !important;
  }
  
  .text-muted {
    color: rgba(255, 255, 255, 0.6) !important;
  }
  
  .text-success {
    color: #10b981 !important;
  }
  
  /* Empty State */
  .scm-empty-state i {
    color: rgba(255, 255, 255, 0.3) !important;
  }
  
  .scm-empty-state h5 {
    color: rgba(255, 255, 255, 0.6) !important;
  }
  
  .scm-empty-state p {
    color: rgba(255, 255, 255, 0.5) !important;
  }
  
  /* Background Light Elements */
  .bg-light {
    background: rgba(255, 255, 255, 0.05) !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
  }
  
  /* Icon Wrappers */
  .scm-icon-wrapper {
    width: 50px;
    height: 50px;
    background: rgba(16, 185, 129, 0.2);
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #10b981;
    font-size: 1.25rem;
  }
  
  /* Fade in animations */
  .ecoverse-fade-in-up {
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
  
  /* Responsive Design */
  @media (max-width: 768px) {
    .customer-dashboard-container {
      padding: 1rem;
    }
    
    .dashboard-header {
      padding: 1.5rem;
    }
    
    .header-info h1 {
      font-size: 2rem;
    }
    
    .scm-metric-card {
      padding: 1.5rem;
    }
    
    .scm-metric-value {
      font-size: 2rem !important;
    }
  }
</style>

<div class="customer-dashboard-container">
  <!-- Customer Dashboard Header -->
  <div class="dashboard-header">
    <div class="header-content">
      <div class="header-info">
        <h1><i class="bi bi-person-circle me-3"></i>Customer Dashboard</h1>
        <p>Welcome back, {{ Auth::user()->name }}. Explore sustainable products and manage your eco-friendly orders.</p>
      </div>
      <div class="d-flex gap-2 flex-wrap">
        <div class="status-badge">
          <i class="bi bi-check-circle"></i>
          Account Active
        </div>
        <div class="status-badge">
          <i class="bi bi-clock"></i>
          {{ now()->format('M d, Y') }}
        </div>
      </div>
    </div>
  </div>

  <!-- Debug Information -->
  @if(config('app.debug'))
      <div class="alert alert-info mb-4" style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.3); color: #3b82f6; border-radius: 1rem; backdrop-filter: blur(10px);">
          <i class="bi bi-info-circle me-2"></i>
          <strong>Debug:</strong> User ID: {{ auth()->id() }} | Total Orders: {{ $totalOrders ?? 'NULL' }} | Active Orders: {{ $activeOrders ?? 'NULL' }} | Total Spent: {{ $totalSpent ?? 'NULL' }}
      </div>
  @endif

  <!-- Performance Metrics -->
  <div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6">
          <div class="scm-metric-card ecoverse-fade-in-up" style="animation-delay: 0.1s;">
              <div class="d-flex align-items-center">
                  <div class="scm-metric-icon" style="background: rgba(16, 185, 129, 0.2); color: #10b981;">
                      <i class="bi bi-bag-check-fill"></i>
                  </div>
                  <div class="ms-3 flex-grow-1">
                      <h3 class="scm-metric-value">{{ $totalOrders ?? 0 }}</h3>
                      <p class="scm-metric-label">Sustainable Orders</p>
                      <div class="scm-metric-trend">
                          <i class="bi bi-arrow-up"></i>
                          <span>+12.3% Eco-Growth</span>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-lg-3 col-md-6">
          <div class="scm-metric-card ecoverse-fade-in-up" style="animation-delay: 0.2s;">
              <div class="d-flex align-items-center">
                  <div class="scm-metric-icon" style="background: rgba(124, 58, 237, 0.2); color: #a855f7;">
                      <i class="bi bi-clock-fill"></i>
                  </div>
                  <div class="ms-3 flex-grow-1">
                      <h3 class="scm-metric-value">{{ $activeOrders ?? 0 }}</h3>
                      <p class="scm-metric-label">Active Eco-Orders</p>
                      <div class="scm-metric-trend">
                          <i class="bi bi-arrow-up"></i>
                          <span>+5.7% Green Activity</span>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-lg-3 col-md-6">
          <div class="scm-metric-card ecoverse-fade-in-up" style="animation-delay: 0.3s;">
              <div class="d-flex align-items-center">
                  <div class="scm-metric-icon" style="background: rgba(245, 158, 11, 0.2); color: #f59e0b;">
                      <i class="bi bi-currency-dollar"></i>
                  </div>
                  <div class="ms-3 flex-grow-1">
                      <h3 class="scm-metric-value">UGX {{ number_format($totalSpent ?? 0) }}</h3>
                      <p class="scm-metric-label">Sustainable Investment</p>
                      <div class="scm-metric-trend">
                          <i class="bi bi-arrow-up"></i>
                          <span>+18.9% Eco-Impact</span>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-lg-3 col-md-6">
          <div class="scm-metric-card ecoverse-fade-in-up" style="animation-delay: 0.4s;">
              <div class="d-flex align-items-center">
                  <div class="scm-metric-icon" style="background: rgba(59, 130, 246, 0.2); color: #3b82f6;">
                      <i class="bi bi-shop"></i>
                  </div>
                  <div class="ms-3 flex-grow-1">
                      <h3 class="scm-metric-value">Apply</h3>
                      <p class="scm-metric-label">Eco-Vendor Status</p>
                      <div class="scm-metric-trend">
                          <i class="bi bi-arrow-right"></i>
                          <span>Available</span>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <!-- Main Action Cards -->
  <div class="row g-4 mb-4">
      <div class="col-xl-4 col-lg-6">
          <div class="scm-card">
              <div class="scm-card-header">
                  <div class="d-flex align-items-center">
                      <div class="scm-icon-wrapper me-3">
                          <i class="bi bi-cart-check-fill"></i>
                      </div>
                      <div>
                          <h5 class="scm-card-title">Product Catalog</h5>
                          <p class="scm-card-subtitle">Browse eco-friendly products</p>
                      </div>
                  </div>
              </div>
              <div class="scm-card-body">
                  <p class="scm-card-text">Browse and order recycled products from our comprehensive eco-friendly catalog</p>
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
          <div class="scm-card">
              <div class="scm-card-header">
                  <div class="d-flex align-items-center">
                      <div class="scm-icon-wrapper me-3">
                          <i class="bi bi-truck"></i>
                      </div>
                      <div>
                          <h5 class="scm-card-title">Order Tracking</h5>
                          <p class="scm-card-subtitle">Real-time delivery updates</p>
                      </div>
                  </div>
              </div>
              <div class="scm-card-body">
                  <p class="scm-card-text">Track your orders and delivery status with real-time updates and notifications</p>
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
          <div class="scm-card">
              <div class="scm-card-header">
                  <div class="d-flex align-items-center">
                      <div class="scm-icon-wrapper me-3">
                          <i class="bi bi-chat-dots-fill"></i>
                      </div>
                      <div>
                          <h5 class="scm-card-title">Support Center</h5>
                          <p class="scm-card-subtitle">Get immediate assistance</p>
                      </div>
                  </div>
              </div>
              <div class="scm-card-body">
                  <p class="scm-card-text">Need help? Chat with our support team for immediate assistance and guidance</p>
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
          <div class="scm-card">
              <div class="scm-card-header">
                  <div class="d-flex align-items-center">
                      <div class="scm-icon-wrapper me-3">
                          <i class="bi bi-shop"></i>
                      </div>
                      <div>
                          <h5 class="scm-card-title">Become a Vendor</h5>
                          <p class="scm-card-subtitle">Expand business opportunities</p>
                      </div>
                  </div>
              </div>
              <div class="scm-card-body">
                  <p class="scm-card-text">Apply to become a vendor for bulk purchases and expand your business opportunities</p>
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
          <div class="scm-card">
              <div class="scm-card-header">
                  <div class="d-flex align-items-center">
                      <div class="scm-icon-wrapper me-3">
                          <i class="bi bi-clock-history"></i>
                      </div>
                      <div>
                          <h5 class="scm-card-title">Order History</h5>
                          <p class="scm-card-subtitle">Complete purchase records</p>
                      </div>
                  </div>
              </div>
              <div class="scm-card-body">
                  <p class="scm-card-text">View your complete order history and download invoices for your records</p>
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
          <div class="scm-card">
              <div class="scm-card-header">
                  <div class="d-flex align-items-center">
                      <div class="scm-icon-wrapper me-3">
                          <i class="bi bi-person-gear"></i>
                      </div>
                      <div>
                          <h5 class="scm-card-title">Profile Settings</h5>
                          <p class="scm-card-subtitle">Account management</p>
                      </div>
                  </div>
              </div>
              <div class="scm-card-body">
                  <p class="scm-card-text">Manage your account settings, preferences, and personal information</p>
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

  <!-- Recent Orders Section -->
  <div class="row mb-4">
      <div class="col-12">
          <div class="scm-card">
              <div class="scm-card-header">
                  <div class="d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center">
                          <div class="scm-icon-wrapper me-3">
                              <i class="bi bi-bag-check-fill"></i>
                          </div>
                          <div>
                              <h5 class="scm-card-title">Recent Orders</h5>
                              <p class="scm-card-subtitle">Track your latest purchases and delivery status</p>
                          </div>
                      </div>
                      <a href="{{ route('sales.history') }}" class="scm-btn scm-btn-outline-light">
                          <i class="bi bi-arrow-right me-1"></i>View All Orders
                      </a>
                  </div>
              </div>
              <div class="scm-card-body">
                  @forelse($recentOrders ?? [] as $order)
                      <div class="scm-order-item d-flex justify-content-between align-items-center p-3 mb-3">
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
                              <i class="bi bi-bag-x display-1"></i>
                              <h5 class="mt-3">No Recent Orders</h5>
                              <p>Start shopping to see your orders here</p>
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
          </div>
      </div>
  </div>

  <!-- Customer Analytics & Insights -->
  <div class="row g-4 mb-4">
      <!-- Order Statistics -->
      <div class="col-xl-4 col-lg-6">
          <div class="scm-card h-100">
              <div class="scm-card-header">
                  <div class="d-flex align-items-center">
                      <div class="scm-icon-wrapper me-3">
                          <i class="bi bi-graph-up"></i>
                      </div>
                      <div>
                          <h5 class="scm-card-title">Order Statistics</h5>
                          <p class="scm-card-subtitle">Your activity overview</p>
                      </div>
                  </div>
              </div>
              <div class="scm-card-body">
                  <div class="row g-3">
                      <div class="col-12">
                          <div class="d-flex align-items-center p-3 bg-light rounded-3">
                              <div class="scm-metric-icon bg-success me-3" style="width: 40px; height: 40px; font-size: 1rem;">
                                  <i class="bi bi-check-circle"></i>
                              </div>
                              <div>
                                  <h6 class="mb-0" style="color: #ffffff !important;">{{ $completedOrders ?? 0 }}</h6>
                                  <small style="color: rgba(255, 255, 255, 0.8) !important;">Completed Orders</small>
                              </div>
                          </div>
                      </div>
                      <div class="col-12">
                          <div class="d-flex align-items-center p-3 bg-light rounded-3">
                              <div class="scm-metric-icon bg-warning me-3" style="width: 40px; height: 40px; font-size: 1rem;">
                                  <i class="bi bi-clock"></i>
                              </div>
                              <div>
                                  <h6 class="mb-0" style="color: #ffffff !important;">{{ $pendingOrders ?? 0 }}</h6>
                                  <small style="color: rgba(255, 255, 255, 0.8) !important;">Pending Orders</small>
                              </div>
                          </div>
                      </div>
                      <div class="col-12">
                          <div class="d-flex align-items-center p-3 bg-light rounded-3">
                              <div class="scm-metric-icon bg-info me-3" style="width: 40px; height: 40px; font-size: 1rem;">
                                  <i class="bi bi-gear"></i>
                              </div>
                              <div>
                                  <h6 class="mb-0" style="color: #ffffff !important;">{{ $processingOrders ?? 0 }}</h6>
                                  <small style="color: rgba(255, 255, 255, 0.8) !important;">Processing Orders</small>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <!-- Favorite Products -->
      <div class="col-xl-4 col-lg-6">
          <div class="scm-card h-100">
              <div class="scm-card-header">
                  <div class="d-flex align-items-center">
                      <div class="scm-icon-wrapper me-3">
                          <i class="bi bi-heart-fill"></i>
                      </div>
                      <div>
                          <h5 class="scm-card-title">Favorite Products</h5>
                          <p class="scm-card-subtitle">Your most ordered items</p>
                      </div>
                  </div>
              </div>
              <div class="scm-card-body">
                  @forelse($favoriteProducts ?? [] as $product)
                      <div class="d-flex justify-content-between align-items-center p-3 mb-2 bg-light rounded-3">
                          <div>
                              <h6 class="mb-1" style="color: #ffffff !important;">{{ $product->name ?? 'Product Name' }}</h6>
                              <small style="color: rgba(255, 255, 255, 0.8) !important;">{{ $product->category ?? 'Category' }}</small>
                          </div>
                          <div class="text-end">
                              <span class="badge bg-primary">{{ $product->order_count ?? 0 }} Orders</span>
                              <div class="small text-success mt-1">
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
          <div class="scm-card h-100">
              <div class="scm-card-header">
                  <div class="d-flex align-items-center">
                      <div class="scm-icon-wrapper me-3">
                          <i class="bi bi-person-circle"></i>
                      </div>
                      <div>
                          <h5 class="scm-card-title">Account Summary</h5>
                          <p class="scm-card-subtitle">Your account overview</p>
                      </div>
                  </div>
              </div>
              <div class="scm-card-body">
                  <div class="d-flex justify-content-between align-items-center p-3 mb-3 bg-light rounded-3">
                      <div>
                          <h6 class="mb-1" style="color: #ffffff !important;">Total Spent</h6>
                          <small style="color: rgba(255, 255, 255, 0.8) !important;">Lifetime purchases</small>
                      </div>
                      <div class="text-end">
                          <h5 class="text-success mb-0">UGX {{ number_format($totalSpent ?? 0) }}</h5>
                      </div>
                  </div>
                  <div class="d-flex justify-content-between align-items-center p-3 mb-3 bg-light rounded-3">
                      <div>
                          <h6 class="mb-1" style="color: #ffffff !important;">Member Since</h6>
                          <small style="color: rgba(255, 255, 255, 0.8) !important;">Account created</small>
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
                          <h6 class="mb-1" style="color: #ffffff !important;">Account Status</h6>
                          <small style="color: rgba(255, 255, 255, 0.8) !important;">Current standing</small>
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

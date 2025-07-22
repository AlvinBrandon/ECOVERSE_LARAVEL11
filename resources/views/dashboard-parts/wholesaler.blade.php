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
  
  /* Wholesaler Dashboard Header */
  .wholesaler-header {
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
  
  .header-badges {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
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
  
  /* Professional Card Styling */
  .scm-card {
    background: rgba(255, 255, 255, 0.1) !important;
    backdrop-filter: blur(20px) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    border-radius: 1rem !important;
    transition: all 0.3s ease !important;
    color: #ffffff !important;
    overflow: hidden;
  }
  
  .scm-card:hover {
    transform: translateY(-4px) !important;
    box-shadow: 0 12px 40px rgba(16, 185, 129, 0.25) !important;
    border-color: rgba(16, 185, 129, 0.4) !important;
  }
  
  .scm-card-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%) !important;
    border-bottom: 1px solid rgba(16, 185, 129, 0.2) !important;
    padding: 1.5rem !important;
    border-radius: 1rem 1rem 0 0 !important;
  }
  
  .scm-card-body {
    padding: 1.5rem !important;
    background: rgba(255, 255, 255, 0.05) !important;
  }
  
  .scm-card-title {
    color: #ffffff !important;
    font-weight: 600 !important;
    margin-bottom: 0 !important;
  }
  
  .scm-card-subtitle {
    color: rgba(255, 255, 255, 0.8) !important;
    margin: 0 !important;
  }
  
  .scm-card-text {
    color: rgba(255, 255, 255, 0.9) !important;
  }
  
  /* Icon Wrapper */
  .scm-icon-wrapper {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #10b981, #059669) !important;
    border-radius: 50% !important;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem !important;
    color: white !important;
  }
  
  /* Metric Cards */
  .scm-metric-card {
    background: rgba(255, 255, 255, 0.1) !important;
    backdrop-filter: blur(20px) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    border-radius: 1rem !important;
    padding: 1.5rem !important;
    transition: all 0.3s ease !important;
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
    transform: translateY(-4px) !important;
    box-shadow: 0 12px 40px rgba(16, 185, 129, 0.25) !important;
    border-color: rgba(16, 185, 129, 0.4) !important;
  }
  
  .scm-metric-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white !important;
  }
  
  .scm-metric-value {
    font-size: 2rem !important;
    font-weight: 700 !important;
    color: #10b981 !important;
    margin: 0 !important;
    line-height: 1;
  }
  
  .scm-metric-label {
    color: rgba(255, 255, 255, 0.8) !important;
    font-size: 0.9rem !important;
    margin: 0.25rem 0 0.5rem 0 !important;
  }
  
  .scm-metric-trend {
    font-size: 0.8rem !important;
    font-weight: 500 !important;
    display: flex;
    align-items: center;
    gap: 0.25rem;
  }
  
  .scm-metric-trend.positive {
    color: #10b981 !important;
  }
  
  .scm-metric-trend.negative {
    color: #ef4444 !important;
  }
  
  /* Button Styling */
  .scm-btn {
    border: none !important;
    border-radius: 0.5rem !important;
    padding: 0.75rem 1.5rem !important;
    font-weight: 500 !important;
    transition: all 0.3s ease !important;
    text-decoration: none !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
  }
  
  .scm-btn-primary {
    background: linear-gradient(135deg, #10b981, #059669) !important;
    color: white !important;
  }
  
  .scm-btn-primary:hover {
    background: linear-gradient(135deg, #059669, #047857) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3) !important;
    color: white !important;
  }
  
  .scm-btn-success {
    background: linear-gradient(135deg, #22c55e, #16a34a) !important;
    color: white !important;
  }
  
  .scm-btn-success:hover {
    background: linear-gradient(135deg, #16a34a, #15803d) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 25px rgba(34, 197, 94, 0.3) !important;
    color: white !important;
  }
  
  .scm-btn-info {
    background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
    color: white !important;
  }
  
  .scm-btn-info:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3) !important;
    color: white !important;
  }
  
  /* Badge Styling */
  .badge {
    font-weight: 500 !important;
    padding: 0.5rem 0.75rem !important;
    border-radius: 0.375rem !important;
  }
  
  .bg-primary {
    background: linear-gradient(135deg, #10b981, #059669) !important;
  }
  
  .bg-success {
    background: linear-gradient(135deg, #22c55e, #16a34a) !important;
  }
  
  .bg-warning {
    background: linear-gradient(135deg, #f59e0b, #d97706) !important;
  }
  
  .bg-info {
    background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
  }
  
  /* Status Badges */
  .scm-status-badge {
    padding: 0.5rem 1rem !important;
    border-radius: 0.5rem !important;
    font-size: 0.85rem !important;
    font-weight: 500 !important;
    display: flex !important;
    align-items: center !important;
    gap: 0.5rem !important;
  }
  
  .scm-status-active {
    background: rgba(16, 185, 129, 0.2) !important;
    color: #10b981 !important;
    border: 1px solid rgba(16, 185, 129, 0.3) !important;
  }
  
  .scm-status-warning {
    background: rgba(245, 158, 11, 0.2) !important;
    color: #f59e0b !important;
    border: 1px solid rgba(245, 158, 11, 0.3) !important;
  }
  
  /* Gradient Headers */
  .bg-gradient-primary {
    background: linear-gradient(135deg, #10b981, #059669) !important;
  }
  
  .bg-gradient-success {
    background: linear-gradient(135deg, #22c55e, #16a34a) !important;
  }
  
  .bg-gradient-info {
    background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
  }
  
  .bg-gradient-warning {
    background: linear-gradient(135deg, #f59e0b, #d97706) !important;
  }
  
  /* Hover Effects */
  .scm-hover-lift:hover {
    transform: translateY(-4px) !important;
  }
  
  .scm-fade-in {
    animation: fadeInUp 0.6s ease-out;
  }
  
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  /* Text Colors */
  .text-muted {
    color: rgba(255, 255, 255, 0.6) !important;
  }
  
  /* Responsive Design */
  @media (max-width: 768px) {
    .header-content {
      flex-direction: column;
      text-align: center;
    }
    
    .header-info h1 {
      font-size: 2rem;
    }
  }
</style>

<!-- Wholesaler Dashboard Header -->
<div class="wholesaler-header">
  <div class="header-content">
    <div class="header-info">
      <h1>Wholesaler Dashboard</h1>
      <p>Welcome back, {{ Auth::user()->name }}. Manage bulk distribution & retailer network operations.</p>
    </div>
    <div class="header-badges">
      <div class="status-badge">
        <i class="bi bi-check-circle"></i>
        Distribution Active
      </div>
      <div class="status-badge">
        <i class="bi bi-clock"></i>
        {{ now()->format('M d, Y') }}
      </div>
    </div>
  </div>
</div>

<!-- SCM Performance Metrics -->
<div class="row g-4 mb-4">
  <div class="col-lg-3 col-md-6">
    <div class="scm-metric-card scm-hover-lift">
      <div class="d-flex align-items-center">
        <div class="scm-metric-icon bg-primary">
          <i class="bi bi-boxes"></i>
        </div>
        <div class="ms-3 flex-grow-1">
          <h3 class="scm-metric-value">{{ number_format($bulkOrders ?? 0) }}</h3>
          <p class="scm-metric-label">Bulk Orders</p>
          <div class="scm-metric-trend {{ ($bulkOrdersGrowth ?? 0) >= 0 ? 'positive' : 'negative' }}">
            <i class="bi bi-arrow-{{ ($bulkOrdersGrowth ?? 0) >= 0 ? 'up' : 'down' }}"></i>
            <span>{{ ($bulkOrdersGrowth ?? 0) >= 0 ? '+' : '' }}{{ number_format($bulkOrdersGrowth ?? 0, 1) }}%</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6">
    <div class="scm-metric-card scm-hover-lift">
      <div class="d-flex align-items-center">
        <div class="scm-metric-icon bg-success">
          <i class="bi bi-people-fill"></i>
        </div>
        <div class="ms-3 flex-grow-1">
          <h3 class="scm-metric-value">{{ number_format($activeRetailers ?? 0) }}</h3>
          <p class="scm-metric-label">Active Retailers</p>
          <div class="scm-metric-trend {{ ($retailersGrowth ?? 0) >= 0 ? 'positive' : 'negative' }}">
            <i class="bi bi-arrow-{{ ($retailersGrowth ?? 0) >= 0 ? 'up' : 'down' }}"></i>
            <span>{{ ($retailersGrowth ?? 0) >= 0 ? '+' : '' }}{{ number_format($retailersGrowth ?? 0, 1) }}%</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6">
    <div class="scm-metric-card scm-hover-lift">
      <div class="d-flex align-items-center">
        <div class="scm-metric-icon bg-warning">
          <i class="bi bi-clipboard-check-fill"></i>
        </div>
        <div class="ms-3 flex-grow-1">
          <h3 class="scm-metric-value">{{ number_format($pendingVerifications ?? 0) }}</h3>
          <p class="scm-metric-label">Pending Verifications</p>
          <div class="scm-metric-trend {{ ($pendingGrowth ?? 0) >= 0 ? 'positive' : 'negative' }}">
            <i class="bi bi-arrow-{{ ($pendingGrowth ?? 0) >= 0 ? 'up' : 'down' }}"></i>
            <span>{{ ($pendingGrowth ?? 0) >= 0 ? '+' : '' }}{{ number_format($pendingGrowth ?? 0, 1) }}%</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6">
    <div class="scm-metric-card scm-hover-lift">
      <div class="d-flex align-items-center">
        <div class="scm-metric-icon bg-info">
          <i class="bi bi-currency-dollar"></i>
        </div>
        <div class="ms-3 flex-grow-1">
          <h3 class="scm-metric-value">UGX {{ number_format($monthlyRevenue ?? 0) }}</h3>
          <p class="scm-metric-label">Monthly Revenue</p>
          <div class="scm-metric-trend {{ ($revenueGrowth ?? 0) >= 0 ? 'positive' : 'negative' }}">
            <i class="bi bi-arrow-{{ ($revenueGrowth ?? 0) >= 0 ? 'up' : 'down' }}"></i>
            <span>{{ ($revenueGrowth ?? 0) >= 0 ? '+' : '' }}{{ number_format($revenueGrowth ?? 0, 1) }}%</span>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- SCM Quick Actions & Management Grid -->
<div class="row g-4 mb-4">
  <div class="col-xl-4 col-lg-6">
    <div class="scm-card scm-hover-lift">
      <div class="scm-card-header bg-gradient-primary">
        <div class="d-flex align-items-center">
          <i class="bi bi-graph-up-arrow me-3 fs-4"></i>
          <h5 class="scm-card-title mb-0">Reports & Analytics</h5>
        </div>
      </div>
      <div class="scm-card-body">
        <p class="scm-card-text mb-3">Comprehensive retailer performance analysis and distribution insights for data-driven decisions</p>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <small class="text-muted">Active Reports</small>
          <span class="badge bg-primary">{{ $generatedReports ?? 24 }} Generated</span>
        </div>
        <a href="{{ route('wholesaler.reports') }}" class="scm-btn scm-btn-primary w-100">
          <i class="bi bi-bar-chart me-2"></i>View Analytics
        </a>
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-lg-6">
    <div class="scm-card scm-hover-lift">
      <div class="scm-card-header bg-gradient-success">
        <div class="d-flex align-items-center">
          <i class="bi bi-boxes me-3 fs-4"></i>
          <h5 class="scm-card-title mb-0">Bulk Order Management</h5>
        </div>
      </div>
      <div class="scm-card-body">
        <p class="scm-card-text mb-3">Streamlined bulk ordering system for large-volume transactions and inventory management</p>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <small class="text-muted">Pending Orders</small>
          <span class="badge bg-warning">{{ $pendingVerifications ?? 0 }} Pending</span>
        </div>
        <a href="{{ route('sales.index') }}" class="scm-btn scm-btn-success w-100">
          <i class="bi bi-bag-check me-2"></i>Manage Orders
        </a>
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-lg-6">
    <div class="scm-card scm-hover-lift">
      <div class="scm-card-header bg-gradient-info">
        <div class="d-flex align-items-center">
          <i class="bi bi-people-fill me-3 fs-4"></i>
          <h5 class="scm-card-title mb-0">Retailer Network</h5>
        </div>
      </div>
      <div class="scm-card-body">
        <p class="scm-card-text mb-3">Monitor retailer transactions, verify purchases, and manage your distribution network effectively</p>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <small class="text-muted">Active Partners</small>
          <span class="badge bg-success">{{ $activeRetailers ?? 0 }} Active</span>
        </div>
        <a href="{{ route('wholesaler.retailer-network') }}" class="scm-btn scm-btn-info w-100">
          <i class="bi bi-people me-2"></i>Network Management
        </a>
      </div>
    </div>
  </div>
</div>

<!-- SCM Order Verification Section -->
<div class="row">
  <div class="col-12">
    <div class="scm-card scm-fade-in">
      <div class="scm-card-header bg-gradient-warning">
        <div class="d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <div class="scm-icon-wrapper me-3">
              <i class="bi bi-clipboard-check-fill"></i>
            </div>
            <div>
              <h5 class="scm-card-title mb-1">Retailer Purchase Order Verification</h5>
              <p class="scm-card-subtitle mb-0">Review and approve incoming retailer orders for distribution</p>
            </div>
          </div>
          <div class="scm-status-badge scm-status-warning">
            <i class="bi bi-clock me-1"></i>
            {{ $pendingVerifications ?? 0 }} Pending
          </div>
        </div>
      </div>
      <div class="scm-card-body">
        @include('partials.verify-orders', ['role' => 'wholesaler'])
      </div>
    </div>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

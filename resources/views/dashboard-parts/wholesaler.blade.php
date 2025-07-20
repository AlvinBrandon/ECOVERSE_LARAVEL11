<!-- SCM Dashboard Title Banner -->
<div class="alert alert-info mb-4 d-flex align-items-center" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); border: none; color: white; font-weight: 600; font-size: 1.1rem; border-radius: 12px;">
  <i class="bi bi-speedometer2 me-3 fs-4"></i>
  <div>
    <strong>WHOLESALER DASHBOARD</strong>
    <div style="font-size: 0.85rem; opacity: 0.9; font-weight: 400;">Bulk Distribution & Retailer Network Management</div>
  </div>
</div>

<!-- Professional SCM Wholesaler Header -->
<div class="scm-card mb-4 scm-fade-in">
  <div class="scm-card-header">
    <div class="d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center">
        <div class="scm-icon-wrapper me-3">
          <i class="bi bi-building-gear"></i>
        </div>
        <div>
          <h4 class="scm-card-title mb-1">Wholesale Distribution Center</h4>
          <p class="scm-card-subtitle">Welcome back, {{ Auth::user()->name }} | Managing bulk operations & retailer network</p>
        </div>
      </div>
      <div class="scm-status-badge scm-status-active">
        <i class="bi bi-check-circle me-1"></i>
        Distribution Active
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
          <h3 class="scm-metric-value">1,847</h3>
          <p class="scm-metric-label">Bulk Orders</p>
          <div class="scm-metric-trend positive">
            <i class="bi bi-arrow-up"></i>
            <span>+12.5%</span>
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
          <h3 class="scm-metric-value">342</h3>
          <p class="scm-metric-label">Active Retailers</p>
          <div class="scm-metric-trend positive">
            <i class="bi bi-arrow-up"></i>
            <span>+8.2%</span>
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
          <h3 class="scm-metric-value">89</h3>
          <p class="scm-metric-label">Pending Verifications</p>
          <div class="scm-metric-trend negative">
            <i class="bi bi-arrow-down"></i>
            <span>-3.1%</span>
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
          <h3 class="scm-metric-value">UGX 2.4M</h3>
          <p class="scm-metric-label">Monthly Revenue</p>
          <div class="scm-metric-trend positive">
            <i class="bi bi-arrow-up"></i>
            <span>+15.7%</span>
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
          <span class="badge bg-primary">24 Generated</span>
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
          <span class="badge bg-warning">23 Pending</span>
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
          <span class="badge bg-success">342 Active</span>
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
            89 Pending
          </div>
        </div>
      </div>
      <div class="scm-card-body">
        @include('partials.verify-orders', ['role' => 'wholesaler'])
      </div>
    </div>
  </div>
</div>

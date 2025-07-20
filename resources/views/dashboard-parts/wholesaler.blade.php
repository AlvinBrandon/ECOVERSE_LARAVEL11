<!-- Welcome Section -->
<div class="welcome-section">
  <div class="d-flex align-items-center">
    <i class="bi bi-person-circle text-primary me-3" style="font-size: 2rem;"></i>
    <div>
      <h5 class="mb-0">Welcome back, {{ Auth::user()->name }}!</h5>
      <p class="text-muted mb-0" style="font-size: 0.95rem;">Ready to manage your wholesale operations and retailer network</p>
    </div>
  </div>
</div>

<!-- Dashboard Header -->
<div class="dashboard-header">
  <div class="d-flex align-items-center">
    <img src="/assets/img/ecoverse-logo.svg" alt="Ecoverse Logo" class="ecoverse-logo">
    <div>
      <h2 class="mb-0">Wholesaler Dashboard</h2>
      <p class="mb-0">Bulk orders & distribution: Large-volume purchases, connect with retailers.</p>
    </div>
  </div>
</div>

<!-- Main Dashboard Cards -->
<div class="row">
  <div class="col-md-4">
    <div class="dashboard-card text-center">
      <i class="bi bi-bar-chart text-info" style="font-size:2.5rem;"></i>
      <h5 class="mt-3">Reports & Analytics</h5>
      <p>View comprehensive retailer orders and detailed analytics to track your wholesale performance.</p>
      <a href="{{ route('wholesaler.reports') }}" class="btn btn-info mt-2">
        <i class="bi bi-graph-up-arrow me-2"></i>
        Retailer Orders & Analytics
      </a>
    </div>
  </div>
  
  <div class="col-md-4">
    <div class="dashboard-card text-center">
      <i class="bi bi-boxes text-primary" style="font-size:2.5rem;"></i>
      <h5 class="mt-3">Bulk Orders</h5>
      <p>Place and manage large-volume orders efficiently with our streamlined bulk ordering system.</p>
      <a href="{{ route('sales.index') }}" class="btn btn-primary mt-2">
        <i class="bi bi-bag-check me-2"></i>
        Manage Bulk Orders
      </a>
    </div>
  </div>
  
  <div class="col-md-4">
    <div class="dashboard-card text-center">
      <i class="bi bi-people text-success" style="font-size:2.5rem;"></i>
      <h5 class="mt-3">Retailer Network</h5>
      <p>Connect with retailers for distribution and expand your wholesale reach across the network.</p>
      <a href="#" class="btn btn-success mt-2">
        <i class="bi bi-people me-2"></i>
        Retailer Network
      </a>
    </div>
  </div>
</div>

<!-- Retailer Orders Verification Section -->
<div class="row mt-4">
  <div class="col-12">
    <div class="dashboard-card">
      <div class="d-flex align-items-center mb-4">
        <i class="bi bi-clipboard-check text-warning me-3" style="font-size: 2rem;"></i>
        <div>
          <h5 class="mb-0">Verify Retailer Purchase Orders</h5>
          <p class="text-muted mb-0" style="font-size: 0.9rem;">Review and approve incoming retailer orders</p>
        </div>
      </div>
      @include('partials.verify-orders', ['role' => 'wholesaler'])
    </div>
  </div>
</div>

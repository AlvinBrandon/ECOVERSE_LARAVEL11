<div class="d-flex align-items-center mb-2">
    <h5 class="mb-0" style="color:#fff;">Welcome, {{ Auth::user()->name }}</h5>
</div>
<div class="dashboard-header d-flex align-items-center">
    <img src="/assets/img/ecoverse-logo.svg" alt="Ecoverse Logo" class="ecoverse-logo">
    <div>
      <h2 class="mb-0">Wholesaler Dashboard</h2>
      <p class="mb-0" style="font-size:1.1rem;">Bulk orders & distribution: Large-volume purchases, connect with retailers.</p>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <i class="bi bi-bar-chart text-info" style="font-size:2rem;"></i>
        <h5 class="mt-2">Reports & Analytics</h5>
        <p>View retailer orders and analytics.</p>
        <a href="{{ route('wholesaler.reports') }}" class="btn btn-info mt-2"><i class="bi bi-graph-up-arrow me-1"></i> Retailer Orders & Analytics</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <i class="bi bi-boxes text-primary" style="font-size:2rem;"></i>
        <h5 class="mt-2">Bulk Orders</h5>
        <p>Place and manage large-volume orders.</p>
        <a href="{{ route('sales.index') }}" class="btn btn-primary mt-2"><i class="bi bi-bag-check me-1"></i> Bulk Orders</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <i class="bi bi-people text-success" style="font-size:2rem;"></i>
        <h5 class="mt-2">Retailer Network</h5>
        <p>Connect with retailers for distribution.</p>
        <a href="#" class="btn btn-success mt-2"><i class="bi bi-people me-1"></i> Retailer Network</a>
      </div>
    </div>
</div>

<!-- Retailer Orders Verification Section -->
<div class="row mt-4">
  <div class="col-12">
    <div class="dashboard-card">
      <h5 class="mb-3"><i class="bi bi-clipboard-check text-warning"></i> Verify Retailer Purchase Orders</h5>
      @include('partials.verify-orders', ['role' => 'wholesaler'])
    </div>
  </div>
</div>

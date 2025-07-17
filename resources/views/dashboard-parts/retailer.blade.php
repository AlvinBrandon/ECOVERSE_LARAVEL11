<div class="dashboard-header d-flex align-items-center">
    <img src="/assets/img/ecoverse-logo.svg" alt="Ecoverse Logo" class="ecoverse-logo">
    <div>
      <h2 class="mb-0">Retailer Dashboard</h2>
      <p class="mb-0" style="font-size:1.1rem;">Resale & networking: Community, product sourcing, connect with wholesalers.</p>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <i class="bi bi-bar-chart text-info" style="font-size:2rem;"></i>
        <h5 class="mt-2">Reports & Analytics</h5>
        <p>View customer orders and analytics.</p>
        <a href="{{ route('retailer.reports') }}" class="btn btn-info mt-2"><i class="bi bi-graph-up-arrow me-1"></i> Customer Orders & Analytics</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <i class="bi bi-people text-primary" style="font-size:2rem;"></i>
        <h5 class="mt-2">Community</h5>
        <p>Collaborate and post product needs.</p>
        <a href="#" class="btn btn-primary mt-2"><i class="bi bi-chat-dots me-1"></i> Community Forum</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <i class="bi bi-box-seam text-success" style="font-size:2rem;"></i>
        <h5 class="mt-2">Product Sourcing</h5>
        <p>Source products and connect with wholesalers.</p>
        <a href="{{ route('sales.index') }}" class="btn btn-success mt-2"><i class="bi bi-bag-check me-1"></i> Source Products</a>
      </div>
    </div>
</div>

<!-- Customer Orders Verification Section -->
<div class="row mt-4">
  <div class="col-12">
    <div class="dashboard-card">
      <h5 class="mb-3"><i class="bi bi-clipboard-check text-warning"></i> Verify Customer Purchase Orders</h5>
      @include('partials.verify-orders', ['role' => 'retailer'])
    </div>
  </div>
</div>
</div>

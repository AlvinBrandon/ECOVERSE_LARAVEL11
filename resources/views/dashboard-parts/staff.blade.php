<div class="dashboard-header d-flex align-items-center">
    <img src="/assets/img/ecoverse-logo.svg" alt="Ecoverse Logo" class="ecoverse-logo">
    <div>
      <h2 class="mb-0">Staff Dashboard</h2>
      <p class="mb-0" style="font-size:1.1rem;">Collection & Processing: Add waste, update stock, handle logistics.</p>
    </div>
</div>
{{--bar for inventory management--}}
<div class="row">
    <div class="col-md-6">
      <div class="dashboard-card text-center">
        <i class="bi bi-box-seam text-primary" style="font-size:2rem;"></i>
        <h5 class="mt-2">Inventory</h5>
        <p>Manage and update inventory, process materials.</p>
        <a href="{{ route('inventory.index') }}" class="btn btn-primary mt-2"><i class="bi bi-archive me-1"></i> Go to Inventory</a>
      </div>
    </div>
{{--bar for managing logistics--}}
    <div class="col-md-6">
      <div class="dashboard-card text-center">
        <i class="bi bi-truck text-success" style="font-size:2rem;"></i>
        <h5 class="mt-2">Logistics</h5>
        <p>Handle stock transfers and logistics.</p>
        <a href="{{ route('stock_transfer.create') }}" class="btn btn-success mt-2"><i class="bi bi-truck me-1"></i> Stock Transfer</a>
      </div>
    </div>
{{--bar for managing orders--}}
    <div class="col-md-6 col-lg-6 mb-6">
    <div class="card shadow-sm border-0 h-100">
        <div class="card-body text-center">
            <div class="mb-3">
                <i class="bi bi-clipboard-data" style="font-size: 2rem; color: #0d6efd;"></i>
            </div>
            <h5 class="card-title">Manage Orders</h5>
            <p class="card-text">Track and manage waste orders placed by clients.</p>
            <a href="{{ route('staff.orders') }}" class="btn btn-primary">
                <i class="bi bi-list-check me-1"></i> View Orders
            </a>
        </div>
    </div>
</div>

</div>

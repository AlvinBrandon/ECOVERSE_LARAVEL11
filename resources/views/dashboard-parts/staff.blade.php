<div class="dashboard-header d-flex align-items-center">
    <img src="/assets/img/ecoverse-logo.svg" alt="Ecoverse Logo" class="ecoverse-logo">
    <div>
      <h2 class="mb-0">Staff Dashboard</h2>
      <p class="mb-0" style="font-size:1.1rem;">Collection & Processing: Add waste, update stock, handle logistics.</p>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
      <div class="dashboard-card text-center">
        <i class="bi bi-box-seam text-primary" style="font-size:2rem;"></i>
        <h5 class="mt-2">Inventory</h5>
        <p>Manage and update inventory, process materials.</p>
        <a href="{{ route('inventory.index') }}" class="btn btn-primary mt-2"><i class="bi bi-archive me-1"></i> Go to Inventory</a>
      </div>
    </div>
    <div class="col-md-6">
      <div class="dashboard-card text-center">
        <i class="bi bi-truck text-success" style="font-size:2rem;"></i>
        <h5 class="mt-2">Logistics</h5>
        <p>Handle stock transfers and logistics.</p>
        <a href="{{ route('stock_transfer.create') }}" class="btn btn-success mt-2"><i class="bi bi-truck me-1"></i> Stock Transfer</a>
      </div>
    </div>
</div>

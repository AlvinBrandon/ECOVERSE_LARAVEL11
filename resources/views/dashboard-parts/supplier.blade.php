<div class="dashboard-header d-flex align-items-center">
    <img src="/assets/img/ecoverse-logo.svg" alt="Ecoverse Logo" class="ecoverse-logo">
    <div>
      <h2 class="mb-0">Supplier Dashboard</h2>
      <p class="mb-0" style="font-size:1.1rem;">Waste input: Submit waste, track deliveries, view payments.</p>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
      <div class="dashboard-card text-center">
        <i class="bi bi-recycle text-primary" style="font-size:2rem;"></i>
        <h5 class="mt-2">Submit Raw Materials</h5>
        <p>Submit new waste/raw materials for processing.</p>
        <a href="{{ route('raw-materials.index') }}" class="btn btn-primary mt-2"><i class="bi bi-plus-circle me-1"></i> Submit Waste</a>
      </div>
    </div>
    <div class="col-md-6">
      <div class="dashboard-card text-center">
        <i class="bi bi-cash-coin text-success" style="font-size:2rem;"></i>
        <h5 class="mt-2">Payments</h5>
        <p>View your compensation and delivery status.</p>
        <a href="#" class="btn btn-success mt-2"><i class="bi bi-wallet2 me-1"></i> View Payments</a>
      </div>
    </div>
</div>

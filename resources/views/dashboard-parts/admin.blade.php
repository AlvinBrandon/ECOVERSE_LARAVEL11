<div class="dashboard-header d-flex align-items-center">
    <img src="/assets/img/ecoverse-logo.svg" alt="Ecoverse Logo" class="ecoverse-logo">
    <div>
      <h2 class="mb-0">Admin Dashboard</h2>
      <p class="mb-0" style="font-size:1.1rem;">Full control: Reports, user management, inventory, system config.</p>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <i class="bi bi-people text-primary" style="font-size:2rem;"></i>
        <h5 class="mt-2">User Management</h5>
        <p>Manage all users and roles in the system.</p>
        <a href="{{ route('user-management') }}" class="btn btn-primary mt-2"><i class="bi bi-person-lines-fill me-1"></i> Manage Users</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <i class="bi bi-box-seam text-success" style="font-size:2rem;"></i>
        <h5 class="mt-2">Inventory</h5>
        <p>Full access to all inventory and analytics.</p>
        <a href="{{ route('inventory.index') }}" class="btn btn-success mt-2"><i class="bi bi-archive me-1"></i> Go to Inventory</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <i class="bi bi-bar-chart text-info" style="font-size:2rem;"></i>
        <h5 class="mt-2">Reports & Analytics</h5>
        <p>View system-wide reports and analytics.</p>
        <a href="{{ route('admin.sales.report') }}" class="btn btn-info mt-2"><i class="bi bi-graph-up-arrow me-1"></i> Sales Report</a>
      </div>
    </div>
</div>

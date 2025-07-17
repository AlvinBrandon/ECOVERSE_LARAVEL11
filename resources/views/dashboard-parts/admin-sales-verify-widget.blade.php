<div class="col-md-4">
  <div class="dashboard-card text-center">
    <i class="bi bi-truck text-primary" style="font-size:2rem;"></i>
    <h5 class="mt-2">Pending Sales Approvals</h5>
    <p>Review and verify sales orders, update delivery status, and manage dispatches.</p>
    <a href="{{ route('admin.sales.pending') }}" class="btn btn-primary mt-2">
      <i class="bi bi-clipboard-check me-1"></i> Go to Sales Verification
    </a>
    <div class="mt-3">
      <span class="badge bg-warning text-dark" style="font-size:1rem;">
        {{ $pendingSalesCount ?? '0' }} Pending
      </span>
    </div>
  </div>
</div>

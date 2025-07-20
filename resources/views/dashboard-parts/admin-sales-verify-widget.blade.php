<div class="col-md-4">
  <div class="action-card card-primary">
    <div class="card-icon">
      <i class="bi bi-truck"></i>
    </div>
    <div class="card-content">
      <h5>Pending Sales Approvals</h5>
      <p>Review and verify sales orders, update delivery status, and manage dispatches.</p>
      <a href="{{ route('admin.sales.pending') }}" class="btn btn-primary btn-modern">
        <i class="bi bi-clipboard-check me-2"></i>Go to Sales Verification
      </a>
      <div class="mt-3">
        <span class="badge bg-warning text-dark fs-6 px-3 py-2">
          {{ $pendingSalesCount ?? '0' }} Pending
        </span>
      </div>
    </div>
  </div>
</div>

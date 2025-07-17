
@extends('layouts.app')

@section('content')
<style>
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%) !important;
  }
  .dashboard-card {
    background: rgba(255,255,255,0.97);
    border-radius: 1rem;
    box-shadow: 0 4px 24px rgba(16, 185, 129, 0.08);
    padding: 2rem 1.5rem;
    margin-bottom: 2rem;
  }
  .dashboard-header {
    background: linear-gradient(90deg, #6366f1 0%, #10b981 100%) !important;
    color: #fff !important;
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
    padding: 1.5rem 1.5rem 1rem 1.5rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
  }
  .dashboard-header .bi {
    font-size: 2.5rem;
    margin-right: 1rem;
    vertical-align: middle;
  }
</style>
<div class="container">
  <div class="dashboard-header">
    <i class="bi bi-truck"></i>
    <div>
      <h2 class="mb-0">Pending Sales Approvals</h2>
      <p class="mb-0" style="font-size:1.1rem;">Review, verify, and update delivery status for all sales orders.</p>
    </div>
  </div>
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  <div class="dashboard-card">
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="bg-light">
          <tr>
            <th><i class="bi bi-hash"></i> Order ID</th>
            <th><i class="bi bi-person"></i> User</th>
            <th><i class="bi bi-box"></i> Product</th>
            <th><i class="bi bi-123"></i> Quantity</th>
            <th><i class="bi bi-calendar"></i> Date</th>
            <th><i class="bi bi-info-circle"></i> Status</th>
            <th><i class="bi bi-gear"></i> Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($sales as $sale)
          <tr>
            <td>{{ $sale->id }}</td>
            <td>{{ $sale->user->name ?? 'N/A' }}</td>
            <td>{{ $sale->product->name ?? 'N/A' }}</td>
            <td>{{ $sale->quantity ?? '-' }}</td>
            <td>{{ $sale->created_at ? $sale->created_at->format('Y-m-d H:i') : '-' }}</td>
            <td>
              @if($sale->status === 'pending')
                <span class="badge bg-warning text-dark">Pending</span>
              @elseif($sale->status === 'approved')
                <span class="badge bg-success">Approved</span>
              @elseif($sale->status === 'rejected')
                <span class="badge bg-danger">Rejected</span>
              @else
                <span class="badge bg-secondary">{{ ucfirst($sale->status) }}</span>
              @endif
            </td>
            <td>
              <form action="{{ route('admin.sales.verify', $sale->id) }}" method="POST" class="mb-2">
                @csrf
                <div class="mb-2">
                  <label for="delivery_status_{{ $sale->id }}" class="form-label">Delivery Status</label>
                  <select name="delivery_status" id="delivery_status_{{ $sale->id }}" class="form-select form-select-sm">
                    <option value="pending" {{ $sale->delivery_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="dispatched" {{ $sale->delivery_status == 'dispatched' ? 'selected' : '' }}>Dispatched</option>
                    <option value="delivered" {{ $sale->delivery_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="pickup_arranged" {{ $sale->delivery_status == 'pickup_arranged' ? 'selected' : '' }}>Pickup Arranged</option>
                  </select>
                </div>
                <div class="mb-2">
                  <label for="tracking_code_{{ $sale->id }}" class="form-label">Tracking Code</label>
                  <input type="text" name="tracking_code" id="tracking_code_{{ $sale->id }}" class="form-control form-control-sm" value="{{ $sale->tracking_code }}">
                </div>
                <div class="mb-2">
                  <label for="dispatch_log_{{ $sale->id }}" class="form-label">Dispatch Log</label>
                  <textarea name="dispatch_log" id="dispatch_log_{{ $sale->id }}" class="form-control form-control-sm" rows="2">{{ $sale->dispatch_log }}</textarea>
                </div>
                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check-circle"></i> Verify & Update</button>
              </form>
              <form action="{{ route('admin.sales.reject', $sale->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-x-circle"></i> Reject</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center text-muted">No pending sales approvals.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

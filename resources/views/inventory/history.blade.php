@extends('layouts.app')

@section('content')
<style>
  body, .main-content, .container-fluid, .container {
    background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%) !important;
  }
  .dashboard-card, .history-card {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    box-shadow: 0 4px 24px rgba(16, 185, 129, 0.08);
    padding: 2rem 1.5rem;
    margin-bottom: 2rem;
    transition: box-shadow 0.2s, transform 0.2s;
  }
  .dashboard-card:hover, .history-card:hover {
    box-shadow: 0 8px 32px rgba(99,102,241,0.18), 0 2px 8px rgba(16,185,129,0.10);
    transform: translateY(-4px) scale(1.025);
    z-index: 2;
    cursor: pointer;
  }
  .history-header {
    background: linear-gradient(90deg, #6366f1 0%, #10b981 100%) !important;
    color: #fff !important;
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
    padding: 1.5rem 1.5rem 1rem 1.5rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
  }
  .history-icon {
    font-size: 2.5rem;
    margin-right: 1rem;
    vertical-align: middle;
  }
</style>
<div class="container py-4">
  <div class="history-header">
    <i class="bi bi-clock-history history-icon"></i>
    <div>
      <h2 class="mb-0">Stock History</h2>
      <p class="mb-0" style="font-size:1.1rem;">View all inventory changes and audit logs.</p>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="history-card">
        @yield('history-table')
      </div>
    </div>
  </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

@section('history-table')
<table class="table table-striped table-hover">
    <thead class="bg-light">
        <tr>
            <th>Date</th>
            <th>User</th>
            <th>Product</th>
            <th>Batch</th>
            <th>Action</th>
            <th>Qty Before</th>
            <th>Qty After</th>
            <th>Note</th>
        </tr>
    </thead>
    <tbody>
        @forelse($histories as $history)
            <tr>
                <td>{{ $history->created_at->format('Y-m-d H:i') }}</td>
                <td>{{ $history->user->name ?? 'System' }}</td>
                <td>{{ $history->inventory->product->name ?? 'N/A' }}</td>
                <td>{{ $history->inventory->batch_id ?? 'N/A' }}</td>
                <td>
                    <span class="badge bg-{{ $history->action === 'add' ? 'success' : ($history->action === 'deduct' ? 'danger' : 'info') }}">
                        {{ ucfirst($history->action) }}
                    </span>
                </td>
                <td>{{ $history->quantity_before }}</td>
                <td>{{ $history->quantity_after }}</td>
                <td>{{ $history->note }}</td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center">No stock history found.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection

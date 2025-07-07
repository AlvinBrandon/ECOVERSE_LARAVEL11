@extends('layouts.app')

@section('content')
<style>
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%) !important;
  }
  .card {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    box-shadow: 0 4px 24px rgba(16, 185, 129, 0.08);
  }
  .card-header.bg-gradient-primary {
    background: linear-gradient(90deg, #6366f1 0%, #10b981 100%) !important;
    color: #fff !important;
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
  }
  .btn-info, .btn-warning, .btn-success, .btn-danger, .btn-primary {
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.08);
  }
  .table thead.bg-light {
    background: #f0fdfa !important;
  }
</style>
<div class="container-fluid py-4">
  <div class="row mb-4">
    <div class="col-12">
      <h4 class="text-dark">Stock History</h4>
      <a href="{{ route('inventory.index') }}" class="btn btn-secondary mb-3">Back to Inventory</a>
      <a href="{{ route('dashboard') }}" class="btn btn-outline-dark me-2"><i class="bi bi-house-door me-1"></i> Home</a>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header pb-0">
          <h6>All Stock Changes</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Batch ID</th>
                  <th>Action</th>
                  <th>User</th>
                  <th>Before</th>
                  <th>After</th>
                  <th>Note</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($histories as $history)
                <tr>
                  <td>{{ $history->inventory->product->name ?? '-' }}</td>
                  <td>{{ $history->inventory->batch_id ?? '-' }}</td>
                  <td>{{ ucfirst($history->action) }}</td>
                  <td>{{ $history->user->name ?? 'System' }}</td>
                  <td>{{ $history->quantity_before }}</td>
                  <td>{{ $history->quantity_after }}</td>
                  <td>{{ $history->note }}</td>
                  <td>{{ $history->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

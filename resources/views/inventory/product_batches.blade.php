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
    <div class="col-12 d-flex align-items-center justify-content-between">
      <h4 class="text-dark fw-bold mb-0"><i class="bi bi-cube me-2"></i>Product Details: <span class="text-primary">{{ $product->name }}</span></h4>
      <a href="{{ route('inventory.index') }}" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Back to Inventory</a>
    </div>
  </div>
  <div class="row mb-4">
    <div class="col-12">
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-gradient-primary text-white pb-2 d-flex align-items-center">
          <i class="bi bi-archive me-2"></i>
          <h6 class="mb-0">Batch Inventory (Stock In)</h6>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table align-items-center mb-0 table-hover">
              <thead class="bg-light">
                <tr>
                  <th>Batch ID</th>
                  <th>Quantity</th>
                  <th>Expiry Date</th>
                  <th>Date Added</th>
                </tr>
              </thead>
              <tbody>
                @forelse($product->batches as $batch)
                <tr>
                  <td>{{ $batch->batch_id }}</td>
                  <td>{{ $batch->quantity }} <span class="unit-label">pcs</span></td>
                  <td>{{ $batch->expiry_date ? \Carbon\Carbon::parse($batch->expiry_date)->format('Y-m-d') : '-' }}</td>
                  <td>{{ $batch->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="4" class="text-center">No batches found for this product.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-4">
    <div class="col-12">
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-gradient-primary text-white pb-2 d-flex align-items-center">
          <i class="bi bi-cart-check me-2"></i>
          <h6 class="mb-0">Sales / Outgoing Stock</h6>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table align-items-center mb-0 table-hover">
              <thead class="bg-light">
                <tr>
                  <th>Order ID</th>
                  <th>Batch ID</th>
                  <th>Type</th>
                  <th>Quantity</th>
                  <th>Sold To</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                @forelse($sales as $sale)
                <tr>
                  <td>{{ $sale->id }}</td>
                  <td>-</td>
                  <td>Out</td>
                  <td>{{ $sale->quantity }}</td>
                  <td>{{ $sale->user->name ?? 'N/A' }}</td>
                  <td>{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center">No sales found for this product.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-4">
    <div class="col-12">
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-gradient-primary text-white pb-2 d-flex align-items-center">
          <i class="bi bi-clock-history me-2"></i>
          <h6 class="mb-0">Stock Movement Records</h6>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table align-items-center mb-0 table-hover">
              <thead class="bg-light">
                <tr>
                  <th>Date</th>
                  <th>Batch ID</th>
                  <th>Action</th>
                  <th>Quantity Before</th>
                  <th>Quantity After</th>
                  <th>User</th>
                  <th>Note</th>
                </tr>
              </thead>
              <tbody>
                @forelse($movements as $move)
                <tr>
                  <td>{{ $move->created_at->format('Y-m-d H:i') }}</td>
                  <td>{{ $move->inventory->batch_id ?? '-' }}</td>
                  <td>{{ ucfirst($move->action) }}</td>
                  <td>{{ $move->quantity_before }}</td>
                  <td>{{ $move->quantity_after }}</td>
                  <td>{{ $move->user->name ?? 'N/A' }}</td>
                  <td>{{ $move->note }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="7" class="text-center">No movement records found for this product.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

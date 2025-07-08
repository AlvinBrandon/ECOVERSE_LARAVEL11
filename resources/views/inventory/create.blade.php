<!-- =============================== -->
<!-- 2. Inventory Create Form (inventory/create.blade.php) -->
<!-- =============================== -->
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
      <h4 class="text-dark">Add or Update Inventory</h4>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <form method="POST" action="{{ route('inventory.store') }}">
            @csrf

            <div class="mb-3">
              <label for="product_id" class="form-label">Select Product:</label>
              <select name="product_id" class="form-control" required>
                <option value="" disabled selected>Select a product</option>
                @foreach ($products as $product)
                  <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="raw_material_id" class="form-label">Select Raw Material:</label>
              <select name="raw_material_id" class="form-control">
                <option value="" disabled selected>Select a raw material</option>
                @foreach ($rawMaterials as $material)
                  <option value="{{ $material->id }}">{{ $material->name }} ({{ $material->type }})</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="batch_id" class="form-label">Batch ID (Optional):</label>
              <input type="text" name="batch_id" class="form-control">
            </div>

            <div class="mb-3">
              <label for="quantity" class="form-label">Quantity to Add:</label>
              <input type="number" name="quantity" class="form-control" min="1" required>
            </div>

            <button type="submit" class="btn btn-success">Update Inventory</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <a href="{{ url('/') }}" class="btn btn-outline-dark me-2"><i class="bi bi-house-door me-1"></i> Home</a>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

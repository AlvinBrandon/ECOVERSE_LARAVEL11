<!-- =============================== -->
<!-- 3. Inventory Deduct Form (inventory/deduct.blade.php) -->
<!-- =============================== -->
@extends('layouts.app')

@section('content')
<style>
  body, .main-content, .container-fluid, .container {
    background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%) !important;
  }
  .dashboard-card, .inventory-card {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    box-shadow: 0 4px 24px rgba(16, 185, 129, 0.08);
    padding: 2rem 1.5rem;
    margin-bottom: 2rem;
    transition: box-shadow 0.2s, transform 0.2s;
  }
  .dashboard-card:hover, .inventory-card:hover {
    box-shadow: 0 8px 32px rgba(99,102,241,0.18), 0 2px 8px rgba(16,185,129,0.10);
    transform: translateY(-4px) scale(1.025);
    z-index: 2;
    cursor: pointer;
  }
  .inventory-header {
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
  .inventory-icon {
    font-size: 2.5rem;
    margin-right: 1rem;
    vertical-align: middle;
  }
</style>
<div class="container py-4">
  <div class="inventory-header">
    <i class="bi bi-dash-circle inventory-icon"></i>
    <div>
      <h2 class="mb-0">Deduct Stock</h2>
      <p class="mb-0" style="font-size:1.1rem;">Remove inventory from batches or raw materials.</p>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="inventory-card">
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <!-- Deduct Stock Form -->
        <form method="POST" action="{{ route('inventory.deduct') }}">
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
            <label for="batch_id" class="form-label">Batch ID (Optional):</label>
            <input type="text" name="batch_id" class="form-control">
          </div>

          <div class="mb-3">
            <label for="quantity" class="form-label">Quantity to Deduct:</label>
            <input type="number" name="quantity" class="form-control" min="1" required>
          </div>

          <button type="submit" class="btn btn-danger">Deduct Stock</button>
        </form>
        <!-- End of Deduct Stock Form -->
      </div>
    </div>
  </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

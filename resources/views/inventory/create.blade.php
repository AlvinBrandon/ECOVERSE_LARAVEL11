!-- =============================== -->
<!-- 2. Inventory Create Form (inventory/create.blade.php) -->
<!-- =============================== -->
@extends('layouts.app')

@section('content')
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
</div>
@endsection

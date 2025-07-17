@extends('layouts.app')

@section('content')
<style>
  body, .main-content, .container-fluid, .container {
    background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%) !important;
  }
  .dashboard-card, .po-card {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    box-shadow: 0 4px 24px rgba(16, 185, 129, 0.08);
    padding: 2rem 1.5rem;
    margin-bottom: 2rem;
    transition: box-shadow 0.2s, transform 0.2s;
  }
  .dashboard-card:hover, .po-card:hover {
    box-shadow: 0 8px 32px rgba(99,102,241,0.18), 0 2px 8px rgba(16,185,129,0.10);
    transform: translateY(-4px) scale(1.025);
    z-index: 2;
    cursor: pointer;
  }
  .po-header {
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
  .po-icon {
    font-size: 2.5rem;
    margin-right: 1rem;
    vertical-align: middle;
  }
</style>
<div class="container py-4">
  <div class="po-header">
    <i class="bi bi-file-earmark-plus po-icon"></i>
    <div>
      <h2 class="mb-0">Create Purchase Order</h2>
      <p class="mb-0" style="font-size:1.1rem;">Send a new purchase order to a supplier.</p>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="po-card">
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
        <form action="{{ route('admin.purchase_orders.store') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="supplier_id" class="form-label">Supplier</label>
            <select name="supplier_id" id="supplier_id" class="form-select" required>
              <option value="">Select Supplier</option>
              @foreach($suppliers as $supplier)
                <option value="{{ $supplier->id }}">{{ $supplier->name }} ({{ $supplier->email }})</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="raw_material_id" class="form-label">Raw Material</label>
            <select name="raw_material_id" id="raw_material_id" class="form-select" required>
              <option value="">Select Material</option>
              @foreach($rawMaterials as $material)
                <option value="{{ $material->id }}">{{ $material->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
          </div>
          <div class="mb-3">
            <label for="price" class="form-label">Price (per unit) <span class="text-primary">(UGX)</span></label>
            <input type="number" name="price" id="price" class="form-control" min="0" step="0.01" required placeholder="Enter price in Ugandan Shillings (UGX)">
          </div>
          <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary"><i class="bi bi-file-earmark-plus"></i> Create PO</button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary"><i class="bi bi-arrow-return-left"></i> Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

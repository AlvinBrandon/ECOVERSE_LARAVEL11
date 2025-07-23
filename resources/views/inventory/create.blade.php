@extends('layouts.app')

@section('content')
<style>
  /* Modern Professional Add Stock Styling */
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
  }

  /* Page Header */
  .page-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    color: white;
  }

  .page-header h4 {
    margin: 0;
    font-weight: 600;
    font-size: 1.5rem;
  }

  .page-header .btn {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    backdrop-filter: blur(10px);
    transition: all 0.2s ease;
  }

  .page-header .btn:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.3);
    color: white;
    transform: translateY(-2px);
  }

  /* Form Card */
  .form-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    border: none;
  }

  .form-card .card-body {
    padding: 2rem;
  }

  /* Form Styling */
  .form-label {
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
  }

  .form-control, .form-select {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    background: #fafbfc;
  }

  .form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    background: white;
  }

  .form-control:hover, .form-select:hover {
    border-color: #d1d5db;
    background: white;
  }

  /* Required Field Indicator */
  .required {
    color: #dc2626;
    font-weight: 600;
  }

  /* Form Help Text */
  .form-text {
    color: #6b7280;
    font-size: 0.75rem;
    margin-top: 0.25rem;
  }

  /* Two Column Layout */
  .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
  }

  @media (max-width: 768px) {
    .form-row {
      grid-template-columns: 1fr;
      gap: 1rem;
    }
  }

  /* Alert Styling */
  .alert {
    border: none;
    border-radius: 0.75rem;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    font-size: 0.875rem;
  }

  .alert-success {
    background: #dcfce7;
    color: #166534;
    border-left: 4px solid #22c55e;
  }

  .alert-danger {
    background: #fee2e2;
    color: #991b1b;
    border-left: 4px solid #ef4444;
  }

  .alert ul {
    margin: 0;
    padding-left: 1rem;
  }

  /* Button Styling */
  .btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    border: none;
    border-radius: 0.5rem;
    padding: 0.75rem 2rem;
    font-weight: 500;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
  }

  .btn-secondary {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    color: #475569;
    border-radius: 0.5rem;
    padding: 0.75rem 2rem;
    font-weight: 500;
    font-size: 0.875rem;
    transition: all 0.2s ease;
  }

  .btn-secondary:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
    color: #334155;
    transform: translateY(-2px);
  }

  /* Input Group for Batch ID */
  .input-group {
    position: relative;
  }

  .input-group .form-control {
    padding-right: 3rem;
  }

  .input-group-text {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6b7280;
    z-index: 10;
    pointer-events: none;
  }

  /* Form Section Headers */
  .form-section {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #f3f4f6;
  }

  .form-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
  }

  .section-title {
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .section-title i {
    color: #6b7280;
  }

  /* Form Actions */
  .form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    padding-top: 1.5rem;
    border-top: 1px solid #f3f4f6;
    margin-top: 2rem;
  }

  @media (max-width: 576px) {
    .form-actions {
      flex-direction: column;
    }
    
    .form-actions .btn {
      width: 100%;
    }
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .page-header {
      padding: 1.5rem;
    }

    .page-header h4 {
      font-size: 1.25rem;
    }

    .form-card .card-body {
      padding: 1.5rem;
    }
  }
</style>

<div class="container-fluid py-4">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h4><i class="bi bi-plus-circle me-2"></i>Add Stock</h4>
        <p class="mb-0 opacity-75">Add new inventory batches or raw materials</p>
      </div>
      <a href="{{ route('dashboard') }}" class="btn">
        <i class="bi bi-house-door me-1"></i>Home
      </a>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
      <!-- Form Card -->
      <div class="card form-card">
        <div class="card-body">
          <!-- Success/Error Messages -->
          @if(session('success'))
            <div class="alert alert-success">
              <i class="bi bi-check-circle me-2"></i>
              {{ session('success') }}
            </div>
          @endif

          @if($errors->any())
            <div class="alert alert-danger">
              <i class="bi bi-exclamation-triangle me-2"></i>
              <strong>Please fix the following errors:</strong>
              <ul class="mt-2 mb-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <!-- Add Stock Form -->
          <form method="POST" action="{{ route('inventory.store') }}">
            @csrf

            <!-- Item Selection Section -->
            <div class="form-section">
              <h5 class="section-title">
                <i class="bi bi-box"></i>
                Item Selection
              </h5>
              
              <div class="form-row">
                <div class="mb-3">
                  <label for="product_id" class="form-label">Select Product</label>
                  <select name="product_id" id="product_id" class="form-select">
                    <option value="">Choose a product...</option>
                    @foreach ($products as $product)
                      <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                      </option>
                    @endforeach
                  </select>
                  <div class="form-text">Select a product to add to inventory</div>
                </div>

                <div class="mb-3">
                  <label for="raw_material_id" class="form-label">Select Raw Material</label>
                  <select name="raw_material_id" id="raw_material_id" class="form-select">
                    <option value="">Choose a raw material...</option>
                    @foreach ($rawMaterials as $material)
                      <option value="{{ $material->id }}" {{ old('raw_material_id') == $material->id ? 'selected' : '' }}>
                        {{ $material->name }} ({{ $material->type }})
                      </option>
                    @endforeach
                  </select>
                  <div class="form-text">Or select a raw material instead</div>
                </div>
              </div>
            </div>

            <!-- Batch Information Section -->
            <div class="form-section">
              <h5 class="section-title">
                <i class="bi bi-archive"></i>
                Batch Information
              </h5>
              
              <div class="form-row">
                <div class="mb-3">
                  <label for="batch_id" class="form-label">
                    Batch ID <span class="required">*</span>
                  </label>
                  <div class="input-group">
                    <input type="text" 
                           name="batch_id" 
                           id="batch_id" 
                           class="form-control" 
                           value="{{ old('batch_id') }}" 
                           required 
                           placeholder="Enter unique batch ID">
                    <span class="input-group-text">
                      <i class="bi bi-hash"></i>
                    </span>
                  </div>
                  <div class="form-text">Each restock must have a unique batch ID</div>
                </div>

                <div class="mb-3">
                  <label for="expiry_date" class="form-label">Expiry Date</label>
                  <input type="date" 
                         name="expiry_date" 
                         id="expiry_date" 
                         class="form-control" 
                         value="{{ old('expiry_date') }}">
                  <div class="form-text">Optional: Set expiry date for perishable items</div>
                </div>
              </div>
            </div>

            <!-- Quantity Section -->
            <div class="form-section">
              <h5 class="section-title">
                <i class="bi bi-plus-circle"></i>
                Quantity Details
              </h5>
              
              <div class="mb-3">
                <label for="quantity" class="form-label">
                  Quantity to Add <span class="required">*</span>
                </label>
                <input type="number" 
                       name="quantity" 
                       id="quantity" 
                       class="form-control" 
                       value="{{ old('quantity') }}" 
                       min="1" 
                       required 
                       placeholder="Enter quantity to add">
                <div class="form-text">Enter the number of units to add to inventory</div>
              </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
              <a href="{{ route('inventory.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Cancel
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Add to Inventory
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

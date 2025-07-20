@extends('layouts.app')

@section('content')
<style>
  /* Global Poppins Font Implementation */
  * {
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
  }

  body, .main-content, .container-fluid, .container {
    background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%) !important;
    font-family: 'Poppins', sans-serif !important;
    min-height: 10vh;
    margin: 0 !important;
    padding: 0 !important;
  }

  .main-content {
    padding-top: 0 !important;
    margin-top: 0 !important;
  }

  /* Override any layout padding/margin */
  .app-content, .content, #app, main {
    padding-top: 0 !important;
    margin-top: 0 !important;
  }

  /* Specifically target the main element from layout */
  main.py-4 {
    padding-top: 0 !important;
    padding-bottom: 1rem !important;
  }

  /* Remove Bootstrap container default margins */
  .container, .container-fluid, .container-sm, .container-md, .container-lg, .container-xl {
    margin-top: 0 !important;
    padding-top: 0 !important;
  }

  .page-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
    color: white;
    padding: 2rem 1.5rem;
    border-radius: 1rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(30, 41, 59, 0.2);
    border: 1px solid rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .page-header h2 {
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
  }

  .page-header p {
    opacity: 0.9;
    font-size: 1.1rem;
    margin-bottom: 0;
    font-weight: 400;
  }

  .page-header i {
    font-size: 2.5rem;
    opacity: 0.9;
  }

  .content-section {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.12);
    border: 1px solid rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
  }

  .form-container {
    max-width: 600px;
    margin: 0 auto;
  }

  .form-group {
    margin-bottom: 1.5rem;
  }

  .form-label {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    display: block;
    font-size: 0.9rem;
  }

  .form-control, .form-select {
    font-family: 'Poppins', sans-serif !important;
    border: 2px solid rgba(226, 232, 240, 0.6);
    border-radius: 0.75rem;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(5px);
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  }

  .form-control:focus, .form-select:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1), 0 4px 12px rgba(0,0,0,0.08);
    background: white;
    outline: none;
  }

  .form-control::placeholder {
    color: #9ca3af;
    font-style: italic;
  }

  .btn {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 500;
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: none;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    cursor: pointer;
    gap: 0.5rem;
    font-size: 0.9rem;
  }

  .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  }

  .btn-primary {
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    color: white;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
    color: white;
  }

  .btn-secondary {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
  }

  .btn-secondary:hover {
    background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
    color: white;
  }

  .alert {
    border-radius: 0.75rem;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    border: none;
    font-weight: 500;
    font-family: 'Poppins', sans-serif !important;
  }

  .alert-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
    border: 1px solid rgba(16, 185, 129, 0.2);
  }

  .alert-danger {
    background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
    color: #991b1b;
    border: 1px solid rgba(239, 68, 68, 0.2);
  }

  .alert ul {
    margin-bottom: 0;
    padding-left: 1rem;
  }

  .text-primary {
    color: #6366f1 !important;
    font-weight: 600;
  }

  .action-buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 2rem;
    gap: 1rem;
  }

  /* Icon styling */
  .bi {
    font-size: 1rem;
  }

  /* Form focus effects */
  .form-group:focus-within .form-label {
    color: #6366f1;
    transform: translateY(-2px);
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .page-header {
      padding: 1.5rem 1rem;
      flex-direction: column;
      text-align: center;
      gap: 0.5rem;
    }
    
    .page-header h2 {
      font-size: 1.5rem;
    }
    
    .content-section {
      padding: 1.5rem 1rem;
    }

    .action-buttons {
      flex-direction: column-reverse;
      gap: 0.75rem;
    }

    .btn {
      width: 100%;
    }
  }

  /* Professional spacing and layout */
  .container {
    padding: 0.5rem 1.5rem 2rem 1.5rem !important;
    margin-top: 0 !important;
  }

  /* Input group styling for currency */
  .input-group {
    position: relative;
  }

  .input-group .form-control {
    padding-left: 3rem;
  }

  .currency-symbol {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    font-weight: 600;
    z-index: 5;
    pointer-events: none;
  }

  /* Enhanced form styling */
  .mb-3 {
    margin-bottom: 1.5rem !important;
  }

  /* Select dropdown arrow styling */
  .form-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23374151' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 12px;
  }
</style>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<div class="container">
  <!-- Page Header -->
  <div class="page-header">
    <i class="bi bi-file-earmark-plus"></i>
    <div>
      <h2>Create Purchase Order</h2>
      <p>Send a new purchase order to a supplier</p>
    </div>
  </div>

  <!-- Content Section -->
  <div class="content-section">
    <div class="form-container">
      @if(session('success'))
        <div class="alert alert-success">
          <i class="bi bi-check-circle me-2"></i>
          {{ session('success') }}
        </div>
      @endif
      
      @if($errors->any())
        <div class="alert alert-danger">
          <i class="bi bi-exclamation-triangle me-2"></i>
          <strong>Please correct the following errors:</strong>
          <ul class="mt-2">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('admin.purchase_orders.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
          <label for="supplier_id" class="form-label">
            <i class="bi bi-building me-2"></i>Supplier
          </label>
          <select name="supplier_id" id="supplier_id" class="form-select" required>
            <option value="">Select a supplier...</option>
            @foreach($suppliers as $supplier)
              <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                {{ $supplier->name }} ({{ $supplier->email }})
              </option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="raw_material_id" class="form-label">
            <i class="bi bi-box me-2"></i>Raw Material
          </label>
          <select name="raw_material_id" id="raw_material_id" class="form-select" required>
            <option value="">Select a material...</option>
            @foreach($rawMaterials as $material)
              <option value="{{ $material->id }}" {{ old('raw_material_id') == $material->id ? 'selected' : '' }}>
                {{ $material->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="quantity" class="form-label">
            <i class="bi bi-123 me-2"></i>Quantity
          </label>
          <input type="number" 
                 name="quantity" 
                 id="quantity" 
                 class="form-control" 
                 min="1" 
                 value="{{ old('quantity') }}"
                 placeholder="Enter quantity needed"
                 required>
        </div>

        <div class="form-group">
          <label for="price" class="form-label">
            <i class="bi bi-currency-exchange me-2"></i>Price per Unit <span class="text-primary">(UGX)</span>
          </label>
          <div class="input-group">
            <span class="currency-symbol">UGX</span>
            <input type="number" 
                   name="price" 
                   id="price" 
                   class="form-control" 
                   min="0" 
                   step="0.01" 
                   value="{{ old('price') }}"
                   placeholder="0.00"
                   required>
          </div>
          <small class="text-muted mt-1 d-block">
            <i class="bi bi-info-circle me-1"></i>
            Enter the price per unit in Ugandan Shillings
          </small>
        </div>

        <div class="action-buttons">
          <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Cancel
          </a>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-file-earmark-plus"></i>
            Create Purchase Order
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

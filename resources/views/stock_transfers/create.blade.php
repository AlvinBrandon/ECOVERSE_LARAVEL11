@extends('layouts.app')

@section('content')
<style>
  /* Global Poppins Font Implementation */
  * {
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
  }

  body, .main-content, .container-fluid {
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

  .content-section {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.12);
    border: 1px solid rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
  }

  .transfer-card {
    background: rgba(255,255,255,0.9);
    border-radius: 1rem;
    border: 1px solid rgba(226, 232, 240, 0.6);
    padding: 2rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(16, 185, 129, 0.08);
    backdrop-filter: blur(5px);
  }

  .transfer-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(16, 185, 129, 0.15);
    border-color: rgba(16, 185, 129, 0.3);
  }

  .form-label {
    font-family: 'Poppins', sans-serif !important;
    color: #374151;
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 0.5rem;
  }

  .form-control, .form-select {
    font-family: 'Poppins', sans-serif !important;
    border: 1px solid #d1d5db;
    border-radius: 0.75rem;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    background: white;
    transition: all 0.3s ease;
    margin-bottom: 1rem;
  }

  .form-control:focus, .form-select:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
  }

  .btn {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 500;
    border-radius: 0.75rem;
    padding: 0.75rem 1.5rem;
    border: none;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    cursor: pointer;
    gap: 0.5rem;
  }

  .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
  }

  .btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    font-size: 0.95rem;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    color: white;
  }

  .btn-secondary {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
    font-size: 0.95rem;
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
    padding-left: 1.5rem;
  }

  /* Form styling */
  .mb-3 {
    margin-bottom: 1.5rem !important;
  }

  textarea.form-control {
    min-height: 100px;
    resize: vertical;
  }

  /* Button container */
  .form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(229, 231, 235, 0.6);
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .page-header {
      padding: 1.5rem 1rem;
    }
    
    .page-header h2 {
      font-size: 1.5rem;
    }
    
    .content-section {
      padding: 1.5rem 1rem;
    }
    
    .transfer-card {
      padding: 1.5rem 1rem;
    }

    .form-actions {
      flex-direction: column;
      gap: 1rem;
    }

    .btn {
      width: 100%;
      justify-content: center;
    }
  }

  /* Professional spacing and layout */
  .container-fluid {
    padding: 0.5rem 1.5rem 2rem 1.5rem !important;
    margin-top: 0 !important;
  }
</style>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<div class="container-fluid">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center">
      <i class="bi bi-arrow-left-right me-3" style="font-size: 2.5rem;"></i>
      <div>
        <h2>Stock Transfer</h2>
        <p>Move inventory between locations and batches</p>
      </div>
    </div>
  </div>

  <!-- Content Section -->
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="content-section">
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
            <ul class="mt-2">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="transfer-card">
          <form action="{{ route('stock_transfer.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
              <label for="inventory_id" class="form-label">
                <i class="bi bi-box me-2"></i>Product
              </label>
              <select name="inventory_id" id="inventory_id" class="form-select" required>
                <option value="">Select Product</option>
                @foreach($inventories as $inventory)
                  <option value="{{ $inventory->id }}">
                    {{ $inventory->product->name ?? 'Unknown Product' }} ({{ $inventory->location->name ?? 'N/A' }}) - Qty: {{ $inventory->quantity }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="from_location_id" class="form-label">
                <i class="bi bi-geo-alt me-2"></i>From Location
              </label>
              <select name="from_location_id" id="from_location_id" class="form-select" required>
                <option value="">Select Location</option>
                @foreach($locations as $location)
                  <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="to_location_id" class="form-label">
                <i class="bi bi-geo-alt-fill me-2"></i>To Location
              </label>
              <select name="to_location_id" id="to_location_id" class="form-select" required>
                <option value="">Select Location</option>
                @foreach($locations as $location)
                  <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="quantity" class="form-label">
                <i class="bi bi-123 me-2"></i>Quantity
              </label>
              <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
            </div>

            <div class="mb-3">
              <label for="note" class="form-label">
                <i class="bi bi-card-text me-2"></i>Note (optional)
              </label>
              <textarea name="note" id="note" class="form-control" placeholder="Add any additional notes about this transfer..."></textarea>
            </div>

            <div class="form-actions">
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-arrow-left-right"></i>
                Transfer Stock
              </button>
              <a href="{{ route('inventory.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-return-left"></i>
                Cancel
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

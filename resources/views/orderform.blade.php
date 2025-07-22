@extends('layouts.app')

@section('content')
<style>
  /* Modern Professional Order Form Styling */
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

  /* Main Card */
  .order-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    border: none;
  }

  .order-card .card-body {
    padding: 2rem;
  }

  /* Product Details Section */
  .product-details-section {
    background: #f8fafc;
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border: 1px solid #e5e7eb;
  }

  .product-details-section h5 {
    color: #374151;
    font-weight: 600;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .product-image {
    border-radius: 0.5rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    max-height: 120px;
    object-fit: cover;
  }

  .product-placeholder {
    background: #e5e7eb;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 120px;
    color: #9ca3af;
  }

  .product-name {
    font-weight: 600;
    color: #1f2937;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
  }

  .product-description {
    color: #6b7280;
    margin-bottom: 1rem;
    line-height: 1.5;
  }

  .product-badges .badge {
    font-size: 0.8rem;
    padding: 0.5rem 0.875rem;
    border-radius: 0.375rem;
    font-weight: 500;
  }

  /* Form Styling */
  .form-label {
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .form-control {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
  }

  .form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  }

  .form-text {
    color: #6b7280;
    font-size: 0.8rem;
    font-weight: 500;
  }

  /* Order Summary */
  .order-summary {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border: 1px solid #e2e8f0;
  }

  .order-summary h6 {
    color: #374151;
    font-weight: 600;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .summary-row {
    display: flex;
    justify-content: between;
    align-items: center;
    margin-bottom: 0.75rem;
    color: #6b7280;
    font-size: 0.875rem;
  }

  .summary-row:last-child {
    margin-bottom: 0;
  }

  .summary-total {
    border-top: 1px solid #e5e7eb;
    padding-top: 1rem;
    margin-top: 1rem;
    font-weight: 600;
    color: #1f2937;
    font-size: 1rem;
  }

  /* Action Buttons */
  .btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    border: none;
    border-radius: 0.5rem;
    padding: 0.875rem 2rem;
    font-weight: 500;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
  }

  .btn-outline-secondary {
    border: 1px solid #e5e7eb;
    color: #6b7280;
    background: white;
    border-radius: 0.5rem;
    padding: 0.875rem 2rem;
    font-weight: 500;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
  }

  .btn-outline-secondary:hover {
    background: #f9fafb;
    border-color: #d1d5db;
    color: #374151;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .page-header {
      padding: 1.5rem;
    }

    .page-header h4 {
      font-size: 1.25rem;
    }

    .order-card .card-body {
      padding: 1.5rem;
    }

    .product-details-section {
      padding: 1rem;
    }

    .order-summary {
      padding: 1rem;
    }

    .btn-primary,
    .btn-outline-secondary {
      padding: 0.75rem 1.5rem;
      font-size: 0.8rem;
    }
  }
</style>

<div class="container-fluid py-4">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h4><i class="bi bi-bag-plus-fill me-2"></i>Place Order</h4>
        <p class="mb-0 opacity-75">Complete your order details below</p>
      </div>
      <a href="{{ url()->previous() }}" class="btn">
        <i class="bi bi-arrow-left me-1"></i>Back
      </a>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card order-card">
        <div class="card-body">
          <!-- Product Information -->
          <div class="product-details-section">
            <h5><i class="bi bi-cube-fill text-primary"></i>Product Details</h5>
            <div class="row align-items-center">
              <div class="col-md-3">
                @if($product->image)
                  <img src="{{ asset('assets/img/products/' . $product->image) }}" 
                       alt="{{ $product->name }}" 
                       class="img-fluid product-image">
                @else
                  <div class="product-placeholder">
                    <i class="bi bi-image" style="font-size: 2rem;"></i>
                  </div>
                @endif
              </div>
              <div class="col-md-9">
                <h6 class="product-name">{{ $product->name }}</h6>
                <p class="product-description">{{ $product->description ?? 'No description available' }}</p>
                <div class="product-badges d-flex align-items-center gap-2">
                  <span class="badge bg-primary">UGX {{ number_format($product->price) }}</span>
                  @if(isset($product->stock))
                    <span class="badge bg-success">{{ $product->stock }} in stock</span>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <!-- Order Form -->
          <form action="{{ route('order.place') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="quantity" class="form-label">
                  <i class="bi bi-123"></i>Quantity
                </label>
                <input type="number" 
                       class="form-control @error('quantity') is-invalid @enderror" 
                       id="quantity" 
                       name="quantity" 
                       value="{{ old('quantity', 1) }}" 
                       min="1" 
                       required>
                @error('quantity')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">
                  Total: UGX <span id="totalPrice">{{ number_format($product->price) }}</span>
                </div>
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="address" class="form-label">
                  <i class="bi bi-geo-alt"></i>Delivery Address
                </label>
                <textarea class="form-control @error('address') is-invalid @enderror" 
                          id="address" 
                          name="address" 
                          rows="3" 
                          required 
                          placeholder="Enter your complete delivery address">{{ old('address') }}</textarea>
                @error('address')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
              <h6><i class="bi bi-receipt text-primary"></i>Order Summary</h6>
              <div class="summary-row d-flex justify-content-between">
                <span>Product:</span>
                <span>{{ $product->name }}</span>
              </div>
              <div class="summary-row d-flex justify-content-between">
                <span>Unit Price:</span>
                <span>UGX {{ number_format($product->price) }}</span>
              </div>
              <div class="summary-row d-flex justify-content-between">
                <span>Quantity:</span>
                <span id="summaryQuantity">1</span>
              </div>
              <div class="summary-total d-flex justify-content-between">
                <span>Total Amount:</span>
                <span>UGX <span id="summaryTotal">{{ number_format($product->price) }}</span></span>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="row g-3">
              <div class="col-md-8">
                <button type="submit" class="btn btn-primary w-100">
                  <i class="bi bi-bag-check"></i>Place Order
                </button>
              </div>
              <div class="col-md-4">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary w-100">
                  <i class="bi bi-arrow-left"></i>Back
                </a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const unitPrice = {{ $product->price }};
    
    function updateTotal() {
        const quantity = parseInt(quantityInput.value) || 1;
        const total = unitPrice * quantity;
        
        document.getElementById('totalPrice').textContent = new Intl.NumberFormat().format(total);
        document.getElementById('summaryQuantity').textContent = quantity;
        document.getElementById('summaryTotal').textContent = new Intl.NumberFormat().format(total);
    }
    
    quantityInput.addEventListener('input', updateTotal);
    updateTotal(); // Initialize totals
});
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

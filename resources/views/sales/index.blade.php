<!-- resources/views/sales/index.blade.php -->
@extends('layouts.app')

@section('content')
<style>
  /* Modern Professional Sales & Product Catalog Styling */
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

  .page-header p {
    margin: 0;
    opacity: 0.75;
  }

  /* Filter Section */
  .filter-section {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
  }

  .filter-section .form-label {
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
  }

  .filter-section .form-select {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
  }

  .filter-section .form-select:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
  }

  .filter-section .btn {
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .filter-section .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
  }

  /* Navigation Tabs */
  .nav-tabs-section {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
  }

  .nav-tabs-section .btn {
    border-radius: 0.5rem;
    font-weight: 500;
    padding: 0.75rem 1.5rem;
    margin-right: 0.5rem;
    transition: all 0.2s ease;
    border: 1px solid #e5e7eb;
  }

  .nav-tabs-section .btn.active {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border-color: #10b981;
    color: white;
  }

  .nav-tabs-section .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  }

  /* Alert Section */
  .info-alert {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border: 1px solid #f59e0b;
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    color: #92400e;
  }

  .info-alert strong {
    color: #78350f;
  }

  /* Product Cards */
  .product-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    border: 1px solid #f3f4f6;
    height: 100%;
  }

  .product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
    border-color: #10b981;
  }

  .product-card .card-body {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  .product-info {
    flex-grow: 1;
  }

  .product-image-container {
    min-width: 110px;
    max-width: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
    border-radius: 0.75rem;
    padding: 1rem;
    margin-right: 1rem;
  }

  .product-image-container img {
    max-height: 80px;
    object-fit: contain;
    border-radius: 0.5rem;
  }

  .product-icon {
    font-size: 2.5rem;
    color: #10b981;
  }

  .product-title {
    font-weight: 600;
    color: #1f2937;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
  }

  .product-type {
    font-size: 0.875rem;
    color: #6b7280;
    margin-bottom: 0.5rem;
  }

  .product-description {
    color: #4b5563;
    font-size: 0.875rem;
    line-height: 1.5;
    margin-bottom: 1rem;
  }

  .product-price {
    color: #059669;
    font-weight: 700;
    font-size: 1.25rem;
    margin-bottom: 1.5rem;
  }

  /* Order Form */
  .order-form {
    margin-top: auto;
    padding-top: 1rem;
    border-top: 1px solid #f3f4f6;
  }

  .order-form .form-label {
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
  }

  .order-form .form-control,
  .order-form .form-select {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
  }

  .order-form .form-control:focus,
  .order-form .form-select:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
  }

  .order-form .btn-primary {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    border-radius: 0.5rem;
    padding: 0.875rem 1.5rem;
    font-weight: 600;
    font-size: 0.875rem;
    letter-spacing: 0.5px;
    transition: all 0.2s ease;
    width: 100%;
  }

  .order-form .btn-primary:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
  }

  /* Delivery Info */
  .delivery-info {
    background: #dbeafe;
    border: 1px solid #93c5fd;
    border-radius: 0.5rem;
    padding: 0.75rem;
    margin-bottom: 1rem;
    font-size: 0.8rem;
    color: #1e40af;
  }

  /* Toast Styling */
  .toast.text-bg-success {
    background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
    border-radius: 0.75rem;
  }

  /* Modal Styling */
  .modal-content {
    border-radius: 1rem;
    border: none;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
  }

  .modal-header.bg-success {
    background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
    border-radius: 1rem 1rem 0 0;
  }

  .modal-header.bg-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
    border-radius: 1rem 1rem 0 0;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .page-header {
      padding: 1.5rem;
    }

    .page-header h4 {
      font-size: 1.25rem;
    }

    .filter-section,
    .nav-tabs-section {
      padding: 1rem;
    }

    .product-card .card-body {
      padding: 1rem;
    }

    .product-image-container {
      min-width: 80px;
      max-width: 90px;
      padding: 0.75rem;
    }

    .product-icon {
      font-size: 2rem;
    }

    .product-title {
      font-size: 1rem;
    }

    .product-price {
      font-size: 1.1rem;
    }
  }
</style>

<div class="container-fluid py-4">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h4><i class="bi bi-cart-check me-2"></i>Sales & Product Catalog</h4>
        <p>Browse and order recycled products from verified sellers</p>
      </div>
    </div>
  </div>

  <!-- Filter Section -->
  <div class="filter-section">
    <form method="GET" action="{{ route('sales.index') }}" class="d-flex align-items-end gap-3">
      @php
        $user = auth()->user();
        $allowedTypes = [];
        if ($user) {
          if ($user->role === 'wholesaler') {
            $allowedTypes = ['factory'];
          } elseif ($user->role === 'retailer') {
            $allowedTypes = ['wholesaler'];
          } elseif ($user->role === 'customer') {
            $allowedTypes = ['retailer'];
          } elseif ($user->role === 'admin') {
            $allowedTypes = ['factory', 'wholesaler', 'retailer'];
          }
        }
      @endphp
      <div>
        <label for="type" class="form-label">Filter by Seller Type</label>
        <select name="type" id="type" class="form-select">
          <option value="">All Sellers</option>
          @foreach($allowedTypes as $type)
            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-funnel me-1"></i>Apply Filter
      </button>
    </form>
  </div>

  <!-- Navigation Tabs -->
  <div class="nav-tabs-section">
    <div class="d-flex flex-wrap gap-2">
      <a href="{{ route('sales.index') }}" class="btn {{ request()->routeIs('sales.index') ? 'active' : 'btn-outline-secondary' }}">
        <i class="bi bi-box-seam me-1"></i>Product Catalog
      </a>
      <a href="{{ route('sales.history') }}" class="btn {{ request()->routeIs('sales.history') ? 'active' : 'btn-outline-secondary' }}">
        <i class="bi bi-clock-history me-1"></i>Order History
      </a>
      <a href="{{ route('sales.status') }}" class="btn {{ request()->routeIs('sales.status') ? 'active' : 'btn-outline-secondary' }}">
        <i class="bi bi-clipboard-check me-1"></i>Order Status
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success d-none" id="orderSuccessAlert">{{ session('success') }}</div>
    <!-- Bootstrap Toast for Success Message -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
      <div id="orderSuccessToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var toastEl = document.getElementById('orderSuccessToast');
        if (toastEl) {
          var toast = new bootstrap.Toast(toastEl, { delay: 10000 }); // 10 seconds
          toast.show();
        }
      });
    </script>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  @php
    $user = auth()->user();
    $role = $user->role ?? ($user->role_as == 5 ? 'wholesaler' : ($user->role_as == 2 ? 'retailer' : ($user->role_as == 0 ? 'customer' : 'other')));
    $note = '';
    if ($role === 'wholesaler') {
      $note = 'Orders placed here will only be deducted from stock after admin verification. Your order will remain pending until approved by an admin.';
    } elseif ($role === 'retailer') {
      $note = 'Orders placed here will only be deducted from stock after wholesaler verification. Your order will remain pending until approved by a wholesaler.';
    } elseif ($role === 'customer') {
      $note = 'Orders placed here will only be deducted from stock after retailer verification. Your order will remain pending until approved by a retailer.';
    } else {
      $note = 'Orders placed here will only be deducted from stock after verification.';
    }
  @endphp
  
  <!-- Important Information Alert -->
  <div class="info-alert">
    <div class="d-flex align-items-center">
      <i class="bi bi-info-circle fs-4 me-3"></i>
      <div>
        <strong>Order Verification Process:</strong> {{ $note }}
      </div>
    </div>
  </div>

  <!-- Products Grid -->
  <div class="row g-4">
    @php
      $user = auth()->user();
    @endphp
    @foreach ($products as $product)
      @php
        $showProduct = false;
        if ($user) {
          if ($user->role === 'wholesaler') {
            $showProduct = true; // Wholesaler sees all products
          } elseif ($user->role === 'retailer' && $product->seller_role === 'wholesaler') {
            $showProduct = true;
          } elseif ($user->role === 'customer') {
            // Customers see products that are available in retailer inventory
            // Since controller already filters these, show all products passed to view
            $showProduct = true;
          } elseif ($user->role === 'admin') {
            $showProduct = true;
          }
        } else {
          // Guest users see retailer inventory products (already filtered by controller)
          $showProduct = true;
        }
      @endphp
      @if($showProduct)
      <div class="col-lg-4 col-md-6">
        <div class="card product-card">
          <div class="card-body">
            <div class="d-flex align-items-start gap-3 product-info">
              <div class="product-image-container">
                @if($product->image)
                  <img src="/assets/img/products/{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid">
                @else
                  <i class="bi bi-cube product-icon"></i>
                @endif
              </div>
              <div class="flex-grow-1">
                <h5 class="product-title">{{ $product->name }}</h5>
                <p class="product-type">Type: {{ $product->type }}</p>
                <p class="product-description">{{ $product->description }}</p>
                <p class="product-price">UGX {{ number_format($product->price) }}</p>
              </div>
            </div>
            
            <!-- Order Form -->
            <form action="{{ route('sales.store') }}" method="POST" class="order-form">
              @csrf
              <input type="hidden" name="product_id" value="{{ $product->id }}">
              
              <div class="mb-3">
                <label for="quantity_{{ $product->id }}" class="form-label">Quantity</label>
                <input type="number" name="quantity" id="quantity_{{ $product->id }}" class="form-control" min="1" required placeholder="Enter quantity...">
              </div>
              
              @php
                $deliveryRequired = false;
                $deliveryOptional = false;
                if ($user) {
                  if ($user->role === 'wholesaler' && $product->seller_role === 'factory') {
                    $deliveryRequired = true;
                  } elseif ($user->role === 'retailer' && $product->seller_role === 'wholesaler') {
                    $deliveryOptional = true;
                  } elseif ($user->role === 'customer') {
                    // Customers buying from retailer inventory always require delivery
                    $deliveryRequired = true;
                  }
                }
              @endphp
              
              @if($deliveryRequired)
                <input type="hidden" name="delivery_method" value="delivery">
                <div class="delivery-info">
                  <i class="bi bi-truck me-1"></i> Delivery required for this order
                </div>
              @elseif($deliveryOptional)
                <div class="mb-3">
                  <label for="delivery_method_{{ $product->id }}" class="form-label">Delivery Method</label>
                  <select name="delivery_method" id="delivery_method_{{ $product->id }}" class="form-select" required>
                    <option value="delivery">Delivery</option>
                    <option value="pickup">Local Pickup</option>
                  </select>
                </div>
              @elseif($user && $user->role === 'admin')
                <input type="hidden" name="delivery_method" value="delivery">
              @endif
              
              <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-primary add-to-cart-btn" data-product-id="{{ $product->id }}">
                  <i class="bi bi-cart-plus me-2"></i>Add to Cart
                </button>
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-bag-check me-2"></i>Place Order
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      @endif
    @endforeach
  </div>
</div>
<!-- Add to Cart Success Modal -->
<div class="modal fade" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="addToCartModalLabel"><i class="bi bi-check-circle me-2"></i>Product Added to Cart</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-3">Product added to cart successfully!</p>
        <div class="d-flex justify-content-center gap-3">
          <button type="button" class="btn btn-outline-success" id="modalCheckCartBtn">Check Cart</button>
          <button type="button" class="btn btn-outline-secondary" id="modalContinueShoppingBtn">Continue Shopping</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Low Stock Modal -->
<div class="modal fade" id="lowStockModal" tabindex="-1" aria-labelledby="lowStockModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title" id="lowStockModalLabel"><i class="bi bi-exclamation-triangle me-2"></i>Quantity Limit Exceeded</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-3">You cannot order more than 100 pcs at a time. Please enter a quantity of 100 or less.</p>
        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>
<script>
  document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const productId = this.getAttribute('data-product-id');
      const qtyInput = document.getElementById('quantity_' + productId);
      let quantity = qtyInput.value ? parseInt(qtyInput.value) : 1;
      if (quantity > 100) {
        // Show low stock modal and do not add to cart
        var lowStockModalEl = document.getElementById('lowStockModal');
        var lowStockModal = new bootstrap.Modal(lowStockModalEl);
        lowStockModal.show();
        return;
      }
      fetch("{{ route('cart.add') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({ product_id: productId, quantity: quantity })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          var modalEl = document.getElementById('addToCartModal');
          var modal = new bootstrap.Modal(modalEl);
          modal.show();
        }
      });
    });
  });
  document.addEventListener('DOMContentLoaded', function() {
    var modalEl = document.getElementById('addToCartModal');
    if (modalEl) {
      document.getElementById('modalCheckCartBtn').onclick = function() {
        window.location.href = "{{ route('cart.index') }}";
      };
      document.getElementById('modalContinueShoppingBtn').onclick = function() {
        var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.hide();
      };
    }
  });
</script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

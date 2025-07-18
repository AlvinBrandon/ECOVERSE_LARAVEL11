<!-- resources/views/sales/index.blade.php -->
@extends('layouts.app')

@section('content')
<style>
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%) !important;
  }
  .card {
    background: rgba(255,255,255,0.97);
    border-radius: 1.25rem;
    box-shadow: 0 6px 32px rgba(16, 185, 129, 0.10);
    transition: transform 0.18s;
  }
  .card:hover {
    transform: translateY(-6px) scale(1.03);
    box-shadow: 0 12px 40px #10b98133;
  }
  .card-header.bg-gradient-primary {
    background: linear-gradient(90deg, #6366f1 0%, #10b981 100%) !important;
    color: #fff !important;
    border-top-left-radius: 1.25rem;
    border-top-right-radius: 1.25rem;
  }
  .btn-info, .btn-warning, .btn-success, .btn-danger, .btn-primary {
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.08);
  }
  .table thead.bg-light {
    background: #f0fdfa !important;
  }
  .product-icon {
    font-size: 2.5rem;
    color: #10b981;
    margin-bottom: 0.5rem;
  }
  .card-title {
    font-weight: 600;
    color: #374151;
  }
  .card-text.text-success {
    font-size: 1.1rem;
    font-weight: 500;
  }
  .form-label {
    font-weight: 500;
    color: #6366f1;
  }
  .btn-primary.w-100 {
    font-size: 1.1rem;
    font-weight: 600;
    letter-spacing: 1px;
    border-radius: 0.75rem;
    padding: 0.75rem 0;
  }
</style>

<div class="container-fluid py-4">
  <div class="row mb-4">
    <div class="col-12 mb-3">
      <form method="GET" action="{{ route('sales.index') }}" class="d-flex align-items-center gap-3">
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
        <label for="type" class="form-label mb-0">Filter by Seller Type:</label>
        <select name="type" id="type" class="form-select w-auto">
          <option value="">All</option>
          @foreach($allowedTypes as $type)
            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
          @endforeach
        </select>
        <button type="submit" class="btn btn-outline-primary">Filter</button>
      </form>
    </div>
    <div class="col-12 d-flex align-items-center justify-content-between">
      <h4 class="text-dark fw-bold mb-0"><i class="bi bi-cart-check me-2"></i>Sales & Product Catalog</h4>
      <!-- Home button removed -->
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-12 d-flex gap-2">
      <a href="{{ route('sales.index') }}" class="btn btn-outline-primary {{ request()->routeIs('sales.index') ? 'active' : '' }}"><i class="bi bi-box-seam me-1"></i>Product Catalog</a>
      <a href="{{ route('sales.history') }}" class="btn btn-outline-info {{ request()->routeIs('sales.history') ? 'active' : '' }}"><i class="bi bi-clock-history me-1"></i>Order History</a>
      <a href="{{ route('sales.status') }}" class="btn btn-outline-success {{ request()->routeIs('sales.status') ? 'active' : '' }}"><i class="bi bi-clipboard-check me-1"></i>Order Status</a>
      
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
  <div class="alert alert-warning">
    <strong>Note:</strong> {{ $note }}
  </div>

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
          } elseif ($user->role === 'customer' && $product->seller_role === 'retailer') {
            $showProduct = true;
          } elseif ($user->role === 'admin') {
            $showProduct = true;
          }
        }
      @endphp
      @if($showProduct)
      <div class="col-md-4">
        <div class="card h-100">
          <div class="card-body d-flex flex-column justify-content-between">
            <div class="d-flex align-items-center gap-3">
              <div style="min-width:110px;max-width:120px;">
                @if($product->image)
                  <img src="/assets/img/products/{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-height:100px;object-fit:contain;">
                @else
                  <i class="bi bi-cube product-icon"></i>
                @endif
              </div>
              <div class="flex-grow-1">
                <h5 class="card-title mt-2">{{ $product->name }}</h5>
                <p class="card-text text-sm text-muted">Type: {{ $product->type }}</p>
                <p class="card-text">{{ $product->description }}</p>
                <p class="card-text text-success">Price: UGX {{ number_format($product->price) }}</p>
              </div>
            </div>
            <form action="{{ route('sales.store') }}" method="POST" class="mt-3">
              @csrf
              <input type="hidden" name="product_id" value="{{ $product->id }}">
              <div class="mb-3">
                <label for="quantity_{{ $product->id }}" class="form-label">Quantity</label>
                <input type="number" name="quantity" id="quantity_{{ $product->id }}" class="form-control form-control-lg" min="1" required placeholder="Enter quantity...">
              </div>
              @php
                $deliveryRequired = false;
                $deliveryOptional = false;
                if ($user) {
                  if ($user->role === 'wholesaler' && $product->seller_role === 'factory') {
                    $deliveryRequired = true;
                  } elseif ($user->role === 'retailer' && $product->seller_role === 'wholesaler') {
                    $deliveryOptional = true;
                  } elseif ($user->role === 'customer' && $product->seller_role === 'retailer') {
                    $deliveryRequired = true;
                  }
                }
              @endphp
              @if($deliveryRequired)
                <input type="hidden" name="delivery_method" value="delivery">
                <div class="mb-2 text-info small">Delivery required for this order.</div>
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
              <button type="submit" class="btn btn-primary w-100"><i class="bi bi-cart-plus me-1"></i>Place Order</button>
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
        <p class="mb-3">You cannot order more than 100 units at a time. Please enter a quantity of 100 or less.</p>
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

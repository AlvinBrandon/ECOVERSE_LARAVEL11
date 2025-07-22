@extends('layouts.app')

@section('content')
<style>
  /* Modern Professional Cart Styling */
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
  }

  .container {
    background: transparent !important;
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

  .page-header h3 {
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

  /* Main Table Card */
  .table-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    border: none;
    margin-bottom: 2rem;
  }

  .table-card .table-responsive {
    padding: 0;
  }

  /* Table Styling */
  .modern-table {
    margin: 0;
    border-collapse: separate;
    border-spacing: 0;
  }

  .modern-table thead th {
    background: #f8fafc;
    color: #374151;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1.25rem 1.5rem;
    border: none;
    border-bottom: 1px solid #e5e7eb;
    position: sticky;
    top: 0;
    z-index: 10;
  }

  .modern-table thead th i {
    color: #6b7280;
    margin-right: 0.5rem;
  }

  .modern-table tbody tr {
    transition: all 0.2s ease;
  }

  .modern-table tbody tr:hover {
    background: #f9fafb;
  }

  .modern-table tbody td {
    padding: 1.25rem 1.5rem;
    border: none;
    border-bottom: 1px solid #f3f4f6;
    font-size: 0.875rem;
    color: #374151;
    vertical-align: middle;
  }

  .modern-table tbody tr:last-child td {
    border-bottom: none;
  }

  /* Product Name Styling */
  .product-name {
    font-weight: 500;
    color: #1f2937;
  }

  /* Quantity Styling */
  .quantity {
    font-weight: 600;
    color: #374151;
  }

  /* Price Styling */
  .price {
    font-weight: 600;
    color: #059669;
  }

  /* Alert Styling */
  .alert {
    border-radius: 0.75rem;
    border: none;
    padding: 1rem 1.5rem;
    margin-bottom: 2rem;
    font-weight: 500;
  }

  .alert-info {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1e40af;
  }

  .alert-success {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    color: #166534;
  }

  .alert-danger {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
  }

  /* Button Enhancements */
  .btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    border: none;
    font-weight: 500;
    transition: all 0.2s ease;
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
    transform: translateY(-2px);
  }

  .btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    font-weight: 500;
    transition: all 0.2s ease;
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
  }

  .btn-success:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    transform: translateY(-2px);
  }

  .btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    border: none;
    font-weight: 500;
    transition: all 0.2s ease;
    border-radius: 0.375rem;
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
  }

  .btn-danger:hover {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
    transform: translateY(-2px);
  }

  .btn-outline-primary {
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    transition: all 0.2s ease;
  }

  .btn-outline-primary:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.3);
    color: white;
    transform: translateY(-2px);
  }

  /* Checkout Section */
  .checkout-section {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    text-align: center;
  }

  .checkout-section .btn-lg {
    padding: 1rem 2rem;
    font-size: 1.125rem;
    font-weight: 600;
  }

  /* Modal Enhancements */
  .modal-content {
    border-radius: 1rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    border: none;
  }

  .modal-header {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    border-bottom: none;
    border-radius: 1rem 1rem 0 0;
    padding: 1.25rem 1.5rem;
  }

  .modal-header .modal-title {
    color: white;
    font-weight: 600;
  }

  .modal-header .btn-close {
    filter: invert(1);
  }

  .modal-footer {
    background: #f8fafc;
    border-top: 1px solid #e5e7eb;
    border-radius: 0 0 1rem 1rem;
    padding: 1.25rem 1.5rem;
  }

  /* Form Controls in Modals */
  .modal .form-control,
  .modal .form-select {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    transition: all 0.2s ease;
  }

  .modal .form-control:focus,
  .modal .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  }

  /* Image Styling */
  .product-image {
    border-radius: 0.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
  }

  .product-image:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  }

  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: #6b7280;
  }

  .empty-state i {
    font-size: 4rem;
    color: #a78bfa;
    margin-bottom: 1.5rem;
  }

  .empty-state h5 {
    color: #374151;
    margin-bottom: 0.75rem;
    font-weight: 600;
    font-size: 1.25rem;
  }

  .empty-state p {
    margin: 0;
    font-size: 0.875rem;
    max-width: 400px;
    margin: 0 auto;
    line-height: 1.5;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .page-header {
      padding: 1.5rem;
    }

    .page-header h3 {
      font-size: 1.25rem;
    }

    .checkout-section {
      padding: 1.5rem;
    }

    .modern-table thead th,
    .modern-table tbody td {
      padding: 1rem;
      font-size: 0.8rem;
    }
  }
</style>

<div class="container py-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3><i class="bi bi-cart me-2"></i>Your Shopping Cart</h3>
                <p class="mb-0 opacity-75">Review and manage your selected items</p>
            </div>
            <a href="/dashboard" class="btn btn-outline-primary">
                <i class="bi bi-house-door me-1"></i>Home
            </a>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(empty($cart))
        <div class="alert alert-info">
            <div class="empty-state">
                <i class="bi bi-cart-x"></i>
                <h5>Your cart is empty</h5>
                <p>Start shopping to add items to your cart. <a href="{{ route('sales.index') }}" class="text-decoration-underline">Continue shopping</a>.</p>
            </div>
        </div>
    @else
    <div class="table-card">
        <div class="table-responsive">
            <table class="table modern-table align-middle">
                <thead>
                    <tr>
                        <th><i class="bi bi-cube"></i>Product</th>
                        <th><i class="bi bi-image"></i>Image</th>
                        <th><i class="bi bi-currency-dollar"></i>Unit Price</th>
                        <th><i class="bi bi-123"></i>Quantity</th>
                        <th><i class="bi bi-calculator"></i>Total</th>
                        <th><i class="bi bi-gear"></i>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                    <tr>
                        <td>
                            <span class="product-name">{{ $item['name'] }}</span>
                        </td>
                        <td>
                            @if($item['image'])
                                <img src="/assets/img/products/{{ $item['image'] }}" alt="{{ $item['name'] }}" class="product-image" style="max-width:60px;max-height:60px;object-fit:contain;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:60px;height:60px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="price">UGX {{ number_format($item['price']) }}</span>
                        </td>
                        <td>
                            <span class="quantity">{{ $item['quantity'] }}</span>
                        </td>
                        <td>
                            <span class="price">UGX {{ number_format($item['price'] * $item['quantity']) }}</span>
                        </td>
                        <td>
                            <form action="{{ route('cart.remove') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="checkout-section">
        <button type="button" class="btn btn-success btn-lg" id="openCartCheckoutModal">
            <i class="bi bi-bag-check me-2"></i>Proceed to Checkout
        </button>
    </div>
    @endif
</div>

<!-- Cart Checkout Modal -->
<div class="modal fade" id="cartCheckoutModal" tabindex="-1" aria-labelledby="cartCheckoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="cartCheckoutForm" method="POST" action="{{ route('cart.checkout') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="cartCheckoutModalLabel"><i class="bi bi-bag-check me-2"></i>Confirm Your Order</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="table-responsive mb-3">
            <table class="table modern-table align-middle">
              <thead>
                <tr>
                  <th><i class="bi bi-cube"></i>Product</th>
                  <th><i class="bi bi-image"></i>Image</th>
                  <th><i class="bi bi-currency-dollar"></i>Unit Price</th>
                  <th><i class="bi bi-123"></i>Quantity</th>
                  <th><i class="bi bi-calculator"></i>Total</th>
                </tr>
              </thead>
              <tbody>
                @php $grandTotal = 0; @endphp
                @foreach($cart as $item)
                  @php $grandTotal += $item['price'] * $item['quantity']; @endphp
                  <tr data-product-id="{{ $item['product_id'] }}" data-stock="{{ $item['stock'] }}">
                    <td>
                        <span class="product-name">{{ $item['name'] }}</span>
                    </td>
                    <td>
                      @if($item['image'])
                        <img src="/assets/img/products/{{ $item['image'] }}" alt="{{ $item['name'] }}" class="product-image" style="max-width:60px;max-height:60px;object-fit:contain;">
                      @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:60px;height:60px;">
                            <i class="bi bi-image text-muted"></i>
                        </div>
                      @endif
                    </td>
                    <td class="modal-price" data-price="{{ $item['price'] }}">
                        <span class="price">UGX {{ number_format($item['price']) }}</span>
                        <br><span class="badge bg-info text-dark">Stock: {{ $item['stock'] }}</span>
                    </td>
                    <td><input type="number" class="form-control modal-qty-input modal-qty" min="1" value="{{ $item['quantity'] }}" style="width:80px;"></td>
                    <td class="modal-total">
                        <span class="price">UGX {{ number_format($item['price'] * $item['quantity']) }}</span>
                        <br><span class="text-danger small d-none stock-warning">Only {{ $item['stock'] }} left in stock!</span>
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="4" class="text-end">Grand Total:</th>
                  <th id="modalGrandTotal" class="price">UGX {{ number_format($grandTotal) }}</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <div class="mb-3">
            <label class="form-label">Payment Method</label>
            <select name="payment_method" id="paymentMethod" class="form-select" required>
              <option value="">Select Payment Method</option>
              <option value="mobile_money">Mobile Money</option>
              <option value="visa_card">Visa Card</option>
            </select>
          </div>
          <div class="mb-3 d-none" id="mmProviderGroup">
            <label class="form-label">Mobile Money Provider</label>
            <select name="mm_provider" id="mmProvider" class="form-select">
              <option value="">Select Provider</option>
              <option value="mtn">MTN</option>
              <option value="airtel">Airtel</option>
            </select>
          </div>
          <div class="mb-3 d-none" id="mmPhoneGroup">
            <label class="form-label">Mobile Money Number</label>
            <input type="text" name="mm_phone" id="mmPhone" class="form-control" maxlength="10" placeholder="e.g. 078xxxxxxx">
            <div class="invalid-feedback" id="mmPhoneError"></div>
          </div>
          <div class="mb-3 d-none" id="cardGroup">
            <label class="form-label">Visa Card Number</label>
            <input type="text" name="card_number" id="cardNumber" class="form-control" maxlength="20" placeholder="Enter 20-digit card number">
            <div class="invalid-feedback" id="cardNumberError"></div>
          </div>
          <div class="mb-3">
            <label class="form-label">Delivery Address</label>
            <input type="text" name="address" class="form-control" maxlength="255" required placeholder="Enter delivery address...">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Confirm Order</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Post-Order Options Modal -->
<div class="modal fade" id="postOrderOptionsModal" tabindex="-1" aria-labelledby="postOrderOptionsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="postOrderOptionsModalLabel"><i class="bi bi-bag-check me-2"></i>Order Placed!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-4">Your order has been placed successfully.<br>What would you like to do next?</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
          <button type="button" class="btn btn-outline-primary" id="continueShoppingBtn"><i class="bi bi-shop me-1"></i>Continue Shopping</button>
          <button type="button" class="btn btn-success" id="viewOrderStatusBtn"><i class="bi bi-clipboard-check me-1"></i>Check Order Status</button>
          <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger"><i class="bi bi-box-arrow-right me-1"></i>Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  document.getElementById('openCartCheckoutModal').addEventListener('click', function() {
    var modal = new bootstrap.Modal(document.getElementById('cartCheckoutModal'));
    modal.show();
  });
  // Modal payment logic (same as cart_checkout.blade.php)
  const paymentMethod = document.getElementById('paymentMethod');
  const mmProviderGroup = document.getElementById('mmProviderGroup');
  const mmProvider = document.getElementById('mmProvider');
  const mmPhoneGroup = document.getElementById('mmPhoneGroup');
  const mmPhone = document.getElementById('mmPhone');
  const mmPhoneError = document.getElementById('mmPhoneError');
  const cardGroup = document.getElementById('cardGroup');
  const cardNumber = document.getElementById('cardNumber');
  const cardNumberError = document.getElementById('cardNumberError');
  const form = document.getElementById('cartCheckoutForm');
  paymentMethod.addEventListener('change', function() {
    mmProviderGroup.classList.add('d-none');
    mmPhoneGroup.classList.add('d-none');
    cardGroup.classList.add('d-none');
    if (this.value === 'mobile_money') {
      mmProviderGroup.classList.remove('d-none');
    } else if (this.value === 'visa_card') {
      cardGroup.classList.remove('d-none');
    }
  });
  mmProvider.addEventListener('change', function() {
    mmPhoneGroup.classList.add('d-none');
    if (this.value) {
      mmPhoneGroup.classList.remove('d-none');
    }
  });
  form.addEventListener('submit', function(e) {
    let valid = true;
    mmPhone.classList.remove('is-invalid');
    mmPhoneError.textContent = '';
    cardNumber.classList.remove('is-invalid');
    cardNumberError.textContent = '';
    if (paymentMethod.value === 'mobile_money') {
      if (!mmProvider.value) {
        mmProvider.classList.add('is-invalid');
        valid = false;
      } else {
        mmProvider.classList.remove('is-invalid');
      }
      const phone = mmPhone.value.trim();
      let prefixOk = false;
      if (mmProvider.value === 'mtn') {
        prefixOk = /^(078|076|079)\d{7}$/.test(phone);
      } else if (mmProvider.value === 'airtel') {
        prefixOk = /^(070|074)\d{7}$/.test(phone);
      }
      if (!prefixOk) {
        mmPhone.classList.add('is-invalid');
        mmPhoneError.textContent = 'Enter a valid ' + mmProvider.value.toUpperCase() + ' number (10 digits, correct prefix)';
        valid = false;
      }
    }
    if (paymentMethod.value === 'visa_card') {
      const card = cardNumber.value.trim();
      if (!/^\d{20}$/.test(card)) {
        cardNumber.classList.add('is-invalid');
        cardNumberError.textContent = 'Card number must be exactly 20 digits.';
        valid = false;
      }
    }
    if (!valid) {
      e.preventDefault();
      return;
    }
    // Show post-order modal after successful order
    e.preventDefault();
    fetch(form.action, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': form.querySelector('[name=_token]').value,
        'X-Requested-With': 'XMLHttpRequest',
      },
      body: new FormData(form)
    })
    .then(res => res.ok ? res.json().catch(() => ({})) : Promise.reject(res))
    .then(() => {
      var modal = bootstrap.Modal.getInstance(document.getElementById('cartCheckoutModal'));
      modal.hide();
      setTimeout(() => {
        var postOrderModal = new bootstrap.Modal(document.getElementById('postOrderOptionsModal'));
        postOrderModal.show();
      }, 400);
      form.reset();
    })
    .catch(() => {
      alert('Order could not be placed. Please try again.');
    });
  });
  document.getElementById('continueShoppingBtn').addEventListener('click', function() {
    var postOrderModal = bootstrap.Modal.getInstance(document.getElementById('postOrderOptionsModal'));
    postOrderModal.hide();
    setTimeout(() => {
      window.location.href = '{{ route('sales.index') }}';
    }, 400);
  });
  document.getElementById('viewOrderStatusBtn').addEventListener('click', function() {
    var postOrderModal = bootstrap.Modal.getInstance(document.getElementById('postOrderOptionsModal'));
    postOrderModal.hide();
    setTimeout(() => {
      window.location.href = '{{ route('sales.status') }}';
    }, 400);
  });
  // Live update grand total and update cart session on qty change
  function updateModalTotals() {
    let grandTotal = 0;
    document.querySelectorAll('#cartCheckoutModal tbody tr').forEach(function(row) {
      const qtyInput = row.querySelector('.modal-qty-input');
      const priceCell = row.querySelector('.modal-price');
      const totalCell = row.querySelector('.modal-total');
      if (qtyInput && priceCell && totalCell) {
        const price = parseInt(priceCell.getAttribute('data-price'));
        const qty = parseInt(qtyInput.value);
        const total = price * qty;
        totalCell.textContent = 'UGX ' + total.toLocaleString();
        grandTotal += total;
      }
    });
    document.getElementById('modalGrandTotal').textContent = 'UGX ' + grandTotal.toLocaleString();
  }
  document.querySelectorAll('.modal-qty-input').forEach(function(input) {
    input.addEventListener('input', function() {
      const row = this.closest('tr');
      const stock = parseInt(row.getAttribute('data-stock'));
      if (parseInt(this.value) < 1) this.value = 1;
      if (parseInt(this.value) > stock) {
        this.value = stock;
        row.querySelector('.stock-warning').classList.remove('d-none');
      } else {
        row.querySelector('.stock-warning').classList.add('d-none');
      }
      updateModalTotals();
      // Update cart session via AJAX
      const productId = row.getAttribute('data-product-id');
      fetch("{{ route('cart.add') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({ product_id: productId, quantity: parseInt(this.value) - 1 }) // -1 because add increments
      });
    });
  });
  // Call on modal show
  document.getElementById('openCartCheckoutModal').addEventListener('click', function() {
    setTimeout(updateModalTotals, 300);
  });
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection 
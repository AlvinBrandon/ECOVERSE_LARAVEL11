@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="bi bi-cart me-2"></i>Your Shopping Cart</h3>
        <a href="/dashboard" class="btn btn-outline-primary"><i class="bi bi-house-door me-1"></i>Home</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(empty($cart))
        <div class="alert alert-info">Your cart is empty. <a href="{{ route('sales.index') }}">Continue shopping</a>.</div>
    @else
    <div class="table-responsive mb-4">
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>
                        @if($item['image'])
                            <img src="/assets/img/products/{{ $item['image'] }}" alt="{{ $item['name'] }}" style="max-width:60px;max-height:60px;object-fit:contain;">
                        @endif
                    </td>
                    <td>UGX {{ number_format($item['price']) }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>UGX {{ number_format($item['price'] * $item['quantity']) }}</td>
                    <td>
                        <form action="{{ route('cart.remove') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-end">
        <button type="button" class="btn btn-success btn-lg" id="openCartCheckoutModal"><i class="bi bi-bag-check me-1"></i>Checkout</button>
    </div>
    @endif
</div>

<!-- Cart Checkout Modal -->
<div class="modal fade" id="cartCheckoutModal" tabindex="-1" aria-labelledby="cartCheckoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="cartCheckoutForm" method="POST" action="{{ route('cart.checkout') }}">
        @csrf
        <div class="modal-header bg-gradient-primary text-white">
          <h5 class="modal-title" id="cartCheckoutModalLabel"><i class="bi bi-bag-check me-2"></i>Confirm Your Order</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="table-responsive mb-3">
            <table class="table align-middle">
              <thead class="table-light">
                <tr>
                  <th>Product</th>
                  <th>Image</th>
                  <th>Unit Price</th>
                  <th>Quantity</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                @php $grandTotal = 0; @endphp
                @foreach($cart as $item)
                  @php $grandTotal += $item['price'] * $item['quantity']; @endphp
                  <tr data-product-id="{{ $item['product_id'] }}" data-stock="{{ $item['stock'] }}">
                    <td>{{ $item['name'] }}</td>
                    <td>
                      @if($item['image'])
                        <img src="/assets/img/products/{{ $item['image'] }}" alt="{{ $item['name'] }}" style="max-width:60px;max-height:60px;object-fit:contain;">
                      @endif
                    </td>
                    <td class="modal-price" data-price="{{ $item['price'] }}">UGX {{ number_format($item['price']) }}<br><span class="badge bg-info text-dark">Stock: {{ $item['stock'] }}</span></td>
                    <td><input type="number" class="form-control modal-qty-input modal-qty" min="1" value="{{ $item['quantity'] }}" style="width:80px;"></td>
                    <td class="modal-total">UGX {{ number_format($item['price'] * $item['quantity']) }}<br><span class="text-danger small d-none stock-warning">Only {{ $item['stock'] }} left in stock!</span></td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="4" class="text-end">Grand Total:</th>
                  <th id="modalGrandTotal">UGX {{ number_format($grandTotal) }}</th>
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
      <div class="modal-header bg-gradient-primary text-white">
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
@endsection 
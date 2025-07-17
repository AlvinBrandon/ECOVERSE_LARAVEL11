@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4"><i class="bi bi-bag-check me-2"></i>Confirm Your Order</h3>
    <!-- The modal will be triggered automatically -->
</div>

<!-- Order Confirmation Modal -->
<div class="modal fade" id="cartOrderConfirmModal" tabindex="-1" aria-labelledby="cartOrderConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="cartOrderConfirmForm" method="POST" action="{{ route('cart.checkout') }}">
        @csrf
        <div class="modal-header bg-gradient-primary text-white">
          <h5 class="modal-title" id="cartOrderConfirmModalLabel"><i class="bi bi-bag-check me-2"></i>Confirm Your Order</h5>
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
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="4" class="text-end">Grand Total:</th>
                  <th>UGX {{ number_format($grandTotal) }}</th>
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

<!-- Order Placed Success Modal -->
<div class="modal fade" id="orderPlacedSuccessModal" tabindex="-1" aria-labelledby="orderPlacedSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="orderPlacedSuccessModalLabel"><i class="bi bi-check-circle me-2"></i>Order Placed Successfully!</h5>
      </div>
      <div class="modal-body text-center">
        <p>Your order has been placed successfully. You will be redirected to your order status page shortly.</p>
        <div class="spinner-border text-success" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var modal = new bootstrap.Modal(document.getElementById('cartOrderConfirmModal'));
    modal.show();

    const paymentMethod = document.getElementById('paymentMethod');
    const mmProviderGroup = document.getElementById('mmProviderGroup');
    const mmProvider = document.getElementById('mmProvider');
    const mmPhoneGroup = document.getElementById('mmPhoneGroup');
    const mmPhone = document.getElementById('mmPhone');
    const mmPhoneError = document.getElementById('mmPhoneError');
    const cardGroup = document.getElementById('cardGroup');
    const cardNumber = document.getElementById('cardNumber');
    const cardNumberError = document.getElementById('cardNumberError');
    const form = document.getElementById('cartOrderConfirmForm');

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
      // Intercept form submission and use AJAX to submit, then redirect to order status
      e.preventDefault();
      const formData = new FormData(form);
      fetch(form.action, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: formData
      })
      .then(async response => {
        if (response.redirected) {
          window.location.href = response.url;
          return;
        }
        let data;
        try {
          data = await response.json();
        } catch (e) {
          data = null;
        }
        if (response.status === 422 && data && data.errors) {
          // Show the first validation error
          let firstError = Object.values(data.errors)[0][0];
          alert('Validation error: ' + firstError);
        } else if (data && data.error) {
          alert(data.error);
        } else if (data && data.success) {
          // Show success modal, then redirect
          var successModalEl = document.getElementById('orderPlacedSuccessModal');
          var successModal = new bootstrap.Modal(successModalEl);
          successModal.show();
          setTimeout(function() {
            window.location.href = "{{ route('sales.status') }}";
          }, 2500);
        } else {
          // If backend redirects, show modal and redirect
          var successModalEl = document.getElementById('orderPlacedSuccessModal');
          var successModal = new bootstrap.Modal(successModalEl);
          successModal.show();
          setTimeout(function() {
            window.location.href = "{{ route('sales.status') }}";
          }, 2500);
        }
      });
    });
  });
</script>
@endsection 
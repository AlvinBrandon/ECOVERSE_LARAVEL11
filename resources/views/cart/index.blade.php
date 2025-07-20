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
    margin-right: 1rem;
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
    margin-bottom: 2rem;
  }

  .cart-container {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 2rem;
    align-items: start;
  }

  .table-container {
    background: rgba(255,255,255,0.9);
    border-radius: 1rem;
    border: 1px solid rgba(226, 232, 240, 0.6);
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(16, 185, 129, 0.08);
    backdrop-filter: blur(5px);
  }

  .table {
    margin-bottom: 0;
    font-family: 'Poppins', sans-serif !important;
    width: 100%;
    border-collapse: collapse;
  }

  .table thead th {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    color: #1f2937;
    font-weight: 600;
    font-size: 0.9rem;
    padding: 1rem 0.75rem;
    border: none;
    position: sticky;
    top: 0;
    z-index: 10;
  }

  .table tbody td {
    padding: 1rem 0.75rem;
    border-bottom: 1px solid rgba(226, 232, 240, 0.4);
    vertical-align: middle;
    font-size: 0.9rem;
  }

  .table tbody tr:hover {
    background: rgba(99, 102, 241, 0.02);
  }

  .table tbody tr:last-child td {
    border-bottom: none;
  }

  .table tbody tr:nth-child(even) {
    background: rgba(248, 250, 252, 0.5);
  }

  /* Product Display */
  .product-info {
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .product-image {
    width: 60px;
    height: 60px;
    border-radius: 0.75rem;
    object-fit: cover;
    border: 2px solid rgba(226, 232, 240, 0.6);
  }

  .product-name {
    font-weight: 600;
    color: #1f2937;
  }

  .product-price {
    font-weight: 600;
    color: #059669;
    font-size: 1rem;
  }

  /* Quantity Controls */
  .quantity-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    width: fit-content;
  }

  .quantity-btn {
    width: 32px;
    height: 32px;
    border: 2px solid rgba(226, 232, 240, 0.6);
    background: rgba(255,255,255,0.9);
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 600;
    color: #6b7280;
  }

  .quantity-btn:hover {
    border-color: #6366f1;
    background: #6366f1;
    color: white;
  }

  .quantity-input {
    width: 60px;
    text-align: center;
    border: 2px solid rgba(226, 232, 240, 0.6);
    border-radius: 0.5rem;
    padding: 0.375rem;
    font-weight: 600;
    background: rgba(255,255,255,0.9);
  }

  .quantity-input:focus {
    border-color: #6366f1;
    outline: none;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
  }

  .stock-warning {
    font-size: 0.75rem;
    color: #dc2626;
    font-weight: 500;
    margin-top: 0.25rem;
  }

  /* Order Summary */
  .order-summary {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.12);
    border: 1px solid rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    position: sticky;
    top: 2rem;
  }

  .summary-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    color: #1f2937;
    font-weight: 600;
    padding: 1rem 1.5rem;
    border-radius: 0.75rem;
    margin: -1rem -1rem 1.5rem -1rem;
    text-align: center;
    font-size: 1.1rem;
  }

  .summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(226, 232, 240, 0.3);
  }

  .summary-item:last-child {
    border-bottom: none;
    font-weight: 700;
    font-size: 1.1rem;
    color: #1f2937;
  }

  /* Button Styling */
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
    text-decoration: none;
  }

  .btn-primary {
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    color: white;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
    color: white;
  }

  .btn-link {
    background: transparent;
    color: #dc2626;
    box-shadow: none;
    padding: 0.5rem;
    font-size: 1rem;
  }

  .btn-link:hover {
    background: rgba(239, 68, 68, 0.1);
    color: #b91c1c;
    transform: none;
  }

  /* Empty State */
  .empty-cart {
    text-align: center;
    padding: 4rem 2rem;
    color: #6b7280;
  }

  .empty-cart i {
    font-size: 4rem;
    margin-bottom: 1.5rem;
    opacity: 0.5;
    color: #9ca3af;
  }

  .empty-cart h4 {
    font-weight: 600;
    color: #374151;
    margin-bottom: 1rem;
  }

  .empty-cart p {
    margin-bottom: 2rem;
    font-size: 1.1rem;
  }

  /* Responsive Design */
  @media (max-width: 992px) {
    .cart-container {
      grid-template-columns: 1fr;
      gap: 1.5rem;
    }
    
    .order-summary {
      position: static;
    }
  }

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

    .product-info {
      flex-direction: column;
      align-items: flex-start;
      gap: 0.5rem;
    }

    .product-image {
      width: 50px;
      height: 50px;
    }
    
    .table thead th,
    .table tbody td {
      padding: 0.75rem 0.5rem;
      font-size: 0.8rem;
    }

    .quantity-controls {
      flex-direction: column;
      gap: 0.25rem;
    }
  }

  /* Professional spacing and layout */
  .container {
    padding: 0.5rem 1.5rem 2rem 1.5rem !important;
    margin-top: 0 !important;
  }

  /* Currency styling */
  .currency {
    font-weight: 600;
    color: #059669;
  }

  /* Remove button styling */
  .remove-btn {
    padding: 0.5rem;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
  }

  .remove-btn:hover {
    background: rgba(239, 68, 68, 0.1);
  }
</style>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<div class="container">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center">
      <i class="bi bi-cart3"></i>
      <div>
        <h2>Shopping Cart</h2>
        <p>Review your items and proceed to checkout</p>
      </div>
    </div>
  </div>

  <!-- Cart Content -->
  <div class="content-section">
    @if(count($cart) > 0)
      <div class="cart-container">
        <!-- Cart Items -->
        <div class="table-container">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th><i class="bi bi-box me-2"></i>Product</th>
                  <th><i class="bi bi-currency-dollar me-2"></i>Price</th>
                  <th><i class="bi bi-123 me-2"></i>Quantity</th>
                  <th><i class="bi bi-calculator me-2"></i>Total</th>
                  <th><i class="bi bi-gear me-2"></i>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($cart as $id => $item)
                  <tr>
                    <td>
                      <div class="product-info">
                        @if($item['image'])
                          <img src="{{ asset('storage/'.$item['image']) }}" alt="{{ $item['name'] }}" class="product-image">
                        @else
                          <div class="product-image d-flex align-items-center justify-content-center bg-light">
                            <i class="bi bi-image text-muted"></i>
                          </div>
                        @endif
                        <span class="product-name">{{ $item['name'] }}</span>
                      </div>
                    </td>
                    <td><span class="product-price">₱{{ number_format($item['price'], 2) }}</span></td>
                    <td>
                      <div class="quantity-controls">
                        <div class="d-flex align-items-center gap-2">
                          <button class="quantity-btn" onclick="updateQuantity({{ $id }}, -1)">-</button>
                          <input type="number" class="quantity-input" value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] }}" onchange="updateQuantity({{ $id }}, this.value)" readonly>
                          <button class="quantity-btn" onclick="updateQuantity({{ $id }}, 1)">+</button>
                        </div>
                        @if($item['stock'] < 10)
                          <div class="stock-warning">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            Only {{ $item['stock'] }} left
                          </div>
                        @endif
                      </div>
                    </td>
                    <td><span class="currency">₱{{ number_format($item['price'] * $item['quantity'], 2) }}</span></td>
                    <td>
                      <form action="{{ route('cart.remove') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $id }}">
                        <button type="submit" class="btn btn-link remove-btn" onclick="return confirm('Remove this item from cart?')">
                          <i class="bi bi-trash"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <!-- Order Summary -->
        <div class="order-summary">
          <div class="summary-header">
            <i class="bi bi-receipt me-2"></i>Order Summary
          </div>
          <div class="summary-item">
            <span>Items ({{ count($cart) }})</span>
            <span>{{ count($cart) }} item{{ count($cart) > 1 ? 's' : '' }}</span>
          </div>
          <div class="summary-item">
            <span>Subtotal</span>
            <span class="currency">₱{{ number_format(collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']), 2) }}</span>
          </div>
          <div class="summary-item">
            <span><strong>Total</strong></span>
            <span class="currency"><strong>₱{{ number_format(collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']), 2) }}</strong></span>
          </div>
          <form action="{{ route('cart.checkout') }}" method="POST" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-primary w-100">
              <i class="bi bi-credit-card me-2"></i>
              Proceed to Checkout
            </button>
          </form>
        </div>
      </div>
    @else
      <div class="empty-cart">
        <i class="bi bi-cart-x"></i>
        <h4>Your cart is empty</h4>
        <p>Add items to get started with your shopping!</p>
        <a href="{{ route('sales.index') }}" class="btn btn-primary">
          <i class="bi bi-shop me-2"></i>
          Browse Products
        </a>
      </div>
    @endif
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

@push('scripts')
<script>
function updateQuantity(productId, change) {
    const input = document.querySelector(`input[data-product-id="${productId}"]`);
    let currentQuantity = parseInt(document.querySelector('.quantity-input').value);
    let newQuantity = currentQuantity;
    
    if (typeof change === 'number') {
        newQuantity += change;
    } else {
        newQuantity = parseInt(change);
    }
    
    if (newQuantity < 1) {
        return;
    }
    
    // Update via AJAX
    fetch('{{ route('cart.add') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: newQuantity - currentQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>
@endpush
@endsection

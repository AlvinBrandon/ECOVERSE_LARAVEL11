@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h3 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Shopping Cart</h3>
                </div>
                <div class="card-body">
                    @if(count($cart) > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $id => $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item['image'])
                                                        <img src="{{ asset('storage/'.$item['image']) }}" alt="{{ $item['name'] }}" class="img-thumbnail me-2" style="width: 50px;">
                                                    @endif
                                                    <span>{{ $item['name'] }}</span>
                                                </div>
                                            </td>
                                            <td>₱{{ number_format($item['price'], 2) }}</td>
                                            <td>
                                                <div class="input-group" style="width: 120px;">
                                                    <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity({{ $id }}, -1)">-</button>
                                                    <input type="number" class="form-control form-control-sm text-center" value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] }}" onchange="updateQuantity({{ $id }}, this.value)" readonly>
                                                    <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity({{ $id }}, 1)">+</button>
                                                </div>
                                                @if($item['stock'] < 10)
                                                    <small class="text-danger">Only {{ $item['stock'] }} left</small>
                                                @endif
                                            </td>
                                            <td>₱{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                            <td>
                                                <form action="{{ route('cart.remove') }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                                    <button type="submit" class="btn btn-link text-danger"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h4>Your cart is empty</h4>
                            <p class="text-muted">Add items to get started!</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">Browse Products</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Order Summary</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal</span>
                        <span>₱{{ number_format($total, 2) }}</span>
                    </div>
                    @if(count($cart) > 0)
                        <form action="{{ route('cart.checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">Proceed to Checkout</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateQuantity(productId, change) {
    const input = document.querySelector(`input[data-product-id="${productId}"]`);
    let newQuantity = parseInt(input.value);
    
    if (typeof change === 'number') {
        newQuantity += change;
    } else {
        newQuantity = parseInt(change);
    }
    
    if (newQuantity < 1 || newQuantity > parseInt(input.getAttribute('max'))) {
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
            quantity: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        }
    });
}
</script>
@endpush
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Place Your Order</h2>

    <form action="{{ route('order.store') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <p><strong>Product:</strong> {{ $product->name }}</p>
        <p><strong>Unit Price:</strong> UGX {{ number_format($product->price) }}</p>

        <div class="mb-3">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" value="1" class="form-control" min="1">
        </div>

        <div class="mb-3">
            <label for="delivery_address">Delivery Address:</label>
            <textarea name="delivery_address" id="delivery_address" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Total Price:</label>
            <p id="total_price">UGX {{ number_format($product->price) }}</p>
        </div>

        <button type="submit" class="btn btn-primary">Confirm Order</button>
    </form>
</div>

<script>
    const price = {{ $product->price }};
    const quantityInput = document.getElementById('quantity');
    const totalPriceDisplay = document.getElementById('total_price');

    quantityInput.addEventListener('input', function() {
        const total = price * quantityInput.value;
        totalPriceDisplay.innerText = 'UGX ' + total.toLocaleString();
    });
</script>
@endsection

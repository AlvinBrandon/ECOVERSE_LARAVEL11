@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Available Products</h1>
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text"><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                        <p class="card-text"><strong>Stock:</strong> {{ $product->stock }}</p>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary mb-2">View Details</a>

                        <!-- FORM TO PREVIEW ORDER -->
                        <form action="{{ route('order.preview') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <label for="quantity_{{ $product->id }}">Quantity:</label>
                            <input type="number" name="quantity" id="quantity_{{ $product->id }}" class="form-control mb-2" min="1" max="{{ $product->stock }}" value="1" required>
                            <button type="submit" class="btn btn-primary w-100">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

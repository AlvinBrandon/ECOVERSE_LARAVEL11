@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">&larr; Back to Products</a>
    <div class="card">
        <div class="row g-0">
            @if($product->image)
                <div class="col-md-4">
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded-start" alt="{{ $product->name }}">
                </div>
            @endif
            <div class="col-md-8">
                <div class="card-body">
                    <h2 class="card-title">{{ $product->name }}</h2>
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="card-text"><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                    <p class="card-text"><strong>Stock:</strong> {{ $product->stock }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
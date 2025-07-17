@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">&larr; Back to Products</a>
    <div class="card">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid p-3" alt="{{ $product->name }}">
        @endif
        <div class="card-body">
            <h2 class="card-title">{{ $product->name }}</h2>
            <p class="card-text">{{ $product->description }}</p>
            <p class="card-text"><strong>Price:</strong> UGX {{ number_format($product->price, 0) }}</p>
        </div>
    </div>
</div>
@endsection 
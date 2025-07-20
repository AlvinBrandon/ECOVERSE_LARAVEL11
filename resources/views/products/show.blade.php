@extends('layouts.app')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 400px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                        <i class="fas fa-image fa-5x text-muted"></i>
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <h1 class="mb-3">{{ $product->name }}</h1>
            
            <div class="mb-4">
                <h3 class="text-primary mb-0">UGX {{ number_format($product->price, 2) }}</h3>
                <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }} mt-2">
                    {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                </span>
                @if($product->stock > 0)
                    <span class="text-muted ms-2">({{ $product->stock }} units available)</span>
                @endif
            </div>

            <div class="mb-4">
                <h5>Description</h5>
                <p class="text-muted">{{ $product->description }}</p>
            </div>

            @if($product->category)
                <div class="mb-4">
                    <h5>Category</h5>
                    <p class="text-muted">{{ $product->category }}</p>
                </div>
            @endif

            @if($product->stock > 0)
                <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <label for="quantity" class="form-label">Quantity:</label>
                        </div>
                        <div class="col-auto">
                            <select name="quantity" id="quantity" class="form-select">
                                @for($i = 1; $i <= min($product->stock, 10); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </form>
            @endif

            <!-- Additional Information -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body">
                    <h5 class="card-title">Product Information</h5>
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" style="width: 150px;">SKU</td>
                            <td>{{ $product->sku ?? 'N/A' }}</td>
                        </tr>
                        @if($product->manufacturer)
                            <tr>
                                <td class="text-muted">Manufacturer</td>
                                <td>{{ $product->manufacturer }}</td>
                            </tr>
                        @endif
                        @if($product->weight)
                            <tr>
                                <td class="text-muted">Weight</td>
                                <td>{{ $product->weight }} kg</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">Related Products</h3>
                <div class="row">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                @if($relatedProduct->image)
                                    <img src="{{ asset('storage/' . $relatedProduct->image) }}" class="card-img-top" alt="{{ $relatedProduct->name }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $relatedProduct->name }}</h5>
                                    <p class="card-text text-muted">{{ Str::limit($relatedProduct->description, 100) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 mb-0">UGX {{ number_format($relatedProduct->price, 2) }}</span>
                                        <a href="{{ route('products.show', $relatedProduct) }}" class="btn btn-outline-primary btn-sm">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush 
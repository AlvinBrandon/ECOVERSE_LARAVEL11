<!-- resources/views/sales/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
  <div class="row mb-4">
    <div class="col-12">
      <h4 class="text-dark">Product Catalog</h4>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-12 d-flex gap-2">
      <a href="{{ route('sales.index') }}" class="btn btn-outline-primary {{ request()->routeIs('sales.index') ? 'active' : '' }}">Product Catalog</a>
      <a href="{{ route('sales.history') }}" class="btn btn-outline-info {{ request()->routeIs('sales.history') ? 'active' : '' }}">Order History</a>
      <a href="{{ route('sales.status') }}" class="btn btn-outline-success {{ request()->routeIs('sales.status') ? 'active' : '' }}">Order Status</a>
      @if(auth()->user() && auth()->user()->is_admin)
        <a href="{{ route('admin.sales.report') }}" class="btn btn-outline-dark {{ request()->routeIs('admin.sales.report') ? 'active' : '' }}">Admin Report</a>
      @endif
    </div>
  </div>

  <div class="row">
    @foreach ($products as $product)
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">{{ $product->name }}</h5>
          <p class="card-text text-sm text-muted">Type: {{ $product->type }}</p>
          <p class="card-text">{{ $product->description }}</p>
          <p class="card-text text-success">Price: UGX {{ number_format($product->price) }}</p>

          <form action="{{ route('sales.store') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div class="mb-3">
              <label for="quantity_{{ $product->id }}" class="form-label">Quantity:</label>
              <input type="number" name="quantity" id="quantity_{{ $product->id }}" class="form-control" min="1" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Place Order</button>
          </form>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection

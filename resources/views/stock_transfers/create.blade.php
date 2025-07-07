@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Stock Transfer</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('stock_transfer.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="inventory_id" class="form-label">Product</label>
            <select name="inventory_id" id="inventory_id" class="form-select" required>
                <option value="">Select Product</option>
                @foreach($inventories as $inventory)
                    <option value="{{ $inventory->id }}">{{ $inventory->product->name }} ({{ $inventory->location->name ?? 'N/A' }}) - Qty: {{ $inventory->quantity }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="from_location_id" class="form-label">From Location</label>
            <select name="from_location_id" id="from_location_id" class="form-select" required>
                <option value="">Select Location</option>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="to_location_id" class="form-label">To Location</label>
            <select name="to_location_id" id="to_location_id" class="form-select" required>
                <option value="">Select Location</option>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
        </div>
        <div class="mb-3">
            <label for="note" class="form-label">Note (optional)</label>
            <textarea name="note" id="note" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Transfer Stock</button>
        <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

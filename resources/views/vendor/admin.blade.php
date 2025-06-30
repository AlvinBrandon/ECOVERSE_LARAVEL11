@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Vendor Dashboard</h1>
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">Manage Products</h5>
                    <p class="card-text">Add, edit, or remove your products.</p>
                    <a href="#" class="btn btn-primary disabled">Manage Products (Coming Soon)</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">View Orders</h5>
                    <p class="card-text">See orders for your products.</p>
                    <a href="#" class="btn btn-primary disabled">View Orders (Coming Soon)</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">Application Status</h5>
                    <p class="card-text">Check the status of your vendor application.</p>
                    <a href="{{ route('vendor.status') }}" class="btn btn-info">Check Status</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">Support</h5>
                    <p class="card-text">Contact support for help or questions.</p>
                    <a href="{{ route('chat.index') }}" class="btn btn-primary">Contact Support</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
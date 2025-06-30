@extends('layouts.app', ['activePage' => 'vendor-status'])

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Vendor Application Status</h4>
                </div>
                <div class="card-body">
                    <h5 class="mb-3">Hello, {{ $vendor->name }}!</h5>
                    <p><strong>Email:</strong> {{ $vendor->email }}</p>
                    <p><strong>Vendor Type:</strong> {{ ucfirst($vendor->type) }}</p>
                    <p><strong>Submitted At:</strong> {{ $vendor->created_at->toDayDateTimeString() }}</p>
                    <hr>
                    @if($vendor->status === 'pending')
                        <div class="alert alert-warning">
                            <i class="fas fa-hourglass-half"></i>
                            Your application is <strong>pending</strong>. We are reviewing your documents. Please check back later.
                        </div>
                        <p><strong>Scheduled Site Visit:</strong> {{ $vendor->scheduled_visit ? $vendor->scheduled_visit->toDayDateTimeString() : 'TBD' }}</p>
                    @elseif($vendor->status === 'verified')
                        <div class="alert alert-info">
                            <i class="fas fa-user-check"></i>
                            Your URSB document has been <strong>verified</strong>. Awaiting final approval.
                        </div>
                        <p><strong>Scheduled Site Visit:</strong> {{ $vendor->scheduled_visit ? $vendor->scheduled_visit->toDayDateTimeString() : 'TBD' }}</p>
                    @elseif($vendor->status === 'approved')
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            Congratulations! Your application has been <strong>approved</strong>. You are now a registered vendor.
                        </div>
                    @elseif($vendor->status === 'rejected')
                        <div class="alert alert-danger">
                            <i class="fas fa-times-circle"></i>
                            We regret to inform you that your application was <strong>rejected</strong>. Please contact support for more information.
                        </div>
                    @else
                        <div class="alert alert-secondary">
                            <i class="fas fa-info-circle"></i>
                            Status: <strong>{{ ucfirst($vendor->status) }}</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
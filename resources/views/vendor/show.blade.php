@extends('layouts.app')

@section('content')
<div class="container mt-5 d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4" style="max-width: 500px; width: 100%; border-radius: 1rem; background: #fff;">
        <h3 class="mb-4 text-center" style="color: #e91e63; font-weight: 700; letter-spacing: 1px;">Vendor Application Details</h3>
        <div class="mb-3"><strong>Name:</strong> <span style="color: #344767;">{{ $vendor->name }}</span></div>
        <div class="mb-3"><strong>Email:</strong> <span style="color: #344767;">{{ $vendor->email }}</span></div>
        <div class="mb-3"><strong>Type:</strong> <span class="badge bg-info text-white">{{ ucfirst($vendor->type) }}</span></div>
        <div class="mb-3"><strong>Address:</strong> <span style="color: #344767;">{{ $vendor->address }}</span></div>
        <div class="mb-3"><strong>TIN:</strong> <span style="color: #344767;">{{ $vendor->tin }}</span></div>
        <div class="mb-3"><strong>Status:</strong> 
            @if($vendor->status === 'pending')
                <span class="badge bg-warning text-dark">Pending</span>
            @elseif($vendor->status === 'approved')
                <span class="badge bg-success">Approved</span>
            @else
                <span class="badge bg-danger">Rejected</span>
            @endif
        </div>
        <div class="mb-3"><strong>Scheduled Visit:</strong> <span style="color: #344767;">{{ $vendor->scheduled_visit ? $vendor->scheduled_visit->format('D, M d, Y H:i') : '-' }}</span></div>
        <div class="mb-3"><strong>URSB Document:</strong> <a href="{{ asset('storage/' . $vendor->ursb_document) }}" target="_blank" class="btn btn-outline-primary btn-sm">Download</a></div>
        @if($vendor->status === 'pending')
        <div class="d-flex gap-2">
            <form action="{{ route('vendor.approve', $vendor->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success w-100">Approve</button>
            </form>
            <form action="{{ route('vendor.reject', $vendor->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100">Reject</button>
            </form>
        </div>
        @endif
        <a href="{{ route('vendor.admin') }}" class="btn btn-secondary w-100 mt-3">Back to List</a>
    </div>
</div>
@endsection 
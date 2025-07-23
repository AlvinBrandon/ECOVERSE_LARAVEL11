@extends('layouts.app')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    body, .main-content, .container-fluid {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
        font-family: 'Poppins', sans-serif;
    }

    .page-header {
        background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
        border-radius: 1rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        color: white;
    }

    .user-details {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        border: none;
    }

    .user-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 2rem;
        border-bottom: 1px solid #e5e7eb;
        text-align: center;
    }

    .user-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 3rem;
        color: white;
    }

    .user-body {
        padding: 2rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .info-section {
        background: #f8fafc;
        border-radius: 0.75rem;
        padding: 1.5rem;
        border: 1px solid #e5e7eb;
    }

    .info-section h6 {
        color: #374151;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 500;
        color: #6b7280;
        font-size: 0.875rem;
    }

    .info-value {
        font-weight: 600;
        color: #374151;
        text-align: right;
    }

    .role-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .role-admin { background: #dbeafe; color: #1e40af; }
    .role-staff { background: #d1fae5; color: #065f46; }
    .role-supplier { background: #fef3c7; color: #92400e; }
    .role-wholesaler { background: #e0e7ff; color: #3730a3; }
    .role-retailer { background: #fce7f3; color: #be185d; }
    .role-customer { background: #f3f4f6; color: #374151; }

    .btn {
        font-weight: 500;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-verified {
        background: #d1fae5;
        color: #065f46;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="bi bi-person-circle me-3" style="font-size: 2rem;"></i>
                <div>
                    <h4>User Details</h4>
                    <p class="mb-0 opacity-75">View user information and account details</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-1"></i>Edit User
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Back to Users
                </a>
            </div>
        </div>
    </div>

    <!-- User Details -->
    <div class="user-details">
        <div class="user-header">
            <div class="user-avatar">
                <i class="bi bi-person"></i>
            </div>
            <h3>{{ $user->name }}</h3>
            <span class="role-badge role-{{ $user->role }}">
                {{ ucfirst($user->role) }}
            </span>
            @if($user->email_verified_at)
                <span class="status-badge status-verified ms-2">
                    <i class="bi bi-check-circle me-1"></i>Verified
                </span>
            @else
                <span class="status-badge status-pending ms-2">
                    <i class="bi bi-clock me-1"></i>Pending Verification
                </span>
            @endif
        </div>

        <div class="user-body">
            <div class="info-grid">
                <!-- Personal Information -->
                <div class="info-section">
                    <h6><i class="bi bi-person me-2"></i>Personal Information</h6>
                    <div class="info-item">
                        <span class="info-label">Full Name</span>
                        <span class="info-value">{{ $user->name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email Address</span>
                        <span class="info-value">{{ $user->email }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Phone Number</span>
                        <span class="info-value">{{ $user->phone ?? 'Not provided' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Address</span>
                        <span class="info-value">{{ $user->address ?? 'Not provided' }}</span>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="info-section">
                    <h6><i class="bi bi-shield me-2"></i>Account Information</h6>
                    <div class="info-item">
                        <span class="info-label">User ID</span>
                        <span class="info-value">#{{ $user->id }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Role</span>
                        <span class="info-value">
                            <span class="role-badge role-{{ $user->role }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Account Status</span>
                        <span class="info-value">
                            @if($user->email_verified_at)
                                <span class="status-badge status-verified">
                                    <i class="bi bi-check-circle me-1"></i>Active
                                </span>
                            @else
                                <span class="status-badge status-pending">
                                    <i class="bi bi-clock me-1"></i>Pending
                                </span>
                            @endif
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Joined Date</span>
                        <span class="info-value">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Last Updated</span>
                        <span class="info-value">{{ $user->updated_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-3 mt-4">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-2"></i>Edit User
                </a>
                @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                            <i class="bi bi-trash me-2"></i>Delete User
                        </button>
                    </form>
                @endif
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Users
                </a>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

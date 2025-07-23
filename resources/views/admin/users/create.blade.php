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

    .page-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 1.5rem;
    }

    .page-header .btn {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        backdrop-filter: blur(10px);
        transition: all 0.2s ease;
    }

    .page-header .btn:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
    }

    .form-container {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        border: none;
    }

    .form-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 2rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .form-header h5 {
        color: #374151;
        font-weight: 600;
        margin: 0;
        font-size: 1.25rem;
    }

    .form-body {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 0.875rem 1rem;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        background: #f9fafb;
    }

    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        background: white;
        outline: none;
    }

    .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 0.875rem 1rem;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        background: #f9fafb;
        background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23374151' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3E%3C/svg%3E");
    }

    .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        background-color: white;
        outline: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.875rem 2rem;
        border-radius: 0.75rem;
        transition: all 0.2s ease;
        font-size: 0.875rem;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        color: white;
    }

    .btn-secondary {
        background: #6b7280;
        border: none;
        color: white;
        font-weight: 500;
        padding: 0.875rem 2rem;
        border-radius: 0.75rem;
        transition: all 0.2s ease;
        font-size: 0.875rem;
    }

    .btn-secondary:hover {
        background: #4b5563;
        transform: translateY(-2px);
        color: white;
    }

    .alert {
        border-radius: 0.75rem;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        border: none;
        font-weight: 500;
    }

    .alert-danger {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #dc2626;
        border: 1px solid #f87171;
    }

    .role-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        font-weight: 500;
        margin-left: 0.5rem;
    }

    .role-admin { background: #dbeafe; color: #1e40af; }
    .role-staff { background: #d1fae5; color: #065f46; }
    .role-supplier { background: #fef3c7; color: #92400e; }
    .role-wholesaler { background: #e0e7ff; color: #3730a3; }
    .role-retailer { background: #fce7f3; color: #be185d; }
    .role-customer { background: #f3f4f6; color: #374151; }

    .form-text {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .required {
        color: #dc2626;
    }

    .row.g-3 > * {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }

    @media (max-width: 768px) {
        .form-body {
            padding: 1.5rem;
        }
        
        .page-header {
            padding: 1.5rem;
        }
        
        .btn-primary,
        .btn-secondary {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="bi bi-person-plus me-3" style="font-size: 2rem;"></i>
                <div>
                    <h4>Add New User</h4>
                    <p class="mb-0 opacity-75">Create a new user account with specific role and permissions</p>
                </div>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn">
                <i class="bi bi-arrow-left me-1"></i>Back to Users
            </a>
        </div>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <div class="form-header">
            <h5><i class="bi bi-person-circle me-2"></i>User Information</h5>
        </div>
        
        <div class="form-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Please correct the following errors:</strong>
                    <ul class="mt-2 mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                
                <!-- Basic Information -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">
                                Full Name <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            <div class="form-text">Enter the user's full name</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label">
                                Email Address <span class="required">*</span>
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            <div class="form-text">Must be a valid email address</div>
                        </div>
                    </div>
                </div>

                <!-- Password Fields -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="form-label">
                                Password <span class="required">*</span>
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            <div class="form-text">Minimum 8 characters</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">
                                Confirm Password <span class="required">*</span>
                            </label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                            <div class="form-text">Must match the password above</div>
                        </div>
                    </div>
                </div>

                <!-- Role Selection -->
                <div class="form-group">
                    <label for="role" class="form-label">
                        User Role <span class="required">*</span>
                    </label>
                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                        <option value="">Select a role...</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                            Administrator <span class="role-badge role-admin">Full Access</span>
                        </option>
                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>
                            Staff Member <span class="role-badge role-staff">Operations</span>
                        </option>
                        <option value="supplier" {{ old('role') == 'supplier' ? 'selected' : '' }}>
                            Supplier <span class="role-badge role-supplier">Raw Materials</span>
                        </option>
                        <option value="wholesaler" {{ old('role') == 'wholesaler' ? 'selected' : '' }}>
                            Wholesaler <span class="role-badge role-wholesaler">Bulk Orders</span>
                        </option>
                        <option value="retailer" {{ old('role') == 'retailer' ? 'selected' : '' }}>
                            Retailer <span class="role-badge role-retailer">Retail Sales</span>
                        </option>
                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>
                            Customer <span class="role-badge role-customer">Purchase</span>
                        </option>
                    </select>
                    <div class="form-text">Choose the appropriate role for this user's responsibilities</div>
                </div>

                <!-- Contact Information -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}">
                            <div class="form-text">Optional contact number</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3">{{ old('address') }}</textarea>
                            <div class="form-text">Optional physical address</div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-person-plus me-2"></i>Create User
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-lg me-2"></i>Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

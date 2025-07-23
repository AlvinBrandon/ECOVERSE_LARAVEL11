@extends('layouts.app')

@section('content')
<style>
  /* Global Poppins Font Implementation */
  * {
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
  }

  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%) !important;
    font-family: 'Poppins', sans-serif !important;
    min-height: 10vh;
    padding: 0 !important;
  }

  .main-content {
    padding-top: 0 !important;
    margin-top: 0 !important;
    /* Keep sidebar margin but reset top margin */
    margin-bottom: 0 !important;
  }

  /* Ensure sidebar layout is preserved - highest specificity */
  body[data-user-id] .main-content {
    margin-left: 280px !important;
  }

  /* Mobile responsive override */
  @media (max-width: 1199.98px) {
    body[data-user-id] .main-content {
      margin-left: 0 !important;
    }
  }

  /* Override any layout padding/margin */
  .app-content, .content, #app, main {
    padding-top: 0 !important;
    margin-top: 0 !important;
  }

  /* Specifically target the main element from layout */
  main.py-4 {
    padding-top: 0 !important;
    padding-bottom: 1rem !important;
  }

  /* Remove Bootstrap container default margins */
  .container, .container-fluid, .container-sm, .container-md, .container-lg, .container-xl {
    margin-top: 0 !important;
    padding-top: 0 !important;
  }

  .page-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
    color: white;
    padding: 2rem 1.5rem;
    border-radius: 1rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(30, 41, 59, 0.2);
    border: 1px solid rgba(255,255,255,0.1);
  }

  .page-header h2 {
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
  }

  .page-header p {
    opacity: 0.9;
    font-size: 1.1rem;
    margin-bottom: 0;
    font-weight: 400;
  }

  .content-section {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.12);
    border: 1px solid rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
  }

  .content-section h4 {
    color: #1f2937;
    font-weight: 600;
    font-size: 1.25rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .table-container {
    background: rgba(255,255,255,0.9);
    border-radius: 1rem;
    border: 1px solid rgba(226, 232, 240, 0.6);
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(16, 185, 129, 0.08);
    backdrop-filter: blur(5px);
  }

  .table {
    margin-bottom: 0;
    font-family: 'Poppins', sans-serif !important;
  }

  .table thead th {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    color: #1f2937;
    font-weight: 600;
    font-size: 0.9rem;
    padding: 1rem 0.75rem;
    border: none;
    position: sticky;
    top: 0;
    z-index: 10;
  }

  .table tbody td {
    padding: 1rem 0.75rem;
    border-bottom: 1px solid rgba(226, 232, 240, 0.4);
    vertical-align: middle;
    font-size: 0.9rem;
  }

  .table tbody tr:hover {
    background: rgba(99, 102, 241, 0.02);
  }

  .table tbody tr:last-child td {
    border-bottom: none;
  }

  .form-select {
    font-family: 'Poppins', sans-serif !important;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.85rem;
    background: white;
    transition: all 0.3s ease;
    margin-right: 0.5rem;
  }

  .form-select:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.1);
  }

  .btn {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 500;
    border-radius: 0.5rem;
    padding: 0.5rem 1rem;
    border: none;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    cursor: pointer;
    gap: 0.375rem;
    font-size: 0.85rem;
  }

  .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  }

  .btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.8rem;
  }

  .btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    color: white;
  }

  .btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
  }

  .btn-danger:hover {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    color: white;
  }

  .alert {
    border-radius: 0.75rem;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    border: none;
    font-weight: 500;
  }

  .alert-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
    border: 1px solid rgba(16, 185, 129, 0.2);
  }

  .badge {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 500;
    padding: 0.4rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .badge.bg-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
    color: white;
  }

  .badge.bg-secondary {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%) !important;
    color: white;
  }

  .badge.bg-info {
    background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
    color: white;
  }

  .badge.bg-warning {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%) !important;
    color: #92400e;
  }

  .badge.bg-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
    color: white;
  }

  .badge.bg-dark {
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%) !important;
    color: white;
  }

  .role-form {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .delete-form {
    margin: 0;
  }

  /* User info styling */
  .user-name {
    font-weight: 600;
    color: #1f2937;
  }

  .user-email {
    color: #6b7280;
    font-size: 0.9rem;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .page-header {
      padding: 1.5rem 1rem;
    }
    
    .page-header h2 {
      font-size: 1.5rem;
    }
    
    .content-section {
      padding: 1.5rem 1rem;
    }
    
    .table thead th,
    .table tbody td {
      padding: 0.75rem 0.5rem;
      font-size: 0.8rem;
    }

    .role-form {
      flex-direction: column;
      gap: 0.25rem;
      width: 100%;
    }

    .form-select {
      margin-right: 0;
      margin-bottom: 0.5rem;
    }

    .btn-sm {
      width: 100%;
    }
  }

  /* Professional spacing and layout */
  .container-fluid {
    padding: 0.5rem 1.5rem 2rem 1.5rem !important;
    margin-top: 0 !important;
  }

  /* Table actions styling */
  .action-cell {
    white-space: nowrap;
  }

  .role-badge-container {
    display: flex;
    justify-content: center;
  }
</style>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<div class="container-fluid">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center">
      <i class="bi bi-people me-3" style="font-size: 2.5rem;"></i>
      <div>
        <h2>User Management</h2>
        <p>Manage all users and roles in the system. Each role has a dedicated dashboard</p>
      </div>
    </div>
  </div>

  <!-- Content Section -->
  <div class="row justify-content-center">
    <div class="col-md-11">
      <div class="content-section">
        <h4>
          <i class="bi bi-person-gear me-2"></i>
          Manage User Roles
        </h4>
        
        @if(session('success'))
          <div class="alert alert-success">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
          </div>
        @endif

        <div class="table-container">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead>
                <tr>
                  <th><i class="bi bi-person me-2"></i>Name</th>
                  <th><i class="bi bi-envelope me-2"></i>Email</th>
                  <th><i class="bi bi-shield-check me-2"></i>Current Role</th>
                  <th><i class="bi bi-arrow-repeat me-2"></i>Change Role</th>
                  <th><i class="bi bi-trash me-2"></i>Delete User</th>
                </tr>
              </thead>
              <tbody>
                @foreach($users as $user)
                  <tr>
                    <td>
                      <div class="user-name">{{ $user->name }}</div>
                    </td>
                    <td>
                      <div class="user-email">{{ $user->email }}</div>
                    </td>
                    <td>
                      <div class="role-badge-container">
                        @php
                          $roleLabels = [
                            0 => ['Customer', 'secondary'],
                            1 => ['Admin', 'primary'],
                            2 => ['Retailer', 'info'],
                            3 => ['Staff', 'warning'],
                            4 => ['Supplier', 'success'],
                            5 => ['Wholesaler', 'dark'],
                          ];
                          $role = $roleLabels[$user->role_as] ?? ['Unknown', 'secondary'];
                        @endphp
                        <span class="badge bg-{{ $role[1] }}">{{ $role[0] }}</span>
                      </div>
                    </td>
                    <td class="action-cell">
                      <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="role-form">
                        @csrf
                        <select name="role_as" class="form-select">
                          @if($user->role_as == 1) {{-- Admin can be changed to any role --}}
                            <option value="1" selected>Admin</option>
                            <option value="0">Customer</option>
                            <option value="2">Retailer</option>
                            <option value="3">Staff</option>
                            <option value="4">Supplier</option>
                            <option value="5">Wholesaler</option>
                          @elseif($user->role_as == 5) {{-- Wholesaler can only be changed to Retailer --}}
                            <option value="5" selected>Wholesaler</option>
                            <option value="2">Retailer</option>
                          @elseif($user->role_as == 2) {{-- Retailer can only be changed to Customer --}}
                            <option value="2" selected>Retailer</option>
                            <option value="0">Customer</option>
                          @elseif($user->role_as == 0) {{-- Customer can only be changed to Retailer --}}
                            <option value="0" selected>Customer</option>
                            <option value="2">Retailer</option>
                          @else
                            <option value="{{ $user->role_as }}" selected>{{ $roleLabels[$user->role_as][0] ?? 'Unknown' }}</option>
                          @endif
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">
                          <i class="bi bi-check-lg"></i>
                          Update
                        </button>
                      </form>
                    </td>
                    <td class="action-cell">
                      <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                          <i class="bi bi-trash"></i>
                          Delete
                        </button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
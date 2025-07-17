@extends('layouts.app')

@section('content')
<style>
  body, .main-content, .container-fluid, .container {
    background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%) !important;
  }
  .dashboard-card, .user-card {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    box-shadow: 0 4px 24px rgba(16, 185, 129, 0.08);
    padding: 2rem 1.5rem;
    margin-bottom: 2rem;
    transition: box-shadow 0.2s, transform 0.2s;
  }
  .dashboard-card:hover, .user-card:hover {
    box-shadow: 0 8px 32px rgba(99,102,241,0.18), 0 2px 8px rgba(16,185,129,0.10);
    transform: translateY(-4px) scale(1.025);
    z-index: 2;
    cursor: pointer;
  }
  .user-header {
    background: linear-gradient(90deg, #6366f1 0%, #10b981 100%) !important;
    color: #fff !important;
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
    padding: 1.5rem 1.5rem 1rem 1.5rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
  }
  .user-icon {
    font-size: 2.5rem;
    margin-right: 1rem;
    vertical-align: middle;
  }
</style>
<div class="container py-4">
  <div class="user-header">
    <i class="bi bi-people user-icon"></i>
    <div>
      <h2 class="mb-0">User Management</h2>
      <p class="mb-0" style="font-size:1.1rem;">Manage all users and roles in the system. Each role has a dedicated dashboard.</p>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="user-card">
        <h4 class="mb-4">Manage User Roles</h4>
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered table-hover">
          <thead class="bg-light">
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Current Role</th>
              <th>Change Role</th>
              <th>Delete User</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
              <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                  @php
                    $roleLabels = [
                      0 => ['Customer', 'secondary'],
                      1 => ['Admin', 'primary'],
                      2 => ['Retailer', 'info'],
                      3 => ['Staff', 'warning'],
                      4 => ['Supplier', 'success'],
                      5 => ['Wholesaler', 'dark'],
                    ];
                    $role = $roleLabels[$user->role_as] ?? ['Unknown', 'light'];
                  @endphp
                  <span class="badge bg-{{ $role[1] }}">{{ $role[0] }}</span>
                </td>
                <td>
                  <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="d-flex align-items-center">
                    @csrf
                    <select name="role_as" class="form-select me-2">
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
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                  </form>
                </td>
                <td>
                  <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
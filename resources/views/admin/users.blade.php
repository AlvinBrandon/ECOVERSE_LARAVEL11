@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Manage User Roles</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Current Role</th>
                <th>Change Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role_as == 1)
                            Admin
                        @elseif($user->role_as == 2)
                            Vendor
                        @else
                            Customer
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="d-flex align-items-center">
                            @csrf
                            <select name="role_as" class="form-select me-2">
                                <option value="0" @if($user->role_as == 0) selected @endif>Customer</option>
                                <option value="1" @if($user->role_as == 1) selected @endif>Admin</option>
                                <option value="2" @if($user->role_as == 2) selected @endif>Vendor</option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 
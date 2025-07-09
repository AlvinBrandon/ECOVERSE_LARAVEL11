@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pending Sales Approvals</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Product</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->user->name ?? 'N/A' }}</td>
                    <td>{{ $sale->product->name ?? 'N/A' }}</td>
                    <td>{{ $sale->status }}</td>
                    <td>
                        <form action="{{ route('admin.sales.verify', $sale->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Verify</button>
                        </form>
                        <form action="{{ route('admin.sales.reject', $sale->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

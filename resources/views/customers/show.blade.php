@extends('layouts.admin-full')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
@import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&display=swap');

body, .main-content, .container-fluid, .container {
    background-color: #f8fafc !important;
    font-family: 'Poppins', sans-serif;
}

.customer-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.1);
}

.customer-avatar-large {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 2rem;
    color: white;
    margin-right: 1.5rem;
}

.customer-info h2 {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.customer-info p {
    opacity: 0.9;
    font-size: 1.1rem;
    margin-bottom: 0;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
    text-align: center;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.12);
}

.stat-card .stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin: 0 auto 1rem;
}

.stat-card .stat-value {
    font-size: 1.8rem;
    font-weight: 700;
    font-family: 'JetBrains Mono', monospace;
    margin-bottom: 0.5rem;
}

.stat-card .stat-label {
    color: #6b7280;
    font-size: 0.9rem;
    font-weight: 500;
}

.orders-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
}

.table {
    font-family: 'Poppins', sans-serif;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
}

.table thead th {
    background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    color: #1e293b;
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1rem;
    border: none;
}

.table tbody td {
    padding: 1rem;
    vertical-align: middle;
    border-color: #e2e8f0;
    font-weight: 400;
}

.table tbody tr:hover {
    background-color: #f8fafc;
}

.badge {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    border: none;
    transition: all 0.3s ease;
}

.btn-secondary {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
}

.btn-secondary:hover {
    background: linear-gradient(135deg, #4b5563, #374151);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(107, 114, 128, 0.3);
    color: white;
}

.metric-value {
    font-family: 'JetBrains Mono', monospace;
    font-weight: 600;
}
</style>

<div class="container py-4">
    <!-- Customer Header -->
    <div class="customer-header">
        <div class="d-flex align-items-center">
            <div class="customer-avatar-large" style="background: linear-gradient(135deg, #{{ substr(md5($customer->name), 0, 6) }}, #{{ substr(md5($customer->email), 0, 6) }});">
                {{ strtoupper(substr($customer->name, 0, 2)) }}
            </div>
            <div class="customer-info flex-grow-1">
                <h2>{{ $customer->name }}</h2>
                <p>{{ $customer->email }}</p>
            </div>
            <div>
                <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Customers
                </a>
            </div>
        </div>
    </div>

    <!-- Customer Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white;">
                <i class="bi bi-bag-check"></i>
            </div>
            <div class="stat-value" style="color: #3b82f6;">{{ number_format($customerStats['total_orders']) }}</div>
            <div class="stat-label">Total Orders</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669); color: white;">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-value" style="color: #10b981;">{{ number_format($customerStats['approved_orders']) }}</div>
            <div class="stat-label">Approved Orders</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white;">
                <i class="bi bi-currency-exchange"></i>
            </div>
            <div class="stat-value" style="color: #f59e0b;">UGX {{ number_format($customerStats['total_spent']) }}</div>
            <div class="stat-label">Total Spent</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white;">
                <i class="bi bi-star"></i>
            </div>
            <div class="stat-value" style="color: #8b5cf6;">{{ number_format($customerStats['eco_points']) }}</div>
            <div class="stat-label">Eco Points</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white;">
                <i class="bi bi-clock"></i>
            </div>
            <div class="stat-value" style="color: #ef4444;">{{ number_format($customerStats['pending_orders']) }}</div>
            <div class="stat-label">Pending Orders</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #06b6d4, #0891b2); color: white;">
                <i class="bi bi-graph-up"></i>
            </div>
            <div class="stat-value" style="color: #06b6d4;">UGX {{ number_format($customerStats['avg_order_value']) }}</div>
            <div class="stat-label">Avg Order Value</div>
        </div>
    </div>

    <!-- Customer Details -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="orders-card">
                <h5 class="mb-3">Customer Information</h5>
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ $customer->email }}</td>
                    </tr>
                    <tr>
                        <td><strong>Phone:</strong></td>
                        <td>{{ $customer->phone ?? 'Not provided' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Location:</strong></td>
                        <td>{{ $customer->location ?? 'Not provided' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Member Since:</strong></td>
                        <td>{{ $customer->created_at->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Last Order:</strong></td>
                        <td>
                            @if($customerStats['last_order'])
                                {{ $customerStats['last_order']->diffForHumans() }}
                            @else
                                No orders yet
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            @if($customer->orders->where('created_at', '>=', now()->subMonth())->count() > 0)
                                <span class="badge bg-success">Active Customer</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="orders-card">
                <h5 class="mb-3">Quick Stats</h5>
                <div class="row text-center">
                    <div class="col-4">
                        <div class="stat-value text-success">{{ number_format($customerStats['approved_orders']) }}</div>
                        <div class="stat-label">Approved</div>
                    </div>
                    <div class="col-4">
                        <div class="stat-value text-warning">{{ number_format($customerStats['pending_orders']) }}</div>
                        <div class="stat-label">Pending</div>
                    </div>
                    <div class="col-4">
                        <div class="stat-value text-danger">{{ number_format($customerStats['rejected_orders']) }}</div>
                        <div class="stat-label">Rejected</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order History -->
    <div class="orders-card">
        <h5 class="mb-3">Order History</h5>
        
        @if($customer->orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customer->orders as $order)
                        <tr>
                            <td>
                                <span class="metric-value">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td>
                                {{ $order->product->name ?? 'Product Deleted' }}
                            </td>
                            <td>
                                <span class="metric-value">{{ number_format($order->quantity) }}</span>
                            </td>
                            <td>
                                <span class="metric-value">UGX {{ number_format($order->total_amount ?? 0) }}</span>
                            </td>
                            <td>
                                @switch($order->status)
                                    @case('approved')
                                        <span class="badge bg-success">Approved</span>
                                        @break
                                    @case('pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @break
                                    @case('rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                @endswitch
                            </td>
                            <td>
                                {{ $order->created_at->format('M d, Y') }}
                                <small class="text-muted d-block">{{ $order->created_at->diffForHumans() }}</small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-bag display-1 text-muted"></i>
                <h5 class="mt-3 text-muted">No Orders Yet</h5>
                <p class="text-muted">This customer hasn't placed any orders yet.</p>
            </div>
        @endif
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

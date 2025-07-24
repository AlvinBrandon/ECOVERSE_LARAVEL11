@extends('layouts.admin-full')

@push('styles')
<style>
    .dashboard-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    
    .stat-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }
</style>
@endpush

@section('content')
<div class="dashboard-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="fw-bold text-primary mb-0"><i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard</h1>
        <form action="{{ route('logout') }}" method="POST" class="mb-0">
            @csrf
            <button type="submit" class="btn btn-danger"><i class="fas fa-sign-out-alt me-1"></i> Sign Out</button>
        </form>
    </div>
</div>
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card shadow border-0 bg-gradient-info text-white h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-users fa-2x mb-2"></i>
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text display-5 fw-bold">{{ $totalUsers ?? '--' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card shadow border-0 bg-gradient-success text-white h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-boxes fa-2x mb-2"></i>
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text display-5 fw-bold">{{ $totalProducts ?? '--' }}</p>
                </div>
            </div> 
        </div>
        <div class="col-md-3">
            <div class="card stat-card shadow border-0 bg-gradient-warning text-dark h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-store fa-2x mb-2"></i>
                    <h5 class="card-title">Total Vendors</h5>
                    <p class="card-text display-5 fw-bold">{{ $totalVendors ?? '--' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card shadow border-0 bg-gradient-primary text-white h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                    <h5 class="card-title">Total Orders</h5>
                    <p class="card-text display-5 fw-bold">{{ $totalOrders ?? '--' }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card stat-card shadow border-0 bg-gradient-secondary text-white h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-dollar-sign fa-2x mb-2"></i>
                    <h5 class="card-title">Total Revenue</h5>
                    <p class="card-text display-5 fw-bold">UGX {{ number_format($totalRevenue ?? 0, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card stat-card shadow border-0 h-100">
                <div class="card-header bg-light fw-bold">
                    <i class="fas fa-chart-line me-2 text-primary"></i>User Registrations (Last 7 Days)
                </div>
                <div class="card-body">
                    <canvas id="userRegistrationsChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card stat-card shadow border-0 h-100">
                <div class="card-header bg-light fw-bold">
                    <i class="fas fa-chart-bar me-2 text-danger"></i>Revenue Trend (Last 7 Days)
                </div>
                <div class="card-body">
                    <canvas id="revenueTrendChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card stat-card shadow border-0 h-100">
                <div class="card-header bg-light fw-bold">
                    <i class="fas fa-receipt me-2 text-success"></i>Recent Orders
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>User</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                    <tr>
                                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                                        <td>{{ $order->product->name ?? 'N/A' }}</td>
                                        <td>{{ $order->quantity }}</td>
                                        <td>UGX {{ number_format($order->total_price, 2) }}</td>
                                        <td><span class="badge bg-{{ $order->status === 'approved' ? 'success' : ($order->status === 'pending' ? 'warning text-dark' : 'secondary') }}">{{ ucfirst($order->status) }}</span></td>
                                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No recent orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card stat-card shadow border-0 h-100">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <h4 class="card-title fw-bold mb-2">Welcome, Admin!</h4>
                    <p class="card-text mb-0">Use the navigation to manage users, products, vendors, and more. All analytics and management tools are at your fingertips.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card shadow border-0 bg-gradient-info text-white h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-clock fa-2x mb-2"></i>
                    <h5 class="card-title">System Status</h5>
                    <p class="card-text display-6 fw-bold">Active</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-2 mb-3">
            <div class="card stat-card h-100 text-center shadow border-0">
                <div class="card-body p-3">
                    <h6 class="card-title">View Products</h6>
                    <p class="card-text small">Browse and shop available products.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">View Products</a>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card stat-card h-100 text-center shadow border-0">
                <div class="card-body p-3">
                    <h6 class="card-title">My Orders</h6>
                    <p class="card-text small">View and manage your orders.</p>
                    <a href="#" class="btn btn-primary btn-sm disabled">Orders (Coming Soon)</a>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card stat-card h-100 text-center shadow border-0">
                <div class="card-body p-3">
                    <h6 class="card-title">Product Reviews</h6>
                    <p class="card-text small">Review products you've purchased.</p>
                    <a href="#" class="btn btn-primary btn-sm disabled">Reviews (Coming Soon)</a>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card stat-card h-100 text-center shadow border-0">
                <div class="card-body p-3">
                    <h6 class="card-title">Chat Support</h6>
                    <p class="card-text small">Access the chat function for support or questions.</p>
                    <a href="{{ route('chat.index') }}" class="btn btn-primary btn-sm">Go to Chat</a>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card stat-card h-100 text-center shadow border-0">
                <div class="card-body p-3">
                    <h6 class="card-title">Become a Vendor</h6>
                    <p class="card-text small">Apply to become a vendor and sell your products.</p>
                    <a href="{{ route('vendor.apply') }}" class="btn btn-success btn-sm">Apply Now</a>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card stat-card h-100 text-center shadow border-0">
                <div class="card-body p-3">
                    <h6 class="card-title">Manage User Roles</h6>
                    <p class="card-text small">Assign roles to users (admin, vendor, customer).</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-info btn-sm">Manage Roles</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-12">
            <div class="card stat-card h-100 text-center shadow border-0">
                <div class="card-body p-3">
                    <h6 class="card-title">View Vendors</h6>
                    <p class="card-text small">See aspiring and approved vendors.</p>
                    <a href="{{ route('admin.vendors') }}" class="btn btn-outline-primary btn-sm">View Vendors</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('userRegistrationsChart').getContext('2d');
    const userRegistrationsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($userRegistrationLabels ?? []),
            datasets: [{
                label: 'Registrations',
                data: @json($userRegistrationCounts ?? []),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctxRevenue = document.getElementById('revenueTrendChart').getContext('2d');
    const revenueTrendChart = new Chart(ctxRevenue, {
        type: 'bar',
        data: {
            labels: @json($revenueTrendLabels ?? []),
            datasets: [{
                label: 'Revenue',
                data: @json($revenueTrendData ?? []),
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
@extends('layouts.admin-full')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
@import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&display=swap');

body, .main-content, .container-fluid, .container {
    background-color: #f8fafc !important;
    font-family: 'Poppins', sans-serif;
}

.cm-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.cm-header h2 {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 2.5rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    margin-bottom: 0;
}

.cm-header p {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    opacity: 0.9;
    font-size: 1.1rem !important;
    margin-bottom: 0;
}

.cm-icon {
    font-size: 3rem;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
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
    margin-bottom: 1rem;
}

.stat-card .stat-value {
    font-size: 2rem;
    font-weight: 700;
    font-family: 'JetBrains Mono', monospace;
    margin-bottom: 0.5rem;
}

.stat-card .stat-label {
    color: #6b7280;
    font-size: 0.9rem;
    font-weight: 500;
}

.customers-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
    margin-bottom: 2rem;
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

.customer-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: white;
    margin-right: 0.75rem;
}

.customer-info {
    display: flex;
    align-items: center;
}

.customer-name {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.customer-email {
    color: #6b7280;
    font-size: 0.85rem;
}

.metric-value {
    font-family: 'JetBrains Mono', monospace;
    font-weight: 600;
}

.eco-points {
    color: #059669;
    font-weight: 600;
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

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
    color: white;
}

.search-bar {
    margin-bottom: 1.5rem;
}

.search-bar input {
    font-family: 'Poppins', sans-serif;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.search-bar input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
}

.pagination {
    justify-content: center;
    margin-top: 2rem;
}

.pagination .page-link {
    font-family: 'Poppins', sans-serif;
    border: none;
    padding: 0.75rem 1rem;
    margin: 0 0.25rem;
    border-radius: 8px;
    color: #6b7280;
    font-weight: 500;
}

.pagination .page-link:hover {
    background: #f3f4f6;
    color: #374151;
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}
</style>

<div class="container py-4">
    <!-- Header -->
    <div class="cm-header">
        <i class="bi bi-people cm-icon"></i>
        <div>
            <h2 class="mb-0">Customer Management</h2>
            <p class="mb-0">Retailer Dashboard - Manage your customer relationships and track purchase history</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white;">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-value" style="color: #3b82f6;">{{ number_format($stats['total_customers']) }}</div>
            <div class="stat-label">Total Customers</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669); color: white;">
                <i class="bi bi-person-check"></i>
            </div>
            <div class="stat-value" style="color: #10b981;">{{ number_format($stats['active_customers']) }}</div>
            <div class="stat-label">Active This Month</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white;">
                <i class="bi bi-bag-check"></i>
            </div>
            <div class="stat-value" style="color: #f59e0b;">{{ number_format($stats['total_orders']) }}</div>
            <div class="stat-label">Total Orders</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white;">
                <i class="bi bi-currency-exchange"></i>
            </div>
            <div class="stat-value" style="color: #8b5cf6;">UGX {{ number_format($stats['total_revenue']) }}</div>
            <div class="stat-label">Total Revenue</div>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="customers-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Customer Directory</h4>
            <a href="{{ route('customers.analytics') }}" class="btn btn-primary">
                <i class="bi bi-graph-up me-2"></i>View Analytics
            </a>
        </div>

        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" id="customerSearch" class="form-control" placeholder="Search customers by name or email...">
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Eco Points</th>
                        <th>Total Orders</th>
                        <th>Total Spent</th>
                        <th>Last Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="customersTableBody">
                    @forelse($customers as $customer)
                    <tr data-customer-name="{{ strtolower($customer->name) }}" data-customer-email="{{ strtolower($customer->email) }}">
                        <td>
                            <div class="customer-info">
                                <div class="customer-avatar" style="background: linear-gradient(135deg, #{{ substr(md5($customer->name), 0, 6) }}, #{{ substr(md5($customer->email), 0, 6) }});">
                                    {{ strtoupper(substr($customer->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="customer-name">{{ $customer->name }}</div>
                                    <div class="customer-email">{{ $customer->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="eco-points">{{ number_format($customer->eco_points ?? 0) }} points</span>
                        </td>
                        <td>
                            <span class="metric-value">{{ number_format($customer->orders_count) }}</span>
                        </td>
                        <td>
                            <span class="metric-value">UGX {{ number_format($customer->total_spent ?? 0) }}</span>
                        </td>
                        <td>
                            @if($customer->orders->first())
                                {{ $customer->orders->first()->created_at->diffForHumans() }}
                            @else
                                <span class="text-muted">No orders</span>
                            @endif
                        </td>
                        <td>
                            @if($customer->orders->where('created_at', '>=', now()->subMonth())->count() > 0)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="bi bi-people display-1 text-muted"></i>
                            <h5 class="mt-3 text-muted">No customers found</h5>
                            <p class="text-muted">Customers will appear here once they register and place orders.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($customers->hasPages())
            <div class="d-flex justify-content-center">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
</div>

<script>
// Customer search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('customerSearch');
    const tableBody = document.getElementById('customersTableBody');
    const rows = tableBody.querySelectorAll('tr[data-customer-name]');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        rows.forEach(row => {
            const name = row.getAttribute('data-customer-name');
            const email = row.getAttribute('data-customer-email');
            
            if (name.includes(searchTerm) || email.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

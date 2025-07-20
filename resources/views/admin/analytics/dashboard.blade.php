@extends('layouts.app')

@section('title', 'Sales Analytics & Reports')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="analytics-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-2"><i class="bi bi-graph-up-arrow me-2"></i>Sales Analytics & Reports</h2>
                        <p class="text-muted mb-0">Comprehensive business transaction statistics and insights</p>
                    </div>
                    <div class="d-flex gap-2">
                        <!-- Date Range Filter -->
                        <select class="form-select" id="dateRangeFilter" onchange="filterByRange()">
                            <option value="7" {{ $dateRange == '7' ? 'selected' : '' }}>Last 7 Days</option>
                            <option value="30" {{ $dateRange == '30' ? 'selected' : '' }}>Last 30 Days</option>
                            <option value="60" {{ $dateRange == '60' ? 'selected' : '' }}>Last 60 Days</option>
                            <option value="90" {{ $dateRange == '90' ? 'selected' : '' }}>Last 90 Days</option>
                            <option value="365" {{ $dateRange == '365' ? 'selected' : '' }}>Last Year</option>
                        </select>
                        <a href="{{ route('admin.analytics.export', ['range' => $dateRange]) }}" class="btn btn-success">
                            <i class="bi bi-download me-2"></i>Export CSV
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card kpi-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="kpi-icon bg-success bg-gradient">
                            <i class="bi bi-currency-exchange"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="kpi-label">Total Revenue</h6>
                            <h4 class="kpi-value">UGX {{ number_format($totalSales, 2) }}</h4>
                            @if($salesGrowth != 0)
                                <small class="growth-indicator {{ $salesGrowth > 0 ? 'text-success' : 'text-danger' }}">
                                    <i class="bi bi-{{ $salesGrowth > 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                                    {{ abs(round($salesGrowth, 1)) }}% vs previous period
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card kpi-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="kpi-icon bg-primary bg-gradient">
                            <i class="bi bi-cart-check"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="kpi-label">Total Orders</h6>
                            <h4 class="kpi-value">{{ number_format($totalOrders) }}</h4>
                            @if($ordersGrowth != 0)
                                <small class="growth-indicator {{ $ordersGrowth > 0 ? 'text-success' : 'text-danger' }}">
                                    <i class="bi bi-{{ $ordersGrowth > 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                                    {{ abs(round($ordersGrowth, 1)) }}% vs previous period
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card kpi-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="kpi-icon bg-info bg-gradient">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="kpi-label">Avg Order Value</h6>
                            <h4 class="kpi-value">UGX {{ number_format($avgOrderValue->avg_value ?? 0, 2) }}</h4>
                            <small class="text-muted">Per transaction</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card kpi-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="kpi-icon bg-warning bg-gradient">
                            <i class="bi bi-percent"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="kpi-label">Approval Rate</h6>
                            <h4 class="kpi-value">{{ $totalOrders > 0 ? round(($approvedOrders / $totalOrders) * 100, 1) : 0 }}%</h4>
                            <small class="text-muted">{{ $approvedOrders }}/{{ $totalOrders }} orders</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Daily Sales Trend -->
        <div class="col-xl-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Daily Sales Trend</h5>
                </div>
                <div class="card-body">
                    <canvas id="dailySalesChart" height="100"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Order Status Distribution -->
        <div class="col-xl-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="bi bi-pie-chart me-2"></i>Order Status</h5>
                </div>
                <div class="card-body">
                    <canvas id="orderStatusChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Analysis -->
    <div class="row mb-4">
        <!-- Revenue by User Type -->
        <div class="col-xl-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>Revenue by User Type</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueByUserChart" height="150"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Revenue by Role -->
        <div class="col-xl-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Revenue by Role</h5>
                </div>
                <div class="card-body">
                    <div class="role-revenue-list">
                        @foreach($revenueByRole as $role)
                            <div class="role-item d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="mb-1">{{ ucfirst($role->role) }}</h6>
                                    <small class="text-muted">{{ $role->order_count }} orders</small>
                                </div>
                                <div class="text-end">
                                    <div class="revenue-amount">UGX {{ number_format($role->total_revenue, 2) }}</div>
                                    <small class="text-muted">{{ round(($role->total_revenue / $totalSales) * 100, 1) }}%</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Products Table -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="bi bi-trophy me-2"></i>Top Performing Products</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Rank</th>
                                    <th>Product</th>
                                    <th>Unit Price</th>
                                    <th>Quantity Sold</th>
                                    <th>Orders</th>
                                    <th>Total Revenue</th>
                                    <th>Market Share</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topProducts as $index => $product)
                                    <tr>
                                        <td>
                                            <span class="rank-badge rank-{{ $index + 1 }}">{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $product->name }}</strong>
                                        </td>
                                        <td>UGX {{ number_format($product->price, 2) }}</td>
                                        <td>{{ number_format($product->total_quantity) }}</td>
                                        <td>{{ $product->order_count }}</td>
                                        <td>
                                            <strong class="text-success">UGX {{ number_format($product->total_revenue, 2) }}</strong>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-primary" style="width: {{ round(($product->total_revenue / $totalSales) * 100, 1) }}%"></div>
                                            </div>
                                            <small class="text-muted">{{ round(($product->total_revenue / $totalSales) * 100, 1) }}%</small>
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

    <!-- Inventory Alerts -->
    @if($inventoryAlert->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm border-warning">
                <div class="card-header bg-warning bg-gradient text-dark">
                    <h5 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Inventory Restock Alerts</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Products with high sales but low stock levels that may need restocking:</p>
                    <div class="row">
                        @foreach($inventoryAlert as $alert)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="alert alert-warning d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $alert['product'] }}</strong><br>
                                        <small>Stock: {{ $alert['stock'] }} | Sales: {{ $alert['sales'] }}</small>
                                    </div>
                                    <i class="bi bi-exclamation-circle fs-4"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Date Range Filter
function filterByRange() {
    const range = document.getElementById('dateRangeFilter').value;
    window.location.href = `{{ route('admin.analytics') }}?range=${range}`;
}

// Daily Sales Chart
const dailySalesCtx = document.getElementById('dailySalesChart').getContext('2d');
const dailySalesChart = new Chart(dailySalesCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($dailySales->pluck('date')->map(function($date) { return \Carbon\Carbon::parse($date)->format('M d'); })) !!},
        datasets: [{
            label: 'Daily Revenue (UGX)',
            data: {!! json_encode($dailySales->pluck('daily_revenue')) !!},
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.1)',
            tension: 0.3,
            fill: true
        }, {
            label: 'Daily Orders',
            data: {!! json_encode($dailySales->pluck('daily_orders')) !!},
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgba(255, 99, 132, 0.1)',
            tension: 0.3,
            yAxisID: 'y1'
        }]
    },
    options: {
        responsive: true,
        interaction: {
            mode: 'index',
            intersect: false,
        },
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left',
                title: {
                    display: true,
                    text: 'Revenue (UGX)'
                }
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                title: {
                    display: true,
                    text: 'Number of Orders'
                },
                grid: {
                    drawOnChartArea: false,
                },
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        if (context.datasetIndex === 0) {
                            return `Revenue: UGX ${context.parsed.y.toLocaleString()}`;
                        } else {
                            return `Orders: ${context.parsed.y}`;
                        }
                    }
                }
            }
        }
    }
});

// Order Status Chart
const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
const orderStatusChart = new Chart(orderStatusCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($orderStatusStats->pluck('status')->map(function($status) { return ucfirst($status); })) !!},
        datasets: [{
            data: {!! json_encode($orderStatusStats->pluck('count')) !!},
            backgroundColor: [
                '#28a745', // approved - green
                '#ffc107', // pending - yellow
                '#dc3545', // rejected - red
                '#6c757d'  // other - gray
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Revenue by User Type Chart
const revenueByUserCtx = document.getElementById('revenueByUserChart').getContext('2d');
const revenueByUserChart = new Chart(revenueByUserCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($salesByUserType->pluck('user_type')) !!},
        datasets: [{
            label: 'Revenue (UGX)',
            data: {!! json_encode($salesByUserType->pluck('revenue')) !!},
            backgroundColor: [
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 99, 132, 0.8)',
                'rgba(255, 205, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)'
            ]
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Revenue (UGX)'
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `Revenue: UGX ${context.parsed.y.toLocaleString()}`;
                    }
                }
            }
        }
    }
});
</script>

<style>
.analytics-header {
    padding: 2rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    color: white;
    margin-bottom: 2rem;
}

.kpi-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.kpi-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.kpi-label {
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.kpi-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.25rem;
}

.growth-indicator {
    font-size: 0.75rem;
    font-weight: 600;
}

.rank-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-weight: bold;
    font-size: 0.875rem;
}

.rank-1 {
    background: linear-gradient(45deg, #FFD700, #FFA500);
    color: #8B4513;
}

.rank-2 {
    background: linear-gradient(45deg, #C0C0C0, #A9A9A9);
    color: #2F4F4F;
}

.rank-3 {
    background: linear-gradient(45deg, #CD7F32, #B8860B);
    color: white;
}

.rank-badge:not(.rank-1):not(.rank-2):not(.rank-3) {
    background: #e9ecef;
    color: #495057;
}

.role-item {
    padding: 1rem;
    border-radius: 8px;
    background: #f8f9fa;
    border: 1px solid #e9ecef;
}

.revenue-amount {
    font-weight: 700;
    color: #28a745;
    font-size: 1.1rem;
}

.table th {
    font-weight: 600;
    font-size: 0.875rem;
    color: #495057;
    border-bottom: 2px solid #dee2e6;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}

@media (max-width: 768px) {
    .analytics-header {
        padding: 1.5rem;
    }
    
    .kpi-value {
        font-size: 1.5rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>
@endsection

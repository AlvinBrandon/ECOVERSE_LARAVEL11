@extends('layouts.admin-full')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
@import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&display=swap');

body, .main-content, .container-fluid, .container {
    background-color: #f8fafc !important;
    font-family: 'Poppins', sans-serif;
}

.analytics-header {
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

.analytics-header h2 {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 2.5rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    margin-bottom: 0;
}

.analytics-header p {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    opacity: 0.9;
    font-size: 1.1rem !important;
    margin-bottom: 0;
}

.analytics-icon {
    font-size: 3rem;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
}

.chart-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
    margin-bottom: 2rem;
}

.top-customers-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
}

.customer-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.customer-item:hover {
    background: #f8fafc;
    transform: translateX(5px);
}

.customer-rank {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    margin-right: 1rem;
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
    margin-right: 1rem;
}

.customer-info {
    flex-grow: 1;
}

.customer-name {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.customer-orders {
    color: #6b7280;
    font-size: 0.85rem;
}

.customer-spent {
    font-family: 'JetBrains Mono', monospace;
    font-weight: 700;
    color: #059669;
    font-size: 1.1rem;
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
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container py-4">
    <!-- Header -->
    <div class="analytics-header">
        <i class="bi bi-graph-up analytics-icon"></i>
        <div class="flex-grow-1">
            <h2 class="mb-0">Customer Analytics</h2>
            <p class="mb-0">Insights and trends for customer management and growth strategies</p>
        </div>
        <div>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Customers
            </a>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <div class="col-md-8">
            <div class="chart-card">
                <h5 class="mb-3">Customer Growth & Revenue Trends</h5>
                <canvas id="customerTrendsChart" height="100"></canvas>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="chart-card">
                <h5 class="mb-3">Order Distribution</h5>
                <canvas id="orderDistributionChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Customers -->
    <div class="top-customers-card">
        <h5 class="mb-4">Top Customers by Spending</h5>
        
        @forelse($topCustomers as $index => $customer)
            <div class="customer-item">
                <div class="customer-rank" style="background: {{ $index == 0 ? '#fbbf24' : ($index == 1 ? '#d1d5db' : ($index == 2 ? '#cd7c2f' : '#e5e7eb')) }}; color: {{ $index < 3 ? 'white' : '#6b7280' }};">
                    {{ $index + 1 }}
                </div>
                <div class="customer-avatar" style="background: linear-gradient(135deg, #{{ substr(md5($customer->name), 0, 6) }}, #{{ substr(md5($customer->email), 0, 6) }});">
                    {{ strtoupper(substr($customer->name, 0, 2)) }}
                </div>
                <div class="customer-info">
                    <div class="customer-name">{{ $customer->name }}</div>
                    <div class="customer-orders">{{ number_format($customer->orders_count) }} orders</div>
                </div>
                <div class="customer-spent">
                    UGX {{ number_format($customer->total_spent ?? 0) }}
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="bi bi-trophy display-1 text-muted"></i>
                <h5 class="mt-3 text-muted">No Customer Data</h5>
                <p class="text-muted">Customer spending data will appear here once orders are processed.</p>
            </div>
        @endforelse
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly data from server
    const monthlyData = @json($monthlyData);
    
    // Customer Trends Chart
    const ctx1 = document.getElementById('customerTrendsChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: monthlyData.map(item => item.month),
            datasets: [{
                label: 'New Customers',
                data: monthlyData.map(item => item.new_customers),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }, {
                label: 'Total Orders',
                data: monthlyData.map(item => item.orders),
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        font: {
                            family: 'Poppins'
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: {
                            family: 'JetBrains Mono'
                        }
                    }
                },
                x: {
                    ticks: {
                        font: {
                            family: 'Poppins'
                        }
                    }
                }
            }
        }
    });

    // Order Distribution Chart
    const totalOrders = monthlyData.reduce((sum, item) => sum + item.orders, 0);
    const recentOrders = monthlyData.slice(-3).reduce((sum, item) => sum + item.orders, 0);
    const olderOrders = totalOrders - recentOrders;
    
    const ctx2 = document.getElementById('orderDistributionChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Recent 3 Months', 'Older Orders'],
            datasets: [{
                data: [recentOrders, olderOrders],
                backgroundColor: ['#3b82f6', '#e5e7eb'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            family: 'Poppins'
                        },
                        padding: 20
                    }
                }
            }
        }
    });
});
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

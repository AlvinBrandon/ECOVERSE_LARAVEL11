@extends('layouts.app')

@section('content')
<style>
  body, .main-content, .container-fluid, .container {
    background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%) !important;
  }
  .dashboard-card, .analytics-card {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    box-shadow: 0 4px 24px rgba(16, 185, 129, 0.08);
    padding: 2rem 1.5rem;
    margin-bottom: 2rem;
    transition: box-shadow 0.2s, transform 0.2s;
  }
  .dashboard-card:hover, .analytics-card:hover {
    box-shadow: 0 8px 32px rgba(99,102,241,0.18), 0 2px 8px rgba(16,185,129,0.10);
    transform: translateY(-4px) scale(1.025);
    z-index: 2;
    cursor: pointer;
  }
  .analytics-header {
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
  .analytics-icon {
    font-size: 2.5rem;
    margin-right: 1rem;
    vertical-align: middle;
  }
</style>
<div class="container py-4">
  <div class="analytics-header">
    <i class="bi bi-bar-chart analytics-icon"></i>
    <div>
      <h2 class="mb-0">Inventory Analytics</h2>
      <p class="mb-0" style="font-size:1.1rem;">Visualize inventory trends and performance.</p>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="analytics-card">
        <div class="row mb-4">
            <div class="col-12">
                <a href="{{ route('inventory.index') }}" class="btn btn-secondary mt-3">Back to Inventory</a>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-dark me-2"><i class="bi bi-house-door me-1"></i> Home</a>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Inventory Value</div>
                    <div class="card-body">
                        <h5 class="card-title">UGX {{ number_format($totalValue, 2) }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Total Products</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalProducts }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Low Stock Items</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $lowStockCount }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <canvas id="stockLevelChart" height="100"></canvas>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <canvas id="stockHistoryChart" height="100"></canvas>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Stock Level by Product
    const stockLevelCtx = document.getElementById('stockLevelChart').getContext('2d');
    const stockLevelChart = new Chart(stockLevelCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($productNames) !!},
            datasets: [{
                label: 'Stock Quantity',
                data: {!! json_encode($productQuantities) !!},
                backgroundColor: '#10b981',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Stock Levels by Product'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 5 }
                }
            }
        }
    });
    // Stock History (last 7 days)
    const stockHistoryCtx = document.getElementById('stockHistoryChart').getContext('2d');
    const stockHistoryChart = new Chart(stockHistoryCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($historyDates) !!},
            datasets: [
                {
                    label: 'Stock Added',
                    data: {!! json_encode($stockAdded) !!},
                    borderColor: '#4caf50',
                    backgroundColor: 'rgba(76,175,80,0.2)',
                    fill: true
                },
                {
                    label: 'Stock Deducted',
                    data: {!! json_encode($stockDeducted) !!},
                    borderColor: '#f44336',
                    backgroundColor: 'rgba(244,67,54,0.2)',
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Stock Movement (Last 7 Days)'
                }
            }
        }
    });
</script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

@extends('layouts.app')

@section('content')
<style>
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%) !important;
  }
  .card {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    box-shadow: 0 4px 24px rgba(16, 185, 129, 0.08);
  }
  .card-header.bg-gradient-primary {
    background: linear-gradient(90deg, #6366f1 0%, #10b981 100%) !important;
    color: #fff !important;
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
  }
  .btn-info, .btn-warning, .btn-success, .btn-danger, .btn-primary {
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.08);
  }
  .table thead.bg-light {
    background: #f0fdfa !important;
  }
</style>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="text-dark">Inventory Analytics Dashboard</h4>
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

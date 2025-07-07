@extends('layouts.app')

@section('content')
<style>
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%) !important;
  }
  .card {
    background: rgba(255,255,255,0.97);
    border-radius: 1.25rem;
    box-shadow: 0 6px 32px rgba(16, 185, 129, 0.10);
    margin-bottom: 2rem;
  }
  .card-header.bg-gradient-primary {
    background: linear-gradient(90deg, #6366f1 0%, #10b981 100%) !important;
    color: #fff !important;
    border-top-left-radius: 1.25rem;
    border-top-right-radius: 1.25rem;
  }
</style>
<div class="container-fluid py-4">
  <div class="row mb-4">
    <div class="col-12 d-flex align-items-center justify-content-between">
      <h4 class="text-dark fw-bold mb-0"><i class="bi bi-bar-chart me-2"></i>Sales Analytics</h4>
      <a href="{{ route('sales.index') }}" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i>Back to Sales</a>
    </div>
  </div>
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card text-white bg-success mb-3">
        <div class="card-header">Total Sales</div>
        <div class="card-body">
          <h5 class="card-title">UGX {{ number_format($totalSales, 2) }}</h5>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-white bg-primary mb-3">
        <div class="card-header">Total Orders</div>
        <div class="card-body">
          <h5 class="card-title">{{ $totalOrders }}</h5>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-white bg-info mb-3">
        <div class="card-header">Top Product</div>
        <div class="card-body">
          <h5 class="card-title">{{ $topProduct }}</h5>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-4">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <canvas id="salesChart" height="100"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('salesChart').getContext('2d');
  const gradient = ctx.createLinearGradient(0, 0, 0, 400);
  gradient.addColorStop(0, '#10b981');
  gradient.addColorStop(1, '#6366f1');
  const salesChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: {!! json_encode($dates) !!},
      datasets: [{
        label: 'Sales (UGX)',
        data: {!! json_encode($salesData) !!},
        fill: true,
        backgroundColor: 'rgba(16,185,129,0.08)',
        borderColor: gradient,
        borderWidth: 3,
        pointBackgroundColor: '#10b981',
        tension: 0.4
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        title: {
          display: true,
          text: 'Sales Trend (Last 30 Days)',
          color: '#374151',
          font: { size: 20, weight: 'bold', family: 'inherit' }
        },
        tooltip: {
          backgroundColor: '#6366f1',
          titleColor: '#fff',
          bodyColor: '#fff',
          borderColor: '#10b981',
          borderWidth: 1,
          padding: 12,
          cornerRadius: 8
        }
      },
      scales: {
        x: {
          grid: { display: false },
          ticks: { color: '#6366f1', font: { weight: 'bold' } }
        },
        y: {
          beginAtZero: true,
          grid: { color: '#e0e7ff' },
          ticks: {
            color: '#10b981',
            font: { weight: 'bold' }
          }
        }
      },
      animation: {
        duration: 1200,
        easing: 'easeOutBounce'
      }
    }
  });
</script>
@endsection

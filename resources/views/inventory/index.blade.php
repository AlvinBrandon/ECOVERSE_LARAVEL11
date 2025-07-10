<!-- =============================== -->
<!-- 1. Inventory Index (inventory/index.blade.php) -->
<!-- =============================== -->
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
    <div class="col-12 d-flex align-items-center justify-content-between">
      <h4 class="text-dark fw-bold mb-0"><i class="bi bi-box-seam me-2"></i>Inventory Dashboard</h4>
      <div>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-dark me-2"><i class="bi bi-house-door me-1"></i> Home</a>
        <a href="{{ route('inventory.create') }}" class="btn btn-success me-2"><i class="bi bi-plus-circle me-1"></i> Add Stock</a>
        <a href="{{ route('inventory.deductForm') }}" class="btn btn-danger me-2"><i class="bi bi-dash-circle me-1"></i> Deduct Stock</a>
        <a href="{{ route('inventory.history') }}" class="btn btn-outline-secondary me-2"><i class="bi bi-clock-history me-1"></i> Stock History</a>
        <a href="{{ route('inventory.export.csv') }}" class="btn btn-outline-primary me-2"><i class="bi bi-download me-1"></i> Export CSV</a>
        <a href="{{ route('stock_transfer.create') }}" class="btn btn-warning me-2"><i class="bi bi-arrow-left-right me-1"></i> Transfer Stock</a>
        <a href="{{ route('inventory.analytics') }}" class="btn btn-info"><i class="bi bi-bar-chart me-1"></i> Analytics</a>
      </div>
    </div>
  </div>

  <div class="row mb-2">
    <div class="col-12">
      <div class="alert alert-info shadow-sm">
        <strong><i class="bi bi-cash-coin me-1"></i>Total Inventory Value:</strong> UGX {{ number_format($totalValue, 2) }}
      </div>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-12">
      <h5 class="text-dark fw-bold mb-3"><i class="bi bi-cube me-2"></i>Products in Stock</h5>
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-gradient-primary text-white pb-2 d-flex align-items-center">
          <i class="bi bi-archive me-2"></i>
          <h6 class="mb-0">Product Inventory</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0 table-hover">
              <thead class="bg-light">
                <tr>
                  <th>Product</th>
                  <th>Available Quantity</th>
                  <th>Last Updated</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($productInventory as $item)
                <tr @if($item['quantity'] <= 10) style="background-color: #fff3cd;" @endif>
                  <td class="fw-semibold">
                    <i class="bi bi-cube me-1"></i>
                    <a href="{{ route('inventory.product.batches', $item['product_id']) }}">
                      {{ $item['product']->name }}
                    </a>
                  </td>
                  <td>
                    <span class="badge bg-{{ $item['quantity'] <= 10 ? 'danger' : 'success' }}">{{ $item['quantity'] }} <span class="unit-label">pcs</span></span>
                    @if ($item['quantity'] <= 10)
                      <span class="text-danger fw-bold ms-2">(Low)</span>
                    @endif
                  </td>
                  <td>{{ $item['updated_at'] ? \Carbon\Carbon::parse($item['updated_at'])->format('Y-m-d H:i') : '-' }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="mb-5">
        <canvas id="productInventoryChart" height="100"></canvas>
      </div>
      <h5 class="text-dark fw-bold mb-3 mt-5"><i class="bi bi-droplet-half me-2"></i>Raw Materials in Stock</h5>
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-gradient-primary text-white pb-2 d-flex align-items-center">
          <i class="bi bi-archive me-2"></i>
          <h6 class="mb-0">Raw Material Inventory</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0 table-hover">
              <thead class="bg-light">
                <tr>
                  <th>Raw Material</th>
                  <th>Available Quantity</th>
                  <th>Last Updated</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($rawMaterialInventory as $item)
                <tr @if($item->quantity <= 10) style="background-color: #fff3cd;" @endif>
                  <td class="fw-semibold">
                    <i class="bi bi-droplet-half me-1"></i> {{ $item->rawMaterial->name }} <span class="text-muted">({{ $item->rawMaterial->type }})</span>
                  </td>
                  <td>
                    <span class="badge bg-{{ $item->quantity <= 10 ? 'danger' : 'success' }}">{{ $item->quantity }}</span>
                    @if ($item->quantity <= 10)
                      <span class="text-danger fw-bold ms-2">(Low)</span>
                    @endif
                  </td>
                  <td>{{ $item->updated_at->format('Y-m-d H:i') }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="mb-5">
        <canvas id="rawMaterialInventoryChart" height="100"></canvas>
      </div>
    </div>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Product Inventory Chart
  const productCtx = document.getElementById('productInventoryChart').getContext('2d');
  const productGradient = productCtx.createLinearGradient(0, 0, 0, 400);
  productGradient.addColorStop(0, '#10b981');
  productGradient.addColorStop(1, '#6366f1');
  new Chart(productCtx, {
    type: 'bar',
    data: {
      labels: [
        @foreach ($productInventory as $item)
          '{{ $item['product']->name }}',
        @endforeach
      ],
      datasets: [{
        label: 'Stock Quantity',
        data: [
          @foreach ($productInventory as $item)
            {{ $item['quantity'] }},
          @endforeach
        ],
        backgroundColor: productGradient,
        borderRadius: 12,
        borderSkipped: false,
        hoverBackgroundColor: '#f59e42',
        barPercentage: 0.7,
        categoryPercentage: 0.6,
        borderWidth: 0
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        title: {
          display: true,
          text: 'Inventory Stock Levels by Product',
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
            stepSize: 5,
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

  // Raw Material Inventory Chart
  const rawMaterialCtx = document.getElementById('rawMaterialInventoryChart').getContext('2d');
  const rawMaterialGradient = rawMaterialCtx.createLinearGradient(0, 0, 0, 400);
  rawMaterialGradient.addColorStop(0, '#6366f1');
  rawMaterialGradient.addColorStop(1, '#10b981');
  new Chart(rawMaterialCtx, {
    type: 'bar',
    data: {
      labels: [
        @foreach ($rawMaterialInventory as $item)
          '{{ $item->rawMaterial->name }}',
        @endforeach
      ],
      datasets: [{
        label: 'Stock Quantity',
        data: [
          @foreach ($rawMaterialInventory as $item)
            {{ $item->quantity }},
          @endforeach
        ],
        backgroundColor: rawMaterialGradient,
        borderRadius: 12,
        borderSkipped: false,
        hoverBackgroundColor: '#f59e42',
        barPercentage: 0.7,
        categoryPercentage: 0.6,
        borderWidth: 0
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        title: {
          display: true,
          text: 'Inventory Stock Levels by Raw Material',
          color: '#374151',
          font: { size: 20, weight: 'bold', family: 'inherit' }
        },
        tooltip: {
          backgroundColor: '#10b981',
          titleColor: '#fff',
          bodyColor: '#fff',
          borderColor: '#6366f1',
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
            stepSize: 5,
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



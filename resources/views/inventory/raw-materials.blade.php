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
      <h4 class="text-dark fw-bold mb-0"><i class="bi bi-droplet-half me-2"></i>Raw Material Inventory</h4>
      <div>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-dark me-2"><i class="bi bi-house-door me-1"></i> Home</a>
        <a href="{{ route('inventory.create') }}" class="btn btn-success me-2"><i class="bi bi-plus-circle me-1"></i> Add Stock</a>
        <a href="{{ route('inventory.history') }}" class="btn btn-outline-secondary me-2"><i class="bi bi-clock-history me-1"></i> Stock History</a>
        <a href="{{ route('inventory.index') }}" class="btn btn-outline-primary me-2"><i class="bi bi-box-seam me-1"></i> Product Inventory</a>
      </div>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col-12">
      <div class="alert alert-info shadow-sm">
        <strong><i class="bi bi-droplet-half me-1"></i>Raw Material Inventory Overview:</strong> All available raw materials and their current stock levels.
      </div>
    </div>
  </div>
  <div class="row mb-4">
    <div class="col-12">
      <h5 class="text-dark fw-bold mb-3"><i class="bi bi-droplet-half me-2"></i>Materials in Stock</h5>
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-gradient-primary text-white pb-2 d-flex align-items-center">
          <i class="bi bi-droplet-half me-2"></i>
          <h6 class="mb-0">Raw Material Inventory</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0 table-hover">
              <thead class="bg-light">
                <tr>
                  <th>Raw Material</th>
                  <th>Available Quantity</th>
                  <th>Unit</th>
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
                  <td>{{ $item->rawMaterial->unit }}</td>
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

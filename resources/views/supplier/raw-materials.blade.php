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
      <h4 class="text-dark fw-bold mb-0"><i class="bi bi-droplet-half me-2"></i>Raw Material Management</h4>
      <div>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-dark me-2"><i class="bi bi-house-door me-1"></i> Home</a>
        <a href="{{ route('raw-materials.create') }}" class="btn btn-success me-2"><i class="bi bi-plus-circle me-1"></i> Add Raw Material</a>
        <a href="{{ route('raw-materials.index') }}" class="btn btn-outline-primary me-2"><i class="bi bi-list-ul me-1"></i> All Raw Materials</a>
      </div>
    </div>
  </div>
  <!-- Analytics Row -->
  <div class="row mb-4">
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-header bg-gradient-primary">Total Raw Materials</div>
        <div class="card-body">
          <h3 class="fw-bold mb-0">{{ $totalCount }}</h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-header bg-gradient-primary">Total Quantity</div>
        <div class="card-body">
          <h3 class="fw-bold mb-0">{{ $totalQuantity }}</h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-header bg-gradient-primary">Low Stock Items</div>
        <div class="card-body">
          <h3 class="fw-bold mb-0 text-danger">{{ $lowStockCount }}</h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-header bg-gradient-primary">Types</div>
        <div class="card-body">
          <h3 class="fw-bold mb-0">{{ $typeCount }}</h3>
        </div>
      </div>
    </div>
  </div>
  <!-- Raw Material Chart -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-gradient-primary">Raw Material Quantities</div>
        <div class="card-body">
          <canvas id="rawMaterialChart" height="80"></canvas>
        </div>
      </div>
    </div>
  </div>
  <!-- Raw Materials Table -->
  <div class="row mb-2">
    <div class="col-12">
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-gradient-primary d-flex align-items-center justify-content-between">
          <span>Raw Materials List</span>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead class="bg-light">
                <tr>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Unit</th>
                  <th>Quantity</th>
                  <th>Reorder Level</th>
                  <th>Description</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($rawMaterials as $material)
                <tr>
                  <td>{{ $material->name }}</td>
                  <td>{{ $material->type }}</td>
                  <td>{{ $material->unit }}</td>
                  <td>{{ $material->quantity }}</td>
                  <td>{{ $material->reorder_level }}</td>
                  <td>{{ $material->description }}</td>
                  <td>
                    <a href="{{ route('raw-materials.edit', $material->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('raw-materials.destroy', $material->id) }}" method="POST" style="display:inline-block;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      {{ $rawMaterials->links() }}
    </div>
  </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('rawMaterialChart').getContext('2d');
  const labels = [
    @foreach ($rawMaterials as $material)
      '{{ $material->name }}',
    @endforeach
  ];
  const data = [
    @foreach ($rawMaterials as $material)
      {{ $material->quantity }},
    @endforeach
  ];
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Quantity',
        data: data,
        backgroundColor: 'rgba(16, 185, 129, 0.5)',
        borderColor: '#10b981',
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        title: { display: false }
      },
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
</script>
@endsection

@extends('layouts.app')

@section('content')
<style>
  /* Global Poppins Font Implementation */
  * {
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
  }

  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%) !important;
    font-family: 'Poppins', sans-serif !important;
    min-height: 10vh;
    margin: 0 !important;
    padding: 0 !important;
  }

  .main-content {
    padding-top: 0 !important;
    margin-top: 0 !important;
  }

  /* Override any layout padding/margin */
  .app-content, .content, #app, main {
    padding-top: 0 !important;
    margin-top: 0 !important;
  }

  /* Specifically target the main element from layout */
  main.py-4 {
    padding-top: 0 !important;
    padding-bottom: 1rem !important;
  }

  /* Remove Bootstrap container default margins */
  .container, .container-fluid, .container-sm, .container-md, .container-lg, .container-xl {
    margin-top: 0 !important;
    padding-top: 0 !important;
  }

  .page-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
    color: white;
    padding: 2rem 1.5rem;
    border-radius: 1rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(30, 41, 59, 0.2);
    border: 1px solid rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .page-header h2 {
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
  }

  .page-header p {
    opacity: 0.9;
    font-size: 1.1rem;
    margin-bottom: 0;
    font-weight: 400;
  }

  .page-header i {
    font-size: 2.5rem;
    margin-right: 1rem;
    opacity: 0.9;
  }

  .header-actions {
    display: flex;
    gap: 0.75rem;
    align-items: center;
  }

  .content-section {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.12);
    border: 1px solid rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    margin-bottom: 2rem;
  }

  /* Stats Cards */
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
  }

  .stat-card {
    background: rgba(255,255,255,0.9);
    border-radius: 1rem;
    padding: 1.5rem;
    text-align: center;
    border: 1px solid rgba(226, 232, 240, 0.6);
    transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(16, 185, 129, 0.08);
    backdrop-filter: blur(5px);
  }

  .stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(99, 102, 241, 0.15);
  }

  .stat-card .stat-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    color: #1f2937;
    font-weight: 600;
    font-size: 0.9rem;
    padding: 0.75rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
  }

  .stat-card .stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
  }

  .stat-card .stat-value.text-danger {
    color: #dc2626 !important;
  }

  /* Chart Container */
  .chart-container {
    background: rgba(255,255,255,0.9);
    border-radius: 1rem;
    border: 1px solid rgba(226, 232, 240, 0.6);
    overflow: hidden;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(16, 185, 129, 0.08);
    backdrop-filter: blur(5px);
  }

  .chart-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    color: #1f2937;
    font-weight: 600;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid rgba(226, 232, 240, 0.4);
  }

  .chart-body {
    padding: 1.5rem;
  }

  /* Table Container */
  .table-container {
    background: rgba(255,255,255,0.9);
    border-radius: 1rem;
    border: 1px solid rgba(226, 232, 240, 0.6);
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(16, 185, 129, 0.08);
    backdrop-filter: blur(5px);
  }

  .table-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    color: #1f2937;
    font-weight: 600;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid rgba(226, 232, 240, 0.4);
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .table {
    margin-bottom: 0;
    font-family: 'Poppins', sans-serif !important;
    width: 100%;
    border-collapse: collapse;
  }

  .table thead th {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    color: #1f2937;
    font-weight: 600;
    font-size: 0.9rem;
    padding: 1rem 0.75rem;
    border: none;
    position: sticky;
    top: 0;
    z-index: 10;
  }

  .table tbody td {
    padding: 1rem 0.75rem;
    border-bottom: 1px solid rgba(226, 232, 240, 0.4);
    vertical-align: middle;
    font-size: 0.9rem;
  }

  .table tbody tr:hover {
    background: rgba(99, 102, 241, 0.02);
  }

  .table tbody tr:last-child td {
    border-bottom: none;
  }

  .table tbody tr:nth-child(even) {
    background: rgba(248, 250, 252, 0.5);
  }

  /* Button Styling */
  .btn {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 500;
    border-radius: 0.5rem;
    padding: 0.5rem 1rem;
    border: none;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    cursor: pointer;
    gap: 0.375rem;
    font-size: 0.85rem;
  }

  .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    text-decoration: none;
  }

  .btn-outline-dark {
    background: rgba(255,255,255,0.9);
    color: #374151;
    border: 1px solid rgba(55, 65, 81, 0.3);
  }

  .btn-outline-dark:hover {
    background: #374151;
    color: white;
  }

  .btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
  }

  .btn-success:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    color: white;
  }

  .btn-outline-primary {
    background: rgba(255,255,255,0.9);
    color: #6366f1;
    border: 1px solid rgba(99, 102, 241, 0.3);
  }

  .btn-outline-primary:hover {
    background: #6366f1;
    color: white;
  }

  .btn-warning, .btn-sm.btn-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: #92400e;
  }

  .btn-warning:hover, .btn-sm.btn-warning:hover {
    background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    color: white;
  }

  .btn-danger, .btn-sm.btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
  }

  .btn-danger:hover, .btn-sm.btn-danger:hover {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    color: white;
  }

  .btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.8rem;
  }

  /* Action buttons container */
  .action-buttons {
    display: flex;
    gap: 0.5rem;
    align-items: center;
  }

  .action-buttons form {
    margin: 0;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .page-header {
      flex-direction: column;
      gap: 1rem;
      padding: 1.5rem 1rem;
    }
    
    .page-header h2 {
      font-size: 1.5rem;
    }
    
    .header-actions {
      flex-wrap: wrap;
      justify-content: center;
    }

    .content-section {
      padding: 1.5rem 1rem;
    }

    .stats-grid {
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1rem;
    }

    .table thead th,
    .table tbody td {
      padding: 0.75rem 0.5rem;
      font-size: 0.8rem;
    }

    .action-buttons {
      flex-direction: column;
      gap: 0.25rem;
    }

    .btn {
      width: 100%;
    }
  }

  /* Professional spacing and layout */
  .container-fluid {
    padding: 0.5rem 1.5rem 2rem 1.5rem !important;
    margin-top: 0 !important;
  }

  /* Pagination styling */
  .pagination {
    justify-content: center;
    margin-top: 2rem;
  }

  .pagination .page-link {
    font-family: 'Poppins', sans-serif !important;
    border-radius: 0.5rem;
    margin: 0 0.25rem;
    border: 1px solid rgba(226, 232, 240, 0.6);
    color: #6366f1;
  }

  .pagination .page-link:hover {
    background: #6366f1;
    border-color: #6366f1;
    color: white;
  }

  .pagination .page-item.active .page-link {
    background: #6366f1;
    border-color: #6366f1;
  }
</style>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<div class="container-fluid">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center">
      <i class="bi bi-droplet-half"></i>
      <div>
        <h2>Raw Material Management</h2>
        <p>Manage and track your raw material inventory</p>
      </div>
    </div>
    <div class="header-actions">
      <a href="{{ route('dashboard') }}" class="btn btn-outline-dark">
        <i class="bi bi-house-door"></i>
        Home
      </a>
      <a href="{{ route('raw-materials.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i>
        Add Material
      </a>
      <a href="{{ route('raw-materials.index') }}" class="btn btn-outline-primary">
        <i class="bi bi-list-ul"></i>
        All Materials
      </a>
    </div>
  </div>
  <!-- Analytics Section -->
  <div class="content-section">
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-header">
          <i class="bi bi-box me-2"></i>Total Raw Materials
        </div>
        <h3 class="stat-value">{{ $totalCount }}</h3>
      </div>
      <div class="stat-card">
        <div class="stat-header">
          <i class="bi bi-layers me-2"></i>Total Quantity
        </div>
        <h3 class="stat-value">{{ $totalQuantity }}</h3>
      </div>
      <div class="stat-card">
        <div class="stat-header">
          <i class="bi bi-exclamation-triangle me-2"></i>Low Stock Items
        </div>
        <h3 class="stat-value text-danger">{{ $lowStockCount }}</h3>
      </div>
      <div class="stat-card">
        <div class="stat-header">
          <i class="bi bi-tag me-2"></i>Material Types
        </div>
        <h3 class="stat-value">{{ $typeCount }}</h3>
      </div>
    </div>
  </div>

  <!-- Chart Section -->
  <div class="chart-container">
    <div class="chart-header">
      <i class="bi bi-bar-chart me-2"></i>Raw Material Quantities
    </div>
    <div class="chart-body">
      <canvas id="rawMaterialChart" height="80"></canvas>
    </div>
  </div>

  <!-- Materials Table -->
  <div class="table-container">
    <div class="table-header">
      <span>
        <i class="bi bi-table me-2"></i>Raw Materials List
      </span>
    </div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th><i class="bi bi-tag me-2"></i>Name</th>
            <th><i class="bi bi-bookmark me-2"></i>Type</th>
            <th><i class="bi bi-rulers me-2"></i>Unit</th>
            <th><i class="bi bi-123 me-2"></i>Quantity</th>
            <th><i class="bi bi-arrow-repeat me-2"></i>Reorder Level</th>
            <th><i class="bi bi-card-text me-2"></i>Description</th>
            <th><i class="bi bi-gear me-2"></i>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($rawMaterials as $material)
            <tr>
              <td class="fw-semibold">{{ $material->name }}</td>
              <td>
                <span class="badge bg-info">{{ $material->type }}</span>
              </td>
              <td>{{ $material->unit }}</td>
              <td>
                <span class="fw-bold {{ $material->quantity <= $material->reorder_level ? 'text-danger' : 'text-success' }}">
                  {{ $material->quantity }}
                </span>
              </td>
              <td>{{ $material->reorder_level }}</td>
              <td class="text-muted">{{ Str::limit($material->description, 50) }}</td>
              <td>
                <div class="action-buttons">
                  <a href="{{ route('raw-materials.edit', $material->id) }}" class="btn btn-sm btn-warning">
                    <i class="bi bi-pencil"></i>
                    Edit
                  </a>
                  <form action="{{ route('raw-materials.destroy', $material->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this material?')">
                      <i class="bi bi-trash"></i>
                      Delete
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-5">
                <i class="bi bi-inbox display-4 text-muted"></i>
                <h5 class="mt-3 text-muted">No raw materials found</h5>
                <p class="text-muted">Start by adding your first raw material.</p>
                <a href="{{ route('raw-materials.create') }}" class="btn btn-success">
                  <i class="bi bi-plus-circle"></i>
                  Add Raw Material
                </a>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pagination -->
  @if($rawMaterials->hasPages())
    <div class="d-flex justify-content-center">
      {{ $rawMaterials->links() }}
    </div>
  @endif
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
  
  const backgroundColors = data.map((value, index) => {
    const material = {!! json_encode($rawMaterials->pluck('quantity', 'reorder_level')) !!};
    return value <= Object.values(material)[index] ? 'rgba(239, 68, 68, 0.6)' : 'rgba(16, 185, 129, 0.6)';
  });
  
  const borderColors = data.map((value, index) => {
    const material = {!! json_encode($rawMaterials->pluck('quantity', 'reorder_level')) !!};
    return value <= Object.values(material)[index] ? '#ef4444' : '#10b981';
  });
  
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Quantity',
        data: data,
        backgroundColor: backgroundColors,
        borderColor: borderColors,
        borderWidth: 2,
        borderRadius: 6,
        borderSkipped: false,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        legend: { 
          display: true,
          labels: {
            font: {
              family: 'Poppins',
              size: 12
            }
          }
        },
        title: { 
          display: false 
        },
        tooltip: {
          titleFont: {
            family: 'Poppins'
          },
          bodyFont: {
            family: 'Poppins'
          }
        }
      },
      scales: {
        y: { 
          beginAtZero: true,
          ticks: {
            font: {
              family: 'Poppins'
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
</script>
@endsection

@extends('layouts.app')

@section('content')
<style>
  /* Modern Professional Raw Materials Styling */
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
  }

  /* Page Header */
  .page-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    color: white;
  }

  .page-header h4 {
    margin: 0;
    font-weight: 600;
    font-size: 1.5rem;
  }

  .page-header .btn {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    backdrop-filter: blur(10px);
    transition: all 0.2s ease;
  }

  .page-header .btn:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.3);
    color: white;
    transform: translateY(-2px);
  }

  /* Filter Section */
  .filter-section {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
  }

  .filter-section .form-label {
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
  }

  .filter-section .form-control {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
  }

  .filter-section .form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  }

  .filter-section .btn {
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .filter-section .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
  }

  /* Main Table Card */
  .table-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    border: none;
  }

  .table-card .card-body {
    padding: 0;
  }

  /* Table Styling */
  .modern-table {
    margin: 0;
    border-collapse: separate;
    border-spacing: 0;
  }

  .modern-table thead th {
    background: #f8fafc;
    color: #374151;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1.25rem 1.5rem;
    border: none;
    border-bottom: 1px solid #e5e7eb;
    position: sticky;
    top: 0;
    z-index: 10;
  }

  .modern-table thead th i {
    color: #6b7280;
    margin-right: 0.5rem;
  }

  .modern-table tbody tr {
    transition: all 0.2s ease;
  }

  .modern-table tbody tr:hover {
    background: #f9fafb;
  }

  .modern-table tbody td {
    padding: 1.25rem 1.5rem;
    border: none;
    border-bottom: 1px solid #f3f4f6;
    font-size: 0.875rem;
    color: #374151;
    vertical-align: middle;
  }

  .modern-table tbody tr:last-child td {
    border-bottom: none;
  }

  /* Status Badges */
  .status-badge {
    padding: 0.375rem 0.875rem;
    border-radius: 0.5rem;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: capitalize;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
  }

  .status-badge.delivered, .status-badge.completed, .status-badge.success {
    background: #dcfce7;
    color: #166534;
  }

  .status-badge.pending {
    background: #fef3c7;
    color: #92400e;
  }

  .status-badge.approved, .status-badge.processing {
    background: #dbeafe;
    color: #1e40af;
  }

  .status-badge.dispatched, .status-badge.info {
    background: #e0e7ff;
    color: #3730a3;
  }

  .status-badge.cancelled, .status-badge.rejected, .status-badge.danger {
    background: #fee2e2;
    color: #991b1b;
  }

  /* Product Name Styling */
  .product-name {
    font-weight: 500;
    color: #1f2937;
  }

  /* Quantity Styling */
  .quantity {
    font-weight: 600;
    color: #374151;
  }

  /* Date Styling */
  .order-date {
    color: #6b7280;
    font-size: 0.8rem;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .page-header {
      padding: 1.5rem;
    }

    .page-header h4 {
      font-size: 1.25rem;
    }

    .filter-section {
      padding: 1rem;
    }

    .modern-table thead th,
    .modern-table tbody td {
      padding: 1rem;
      font-size: 0.8rem;
    }

    .status-badge {
      padding: 0.25rem 0.625rem;
      font-size: 0.7rem;
    }
  }

  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: #6b7280;
  }

  .empty-state i {
    font-size: 3rem;
    color: #d1d5db;
    margin-bottom: 1rem;
  }

  .empty-state h5 {
    color: #374151;
    margin-bottom: 0.5rem;
    font-weight: 600;
  }

  .empty-state p {
    margin: 0;
    font-size: 0.875rem;
  }

  /* Action Buttons Enhancement */
  .btn-primary {
    background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
    border: none;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #6d28d9 0%, #7c3aed 100%);
    box-shadow: 0 8px 25px rgba(124, 58, 237, 0.3);
    transform: translateY(-2px);
  }

  .btn-success {
    background: #10b981;
    border: none;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .btn-success:hover {
    background: #059669;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
  }

  /* Chart container styling */
  .chart-container {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-top: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
  }

  /* Low stock row highlight */
  .low-stock-row {
    background: #fef3c7 !important;
    border-left: 4px solid #f59e0b;
  }
</style>
<div class="container-fluid py-4">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h4><i class="bi bi-droplet-half me-2"></i>Raw Material Inventory</h4>
        <p class="mb-0 opacity-75">Monitor all available raw materials and their stock levels</p>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('dashboard') }}" class="btn">
          <i class="bi bi-house-door me-1"></i>Home
        </a>
        <a href="{{ route('inventory.create') }}" class="btn">
          <i class="bi bi-plus-circle me-1"></i>Add Stock
        </a>
      </div>
    </div>
  </div>

  <!-- Additional Actions -->
  <div class="filter-section">
    <div class="d-flex gap-2 flex-wrap">
      <a href="{{ route('inventory.history') }}" class="btn btn-primary">
        <i class="bi bi-clock-history me-1"></i>Stock History
      </a>
      <a href="{{ route('inventory.index') }}" class="btn btn-success">
        <i class="bi bi-box-seam me-1"></i>Product Inventory
      </a>
    </div>
  </div>

  <!-- Raw Materials Table -->
  <div class="card table-card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table modern-table">
          <thead>
            <tr>
              <th><i class="bi bi-droplet-half"></i>Raw Material</th>
              <th><i class="bi bi-bar-chart"></i>Available Quantity</th>
              <th><i class="bi bi-rulers"></i>Unit</th>
              <th><i class="bi bi-calendar"></i>Last Updated</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($rawMaterialInventory as $item)
              <tr @if($item->quantity <= 10) class="low-stock-row" @endif>
                <td>
                  <span class="product-name">{{ $item->rawMaterial->name }}</span>
                  <small class="text-muted d-block">({{ $item->rawMaterial->type }})</small>
                </td>
                <td>
                  <span class="status-badge {{ $item->quantity <= 10 ? 'danger' : 'success' }}">
                    {{ $item->quantity }}
                  </span>
                  @if ($item->quantity <= 10)
                    <span class="text-danger fw-bold ms-2">
                      <i class="bi bi-exclamation-triangle me-1"></i>Low Stock
                    </span>
                  @endif
                </td>
                <td>
                  <span class="status-badge info">{{ $item->rawMaterial->unit }}</span>
                </td>
                <td>
                  <span class="order-date">{{ $item->updated_at->format('M d, Y H:i') }}</span>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4">
                  <div class="empty-state">
                    <i class="bi bi-droplet-half"></i>
                    <h5>No Raw Materials Found</h5>
                    <p>No raw materials are currently in the inventory.</p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Chart Section -->
  <div class="chart-container">
    <canvas id="rawMaterialInventoryChart" height="100"></canvas>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Raw Material Inventory Chart
  const rawMaterialCtx = document.getElementById('rawMaterialInventoryChart').getContext('2d');
  const rawMaterialGradient = rawMaterialCtx.createLinearGradient(0, 0, 0, 400);
  rawMaterialGradient.addColorStop(0, '#10b981');
  rawMaterialGradient.addColorStop(1, '#059669');
  
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
        borderRadius: 8,
        borderSkipped: false,
        hoverBackgroundColor: '#34d399',
        barPercentage: 0.8,
        categoryPercentage: 0.7,
        borderWidth: 0
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { 
          display: false 
        },
        title: {
          display: true,
          text: 'Raw Material Inventory Stock Levels',
          color: '#374151',
          font: { 
            size: 16, 
            weight: 'bold', 
            family: 'Poppins' 
          },
          padding: {
            top: 10,
            bottom: 20
          }
        },
        tooltip: {
          backgroundColor: 'rgba(16, 185, 129, 0.9)',
          titleColor: '#ffffff',
          bodyColor: '#ffffff',
          borderColor: '#10b981',
          borderWidth: 1,
          padding: 10,
          cornerRadius: 6,
          titleFont: {
            family: 'Poppins',
            weight: 'bold'
          },
          bodyFont: {
            family: 'Poppins'
          }
        }
      },
      scales: {
        x: {
          grid: { 
            display: false 
          },
          ticks: { 
            color: '#374151', 
            font: { 
              weight: '500',
              family: 'Poppins'
            }
          }
        },
        y: {
          beginAtZero: true,
          grid: { 
            color: '#e5e7eb' 
          },
          ticks: {
            stepSize: 5,
            color: '#374151',
            font: { 
              weight: '500',
              family: 'Poppins'
            }
          }
        }
      },
      animation: {
        duration: 1000,
        easing: 'easeOutQuart'
      }
    }
  });
</script>
@endsection

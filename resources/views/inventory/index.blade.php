<!-- =============================== -->
<!-- 1. Inventory Index (inventory/index.blade.php) -->
<!-- =============================== -->
@extends('layouts.app')

@section('content')
<style>
  /* Modern Professional Inventory Dashboard Styling */
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
    border-radius: 0.5rem;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    margin: 0 0.25rem;
  }

  .page-header .btn:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.3);
    color: white;
    transform: translateY(-2px);
  }

  /* Alert Section */
  .value-alert {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    border: 1px solid #93c5fd;
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    color: #1e40af;
  }

  .value-alert strong {
    color: #1d4ed8;
  }

  /* Section Headers */
  .section-header {
    color: #374151;
    font-weight: 600;
    font-size: 1.25rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e5e7eb;
  }

  /* Main Table Card */
  .table-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    border: none;
    margin-bottom: 2rem;
  }

  .table-card .card-header {
    background: #f8fafc;
    color: #374151;
    font-weight: 600;
    font-size: 1rem;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #e5e7eb;
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

  .modern-table tbody tr.low-stock {
    background: #fef3c7 !important;
  }

  .modern-table tbody tr.low-stock:hover {
    background: #fde68a !important;
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

  /* Product Name Styling */
  .product-name {
    font-weight: 500;
    color: #1f2937;
  }

  .product-name a {
    color: #3b82f6;
    text-decoration: none;
    transition: color 0.2s ease;
  }

  .product-name a:hover {
    color: #1d4ed8;
    text-decoration: underline;
  }

  /* Status Badges */
  .status-badge {
    padding: 0.375rem 0.875rem;
    border-radius: 0.5rem;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
  }

  .status-badge.success {
    background: #dcfce7;
    color: #166534;
  }

  .status-badge.danger {
    background: #fee2e2;
    color: #991b1b;
  }

  .status-badge.warning {
    background: #fef3c7;
    color: #92400e;
  }

  /* Chart Container */
  .chart-container {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .page-header {
      padding: 1.5rem;
    }

    .page-header h4 {
      font-size: 1.25rem;
    }

    .page-header .btn {
      font-size: 0.75rem;
      padding: 0.375rem 0.75rem;
      margin: 0.125rem;
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

    .chart-container {
      padding: 1.5rem;
    }
  }

  /* Low Stock Warning */
  .low-stock-warning {
    background: #fef3c7;
    color: #92400e;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    font-weight: 600;
    margin-left: 0.5rem;
  }
</style>
<div class="container-fluid py-4">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center justify-content-between flex-wrap">
      <div>
        <h4><i class="bi bi-box-seam me-2"></i>Inventory Dashboard</h4>
        <p class="mb-0 opacity-75">Manage your stock levels and inventory operations</p>
      </div>
      <div class="d-flex flex-wrap">
        <a href="{{ route('dashboard') }}" class="btn"><i class="bi bi-house-door me-1"></i>Home</a>
        <a href="{{ route('inventory.create') }}" class="btn"><i class="bi bi-plus-circle me-1"></i>Add Stock</a>
        <a href="{{ route('inventory.deductForm') }}" class="btn"><i class="bi bi-dash-circle me-1"></i>Deduct Stock</a>
        <a href="{{ route('inventory.history') }}" class="btn"><i class="bi bi-clock-history me-1"></i>Stock History</a>
        <a href="{{ route('inventory.raw-materials') }}" class="btn"><i class="bi bi-droplet-half me-1"></i>Raw Materials</a>
        <a href="{{ route('inventory.export.csv') }}" class="btn"><i class="bi bi-download me-1"></i>Export CSV</a>
        <a href="{{ route('stock_transfer.create') }}" class="btn"><i class="bi bi-arrow-left-right me-1"></i>Transfer</a>
        <a href="{{ route('inventory.analytics') }}" class="btn"><i class="bi bi-bar-chart me-1"></i>Analytics</a>
      </div>
    </div>
  </div>

  <!-- Total Value Alert -->
  <div class="value-alert">
    <div class="d-flex align-items-center">
      <i class="bi bi-cash-coin fs-4 me-3"></i>
      <div>
        <strong>Total Inventory Value:</strong> UGX {{ number_format($totalValue, 2) }}
      </div>
    </div>
  </div>

  <!-- Products in Stock Section -->
  <h5 class="section-header"><i class="bi bi-cube me-2"></i>Products in Stock</h5>
  
  <div class="card table-card">
    <div class="card-header d-flex align-items-center">
      <i class="bi bi-archive me-2"></i>
      <span>Product Inventory</span>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table modern-table">
          <thead>
            <tr>
              <th><i class="bi bi-cube"></i>Product</th>
              <th><i class="bi bi-123"></i>Available Quantity</th>
              <th><i class="bi bi-calendar"></i>Last Updated</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($productInventory as $item)
            <tr @if($item['quantity'] <= 10) class="low-stock" @endif>
              <td>
                <span class="product-name">
                  <i class="bi bi-cube me-1"></i>
                  <a href="{{ route('inventory.product.batches', $item['product_id']) }}">
                    {{ $item['product']->name }}
                  </a>
                </span>
              </td>
              <td>
                <span class="status-badge {{ $item['quantity'] <= 10 ? 'danger' : 'success' }}">
                  {{ $item['quantity'] }} <span class="unit-label">pcs</span>
                </span>
                @if ($item['quantity'] <= 10)
                  <span class="low-stock-warning">(Low Stock)</span>
                @endif
              </td>
              <td>
                <span class="text-muted">
                  {{ $item['updated_at'] ? \Carbon\Carbon::parse($item['updated_at'])->format('M d, Y H:i') : '-' }}
                </span>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Chart Section -->
  <div class="chart-container">
    <canvas id="productInventoryChart" height="100"></canvas>
  </div>
  <!-- Raw Materials Section -->
  <h5 class="section-header"><i class="bi bi-droplet-half me-2"></i>Raw Materials in Stock</h5>
  
  <div class="card table-card">
    <div class="card-header d-flex align-items-center">
      <i class="bi bi-archive me-2"></i>
      <span>Raw Material Inventory</span>
    </div>
    <div class="card-body">
      <div class="text-center py-4">
        <i class="bi bi-info-circle fs-1 text-muted mb-3"></i>
        <p class="text-muted">Raw material inventory has been moved to its own dedicated section.</p>
        <a href="{{ route('inventory.raw-materials') }}" class="btn btn-primary">
          <i class="bi bi-droplet-half me-2"></i>View Raw Materials
        </a>
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

  // Raw Material Inventory Chart code removed. See raw-materials.blade.php for the new widget.
</script>
@endsection



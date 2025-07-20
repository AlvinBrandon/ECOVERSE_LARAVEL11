<div class="admin-dashboard-container">
<div class="dashboard-header">
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <div class="dashboard-logo-circle">
                <i class="bi bi-shield-check"></i>
            </div>
            <div class="ms-3">
                <h2 class="mb-1 text-white">Admin Dashboard</h2>
                <p class="mb-0 text-white-50">Welcome back, {{ Auth::user()->name }}</p>
            </div>
        </div>
        <div class="dashboard-stats d-none d-lg-flex">
            <div class="stat-item me-4">
                <div class="stat-number">{{ $totalUsers ?? 0 }}</div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-item me-4">
                <div class="stat-number">{{ $totalProducts ?? 0 }}</div>
                <div class="stat-label">Products</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $activePOs ?? 0 }}</div>
                <div class="stat-label">Active POs</div>
            </div>
        </div>
    </div>
</div>
<!-- Main Action Cards -->
<div class="row g-4 mb-5">
    <!-- Pending Sales Approvals -->
    <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="action-card card-primary">
            <div class="card-icon">
                <i class="bi bi-truck"></i>
            </div>
            <div class="card-content">
                <h5>Pending Sales Approvals</h5>
                <p>Review and verify sales orders, update delivery status, and manage dispatches.</p>
                <a href="{{ route('admin.sales.pending') }}" class="btn btn-primary btn-modern">
                    <i class="bi bi-clipboard-check me-2"></i>Go to Sales Verification
                </a>
                <div class="mt-3">
                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                        {{ $pendingSalesCount ?? '0' }} Pending
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="action-card card-success">
            <div class="card-icon">
                <i class="bi bi-people"></i>
            </div>
            <div class="card-content">
                <h5>User Management</h5>
                <p>Manage all users, roles and permissions</p>
                <a href="{{ route('user-management') }}" class="btn btn-success btn-modern">
                    <i class="bi bi-person-lines-fill me-2"></i>Manage Users
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="action-card card-info">
            <div class="card-icon">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="card-content">
                <h5>Inventory Control</h5>
                <p>Monitor stock levels and analytics</p>
                <a href="{{ route('inventory.index') }}" class="btn btn-info btn-modern">
                    <i class="bi bi-archive me-2"></i>View Inventory
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="action-card card-warning">
            <div class="card-icon">
                <i class="bi bi-bar-chart"></i>
            </div>
            <div class="card-content">
                <h5>Analytics & Reports</h5>
                <p>Business insights and performance</p>
                <a href="{{ route('admin.sales.report') }}" class="btn btn-warning btn-modern">
                    <i class="bi bi-graph-up-arrow me-2"></i>View Reports
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Action Cards -->
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="action-card card-danger">
            <div class="card-icon">
                <i class="bi bi-cpu"></i>
            </div>
            <div class="card-content">
                <h5>ML Predictions</h5>
                <p>AI-powered forecasting tools</p>
                <a href="{{ route('admin.predictions.dashboard') }}" class="btn btn-danger btn-modern">
                    <i class="bi bi-robot me-2"></i>ML Dashboard
                </a>
            </div>
        </div>
    </div>
    
    <!-- Add more cards here as needed -->
    
</div>

<!-- System Health Widget -->
{{-- <div class="row">
  <div class="col-md-4">
    <div class="dashboard-card">
      <h6><i class="bi bi-heart-pulse text-danger dashboard-icon"></i>System Health</h6>
      <ul class="list-unstyled mb-0">
        <li><strong>Server:</strong> <span class="text-success">{{ $systemHealth['server'] }}</span></li>
        <li><strong>Queue:</strong> <span class="text-success">{{ $systemHealth['queue'] }}</span></li>
        <li><strong>Storage:</strong> <span class="text-warning">{{ $systemHealth['storage'] }}</span></li>
        <li><strong>Last Backup:</strong> <span class="text-info">{{ $systemHealth['last_backup'] }}</span></li>
      </ul>
    </div>
  </div> --}}
  <!-- Notifications Panel -->
  {{-- <div class="col-md-4">
    <div class="dashboard-card">
      <h6><i class="bi bi-bell text-warning dashboard-icon"></i>Notifications</h6>
      <ul class="list-unstyled mb-0" style="max-height:120px;overflow:auto;">
        @foreach($notifications as $note)
          <li><i class="bi bi-{{ $note['icon'] }} text-{{ $note['type'] }}"></i> {{ $note['text'] }}</li>
        @endforeach
      </ul>
    </div>
  </div> --}}
<!-- Management Section -->
<div class="row g-4 mb-5">
    <!-- Quick Actions -->
    <div class="col-xl-4 col-lg-6">
        <div class="info-card">
            <div class="card-header-custom">
                <h6><i class="bi bi-lightning-charge me-2"></i>Quick Actions</h6>
            </div>
            <div class="card-body-custom">
                <div class="action-buttons">
                    <a href="{{ route('inventory.create') }}" class="action-btn btn-success">
                        <i class="bi bi-plus-circle me-2"></i>Add Inventory
                    </a>
                    <a href="{{ route('admin.sales.pending') }}" class="action-btn btn-info">
                        <i class="bi bi-hourglass-split me-2"></i>Approve Sales
                    </a>
                    <a href="{{ route('admin.purchase_orders.create') }}" class="action-btn btn-warning">
                        <i class="bi bi-clipboard-plus me-2"></i>Create PO
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Purchase Orders -->
    <div class="col-xl-8 col-lg-6">
        <div class="info-card">
            <div class="card-header-custom">
                <h6><i class="bi bi-clipboard-data me-2"></i>Recent Purchase Orders</h6>
                <a href="{{ route('admin.purchase_orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body-custom">
                <div class="list-group list-group-flush">
                    @forelse($adminPOs ?? [] as $po)
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-secondary me-2">#{{ $po->id }}</span>
                                    <strong>{{ $po->rawMaterial->name ?? 'N/A' }}</strong>
                                    <small class="text-muted d-block">to {{ $po->supplier->name ?? 'N/A' }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-{{ $po->status == 'complete' ? 'success' : ($po->status == 'pending' ? 'warning' : 'info') }}">
                                        {{ ucfirst($po->status) }}
                                    </span>
                                    <a href="{{ route('admin.purchase_orders.show', $po->id) }}" class="btn btn-sm btn-outline-primary ms-2">View</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-3 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            No purchase orders found
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
  {{-- <div class="col-md-6">
    <div class="dashboard-card">
      <h6><i class="bi bi-truck dashboard-icon text-success"></i>Delivery Verification</h6>
      <ul class="list-unstyled mb-0" style="max-height:120px;overflow:auto;">
        @foreach($pendingDeliveries as $po)
          <li>
            <span class="badge bg-secondary">#{{ $po->id }}</span>
            {{ $po->rawMaterial->name ?? 'N/A' }} from {{ $po->supplier->name ?? 'N/A' }}
            <span class="badge bg-warning">Awaiting Verification</span>
            <a href="{{ route('admin.purchase_orders.show', $po->id) }}" class="btn btn-link btn-sm">Verify</a>
          </li>
        @endforeach
      </ul>
    </div>
  </div> --}}

<!-- Analytics & Inventory Section -->
<div class="row g-4 mb-5">
    <!-- Batch Analytics Chart -->
    <div class="col-xl-6 col-lg-12">
        <div class="info-card h-100">
            <div class="card-header-custom">
                <h6><i class="bi bi-pie-chart me-2"></i>Inventory Distribution</h6>
                <small class="text-muted">Product inventory breakdown</small>
            </div>
            <div class="card-body-custom d-flex align-items-center justify-content-center">
                <div class="chart-container">
                    <canvas id="batchAnalyticsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Raw Material Inventory -->
    <div class="col-xl-6 col-lg-12">
        <div class="info-card h-100">
            <div class="card-header-custom">
                <h6><i class="bi bi-boxes me-2"></i>Raw Material Stock</h6>
                <small class="text-muted">Current stock levels</small>
            </div>
            <div class="card-body-custom">
                <div class="inventory-list-container">
                    @forelse($rawMaterials ?? [] as $mat)
                        <div class="inventory-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="item-title">{{ $mat->name }}</div>
                                    <div class="item-subtitle">{{ $mat->type }}</div>
                                </div>
                                <div class="text-end">
                                    <div class="quantity-display">
                                        <span class="quantity-number">{{ $mat->quantity }}</span>
                                        <span class="quantity-unit">{{ $mat->unit }}</span>
                                    </div>
                                    @if($mat->quantity <= $mat->reorder_level)
                                        <div class="stock-alert">
                                            <i class="bi bi-exclamation-triangle me-1"></i>Low Stock
                                        </div>
                                    @else
                                        <div class="stock-ok">
                                            <i class="bi bi-check-circle me-1"></i>In Stock
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <h6>No Raw Materials</h6>
                            <p>No raw materials found in inventory</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Financial & Operations Section -->
<div class="row g-4 mb-5">
    <!-- Supplier Payments -->
    <div class="col-xl-4 col-lg-6">
        <div class="info-card h-100">
            <div class="card-header-custom">
                <h6><i class="bi bi-cash-stack me-2"></i>Supplier Payments</h6>
                <small class="text-muted">Payment status</small>
            </div>
            <div class="card-body-custom">
                <div class="financial-list-container">
                    @forelse($supplierPayments ?? [] as $pay)
                        <div class="financial-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="item-title">{{ $pay['supplier'] }}</div>
                                    <div class="item-subtitle">Payment Record</div>
                                </div>
                                <div class="text-end">
                                    <div class="payment-amount">UGX {{ number_format($pay['amount'],0) }}</div>
                                    <span class="payment-status status-{{ $pay['status'] }}">
                                        <i class="bi bi-{{ $pay['status'] == 'paid' ? 'check-circle-fill' : 'clock-fill' }} me-1"></i>
                                        {{ ucfirst($pay['status']) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="bi bi-wallet2"></i>
                            <h6>No Payment Records</h6>
                            <p>No supplier payments found</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Management -->
    <div class="col-xl-4 col-lg-6">
        <div class="info-card h-100">
            <div class="card-header-custom">
                <h6><i class="bi bi-receipt me-2"></i>Recent Invoices</h6>
                <small class="text-muted">Invoice management</small>
            </div>
            <div class="card-body-custom">
                <div class="financial-list-container">
                    @forelse($invoices ?? [] as $inv)
                        <div class="financial-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="po-badge">#{{ $inv->po_id }}</span>
                                        <a href="{{ asset('storage/'.$inv->invoice_path) }}" target="_blank" class="invoice-link ms-2">
                                            <i class="bi bi-file-earmark-pdf me-1"></i>View PDF
                                        </a>
                                    </div>
                                    <div class="item-subtitle">Purchase Order Invoice</div>
                                </div>
                                <div class="text-end">
                                    <span class="invoice-status status-{{ $inv->status }}">
                                        <i class="bi bi-{{ $inv->status == 'approved' ? 'check-circle-fill' : ($inv->status == 'rejected' ? 'x-circle-fill' : 'clock-fill') }} me-1"></i>
                                        {{ ucfirst($inv->status) }}
                                    </span>
                                    <a href="{{ route('admin.purchase_orders.show', $inv->po_id) }}" class="review-btn">
                                        <i class="bi bi-eye me-1"></i>Review
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="bi bi-receipt-cutoff"></i>
                            <h6>No Invoices</h6>
                            <p>No invoices found</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Summary -->
    <div class="col-xl-4 col-lg-12">
        <div class="info-card h-100">
            <div class="card-header-custom">
                <h6><i class="bi bi-bar-chart-steps me-2"></i>Operations Summary</h6>
                <small class="text-muted">Monthly overview</small>
            </div>
            <div class="card-body-custom">
                <div class="analytics-metrics">
                    <div class="metric-item metric-success">
                        <div class="metric-icon">
                            <i class="bi bi-box-arrow-in-down"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-number">{{ $analytics['received_this_month'] ?? 0 }}</div>
                            <div class="metric-label">Received This Month</div>
                        </div>
                    </div>

                    <div class="metric-item metric-warning">
                        <div class="metric-icon">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-number">{{ $analytics['pending_pos'] ?? 0 }}</div>
                            <div class="metric-label">Pending POs</div>
                        </div>
                    </div>

                    <div class="metric-item metric-info">
                        <div class="metric-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-number">{{ $analytics['pending_deliveries'] ?? 0 }}</div>
                            <div class="metric-label">Pending Deliveries</div>
                        </div>
                    </div>

                    <div class="metric-item metric-danger">
                        <div class="metric-icon">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-number">{{ $analytics['unpaid'] ?? 0 }}</div>
                            <div class="metric-label">Unpaid Invoices</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<!-- Chart.js for analytics -->
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // // Sales Trends Chart (real data)
  // const ctx1 = document.getElementById('salesTrendsChart').getContext('2d');
  // new Chart(ctx1, {
  //   type: 'line',
  //   data: {
  //     labels: @json($revenueTrendLabels),
  //     datasets: [{
  //       label: 'Sales',
  //       data: @json($revenueTrendData),
  //       borderColor: '#6366f1',
  //       backgroundColor: 'rgba(99,102,241,0.1)',
  //       tension: 0.4
  //     }]
  //   },
  //   options: { plugins: { legend: { display: false } } }
  // });
  // Batch Analytics Chart (real data)
  const ctx2 = document.getElementById('batchAnalyticsChart').getContext('2d');
  new Chart(ctx2, {
    type: 'doughnut',
    data: {
      labels: @json($batchLabels),
      datasets: [{
        data: @json($batchData),
        backgroundColor: ['#10b981', '#6366f1', '#f59e42', '#f43f5e', '#0ea5e9', '#fbbf24', '#a3e635']
      }]
    },
    options: { 
      responsive: true,
      maintainAspectRatio: false,
      plugins: { 
        legend: { 
          position: 'bottom',
          labels: {
            padding: 15,
            usePointStyle: true
          }
        }
      }
    }
  });
</script>

<!-- Google Fonts - Poppins -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
/* Modern Professional Dashboard Styling */
body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
}

/* Dashboard Container */
.admin-dashboard-container {
    max-width: 1600px;
    margin: 0 auto;
    padding: 1.5rem;
}

@media (min-width: 1400px) {
    .admin-dashboard-container {
        padding: 2rem 3rem;
    }
}

@media (min-width: 1920px) {
    .admin-dashboard-container {
        padding: 2rem 5rem;
    }
}

/* Dashboard Header */
.dashboard-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.dashboard-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
    border-radius: 50%;
}

.dashboard-logo-circle {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 4px 20px rgba(59, 130, 246, 0.3);
}

.dashboard-stats .stat-item {
    text-align: center;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
}

.stat-label {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.7);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Action Cards */
.action-card {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    height: 100%;
    border: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.action-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--card-color);
}

.action-card.card-primary { --card-color: #3b82f6; }
.action-card.card-success { --card-color: #10b981; }
.action-card.card-info { --card-color: #06b6d4; }
.action-card.card-warning { --card-color: #f59e0b; }
.action-card.card-danger { --card-color: #ef4444; }

.action-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.action-card .card-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, var(--card-color), color-mix(in srgb, var(--card-color) 80%, black));
    color: white;
    box-shadow: 0 8px 25px color-mix(in srgb, var(--card-color) 30%, transparent);
}

.action-card .card-content h5 {
    font-weight: 600;
    margin-bottom: 0.75rem;
    color: #1e293b;
}

.action-card .card-content p {
    color: #64748b;
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
}

.btn-modern {
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    text-transform: none;
    border: none;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

/* Info Cards */
.info-card {
    background: white;
    border-radius: 1rem;
    border: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.card-header-custom {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 1.25rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header-custom h6 {
    margin: 0;
    font-weight: 600;
    color: #1e293b;
    display: flex;
    align-items: center;
}

.card-body-custom {
    padding: 1.5rem;
}

/* Chart Container */
.chart-container {
    position: relative;
    height: 300px;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    overflow: hidden;
}

.chart-container canvas {
    max-height: 280px !important;
    max-width: 100% !important;
    width: auto !important;
    height: auto !important;
}

/* Enhanced Inventory & Financial Lists */
.inventory-list-container, .financial-list-container {
    max-height: 320px;
    overflow-y: auto;
    padding: 0.5rem 0;
}

.inventory-item, .financial-item {
    padding: 1rem 0;
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.2s ease;
}

.inventory-item:last-child, .financial-item:last-child {
    border-bottom: none;
}

.inventory-item:hover, .financial-item:hover {
    background: #f8fafc;
    margin: 0 -1rem;
    padding: 1rem;
    border-radius: 0.5rem;
}

.item-title {
    font-weight: 600;
    color: #1e293b;
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
}

.item-subtitle {
    font-size: 0.8rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Quantity Display */
.quantity-display {
    display: flex;
    align-items: baseline;
    gap: 0.25rem;
    margin-bottom: 0.5rem;
}

.quantity-number {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1e293b;
}

.quantity-unit {
    font-size: 0.8rem;
    color: #64748b;
    text-transform: uppercase;
}

/* Stock Status */
.stock-alert, .stock-ok {
    font-size: 0.75rem;
    font-weight: 500;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    display: inline-flex;
    align-items: center;
}

.stock-alert {
    background: #fef2f2;
    color: #dc2626;
}

.stock-ok {
    background: #f0fdf4;
    color: #16a34a;
}

/* Payment Amount */
.payment-amount {
    font-weight: 700;
    color: #059669;
    font-size: 1rem;
    margin-bottom: 0.5rem;
}

/* Status Badges */
.payment-status, .invoice-status {
    font-size: 0.75rem;
    font-weight: 500;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    display: inline-flex;
    align-items: center;
}

.status-paid, .status-approved {
    background: #f0fdf4;
    color: #16a34a;
}

.status-pending {
    background: #fffbeb;
    color: #d97706;
}

.status-rejected {
    background: #fef2f2;
    color: #dc2626;
}

/* PO Badge & Links */
.po-badge {
    background: #e2e8f0;
    color: #475569;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    font-weight: 600;
}

.invoice-link {
    color: #3b82f6;
    text-decoration: none;
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.invoice-link:hover {
    color: #1d4ed8;
    text-decoration: underline;
}

.review-btn {
    background: #f1f5f9;
    color: #475569;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    text-decoration: none;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    margin-top: 0.5rem;
    transition: all 0.2s ease;
}

.review-btn:hover {
    background: #e2e8f0;
    color: #334155;
    text-decoration: none;
}

/* Enhanced Analytics Metrics */
.analytics-metrics {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    height: 100%;
}

.metric-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 0.75rem;
    border-left: 4px solid var(--metric-color);
    transition: all 0.2s ease;
}

.metric-item:hover {
    background: #f1f5f9;
    transform: translateX(4px);
}

.metric-success { --metric-color: #10b981; }
.metric-warning { --metric-color: #f59e0b; }
.metric-info { --metric-color: #06b6d4; }
.metric-danger { --metric-color: #ef4444; }

.metric-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--metric-color);
    color: white;
    font-size: 1.1rem;
    margin-right: 1rem;
    flex-shrink: 0;
}

.metric-content {
    flex-grow: 1;
}

.metric-number {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.metric-label {
    font-size: 0.75rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Empty States */
.empty-state {
    text-align: center;
    padding: 2rem 1rem;
    color: #64748b;
}

.empty-state i {
    font-size: 2.5rem;
    color: #cbd5e1;
    margin-bottom: 1rem;
    display: block;
}

.empty-state h6 {
    color: #475569;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.empty-state p {
    font-size: 0.875rem;
    margin: 0;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    padding: 0.5rem 0;
}

.action-btn {
    border-radius: 0.5rem;
    padding: 0.875rem 1rem;
    font-weight: 500;
    text-decoration: none;
    border: none;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    text-decoration: none;
}

/* List Items */
.list-group-item {
    padding: 1rem 0;
    border-bottom: 1px solid #f1f5f9 !important;
}

.list-group-item:last-child {
    border-bottom: none !important;
}

/* Responsive Design */
@media (max-width: 1400px) {
    .dashboard-stats {
        display: none !important;
    }
}

@media (max-width: 1024px) {
    .analytics-metrics {
        gap: 0.75rem;
    }
    
    .metric-item {
        padding: 0.75rem;
    }
    
    .chart-container {
        height: 280px;
        padding: 0.75rem;
    }
    
    .chart-container canvas {
        max-height: 260px !important;
    }
}

@media (max-width: 768px) {
    .admin-dashboard-container {
        padding: 1rem;
    }
    
    .dashboard-header {
        padding: 1.5rem;
    }
    
    .action-card {
        padding: 1.5rem;
    }
    
    .card-body-custom {
        padding: 1rem;
    }
    
    .chart-container {
        height: 250px;
        padding: 0.5rem;
    }
    
    .chart-container canvas {
        max-height: 230px !important;
    }
    
    .analytics-metrics {
        gap: 0.5rem;
    }
    
    .metric-item {
        padding: 0.75rem;
        flex-direction: column;
        text-align: center;
    }
    
    .metric-icon {
        margin-right: 0;
        margin-bottom: 0.5rem;
    }
}

/* Custom Scrollbars */
.inventory-list-container::-webkit-scrollbar, 
.financial-list-container::-webkit-scrollbar {
    width: 6px;
}

.inventory-list-container::-webkit-scrollbar-track, 
.financial-list-container::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.inventory-list-container::-webkit-scrollbar-thumb, 
.financial-list-container::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.inventory-list-container::-webkit-scrollbar-thumb:hover, 
.financial-list-container::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>

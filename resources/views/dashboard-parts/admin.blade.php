<div class="d-flex align-items-center mb-2">
    <h5 class="mb-0" style="color:#fff; font-size:1.5rem; font-weight:700; text-shadow:0 2px 8px rgba(0,0,0,0.18);">Welcome, {{ Auth::user()->name }}</h5>
</div>
<div class="dashboard-header d-flex align-items-center">
    <img src="/assets/img/ecoverse-logo.svg" alt="Ecoverse Logo" class="ecoverse-logo">
    <div>
      <h2 class="mb-0">Admin Dashboard</h2>
      <p class="mb-0" style="font-size:1.1rem;">Full control: Reports, user management, inventory, system config.</p>
    </div>
</div>
<!-- Sales Verification Widget Row -->
<div class="row mb-4">
  @include('dashboard-parts.admin-sales-verify-widget')
</div>
<div class="row">
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <i class="bi bi-people text-primary" style="font-size:2rem;"></i>
        <h5 class="mt-2">User Management</h5>
        <p>Manage all users and roles in the system.</p>
        <a href="{{ route('user-management') }}" class="btn btn-primary mt-2"><i class="bi bi-person-lines-fill me-1"></i> Manage Users</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <i class="bi bi-box-seam text-success" style="font-size:2rem;"></i>
        <h5 class="mt-2">Inventory</h5>
        <p>Full access to all inventory and analytics.</p>
        <a href="{{ route('inventory.index') }}" class="btn btn-success mt-2"><i class="bi bi-archive me-1"></i> Go to Inventory</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <i class="bi bi-bar-chart text-info" style="font-size:2rem;"></i>
        <h5 class="mt-2">Reports & Analytics</h5>
        <p>View system-wide reports and analytics.</p>
        <a href="{{ route('admin.sales.report') }}" class="btn btn-info mt-2"><i class="bi bi-graph-up-arrow me-1"></i> Sales Report</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <i class="bi bi-cpu text-primary" style="font-size:2rem;"></i>
        <h5 class="mt-2">ML Predictions</h5>
        <p>Access packaging materials predictions and analytics.</p>
        <a href="{{ route('admin.predictions.dashboard') }}" class="btn btn-primary mt-2"><i class="bi bi-robot me-1"></i> ML Dashboard</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <i class="bi bi-clipboard-check text-warning" style="font-size:2rem;"></i>
        <h5 class="mt-2">Purchase Orders (Admin)</h5>
        <p>Review, verify, and mark purchase orders as paid.</p>
        <a href="{{ route('admin.purchase_orders.index') }}" class="btn btn-warning mt-2"><i class="bi bi-clipboard-check me-1"></i> Manage Purchase Orders</a>
      </div>
    </div>
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
  <!-- Quick Actions -->
  <div class="col-md-4">
    <div class="dashboard-card text-center">
      <h6><i class="bi bi-lightning-charge text-primary dashboard-icon"></i>Quick Actions</h6>
      <a href="{{ route('inventory.create') }}" class="btn btn-outline-success btn-sm mb-2"><i class="bi bi-plus-circle"></i> Add Inventory</a><br>
      <a href="{{ route('admin.sales.pending') }}" class="btn btn-outline-info btn-sm mb-2"><i class="bi bi-hourglass-split"></i> Approve Sales</a><br>
      <a href="#" class="btn btn-outline-primary btn-sm mb-2"><i class="bi bi-box"></i> Add Product</a>
    </div>
  </div>
</div>

<!-- Advanced Analytics & Trends -->
{{-- <div class="row">
  <div class="col-md-6">
    <div class="dashboard-card">
      <h6><i class="bi bi-graph-up-arrow text-info dashboard-icon"></i>Sales Trends</h6>
      <canvas id="salesTrendsChart" height="120"></canvas>
    </div>
  </div> --}}
  <div class="col-md-6 text-sm">
    <div class="dashboard-card">
      <h6><i class="bi bi-pie-chart text-success dashboard-icon"></i>Batch-Level Inventory Analytics</h6>
      <div style="max-width:400px;margin:auto;">
        <canvas id="batchAnalyticsChart" height="120" style="max-width:100%;width:100%;"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Activity Log -->
{{-- <div class="row">
  <div class="col-md-12">
    <div class="dashboard-card">
      <h6><i class="bi bi-clock-history text-secondary dashboard-icon"></i>Recent Activity</h6>
      <ul class="list-unstyled mb-0" style="max-height:140px;overflow:auto;">
        @foreach($activityLog as $log)
          <li><i class="bi bi-{{ $log['icon'] }} text-{{ $log['type'] }}"></i> {{ $log['text'] }}</li>
        @endforeach
      </ul>
    </div>
  </div>
</div> --}}

<!-- Purchase Orders Management -->
<div class="row">
  <div class="col-md-6">
    <div class="dashboard-card">
      <h6><i class="bi bi-clipboard-data dashboard-icon text-primary"></i>Purchase Orders</h6>
      <a href="{{ route('admin.purchase_orders.create') }}" class="btn btn-outline-primary btn-sm mb-2"><i class="bi bi-plus-circle"></i> Create PO</a>
      <ul class="list-unstyled mb-0" style="max-height:120px;overflow:auto;">
        @foreach($adminPOs as $po)
          <li>
            <span class="badge bg-secondary">#{{ $po->id }}</span>
            {{ $po->rawMaterial->name ?? 'N/A' }} to {{ $po->supplier->name ?? 'N/A' }}
            <span class="badge bg-info">{{ ucfirst($po->status) }}</span>
            <a href="{{ route('admin.purchase_orders.show', $po->id) }}" class="btn btn-link btn-sm">View</a>
          </li>
        @endforeach
      </ul>
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
</div>
<!-- Raw Material Inventory & Supplier Payments -->
<div class="row">
  <div class="col-md-6">
    <div class="dashboard-card">
      <h6><i class="bi bi-boxes dashboard-icon text-info"></i>Raw Material Inventory</h6>
      <ul class="list-unstyled mb-0" style="max-height:120px;overflow:auto;">
        @foreach($rawMaterials as $mat)
          <li>
            {{ $mat->name }}: <strong>{{ $mat->quantity }} {{ $mat->unit }}</strong>
            <span class="text-muted">(Reorder: {{ $mat->reorder_level }})</span>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
  <div class="col-md-6">
    <div class="dashboard-card">
      <h6><i class="bi bi-cash-stack dashboard-icon text-success"></i>Supplier Payments</h6>
      <ul class="list-unstyled mb-0" style="max-height:120px;overflow:auto;">
        @foreach($supplierPayments as $pay)
          <li>
            {{ $pay['supplier'] }}: <span class="badge bg-{{ $pay['status'] == 'paid' ? 'success' : 'warning' }}">{{ ucfirst($pay['status']) }}</span>
            <span class="ms-2">₱{{ number_format($pay['amount'],2) }}</span>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
</div>
<!-- Invoice Management & Analytics -->
<div class="row">
  <div class="col-md-6">
    <div class="dashboard-card">
      <h6><i class="bi bi-receipt dashboard-icon text-secondary"></i>Invoice Management</h6>
      <ul class="list-unstyled mb-0" style="max-height:120px;overflow:auto;">
        @foreach($invoices as $inv)
          <li>
            <span class="badge bg-secondary">#{{ $inv->po_id }}</span>
            <a href="{{ asset('storage/'.$inv->invoice_path) }}" target="_blank">Invoice</a>
            <span class="badge bg-{{ $inv->status == 'approved' ? 'success' : ($inv->status == 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($inv->status) }}</span>
            <a href="{{ route('admin.purchase_orders.show', $inv->po_id) }}" class="btn btn-link btn-sm">Review</a>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
  <div class="col-md-6">
    <div class="dashboard-card">
      <h6><i class="bi bi-bar-chart-steps dashboard-icon text-info"></i>Raw Material Analytics</h6>
      <ul class="list-unstyled mb-0">
        <li>Received this month: <strong>{{ $analytics['received_this_month'] ?? 0 }}</strong></li>
        <li>Pending POs: <strong>{{ $analytics['pending_pos'] ?? 0 }}</strong></li>
        <li>Pending Deliveries: <strong>{{ $analytics['pending_deliveries'] ?? 0 }}</strong></li>
        <li>Unpaid: <strong>{{ $analytics['unpaid'] ?? 0 }}</strong></li>
      </ul>
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
    options: { plugins: { legend: { position: 'bottom' } } }
  });
</script>

<style>
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%) !important;
  }
  .dashboard-card {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    box-shadow: 0 4px 24px rgba(16, 185, 129, 0.08);
    padding: 2rem 1.5rem;
    margin-bottom: 2rem;
    transition: box-shadow 0.2s, transform 0.2s;
  }
  .dashboard-card:hover {
    box-shadow: 0 8px 32px rgba(99,102,241,0.18), 0 2px 8px rgba(16,185,129,0.10);
    transform: translateY(-4px) scale(1.025);
    z-index: 2;
    cursor: pointer;
  }
  .dashboard-header {
    background: linear-gradient(90deg, #6366f1 0%, #10b981 100%) !important;
    color: #fff !important;
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
    padding: 1.5rem 1.5rem 1rem 1.5rem;
    margin-bottom: 2rem;
  }
  .dashboard-icon {
    font-size: 2.5rem;
    margin-right: 1rem;
    vertical-align: middle;
  }
  .ecoverse-logo {
    width: 48px;
    height: 48px;
    margin-right: 1rem;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #10b981;
    background: #fff;
  }
</style>

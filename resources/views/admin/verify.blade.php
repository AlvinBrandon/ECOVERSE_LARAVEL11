
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

  .content-section {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.12);
    border: 1px solid rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
  }

  .table-container {
    background: rgba(255,255,255,0.9);
    border-radius: 1rem;
    border: 1px solid rgba(226, 232, 240, 0.6);
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(16, 185, 129, 0.08);
    backdrop-filter: blur(5px);
  }

  .table {
    margin-bottom: 0;
    font-family: 'Poppins', sans-serif !important;
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

  .form-label {
    font-family: 'Poppins', sans-serif !important;
    color: #374151;
    font-weight: 600;
    font-size: 0.8rem;
    margin-bottom: 0.25rem;
  }

  .form-control, .form-select {
    font-family: 'Poppins', sans-serif !important;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.85rem;
    background: white;
    transition: all 0.3s ease;
  }

  .form-control:focus, .form-select:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.1);
  }

  .form-control-sm, .form-select-sm {
    padding: 0.375rem 0.5rem;
    font-size: 0.8rem;
  }

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
  }

  .btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.8rem;
  }

  .btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
  }

  .btn-success:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    color: white;
  }

  .btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
  }

  .btn-danger:hover {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    color: white;
  }

  .alert {
    border-radius: 0.75rem;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    border: none;
    font-weight: 500;
  }

  .alert-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
    border: 1px solid rgba(16, 185, 129, 0.2);
  }

  .alert-danger {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
    border: 1px solid rgba(239, 68, 68, 0.2);
  }

  .badge {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 500;
    padding: 0.4rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .badge.bg-warning {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%) !important;
    color: #92400e;
  }

  .badge.bg-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
    color: white;
  }

  .badge.bg-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
    color: white;
  }

  .badge.bg-secondary {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%) !important;
    color: white;
  }

  .action-forms {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
  }

  .verification-form {
    background: rgba(249, 250, 251, 0.8);
    border-radius: 0.75rem;
    padding: 1rem;
    border: 1px solid rgba(229, 231, 235, 0.6);
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .page-header {
      padding: 1.5rem 1rem;
    }
    
    .page-header h2 {
      font-size: 1.5rem;
    }
    
    .content-section {
      padding: 1.5rem 1rem;
    }
    
    .table thead th,
    .table tbody td {
      padding: 0.75rem 0.5rem;
      font-size: 0.8rem;
    }

    .action-forms {
      gap: 0.5rem;
    }

    .verification-form {
      padding: 0.75rem;
    }
  }

  /* Professional spacing and layout */
  .container-fluid {
    padding: 0.5rem 1.5rem 2rem 1.5rem !important;
    margin-top: 0 !important;
  }

  /* Empty state styling */
  .empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: #6b7280;
  }

  .empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
  }

  /* Enhanced styles for bulk operations */
  .stats-card {
    background: rgba(255,255,255,0.9);
    border-radius: 0.75rem;
    padding: 1rem 1.5rem;
    text-align: center;
    border: 1px solid rgba(226, 232, 240, 0.6);
    backdrop-filter: blur(10px);
  }

  .stats-card small {
    display: block;
    color: #6b7280;
    font-size: 0.75rem;
    margin-bottom: 0.25rem;
  }

  .stats-card strong {
    font-size: 1.25rem;
    color: #1f2937;
  }

  .bulk-actions-panel {
    border: 2px dashed #d1d5db;
    transition: all 0.3s ease;
  }

  .bulk-actions-panel.active {
    border-color: #10b981;
    background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%) !important;
  }

  .compact-form .form-row {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
  }

  .compact-form .form-group {
    flex: 1;
  }

  .compact-form .form-control,
  .compact-form .form-select {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
  }

  .compact-form textarea {
    resize: none;
  }

  .wholesaler-summary {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    border-radius: 0.75rem;
    padding: 1.5rem;
    border: 1px solid #93c5fd;
    margin-bottom: 1rem;
  }

  .wholesaler-item {
    background: white;
    border-radius: 0.5rem;
    padding: 1rem;
    margin-bottom: 0.75rem;
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
  }

  .wholesaler-item:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }

  .wholesaler-item h6 {
    color: #1e40af;
    margin-bottom: 0.5rem;
  }

  .price-highlight {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-weight: 600;
  }

  /* Role-based styling */
  .tr-wholesaler {
    background: rgba(59, 130, 246, 0.05);
  }

  .tr-retailer {
    background: rgba(16, 185, 129, 0.05);
  }

  /* Responsive enhancements */
  @media (max-width: 1200px) {
    .table thead th,
    .table tbody td {
      padding: 0.5rem 0.25rem;
      font-size: 0.8rem;
    }

    .compact-form .form-row {
      flex-direction: column;
      gap: 0.25rem;
    }

    .stats-card {
      padding: 0.75rem 1rem;
    }
  }

  @media (max-width: 768px) {
    .page-header .d-flex {
      flex-direction: column;
      gap: 1rem;
    }

    .stats-card {
      margin: 0.25rem;
    }

    .bulk-actions-panel .row {
      flex-direction: column;
    }

    .bulk-actions-panel .col-md-3,
    .bulk-actions-panel .col-md-4,
    .bulk-actions-panel .col-md-2 {
      margin-bottom: 0.75rem;
    }
  }
</style>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<div class="container-fluid">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center">
        <i class="bi bi-truck me-3" style="font-size: 2.5rem;"></i>
        <div>
          <h2>Pending Sales Approvals</h2>
          <p>Review, verify, and update delivery status for all sales orders</p>
        </div>
      </div>
      <div class="d-flex gap-3">
        <div class="stats-card">
          <small>Total Orders</small>
          <strong>{{ $sales->count() }}</strong>
        </div>
        <div class="stats-card">
          <small>Total Value</small>
          <strong>UGX {{ number_format($sales->sum(function($sale) { return $sale->quantity * $sale->product->price; }), 2) }}</strong>
        </div>
      </div>
    </div>
  </div>

  <!-- Bulk Actions Section -->
  <div class="content-section mb-4">
    <div class="row">
      <div class="col-md-8">
        <h5><i class="bi bi-lightning-charge me-2"></i>Bulk Actions</h5>
        <p class="text-muted">Select orders and perform bulk operations</p>
      </div>
      <div class="col-md-4 text-end">
        <button type="button" class="btn btn-outline-primary me-2" onclick="selectAllOrders()">
          <i class="bi bi-check-all"></i> Select All
        </button>
        <button type="button" class="btn btn-outline-secondary" onclick="clearSelection()">
          <i class="bi bi-x-circle"></i> Clear
        </button>
      </div>
    </div>
    
    <div class="bulk-actions-panel mt-3 p-3 bg-light rounded" style="display: none;" id="bulkActionsPanel">
      <form id="bulkVerificationForm" action="{{ route('admin.sales.bulk-verify') }}" method="POST">
        @csrf
        <input type="hidden" name="selected_sales" id="selectedSalesInput">
        
        <div class="row">
          <div class="col-md-3">
            <label class="form-label">Bulk Delivery Status</label>
            <select name="bulk_delivery_status" class="form-select">
              <option value="">Select Status</option>
              <option value="dispatched">Dispatched</option>
              <option value="delivered">Delivered</option>
              <option value="pickup_arranged">Pickup Arranged</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Bulk Tracking Prefix</label>
            <input type="text" name="bulk_tracking_prefix" class="form-control" placeholder="TRK-">
          </div>
          <div class="col-md-4">
            <label class="form-label">Bulk Dispatch Notes</label>
            <input type="text" name="bulk_dispatch_log" class="form-control" placeholder="Bulk dispatch notes">
          </div>
          <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-success w-100" onclick="submitBulkVerification()">
              <i class="bi bi-check-circle"></i> Bulk Verify
            </button>
          </div>
        </div>
        
        <div class="mt-2">
          <small class="text-muted">Selected: <span id="selectedCount">0</span> orders | Total Value: $<span id="selectedTotal">0.00</span></small>
        </div>
      </form>
    </div>
  </div>

  <!-- Wholesaler Summary Section -->
  <div class="content-section mb-4" id="wholesalerSummary" style="display: none;">
    <h5><i class="bi bi-building me-2"></i>Wholesaler Order Summary</h5>
    <div id="wholesalerBreakdown"></div>
  </div>

  <!-- Content Section -->
  <div class="content-section">
    @if(session('success'))
      <div class="alert alert-success">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle me-2"></i>
        {{ session('error') }}
      </div>
    @endif

    <div class="table-container">
      <div class="table-responsive">
        <table class="table table-hover align-middle" id="salesTable">
          <thead>
            <tr>
              <th width="50">
                <input type="checkbox" class="form-check-input" id="selectAllCheckbox" onchange="toggleAllSelection()">
              </th>
              <th><i class="bi bi-hash me-2"></i>Order ID</th>
              <th><i class="bi bi-person me-2"></i>User</th>
              <th><i class="bi bi-person-badge me-2"></i>Role</th>
              <th><i class="bi bi-box me-2"></i>Product</th>
              <th><i class="bi bi-123 me-2"></i>Quantity</th>
              <th><i class="bi bi-currency-dollar me-2"></i>Unit Price</th>
              <th><i class="bi bi-calculator me-2"></i>Total</th>
              <th><i class="bi bi-calendar me-2"></i>Date</th>
              <th><i class="bi bi-info-circle me-2"></i>Status</th>
              <th><i class="bi bi-gear me-2"></i>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($sales as $sale)
            @php
              $userRole = $sale->user?->getCurrentRole() ?? 'customer';
              $unitPrice = $sale->product?->getPriceForUser($sale->user) ?? $sale->product?->price ?? 0;
              $totalPrice = $unitPrice * $sale->quantity;
            @endphp
            <tr data-sale-id="{{ $sale->id }}" data-user-role="{{ $userRole }}" data-total="{{ $totalPrice }}">
              <td>
                <input type="checkbox" class="form-check-input sale-checkbox" 
                       value="{{ $sale->id }}" 
                       data-total="{{ $totalPrice }}"
                       data-user="{{ $sale->user->name ?? 'N/A' }}"
                       data-role="{{ $userRole }}"
                       onchange="updateSelection()">
              </td>
              <td><strong>#{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</strong></td>
              <td>{{ $sale->user->name ?? 'N/A' }}</td>
              <td>
                <span class="badge bg-{{ $userRole === 'wholesaler' ? 'primary' : ($userRole === 'retailer' ? 'info' : 'secondary') }}">
                  {{ ucfirst($userRole) }}
                </span>
              </td>
              <td>{{ $sale->product->name ?? 'N/A' }}</td>
              <td>{{ $sale->quantity ?? '-' }}</td>
              <td>UGX {{ number_format($unitPrice, 2) }}</td>
              <td>
                <strong class="text-{{ $userRole === 'wholesaler' ? 'primary' : 'dark' }}">
                  UGX {{ number_format($totalPrice, 2) }}
                </strong>
              </td>
              <td>{{ $sale->created_at ? $sale->created_at->format('M d, Y H:i') : '-' }}</td>
              <td>
                @if($sale->status === 'pending')
                  <span class="badge bg-warning">Pending</span>
                @elseif($sale->status === 'approved')
                  <span class="badge bg-success">Approved</span>
                @elseif($sale->status === 'rejected')
                  <span class="badge bg-danger">Rejected</span>
                @else
                  <span class="badge bg-secondary">{{ ucfirst($sale->status) }}</span>
                @endif
              </td>
              <td>
                <div class="action-forms">
                  <div class="verification-form">
                    <form action="{{ route('admin.sales.verify', $sale->id) }}" method="POST" class="compact-form">
                      @csrf
                      <div class="form-row">
                        <div class="form-group">
                          <select name="delivery_status" class="form-select form-select-sm">
                            <option value="pending" {{ $sale->delivery_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="dispatched" {{ $sale->delivery_status == 'dispatched' ? 'selected' : '' }}>Dispatched</option>
                            <option value="delivered" {{ $sale->delivery_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="pickup_arranged" {{ $sale->delivery_status == 'pickup_arranged' ? 'selected' : '' }}>Pickup Arranged</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <input type="text" name="tracking_code" class="form-control form-control-sm" 
                                 value="{{ $sale->tracking_code }}" placeholder="Tracking">
                        </div>
                      </div>
                      <div class="form-group mt-1">
                        <textarea name="dispatch_log" class="form-control form-control-sm" rows="1" 
                                  placeholder="Dispatch notes">{{ $sale->dispatch_log }}</textarea>
                      </div>
                      <div class="btn-group mt-2" role="group">
                        <button type="submit" class="btn btn-success btn-sm">
                          <i class="bi bi-check-circle"></i> Verify
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" 
                                onclick="rejectSale({{ $sale->id }})">
                          <i class="bi bi-x-circle"></i> Reject
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="11" class="empty-state">
                <i class="bi bi-inbox"></i>
                <h5>No pending sales approvals</h5>
                <p>All sales orders are currently processed.</p>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<script>
let selectedSales = [];

function updateSelection() {
    selectedSales = [];
    let totalValue = 0;
    const checkboxes = document.querySelectorAll('.sale-checkbox:checked');
    
    checkboxes.forEach(checkbox => {
        selectedSales.push(checkbox.value);
        totalValue += parseFloat(checkbox.dataset.total);
    });
    
    document.getElementById('selectedCount').textContent = selectedSales.length;
    document.getElementById('selectedTotal').textContent = totalValue.toFixed(2);
    document.getElementById('selectedSalesInput').value = selectedSales.join(',');
    
    const bulkPanel = document.getElementById('bulkActionsPanel');
    if (selectedSales.length > 0) {
        bulkPanel.style.display = 'block';
        bulkPanel.classList.add('active');
        updateWholesalerSummary();
    } else {
        bulkPanel.style.display = 'none';
        bulkPanel.classList.remove('active');
        document.getElementById('wholesalerSummary').style.display = 'none';
    }
}

function toggleAllSelection() {
    const selectAll = document.getElementById('selectAllCheckbox');
    const checkboxes = document.querySelectorAll('.sale-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    
    updateSelection();
}

function selectAllOrders() {
    document.getElementById('selectAllCheckbox').checked = true;
    toggleAllSelection();
}

function clearSelection() {
    document.getElementById('selectAllCheckbox').checked = false;
    toggleAllSelection();
}

function updateWholesalerSummary() {
    const checkboxes = document.querySelectorAll('.sale-checkbox:checked');
    const wholesalerData = {};
    
    checkboxes.forEach(checkbox => {
        const role = checkbox.dataset.role;
        const user = checkbox.dataset.user;
        const total = parseFloat(checkbox.dataset.total);
        
        if (role === 'wholesaler') {
            if (!wholesalerData[user]) {
                wholesalerData[user] = { count: 0, total: 0 };
            }
            wholesalerData[user].count++;
            wholesalerData[user].total += total;
        }
    });
    
    const summaryDiv = document.getElementById('wholesalerSummary');
    const breakdownDiv = document.getElementById('wholesalerBreakdown');
    
    if (Object.keys(wholesalerData).length > 0) {
        let html = '<div class="wholesaler-summary">';
        html += '<h6><i class="bi bi-building me-2"></i>Wholesaler Orders Breakdown</h6>';
        
        Object.entries(wholesalerData).forEach(([user, data]) => {
            html += `
                <div class="wholesaler-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">${user}</h6>
                            <small class="text-muted">${data.count} orders selected</small>
                        </div>
                        <div class="text-end">
                            <div class="price-highlight">
                                UGX ${data.total.toFixed(2)}
                            </div>
                            <small class="text-muted">Total Value</small>
                        </div>
                    </div>
                </div>
            `;
        });
        
        html += '</div>';
        breakdownDiv.innerHTML = html;
        summaryDiv.style.display = 'block';
    } else {
        summaryDiv.style.display = 'none';
    }
}

function submitBulkVerification() {
    if (selectedSales.length === 0) {
        alert('Please select at least one order to verify.');
        return;
    }
    
    const form = document.getElementById('bulkVerificationForm');
    const deliveryStatus = form.bulk_delivery_status.value;
    
    if (!deliveryStatus) {
        alert('Please select a delivery status for bulk verification.');
        return;
    }
    
    if (confirm(`Are you sure you want to bulk verify ${selectedSales.length} orders?`)) {
        form.submit();
    }
}

function rejectSale(saleId) {
    if (confirm('Are you sure you want to reject this sale?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/sales/${saleId}/reject`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
        
        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }
}

// Auto-generate tracking codes
document.addEventListener('DOMContentLoaded', function() {
    const trackingInputs = document.querySelectorAll('input[name="tracking_code"]');
    trackingInputs.forEach(input => {
        if (!input.value) {
            input.addEventListener('focus', function() {
                if (!this.value) {
                    const saleId = this.closest('tr').dataset.saleId;
                    this.value = `TRK-${new Date().getFullYear()}${String(new Date().getMonth() + 1).padStart(2, '0')}${String(new Date().getDate()).padStart(2, '0')}-${saleId}`;
                }
            });
        }
    });
    
    // Highlight wholesaler rows
    document.querySelectorAll('tr[data-user-role="wholesaler"]').forEach(row => {
        row.classList.add('tr-wholesaler');
    });
    
    document.querySelectorAll('tr[data-user-role="retailer"]').forEach(row => {
        row.classList.add('tr-retailer');
    });
});
</script>
@endsection

@extends('layouts.app')

@section('content')
<style>
  /* Modern Professional Stock History Styling */
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

  .filter-section .form-control, .filter-section .form-select {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
  }

  .filter-section .form-control:focus, .filter-section .form-select:focus {
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

  .status-badge.add {
    background: #dcfce7;
    color: #166534;
  }

  .status-badge.deduct {
    background: #fee2e2;
    color: #991b1b;
  }

  .status-badge.add_from_po, .status-badge.transfer {
    background: #dbeafe;
    color: #1e40af;
  }

  /* Item Type Badges */
  .item-badge {
    padding: 0.25rem 0.625rem;
    border-radius: 0.375rem;
    font-size: 0.7rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.025em;
    margin-right: 0.5rem;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
  }

  .item-badge.product {
    background: #ede9fe;
    color: #6b21a8;
  }

  .item-badge.raw-material {
    background: #e0f2fe;
    color: #0369a1;
  }

  /* User Name Styling */
  .user-name {
    font-weight: 500;
    color: #1f2937;
  }

  /* Date Styling */
  .date-cell {
    color: #6b7280;
    font-size: 0.8rem;
  }

  /* Quantity Styling */
  .quantity {
    font-weight: 600;
    color: #374151;
  }

  /* Note Styling */
  .note-cell {
    max-width: 200px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
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

    .status-badge, .item-badge {
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
    font-size: 4rem;
    color: #a78bfa;
    margin-bottom: 1.5rem;
  }

  .empty-state h5 {
    color: #374151;
    margin-bottom: 0.75rem;
    font-weight: 600;
    font-size: 1.25rem;
  }

  .empty-state p {
    margin: 0;
    font-size: 0.875rem;
    max-width: 400px;
    margin: 0 auto;
    line-height: 1.5;
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

  .btn-secondary {
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    color: #475569;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .btn-secondary:hover {
    background: #e2e8f0;
    border-color: #cbd5e1;
    color: #334155;
    transform: translateY(-2px);
  }

  /* Pagination Enhancement */
  .pagination {
    margin: 0;
  }

  .pagination .page-link {
    border: 1px solid #e5e7eb;
    color: #374151;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 0.5rem;
    margin: 0 0.25rem;
    transition: all 0.2s ease;
  }

  .pagination .page-link:hover {
    background: #f3f4f6;
    border-color: #d1d5db;
    transform: translateY(-1px);
  }

  .pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
    border-color: #7c3aed;
  }
</style>
<div class="container-fluid py-4">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h4><i class="bi bi-clock-history me-2"></i>Stock History</h4>
        <p class="mb-0 opacity-75">Complete inventory changes and audit logs</p>
      </div>
      <a href="{{ route('dashboard') }}" class="btn">
        <i class="bi bi-house-door me-1"></i>Home
      </a>
    </div>
  </div>

  <!-- Filter Section -->
  <div class="filter-section">
    <form method="GET" action="{{ route('inventory.history') }}" class="row g-3 align-items-end">
      <div class="col-md-2">
        <label for="action" class="form-label">Action Type</label>
        <select name="action" id="action" class="form-select">
          <option value="">All Actions</option>
          <option value="add" {{ request('action') === 'add' ? 'selected' : '' }}>Add</option>
          <option value="deduct" {{ request('action') === 'deduct' ? 'selected' : '' }}>Deduct</option>
          <option value="add_from_po" {{ request('action') === 'add_from_po' ? 'selected' : '' }}>Add from PO</option>
          <option value="transfer" {{ request('action') === 'transfer' ? 'selected' : '' }}>Transfer</option>
        </select>
      </div>
      <div class="col-md-2">
        <label for="item_type" class="form-label">Item Type</label>
        <select name="item_type" id="item_type" class="form-select">
          <option value="">All Items</option>
          <option value="product" {{ request('item_type') === 'product' ? 'selected' : '' }}>Products</option>
          <option value="raw_material" {{ request('item_type') === 'raw_material' ? 'selected' : '' }}>Raw Materials</option>
        </select>
      </div>
      <div class="col-md-2">
        <label for="date_from" class="form-label">From</label>
        <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
      </div>
      <div class="col-md-2">
        <label for="date_to" class="form-label">To</label>
        <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">
          <i class="bi bi-search me-1"></i>Filter
        </button>
      </div>
      <div class="col-md-2">
        <a href="{{ route('inventory.history') }}" class="btn btn-secondary w-100">
          <i class="bi bi-arrow-clockwise me-1"></i>Clear
        </a>
      </div>
    </form>
  </div>

  <!-- Stock History Table -->
  <div class="card table-card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table modern-table">
          <thead>
            <tr>
              <th><i class="bi bi-calendar"></i>Date</th>
              <th><i class="bi bi-person"></i>User</th>
              <th><i class="bi bi-box"></i>Item</th>
              <th><i class="bi bi-archive"></i>Batch</th>
              <th><i class="bi bi-arrow-repeat"></i>Action</th>
              <th><i class="bi bi-dash-circle"></i>Qty Before</th>
              <th><i class="bi bi-plus-circle"></i>Qty After</th>
              <th><i class="bi bi-chat-left-text"></i>Note</th>
            </tr>
          </thead>
          <tbody>
            @forelse($histories as $history)
              <tr>
                <td>
                  <span class="date-cell">{{ $history->created_at->format('M d, Y H:i') }}</span>
                </td>
                <td>
                  <span class="user-name">{{ $history->user->name ?? 'System' }}</span>
                </td>
                <td>
                  @if($history->inventory->product)
                    <span class="item-badge product">
                      <i class="bi bi-cube-fill"></i>Product
                    </span>
                    {{ $history->inventory->product->name }}
                  @elseif($history->inventory->rawMaterial)
                    <span class="item-badge raw-material">
                      <i class="bi bi-gear-fill"></i>Raw Material
                    </span>
                    {{ $history->inventory->rawMaterial->name }}
                  @else
                    <span class="text-muted">N/A</span>
                  @endif
                </td>
                <td>
                  <span class="text-muted">{{ $history->inventory->batch_id ?? 'N/A' }}</span>
                </td>
                <td>
                  <span class="status-badge {{ strtolower($history->action) }}">
                    @if($history->action === 'add')
                      <i class="bi bi-plus-lg"></i>
                    @elseif($history->action === 'deduct')
                      <i class="bi bi-dash-lg"></i>
                    @else
                      <i class="bi bi-arrow-repeat"></i>
                    @endif
                    {{ ucfirst(str_replace('_', ' ', $history->action)) }}
                  </span>
                </td>
                <td>
                  <span class="quantity">{{ number_format($history->quantity_before) }}</span>
                </td>
                <td>
                  <span class="quantity">{{ number_format($history->quantity_after) }}</span>
                </td>
                <td>
                  <span class="note-cell" title="{{ $history->note }}">{{ $history->note }}</span>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8">
                  <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h5>No Stock History Found</h5>
                    <p>No inventory changes have been recorded yet or no records match your filter criteria.</p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      
      <!-- Pagination Links -->
      @if($histories->hasPages())
        <div class="d-flex justify-content-center mt-4">
          {{ $histories->links() }}
        </div>
      @endif
    </div>
  </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

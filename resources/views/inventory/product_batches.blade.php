@extends('layouts.app')

@section('content')
<style>
  /* Modern Professional Product Details Styling */
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

  .page-header .product-name {
    color: #3b82f6;
    font-weight: 700;
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

  /* Section Cards */
  .section-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    border: none;
    margin-bottom: 2rem;
  }

  .section-header {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: white;
    padding: 1.25rem 1.5rem;
    border: none;
    margin: 0;
  }

  .section-header h6 {
    margin: 0;
    font-weight: 600;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .section-header i {
    font-size: 1.1rem;
  }

  .section-body {
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

  /* Quantity Styling */
  .quantity {
    font-weight: 600;
    color: #374151;
  }

  .unit-label {
    color: #3b82f6;
    font-weight: 500;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-left: 0.25rem;
  }

  /* Batch ID Styling */
  .batch-id {
    font-family: 'Monaco', 'Consolas', monospace;
    background: #f3f4f6;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.8rem;
    color: #374151;
    font-weight: 500;
  }

  /* Action Badges */
  .action-badge {
    padding: 0.375rem 0.875rem;
    border-radius: 0.5rem;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: capitalize;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
  }

  .action-badge.add {
    background: #dcfce7;
    color: #166534;
  }

  .action-badge.deduct {
    background: #fee2e2;
    color: #991b1b;
  }

  .action-badge.out {
    background: #fef3c7;
    color: #92400e;
  }

  /* Date Styling */
  .date-text {
    color: #6b7280;
    font-size: 0.8rem;
  }

  /* User Name Styling */
  .user-name {
    font-weight: 500;
    color: #1f2937;
  }

  /* Note Styling */
  .note-text {
    font-style: italic;
    color: #6b7280;
    font-size: 0.8rem;
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .page-header {
      padding: 1.5rem;
    }

    .page-header h4 {
      font-size: 1.25rem;
    }

    .section-header {
      padding: 1rem 1.25rem;
    }

    .modern-table thead th,
    .modern-table tbody td {
      padding: 1rem;
      font-size: 0.8rem;
    }

    .note-text {
      max-width: 150px;
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

  /* Gradient Variants for Different Sections */
  .section-header.inventory {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  }

  .section-header.sales {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
  }

  .section-header.movements {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
  }
</style>

<div class="container-fluid py-4">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h4><i class="bi bi-cube me-2"></i>Product Details: <span class="product-name">{{ $product->name }}</span></h4>
        <p class="mb-0 opacity-75">Detailed inventory tracking and batch information</p>
      </div>
      <a href="{{ route('inventory.index') }}" class="btn">
        <i class="bi bi-arrow-left me-1"></i>Back to Inventory
      </a>
    </div>
  </div>

  <!-- Batch Inventory Section -->
  <div class="section-card">
    <div class="section-header inventory">
      <h6><i class="bi bi-archive"></i>Batch Inventory (Stock In)</h6>
    </div>
    <div class="section-body">
      <div class="table-responsive">
        <table class="table modern-table">
          <thead>
            <tr>
              <th><i class="bi bi-upc-scan"></i>Batch ID</th>
              <th><i class="bi bi-123"></i>Quantity</th>
              <th><i class="bi bi-calendar-x"></i>Expiry Date</th>
              <th><i class="bi bi-calendar-plus"></i>Date Added</th>
            </tr>
          </thead>
          <tbody>
            @forelse($product->batches as $batch)
            <tr>
              <td>
                <span class="batch-id">{{ $batch->batch_id }}</span>
              </td>
              <td>
                <span class="quantity">{{ $batch->quantity }}</span><span class="unit-label">pcs</span>
              </td>
              <td>
                <span class="date-text">{{ $batch->expiry_date ? \Carbon\Carbon::parse($batch->expiry_date)->format('M d, Y') : '-' }}</span>
              </td>
              <td>
                <span class="date-text">{{ $batch->created_at->format('M d, Y H:i') }}</span>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4">
                <div class="empty-state">
                  <i class="bi bi-archive"></i>
                  <h5>No Batches Found</h5>
                  <p>No batch inventory records exist for this product.</p>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Sales/Outgoing Stock Section -->
  <div class="section-card">
    <div class="section-header sales">
      <h6><i class="bi bi-cart-check"></i>Sales / Outgoing Stock</h6>
    </div>
    <div class="section-body">
      <div class="table-responsive">
        <table class="table modern-table">
          <thead>
            <tr>
              <th><i class="bi bi-hash"></i>Order ID</th>
              <th><i class="bi bi-upc-scan"></i>Batch ID</th>
              <th><i class="bi bi-arrow-up-right"></i>Type</th>
              <th><i class="bi bi-123"></i>Quantity</th>
              <th><i class="bi bi-person"></i>Sold To</th>
              <th><i class="bi bi-calendar"></i>Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse($sales as $sale)
            <tr>
              <td>
                <span class="font-weight-bold">#{{ $sale->id }}</span>
              </td>
              <td>
                <span class="text-muted">-</span>
              </td>
              <td>
                <span class="action-badge out">Out</span>
              </td>
              <td>
                <span class="quantity">{{ $sale->quantity }}</span><span class="unit-label">pcs</span>
              </td>
              <td>
                <span class="user-name">{{ $sale->user->name ?? 'N/A' }}</span>
              </td>
              <td>
                <span class="date-text">{{ $sale->created_at->format('M d, Y H:i') }}</span>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6">
                <div class="empty-state">
                  <i class="bi bi-cart-x"></i>
                  <h5>No Sales Found</h5>
                  <p>No sales records exist for this product.</p>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Stock Movement Records Section -->
  <div class="section-card">
    <div class="section-header movements">
      <h6><i class="bi bi-clock-history"></i>Stock Movement Records</h6>
    </div>
    <div class="section-body">
      <div class="table-responsive">
        <table class="table modern-table">
          <thead>
            <tr>
              <th><i class="bi bi-calendar"></i>Date</th>
              <th><i class="bi bi-upc-scan"></i>Batch ID</th>
              <th><i class="bi bi-arrow-repeat"></i>Action</th>
              <th><i class="bi bi-dash-circle"></i>Qty Before</th>
              <th><i class="bi bi-plus-circle"></i>Qty After</th>
              <th><i class="bi bi-person"></i>User</th>
              <th><i class="bi bi-chat-text"></i>Note</th>
            </tr>
          </thead>
          <tbody>
            @forelse($movements as $move)
            <tr>
              <td>
                <span class="date-text">{{ $move->created_at->format('M d, Y H:i') }}</span>
              </td>
              <td>
                <span class="batch-id">{{ $move->inventory->batch_id ?? '-' }}</span>
              </td>
              <td>
                <span class="action-badge {{ strtolower($move->action) }}">{{ ucfirst($move->action) }}</span>
              </td>
              <td>
                <span class="quantity">{{ $move->quantity_before }}</span><span class="unit-label">pcs</span>
              </td>
              <td>
                <span class="quantity">{{ $move->quantity_after }}</span><span class="unit-label">pcs</span>
              </td>
              <td>
                <span class="user-name">{{ $move->user->name ?? 'N/A' }}</span>
              </td>
              <td>
                <span class="note-text" title="{{ $move->note }}">{{ $move->note }}</span>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7">
                <div class="empty-state">
                  <i class="bi bi-clock-history"></i>
                  <h5>No Movement Records</h5>
                  <p>No stock movement history exists for this product.</p>
                </div>
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
@endsection

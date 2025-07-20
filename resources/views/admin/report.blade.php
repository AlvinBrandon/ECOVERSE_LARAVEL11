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
    margin-right: 0.5rem;
  }

  .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  }

  .btn-verify, .btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
  }

  .btn-verify:hover, .btn-success:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    color: white;
  }

  .btn-reject, .btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
  }

  .btn-reject:hover, .btn-danger:hover {
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

  .action-buttons {
    display: flex;
    gap: 0.5rem;
    align-items: center;
  }

  .action-buttons form {
    margin: 0;
  }

  /* Order ID styling */
  .order-id {
    font-weight: 600;
    color: #1f2937;
  }

  /* Customer name styling */
  .customer-name {
    color: #374151;
    font-weight: 500;
  }

  /* Product name styling */
  .product-name {
    color: #4b5563;
  }

  /* Quantity styling */
  .quantity {
    font-weight: 600;
    color: #059669;
  }

  /* Date styling */
  .date {
    color: #6b7280;
    font-size: 0.85rem;
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

    .action-buttons {
      flex-direction: column;
      gap: 0.25rem;
    }

    .btn {
      width: 100%;
      margin-right: 0;
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
</style>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<div class="container-fluid">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center">
      <i class="bi bi-check-circle me-3" style="font-size: 2.5rem;"></i>
      <div>
        <h2>Pending Orders for Verification</h2>
        <p>Review and verify pending customer orders</p>
      </div>
    </div>
  </div>

  <!-- Content Section -->
  <div class="content-section">
    @if(session('success'))
      <div class="alert alert-success">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
      </div>
    @endif

    <div class="table-container">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th><i class="bi bi-hash me-2"></i>Order ID</th>
              <th><i class="bi bi-person me-2"></i>Customer</th>
              <th><i class="bi bi-box me-2"></i>Product</th>
              <th><i class="bi bi-123 me-2"></i>Quantity</th>
              <th><i class="bi bi-info-circle me-2"></i>Status</th>
              <th><i class="bi bi-calendar me-2"></i>Date</th>
              <th><i class="bi bi-gear me-2"></i>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($sales as $sale)
              <tr>
                <td><span class="order-id">#{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</span></td>
                <td><span class="customer-name">{{ $sale->user->name ?? 'Guest' }}</span></td>
                <td><span class="product-name">{{ $sale->product->name ?? 'N/A' }}</span></td>
                <td><span class="quantity">{{ $sale->quantity }}</span></td>
                <td><span class="badge bg-warning">{{ ucfirst($sale->status) }}</span></td>
                <td><span class="date">{{ $sale->created_at->format('Y-m-d') }}</span></td>
                <td>
                  <div class="action-buttons">
                    <form method="POST" action="{{ route('admin.sales.verify', $sale->id) }}">
                      @csrf
                      <button type="submit" class="btn btn-verify">
                        <i class="bi bi-check-lg"></i>
                        Verify
                      </button>
                    </form>
                    <form method="POST" action="{{ route('admin.sales.reject', $sale->id) }}">
                      @csrf
                      <button type="submit" class="btn btn-reject" onclick="return confirm('Are you sure you want to reject this order?')">
                        <i class="bi bi-x-lg"></i>
                        Reject
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="empty-state">
                  <i class="bi bi-inbox"></i>
                  <h5>No pending orders found</h5>
                  <p>All orders have been processed.</p>
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

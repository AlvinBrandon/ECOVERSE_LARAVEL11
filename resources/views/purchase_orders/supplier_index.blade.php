@extends('layouts.app')

@section('content')
<style>
  /* Global Poppins Font Implementation */
  * {
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
  }

  body, .main-content, .container-fluid, .container {
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
    gap: 1rem;
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
    opacity: 0.9;
  }

  .content-section {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.12);
    border: 1px solid rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
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
  }

  .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    text-decoration: none;
  }

  .btn-success, .btn-sm.btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
  }

  .btn-success:hover, .btn-sm.btn-success:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    color: white;
  }

  .btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.8rem;
  }

  .alert {
    border-radius: 0.75rem;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    border: none;
    font-weight: 500;
    font-family: 'Poppins', sans-serif !important;
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

  .badge.bg-secondary {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%) !important;
  }

  .badge.bg-info {
    background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
  }

  .badge.bg-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
  }

  .badge.bg-dark {
    background: linear-gradient(135deg, #374151 0%, #1f2937 100%) !important;
  }

  .form-control {
    font-family: 'Poppins', sans-serif !important;
    border: 2px solid rgba(226, 232, 240, 0.6);
    border-radius: 0.5rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.85rem;
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(5px);
    transition: all 0.3s ease;
  }

  .form-control:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    background: white;
    outline: none;
  }

  .form-control-sm {
    padding: 0.375rem 0.5rem;
    font-size: 0.8rem;
  }

  .delivery-form {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
  }

  .delivery-form input {
    flex: 1;
    min-width: 200px;
  }

  /* Order ID styling */
  .order-id {
    font-weight: 600;
    color: #1f2937;
  }

  /* Material name styling */
  .material-name {
    color: #374151;
    font-weight: 500;
  }

  /* Price styling */
  .price {
    font-weight: 600;
    color: #059669;
  }

  /* Quantity styling */
  .quantity {
    font-weight: 600;
    color: #6366f1;
  }

  /* Invoice link styling */
  .invoice-link {
    color: #6366f1;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
  }

  .invoice-link:hover {
    color: #4f46e5;
    text-decoration: underline;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .page-header {
      padding: 1.5rem 1rem;
      flex-direction: column;
      text-align: center;
      gap: 0.5rem;
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

    .delivery-form {
      flex-direction: column;
      align-items: stretch;
      gap: 0.5rem;
    }

    .delivery-form input {
      min-width: auto;
    }

    .btn {
      width: 100%;
    }
  }

  /* Professional spacing and layout */
  .container {
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

<div class="container">
  <!-- Page Header -->
  <div class="page-header">
    <i class="bi bi-truck"></i>
    <div>
      <h2>My Purchase Orders</h2>
      <p>View and deliver your assigned purchase orders</p>
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
              <th><i class="bi bi-hash me-2"></i>ID</th>
              <th><i class="bi bi-box me-2"></i>Material</th>
              <th><i class="bi bi-123 me-2"></i>Quantity</th>
              <th><i class="bi bi-currency-exchange me-2"></i>Price (UGX)</th>
              <th><i class="bi bi-info-circle me-2"></i>Status</th>
              <th><i class="bi bi-file-earmark-text me-2"></i>Invoice</th>
              <th><i class="bi bi-gear me-2"></i>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($orders as $order)
              <tr>
                <td><span class="order-id">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span></td>
                <td><span class="material-name">{{ $order->rawMaterial->name ?? 'N/A' }}</span></td>
                <td><span class="quantity">{{ $order->quantity }}</span></td>
                <td><span class="price">UGX {{ number_format($order->price) }}</span></td>
                <td>
                  <span class="badge bg-{{ $order->status == 'pending' ? 'secondary' : ($order->status == 'delivered' ? 'info' : ($order->status == 'complete' ? 'success' : 'dark')) }}">
                    {{ ucfirst($order->status) }}
                  </span>
                </td>
                <td>
                  @if($order->invoice_path)
                    <a href="{{ asset('storage/' . $order->invoice_path) }}" target="_blank" class="invoice-link">
                      <i class="bi bi-file-earmark-pdf me-1"></i>View Invoice
                    </a>
                  @else
                    <span class="text-muted">No invoice</span>
                  @endif
                </td>
                <td>
                  @if($order->status == 'pending')
                    <form action="{{ route('supplier.purchase_orders.markDelivered', $order->id) }}" method="POST" enctype="multipart/form-data" class="delivery-form">
                      @csrf
                      <input type="file" name="invoice" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png" required>
                      <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to mark this order as delivered?')">
                        <i class="bi bi-check-lg"></i>
                        Mark Delivered
                      </button>
                    </form>
                  @else
                    <span class="text-muted">
                      <i class="bi bi-check-circle"></i>
                      Completed
                    </span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="empty-state">
                  <i class="bi bi-inbox"></i>
                  <h5>No purchase orders found</h5>
                  <p>You don't have any purchase orders assigned yet.</p>
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

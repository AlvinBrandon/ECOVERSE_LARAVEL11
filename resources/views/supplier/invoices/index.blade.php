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
    min-height: 100vh;
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
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
    font-size: 1.8rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
  }

  .stat-card .stat-value.text-success {
    color: #10b981 !important;
  }

  .stat-card .stat-value.text-warning {
    color: #f59e0b !important;
  }

  .stat-card .stat-value.text-danger {
    color: #dc2626 !important;
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

  .btn-primary {
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    color: white;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
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

  /* Badge Styling */
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
  }

  .badge.bg-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
  }

  .badge.bg-info {
    background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
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

  /* Action buttons container */
  .action-buttons {
    display: flex;
    gap: 0.5rem;
    align-items: center;
  }

  .action-buttons form {
    margin: 0;
  }

  /* Invoice specific styling */
  .invoice-number {
    font-weight: 600;
    color: #1f2937;
  }

  .po-number {
    color: #6366f1;
    font-weight: 500;
  }

  .amount {
    font-weight: 600;
    color: #059669;
  }

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
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
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
  .container {
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
    <div class="d-flex align-items-center">
      <i class="bi bi-receipt"></i>
      <div>
        <h2>My Invoices</h2>
        <p>Manage and track your submitted invoices</p>
      </div>
    </div>
    <div class="header-actions">
      <a href="{{ route('dashboard') }}" class="btn btn-outline-dark">
        <i class="bi bi-house-door"></i>
        Dashboard
      </a>
      <a href="{{ route('supplier.invoices.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i>
        Create Invoice
      </a>
    </div>
  </div>

  <!-- Analytics Section -->
  <div class="content-section">
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-header">
          <i class="bi bi-receipt me-2"></i>Total Invoices
        </div>
        <h3 class="stat-value">{{ $totalInvoices ?? 0 }}</h3>
      </div>
      <div class="stat-card">
        <div class="stat-header">
          <i class="bi bi-check-circle me-2"></i>Paid Invoices
        </div>
        <h3 class="stat-value text-success">{{ $paidInvoices ?? 0 }}</h3>
      </div>
      <div class="stat-card">
        <div class="stat-header">
          <i class="bi bi-clock me-2"></i>Pending Invoices
        </div>
        <h3 class="stat-value text-warning">{{ $pendingInvoices ?? 0 }}</h3>
      </div>
      <div class="stat-card">
        <div class="stat-header">
          <i class="bi bi-currency-exchange me-2"></i>Total Amount
        </div>
        <h3 class="stat-value text-success">UGX {{ number_format($totalAmount ?? 0) }}</h3>
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
      <div class="table-header">
        <span>
          <i class="bi bi-table me-2"></i>Invoice List
        </span>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th><i class="bi bi-receipt me-2"></i>Invoice #</th>
              <th><i class="bi bi-hash me-2"></i>PO #</th>
              <th><i class="bi bi-calendar me-2"></i>Date</th>
              <th><i class="bi bi-calendar-check me-2"></i>Due Date</th>
              <th><i class="bi bi-123 me-2"></i>Quantity</th>
              <th><i class="bi bi-currency-exchange me-2"></i>Amount</th>
              <th><i class="bi bi-info-circle me-2"></i>Status</th>
              <th><i class="bi bi-file-earmark me-2"></i>Document</th>
              <th><i class="bi bi-gear me-2"></i>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($invoices ?? [] as $invoice)
              <tr>
                <td><span class="invoice-number">{{ $invoice->invoice_number }}</span></td>
                <td><span class="po-number">#{{ str_pad($invoice->purchase_order_id, 6, '0', STR_PAD_LEFT) }}</span></td>
                <td>{{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') : '-' }}</td>
                <td>{{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') : '-' }}</td>
                <td>{{ $invoice->quantity_delivered ?? 0 }}</td>
                <td><span class="amount">UGX {{ number_format($invoice->total_amount ?? 0) }}</span></td>
                <td>
                  <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'pending' ? 'warning' : 'danger') }}">
                    {{ ucfirst($invoice->status ?? 'pending') }}
                  </span>
                </td>
                <td>
                  @if($invoice->invoice_file)
                    <a href="{{ asset('storage/' . $invoice->invoice_file) }}" target="_blank" class="invoice-link">
                      <i class="bi bi-file-earmark-pdf me-1"></i>View PDF
                    </a>
                  @else
                    <span class="text-muted">No file</span>
                  @endif
                </td>
                <td>
                  <div class="action-buttons">
                    @if($invoice->status == 'pending')
                      <a href="{{ route('supplier.invoices.edit', $invoice->id) }}" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i>
                        Edit
                      </a>
                    @endif
                    <a href="{{ route('supplier.invoices.show', $invoice->id) }}" class="btn btn-sm btn-primary">
                      <i class="bi bi-eye"></i>
                      View
                    </a>
                    @if($invoice->status == 'pending')
                      <form action="{{ route('supplier.invoices.destroy', $invoice->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this invoice?')">
                          <i class="bi bi-trash"></i>
                          Delete
                        </button>
                      </form>
                    @endif
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="empty-state">
                  <i class="bi bi-receipt"></i>
                  <h5>No invoices found</h5>
                  <p>You haven't created any invoices yet.</p>
                  <a href="{{ route('supplier.invoices.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i>
                    Create Your First Invoice
                  </a>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination -->
    @if(isset($invoices) && $invoices->hasPages())
      <div class="d-flex justify-content-center">
        {{ $invoices->links() }}
      </div>
    @endif
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

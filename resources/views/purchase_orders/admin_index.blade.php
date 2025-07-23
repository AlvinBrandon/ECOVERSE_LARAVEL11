@extends('layouts.app')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

body, .main-content, .container-fluid, .container {
    background-color: #f8fafc !important;
    font-family: 'Poppins', sans-serif;
}

.po-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.po-header h2 {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 2.5rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    margin-bottom: 0;
}

.po-header p {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    opacity: 0.9;
    font-size: 1.1rem !important;
    margin-bottom: 0;
}

.po-icon {
    font-size: 3rem;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
}

.po-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
    margin-bottom: 2rem;
    font-family: 'Poppins', sans-serif;
}

.table {
    font-family: 'Poppins', sans-serif;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
}

.table thead th {
    background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    color: #1e293b;
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1rem;
    border: none;
}

.table tbody td {
    padding: 1rem;
    vertical-align: middle;
    border-color: #e2e8f0;
    font-weight: 400;
}

.table tbody tr:hover {
    background-color: #f8fafc;
}

.badge {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.bg-secondary {
    background: linear-gradient(135deg, #64748b, #475569) !important;
}

.bg-info {
    background: linear-gradient(135deg, #06b6d4, #0891b2) !important;
}

.bg-success {
    background: linear-gradient(135deg, #10b981, #059669) !important;
}

.bg-dark {
    background: linear-gradient(135deg, #374151, #1f2937) !important;
}

.btn {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    border: none;
    transition: all 0.3s ease;
}

.btn-success {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.btn-success:hover {
    background: linear-gradient(135deg, #059669, #047857);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    color: white;
}

.btn-dark {
    background: linear-gradient(135deg, #374151, #1f2937);
    color: white;
}

.btn-dark:hover {
    background: linear-gradient(135deg, #1f2937, #111827);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(55, 65, 81, 0.3);
    color: white;
}

.alert-success {
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    border: 1px solid #86efac;
    color: #166534;
    border-radius: 10px;
    padding: 1rem;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
}

a {
    color: #3b82f6;
    text-decoration: none;
    font-weight: 500;
}

a:hover {
    color: #1d4ed8;
    text-decoration: underline;
}

/* Override any Bootstrap spacing */
.py-4 {
    padding-top: 0 !important;
    padding-bottom: 0 !important;
}
</style>
<div class="container py-4">
  <div class="po-header">
    <i class="bi bi-clipboard-check po-icon"></i>
    <div>
      <h2 class="mb-0">Purchase Orders (Admin)</h2>
      <p class="mb-0" style="font-size:1.1rem;">Review, verify, and mark purchase orders as paid.</p>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="po-card">
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered table-hover">
          <thead class="bg-light">
            <tr>
              <th>ID</th>
              <th>Supplier</th>
              <th>Material</th>
              <th>Quantity</th>
              <th>Price (UGX)</th>
              <th>Status</th>
              <th>Invoice</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
              <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->supplier->name ?? 'N/A' }}</td>
                <td>{{ $order->rawMaterial->name ?? 'N/A' }}</td>
                <td>{{ $order->quantity }}</td>
                <td>UGX {{ number_format($order->price) }}</td>
                <td><span class="badge bg-{{ $order->status == 'pending' ? 'secondary' : ($order->status == 'delivered' ? 'info' : ($order->status == 'complete' ? 'success' : 'dark')) }}">{{ ucfirst($order->status) }}</span></td>
                <td>
                  @if($order->invoice_path)
                    <button type="button" class="btn btn-sm btn-outline-success" onclick="showInvoiceInfo('{{ $order->id }}', '{{ $order->invoice_path }}')">
                      <i class="bi bi-file-earmark-check me-1"></i>Invoice Available
                    </button>
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </td>
                <td>
                  @if($order->status == 'delivered')
                    <form action="{{ route('admin.purchase_orders.verify', $order->id) }}" method="POST" class="d-inline">
                      @csrf
                      <button type="submit" class="btn btn-success btn-sm">Verify & Add to Stock</button>
                    </form>
                  @endif
                  @if($order->status == 'complete')
                    <form action="{{ route('admin.purchase_orders.markPaid', $order->id) }}" method="POST" class="d-inline">
                      @csrf
                      <button type="submit" class="btn btn-dark btn-sm">Mark as Paid</button>
                    </form>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Invoice Information Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="invoiceModalLabel">
          <i class="bi bi-file-earmark-pdf me-2"></i>Invoice Information
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success">
          <i class="bi bi-check-circle me-2"></i>
          <strong>Invoice Available for Review</strong><br>
          <small>The supplier has uploaded an invoice for this purchase order.</small>
        </div>
        <div class="row">
          <div class="col-sm-4"><strong>Purchase Order:</strong></div>
          <div class="col-sm-8" id="modal-order-id">-</div>
        </div>
        <div class="row mt-2">
          <div class="col-sm-4"><strong>Invoice File:</strong></div>
          <div class="col-sm-8" id="modal-invoice-file">-</div>
        </div>
        <div class="row mt-2">
          <div class="col-sm-4"><strong>Status:</strong></div>
          <div class="col-sm-8">
            <span class="badge bg-info">Ready for Verification</span>
          </div>
        </div>
        <div class="mt-3">
          <small class="text-muted">
            <i class="bi bi-info-circle me-1"></i>
            Note: Invoice files are stored securely and processed through the admin verification workflow.
          </small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
function showInvoiceInfo(orderId, invoicePath) {
    document.getElementById('modal-order-id').textContent = '#' + String(orderId).padStart(6, '0');
    document.getElementById('modal-invoice-file').textContent = invoicePath.split('/').pop() || 'Invoice file';
    
    const modal = new bootstrap.Modal(document.getElementById('invoiceModal'));
    modal.show();
}
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

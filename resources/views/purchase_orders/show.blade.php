@extends('layouts.app')

@section('content')
<style>
  body, .main-content, .container-fluid, .container {
    background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%) !important;
  }
  .dashboard-card, .po-card {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    box-shadow: 0 4px 24px rgba(16, 185, 129, 0.08);
    padding: 2rem 1.5rem;
    margin-bottom: 2rem;
    transition: box-shadow 0.2s, transform 0.2s;
  }
  .dashboard-card:hover, .po-card:hover {
    box-shadow: 0 8px 32px rgba(99,102,241,0.18), 0 2px 8px rgba(16,185,129,0.10);
    transform: translateY(-4px) scale(1.025);
    z-index: 2;
    cursor: pointer;
  }
  .po-header {
    background: linear-gradient(90deg, #6366f1 0%, #10b981 100%) !important;
    color: #fff !important;
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
    padding: 1.5rem 1.5rem 1rem 1.5rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
  }
  .po-icon {
    font-size: 2.5rem;
    margin-right: 1rem;
    vertical-align: middle;
  }
</style>
<div class="container py-4">
  <div class="po-header">
    <i class="bi bi-file-earmark-text po-icon"></i>
    <div>
      <h2 class="mb-0">Purchase Order #{{ $order->id }}</h2>
      <p class="mb-0" style="font-size:1.1rem;">Details for this purchase order.</p>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="po-card">
        <table class="table table-bordered">
          <tr><th>Supplier</th><td>{{ $order->supplier->name ?? 'N/A' }}</td></tr>
          <tr><th>Raw Material</th><td>{{ $order->rawMaterial->name ?? 'N/A' }}</td></tr>
          <tr><th>Quantity</th><td>{{ $order->quantity }}</td></tr>
          <tr><th>Price (UGX)</th><td>UGX {{ number_format($order->price) }}</td></tr>
          <tr><th>Status</th><td><span class="badge bg-{{ $order->status == 'pending' ? 'secondary' : ($order->status == 'delivered' ? 'info' : ($order->status == 'complete' ? 'success' : 'dark')) }}">{{ ucfirst($order->status) }}</span></td></tr>
          <tr><th>Created By</th><td>{{ $order->creator->name ?? 'N/A' }}</td></tr>
          <tr><th>Created At</th><td>{{ $order->created_at }}</td></tr>
          <tr><th>Delivered At</th><td>{{ $order->delivered_at ?? '-' }}</td></tr>
          <tr><th>Completed At</th><td>{{ $order->completed_at ?? '-' }}</td></tr>
          <tr><th>Paid At</th><td>{{ $order->paid_at ?? '-' }}</td></tr>
          <tr><th>Invoice</th><td>
            @if($order->invoice_path)
              <button type="button" class="btn btn-sm btn-outline-primary" onclick="showInvoiceInfo('{{ $order->id }}', '{{ $order->invoice_path }}')">
                <i class="bi bi-file-earmark-pdf me-1"></i>Invoice Uploaded ({{ basename($order->invoice_path) }})
              </button>
            @else
              <span class="text-muted">No invoice uploaded</span>
            @endif
          </td></tr>
        </table>
        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3"><i class="bi bi-arrow-return-left"></i> Back</a>
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
          <i class="bi bi-file-earmark-pdf me-2"></i>Invoice Details
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info">
          <i class="bi bi-file-earmark-check me-2"></i>
          <strong>Invoice Information</strong><br>
          <small>Invoice has been uploaded and is available for processing.</small>
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
            <span class="badge bg-primary">Invoice Uploaded</span>
          </div>
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

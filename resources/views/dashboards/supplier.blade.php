@extends('layouts.app')

@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
  
  * {
    font-family: 'Poppins', sans-serif;
  }
  
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #10b981 100%) !important;
    font-family: 'Poppins', sans-serif;
    color: #ffffff;
    min-height: 10vh;
  }

  
  /* Layout Structure */
  .supplier-layout {
    display: flex;
    min-height: 100vh;
    position: relative;
    padding: 2rem;
  }
  
  .supplier-main {
    flex: 1;
    background: transparent;
    max-width: 1400px;
    margin: 0 auto;
  }

  /* Welcome Message Styling */
  .welcome-message {
    background: rgba(255, 255, 255, 0.1) !important;
    backdrop-filter: blur(20px) !important;
    border: 1px solid rgba(16, 185, 129, 0.2) !important;
    color: #fff !important;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.15);
  }

  .welcome-message h5 {
    color: #ffffff !important;
    font-weight: 600;
    margin: 0;
    font-size: 1.25rem;
  }

  /* Dashboard Header */
  .dashboard-header {
    background: rgba(255, 255, 255, 0.1) !important;
    backdrop-filter: blur(20px) !important;
    border: 1px solid rgba(16, 185, 129, 0.2) !important;
    color: #fff !important;
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.15);
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .dashboard-header h2 {
    font-weight: 700;
    font-size: 2.5rem;
    color: #ffffff;
    margin-bottom: 0.5rem;
    line-height: 1.2;
  }

  .dashboard-header p {
    color: rgba(255, 255, 255, 0.8);
    margin: 0;
    font-size: 1.1rem;
  }

  .ecoverse-logo {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid rgba(255,255,255,0.3);
    background: white;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }

  /* Dashboard Cards */
  .dashboard-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    height: 100%;
  }

  .dashboard-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #10b981, #059669);
  }

  .dashboard-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(16, 185, 129, 0.25);
    border-color: rgba(16, 185, 129, 0.4);
  }

  .dashboard-card h5 {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 600;
    color: #ffffff;
    margin: 1rem 0 0.75rem 0;
    font-size: 1.25rem;
  }

  .dashboard-card p {
    font-family: 'Poppins', sans-serif !important;
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1.5rem;
  }

  .dashboard-card i {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color: #10b981;
  }

  /* Button Styling */
  .btn {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 500;
    border-radius: 0.75rem;
    padding: 0.75rem 1.5rem;
    border: none;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 16px rgba(16, 185, 129, 0.3);
    cursor: pointer;
    gap: 0.5rem;
    font-size: 0.9rem;
  }

  .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.4);
    text-decoration: none;
  }

  .btn-primary {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #059669, #047857);
    color: white;
  }

  .btn-success {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
  }

  .btn-success:hover {
    background: linear-gradient(135deg, #059669, #047857);
    color: white;
  }

  .btn-link {
    background: transparent;
    color: #10b981;
    font-size: 0.8rem;
    padding: 0.25rem 0.5rem;
    box-shadow: none;
  }

  .btn-link:hover {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
    transform: none;
  }

  /* Badge Styling */
  .badge {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 500;
    padding: 0.35rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.75rem;
    margin-right: 0.5rem;
  }

  .badge.bg-secondary {
    background: rgba(16, 185, 129, 0.2) !important;
    color: #10b981 !important;
    border: 1px solid rgba(16, 185, 129, 0.3);
  }

  .badge.bg-info {
    background: rgba(6, 182, 212, 0.2) !important;
    color: #06b6d4 !important;
    border: 1px solid rgba(6, 182, 212, 0.3);
  }

  .badge.bg-success {
    background: rgba(16, 185, 129, 0.2) !important;
    color: #10b981 !important;
    border: 1px solid rgba(16, 185, 129, 0.3);
  }

  .badge.bg-warning {
    background: rgba(245, 158, 11, 0.2) !important;
    color: #f59e0b !important;
    border: 1px solid rgba(245, 158, 11, 0.3);
  }

  .badge.bg-danger {
    background: rgba(239, 68, 68, 0.2) !important;
    color: #ef4444 !important;
    border: 1px solid rgba(239, 68, 68, 0.3);
  }

  /* List Styling */
  .list-unstyled {
    max-height: 120px;
    overflow-y: auto;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 0.75rem;
    padding: 1rem;
    margin-top: 1rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
  }

  .list-unstyled::-webkit-scrollbar {
    width: 4px;
  }

  .list-unstyled::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 2px;
  }

  .list-unstyled::-webkit-scrollbar-thumb {
    background: rgba(16, 185, 129, 0.4);
    border-radius: 2px;
  }

  .list-unstyled::-webkit-scrollbar-thumb:hover {
    background: rgba(16, 185, 129, 0.6);
  }

  .list-unstyled li {
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.5rem;
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.9);
  }

  .list-unstyled li:last-child {
    border-bottom: none;
  }

  /* Responsive Design */
  @media (max-width: 1024px) {
    .supplier-layout {
      padding: 1rem;
    }
    
    .dashboard-header {
      flex-direction: column;
      text-align: center;
      gap: 1rem;
      padding: 1.5rem;
    }
    
    .dashboard-header h2 {
      font-size: 2rem;
    }
    
    .dashboard-card {
      padding: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .ecoverse-logo {
      width: 50px;
      height: 50px;
    }

    .list-unstyled li {
      flex-direction: column;
      align-items: flex-start;
      gap: 0.25rem;
    }
  }

  /* Additional professional styling */
  .container-fluid {
    padding: 0 !important;
    margin: 0 !important;
  }

  /* Link styling in lists */
  .list-unstyled a {
    color: #10b981;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
  }

  .list-unstyled a:hover {
    color: #059669;
    text-decoration: underline;
  }

  /* Text styling */
  .text-danger {
    color: #ef4444 !important;
    font-weight: 500;
  }

  .text-muted {
    color: rgba(255, 255, 255, 0.6) !important;
  }

  .fw-bold {
    color: #10b981 !important;
  }

  /* Grid spacing */
  .row {
    margin-bottom: 1rem;
  }

  .row:last-child {
    margin-bottom: 0;
  }
</style>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<!-- Supplier Dashboard Layout -->
<div class="supplier-layout">
  <main class="supplier-main">
    
    <!-- Welcome Message -->
    <section class="welcome-message">
      <h5>Welcome back, {{ Auth::user()->name }}</h5>
    </section>

    <!-- Dashboard Header -->
    <section class="dashboard-header">
      <img src="/assets/img/ecoverse-logo.svg" alt="Ecoverse Logo" class="ecoverse-logo">
      <div>
        <h2>Supplier Dashboard</h2>
        <p>Waste input: Submit waste, track deliveries, view payments</p>
      </div>
    </section>
    
    <!-- Dashboard Grid -->
    <section class="content-grid">
      <div class="row">
        <div class="col-md-6">
          <div class="dashboard-card">
            <i class="bi bi-recycle"></i>
            <h5>Raw Material Management</h5>
            <p>Submit, view, and manage your raw materials for processing</p>
            <a href="{{ route('raw-materials.index') }}" class="btn btn-primary">
              <i class="bi bi-list-ul"></i>
              Manage Raw Materials
            </a>
          </div>
        </div>
        <div class="col-md-6">
          <div class="dashboard-card">
            <i class="bi bi-cash-coin"></i>
            <h5>Payments</h5>
            <p>View your compensation and delivery status</p>
            <a href="{{ route('supplier.purchase_orders.index') }}" class="btn btn-success">
              <i class="bi bi-wallet2"></i>
              View Payments
            </a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="dashboard-card">
            <i class="bi bi-clipboard-data"></i>
            <h5>Purchase Orders</h5>
            <p>View and manage your assigned POs</p>
            <a href="{{ route('supplier.purchase_orders.index') }}" class="btn btn-primary">
              <i class="bi bi-list-check"></i>
              View POs
            </a>
            @if($supplierPOs->count() > 0)
              <ul class="list-unstyled">
                @foreach($supplierPOs as $po)
                  <li>
                    <span class="badge bg-secondary">#{{ str_pad($po->id, 4, '0', STR_PAD_LEFT) }}</span>
                    <span>{{ $po->rawMaterial->name ?? 'N/A' }}</span>
                    <span class="badge bg-info">{{ ucfirst($po->status) }}</span>
                    <a href="{{ route('supplier.purchase_orders.show', $po->id) }}" class="btn btn-link">
                      <i class="bi bi-eye"></i> Details
                    </a>
                  </li>
                @endforeach
              </ul>
            @else
              <div class="text-muted mt-3">
                <i class="bi bi-inbox"></i>
                <p class="mb-0">No purchase orders available</p>
              </div>
            @endif
          </div>
        </div>
        <div class="col-md-6">
          <div class="dashboard-card">
            <i class="bi bi-truck"></i>
            <h5>Delivery Submission</h5>
            <p>Upload delivery details and invoice for a PO</p>
            <a href="{{ route('supplier.purchase_orders.index') }}" class="btn btn-success">
              <i class="bi bi-upload"></i>
              Submit Delivery
            </a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="dashboard-card">
            <i class="bi bi-cash-coin"></i>
            <h5>Payment Status</h5>
            <p>Track payment for your deliveries and invoices</p>
            @if(count($supplierPayments) > 0)
              <ul class="list-unstyled">
                @foreach($supplierPayments as $pay)
                  <li>
                    <span class="badge bg-secondary">#{{ str_pad($pay['po_id'], 4, '0', STR_PAD_LEFT) }}</span>
                    <span class="badge bg-{{ $pay['status'] == 'paid' ? 'success' : ($pay['status'] == 'pending' ? 'warning' : 'danger') }}">
                      {{ ucfirst($pay['status']) }}
                    </span>
                    <span class="fw-bold">₱{{ number_format($pay['amount'], 2) }}</span>
                  </li>
                @endforeach
              </ul>
            @else
              <div class="text-muted mt-3">
                <i class="bi bi-credit-card"></i>
                <p class="mb-0">No payment records found</p>
              </div>
            @endif
          </div>
        </div>
        <div class="col-md-6">
          <div class="dashboard-card">
            <i class="bi bi-clock-history"></i>
            <h5>Delivery History</h5>
            <p>See all your completed deliveries and download invoices</p>
            @if($deliveryHistory->count() > 0)
              <ul class="list-unstyled">
                @foreach($deliveryHistory as $del)
                  <li>
                    <span class="badge bg-secondary">#{{ str_pad($del->id, 4, '0', STR_PAD_LEFT) }}</span>
                    <span>{{ $del->rawMaterial->name ?? 'N/A' }}</span>
                    <button type="button" class="btn btn-link btn-sm" onclick="showInvoiceInfo('{{ $del->id }}', '{{ $del->invoice_path }}')">
                      <i class="bi bi-file-earmark-pdf"></i> Invoice
                    </button>
                    <span class="badge bg-{{ $del->status == 'complete' ? 'success' : ($del->status == 'pending' ? 'warning' : 'danger') }}">
                      {{ ucfirst($del->status) }}
                    </span>
                  </li>
                @endforeach
              </ul>
            @else
              <div class="text-muted mt-3">
                <i class="bi bi-archive"></i>
                <p class="mb-0">No delivery history found</p>
              </div>
            @endif
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="dashboard-card">
            <i class="bi bi-receipt"></i>
            <h5>Upload Invoices & Feedback</h5>
            <p>Attach invoices to deliveries and view feedback if any issues</p>
            @if(count($invoiceFeedback) > 0)
              <ul class="list-unstyled">
                @foreach($invoiceFeedback as $inv)
                  <li>
                    <span class="badge bg-secondary">#{{ str_pad($inv->po_id, 4, '0', STR_PAD_LEFT) }}</span>
                    <button type="button" class="btn btn-link btn-sm" onclick="showInvoiceInfo('{{ $inv->po_id }}', '{{ $inv->invoice_path }}')">
                      <i class="bi bi-file-earmark-pdf"></i> Invoice
                    </button>
                    <span class="badge bg-{{ $inv->status == 'approved' ? 'success' : ($inv->status == 'rejected' ? 'danger' : 'warning') }}">
                      {{ ucfirst($inv->status) }}
                    </span>
                    @if($inv->feedback)
                      <span class="text-danger fw-bold">
                        <i class="bi bi-chat-quote"></i> {{ $inv->feedback }}
                      </span>
                    @endif
                  </li>
                @endforeach
              </ul>
            @else
              <div class="text-muted mt-3">
                <i class="bi bi-receipt-cutoff"></i>
                <p class="mb-0">No invoice feedback available</p>
              </div>
            @endif
          </div>
        </div>
      </div>
      
    </section>
  </main>
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
          <strong>Invoice Successfully Submitted</strong><br>
          <small>Your invoice has been processed and recorded in the system.</small>
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
            <span class="badge bg-success">Processed</span>
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

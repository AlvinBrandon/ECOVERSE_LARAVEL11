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

  /* Welcome Message Styling */
  .welcome-message {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    border-radius: 0.75rem;
    padding: 0.75rem 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid rgba(255,255,255,0.2);
  }

  .welcome-message h5 {
    color: #1f2937 !important;
    font-weight: 600;
    margin: 0;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
  }

  /* Dashboard Header */
  .dashboard-header {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #10b981 100%);
    color: white;
    padding: 2rem 1.5rem;
    border-radius: 1rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(99, 102, 241, 0.2);
    border: 1px solid rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .dashboard-header h2 {
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
  }

  .dashboard-header p {
    opacity: 0.9;
    font-size: 1.1rem;
    margin-bottom: 0;
    font-weight: 400;
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
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    padding: 2rem 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.12);
    border: 1px solid rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
    text-align: center;
    height: 100%;
  }

  .dashboard-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 40px rgba(99, 102, 241, 0.15);
  }

  .dashboard-card h5 {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 600;
    color: #1f2937;
    margin: 1rem 0 0.75rem 0;
    font-size: 1.1rem;
  }

  .dashboard-card p {
    font-family: 'Poppins', sans-serif !important;
    color: #6b7280;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1.5rem;
  }

  .dashboard-card i {
    font-size: 2.5rem;
    margin-bottom: 1rem;
  }

  .dashboard-card .text-primary {
    color: #6366f1 !important;
  }

  .dashboard-card .text-success {
    color: #10b981 !important;
  }

  .dashboard-card .text-warning {
    color: #f59e0b !important;
  }

  .dashboard-card .text-info {
    color: #06b6d4 !important;
  }

  .dashboard-card .text-secondary {
    color: #6b7280 !important;
  }

  /* Button Styling */
  .btn {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 500;
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: none;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    cursor: pointer;
    gap: 0.5rem;
    font-size: 0.9rem;
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

  .btn-link {
    background: transparent;
    color: #6366f1;
    font-size: 0.8rem;
    padding: 0.25rem 0.5rem;
    box-shadow: none;
  }

  .btn-link:hover {
    background: rgba(99, 102, 241, 0.1);
    color: #4f46e5;
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
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%) !important;
  }

  .badge.bg-info {
    background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
  }

  .badge.bg-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
  }

  .badge.bg-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
    color: #92400e !important;
  }

  .badge.bg-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
  }

  /* List Styling */
  .list-unstyled {
    max-height: 120px;
    overflow-y: auto;
    background: rgba(248, 250, 252, 0.8);
    border-radius: 0.5rem;
    padding: 1rem;
    margin-top: 1rem;
    border: 1px solid rgba(226, 232, 240, 0.6);
  }

  .list-unstyled::-webkit-scrollbar {
    width: 4px;
  }

  .list-unstyled::-webkit-scrollbar-track {
    background: rgba(226, 232, 240, 0.3);
    border-radius: 2px;
  }

  .list-unstyled::-webkit-scrollbar-thumb {
    background: rgba(99, 102, 241, 0.4);
    border-radius: 2px;
  }

  .list-unstyled::-webkit-scrollbar-thumb:hover {
    background: rgba(99, 102, 241, 0.6);
  }

  .list-unstyled li {
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(226, 232, 240, 0.3);
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.5rem;
    font-size: 0.85rem;
  }

  .list-unstyled li:last-child {
    border-bottom: none;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .dashboard-header {
      flex-direction: column;
      text-align: center;
      gap: 1rem;
      padding: 1.5rem 1rem;
    }
    
    .dashboard-header h2 {
      font-size: 1.5rem;
    }
    
    .dashboard-card {
      padding: 1.5rem 1rem;
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

  /* Professional spacing and layout */
  .container-fluid {
    padding: 0.5rem 1.5rem 2rem 1.5rem !important;
    margin-top: 0 !important;
  }

  /* Link styling in lists */
  .list-unstyled a {
    color: #6366f1;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
  }

  .list-unstyled a:hover {
    color: #4f46e5;
    text-decoration: underline;
  }

  /* Text styling */
  .text-danger {
    color: #dc2626 !important;
    font-weight: 500;
  }

  /* Row gap for better spacing */
  .row {
    margin-bottom: 1rem;
  }

  .row:last-child {
    margin-bottom: 0;
  }
</style>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<div class="container-fluid">
  <!-- Welcome Message -->
  <div class="welcome-message">
    <h5>Welcome, {{ Auth::user()->name }}</h5>
  </div>

  <!-- Dashboard Header -->
  <div class="dashboard-header">
    <img src="/assets/img/ecoverse-logo.svg" alt="Ecoverse Logo" class="ecoverse-logo">
    <div>
      <h2>Supplier Dashboard</h2>
      <p>Waste input: Submit waste, track deliveries, view payments</p>
    </div>
  </div>
  <!-- Dashboard Grid -->
  <div class="row">
    <div class="col-md-6">
      <div class="dashboard-card">
        <i class="bi bi-recycle text-primary"></i>
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
        <i class="bi bi-cash-coin text-success"></i>
        <h5>Payments</h5>
        <p>View your compensation and delivery status</p>
        <a href="#" class="btn btn-success">
          <i class="bi bi-wallet2"></i>
          View Payments
        </a>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="dashboard-card">
        <i class="bi bi-clipboard-data text-primary"></i>
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
        <i class="bi bi-truck text-success"></i>
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
        <i class="bi bi-cash-coin text-warning"></i>
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
        <i class="bi bi-clock-history text-info"></i>
        <h5>Delivery History</h5>
        <p>See all your completed deliveries and download invoices</p>
        @if($deliveryHistory->count() > 0)
          <ul class="list-unstyled">
            @foreach($deliveryHistory as $del)
              <li>
                <span class="badge bg-secondary">#{{ str_pad($del->id, 4, '0', STR_PAD_LEFT) }}</span>
                <span>{{ $del->rawMaterial->name ?? 'N/A' }}</span>
                <a href="{{ asset('storage/'.$del->invoice_path) }}" target="_blank" class="btn btn-link">
                  <i class="bi bi-file-earmark-pdf"></i> Invoice
                </a>
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
        <i class="bi bi-receipt text-secondary"></i>
        <h5>Upload Invoices & Feedback</h5>
        <p>Attach invoices to deliveries and view feedback if any issues</p>
        @if(count($invoiceFeedback) > 0)
          <ul class="list-unstyled">
            @foreach($invoiceFeedback as $inv)
              <li>
                <span class="badge bg-secondary">#{{ str_pad($inv->po_id, 4, '0', STR_PAD_LEFT) }}</span>
                <a href="{{ asset('storage/'.$inv->invoice_path) }}" target="_blank" class="btn btn-link">
                  <i class="bi bi-file-earmark-pdf"></i> Invoice
                </a>
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
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

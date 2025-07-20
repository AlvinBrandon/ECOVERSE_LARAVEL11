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

  .form-container {
    max-width: 800px;
    margin: 0 auto;
  }

  .invoice-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border: 1px solid rgba(226, 232, 240, 0.6);
  }

  .invoice-header h4 {
    color: #1f2937;
    font-weight: 600;
    margin-bottom: 0.5rem;
  }

  .invoice-header p {
    color: #6b7280;
    margin-bottom: 0;
    font-size: 0.9rem;
  }

  .form-section {
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: rgba(248, 250, 252, 0.8);
    border-radius: 1rem;
    border: 1px solid rgba(226, 232, 240, 0.6);
  }

  .form-section h5 {
    color: #1f2937;
    font-weight: 600;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .form-group {
    margin-bottom: 1.5rem;
  }

  .form-label {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    display: block;
    font-size: 0.9rem;
  }

  .form-control, .form-select {
    font-family: 'Poppins', sans-serif !important;
    border: 2px solid rgba(226, 232, 240, 0.6);
    border-radius: 0.75rem;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(5px);
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  }

  .form-control:focus, .form-select:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1), 0 4px 12px rgba(0,0,0,0.08);
    background: white;
    outline: none;
  }

  .form-control::placeholder {
    color: #9ca3af;
    font-style: italic;
  }

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

  .btn-secondary {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
  }

  .btn-secondary:hover {
    background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
    color: white;
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

  .alert-danger {
    background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
    color: #991b1b;
    border: 1px solid rgba(239, 68, 68, 0.2);
  }

  .alert ul {
    margin-bottom: 0;
    padding-left: 1rem;
  }

  .text-primary {
    color: #6366f1 !important;
    font-weight: 600;
  }

  .action-buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 2rem;
    gap: 1rem;
  }

  .currency-symbol {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    font-weight: 600;
    z-index: 5;
    pointer-events: none;
  }

  .input-group {
    position: relative;
  }

  .input-group .form-control {
    padding-left: 3rem;
  }

  .file-upload-area {
    border: 2px dashed rgba(99, 102, 241, 0.3);
    border-radius: 1rem;
    padding: 2rem;
    text-align: center;
    background: rgba(99, 102, 241, 0.02);
    transition: all 0.3s ease;
  }

  .file-upload-area:hover {
    border-color: rgba(99, 102, 241, 0.5);
    background: rgba(99, 102, 241, 0.05);
  }

  .file-upload-area.dragover {
    border-color: #6366f1;
    background: rgba(99, 102, 241, 0.1);
  }

  .invoice-summary {
    background: linear-gradient(135deg, #f0fdfa 0%, #ecfdf5 100%);
    border-radius: 1rem;
    padding: 1.5rem;
    border: 1px solid rgba(16, 185, 129, 0.2);
  }

  .summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(16, 185, 129, 0.1);
  }

  .summary-row:last-child {
    border-bottom: none;
    font-weight: 600;
    font-size: 1.1rem;
    color: #065f46;
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

    .action-buttons {
      flex-direction: column-reverse;
      gap: 0.75rem;
    }

    .btn {
      width: 100%;
    }

    .form-section {
      padding: 1rem;
    }
  }

  /* Professional spacing and layout */
  .container {
    padding: 0.5rem 1.5rem 2rem 1.5rem !important;
    margin-top: 0 !important;
  }

  .row {
    margin-bottom: 1rem;
  }

  .col-md-6 .form-group:last-child {
    margin-bottom: 0;
  }
</style>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<div class="container">
  <!-- Page Header -->
  <div class="page-header">
    <i class="bi bi-receipt"></i>
    <div>
      <h2>Create Invoice</h2>
      <p>Generate a new invoice for delivered materials</p>
    </div>
  </div>

  <!-- Content Section -->
  <div class="content-section">
    <div class="form-container">
      <!-- Invoice Header -->
      <div class="invoice-header">
        <h4><i class="bi bi-file-earmark-text me-2"></i>Invoice Details</h4>
        <p>Fill in the details below to create a new invoice for your delivered materials</p>
      </div>

      @if(session('success'))
        <div class="alert alert-success">
          <i class="bi bi-check-circle me-2"></i>
          {{ session('success') }}
        </div>
      @endif
      
      @if($errors->any())
        <div class="alert alert-danger">
          <i class="bi bi-exclamation-triangle me-2"></i>
          <strong>Please correct the following errors:</strong>
          <ul class="mt-2">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('supplier.invoices.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Purchase Order Section -->
        <div class="form-section">
          <h5><i class="bi bi-clipboard-data"></i>Purchase Order Information</h5>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="purchase_order_id" class="form-label">
                  <i class="bi bi-hash me-2"></i>Purchase Order
                </label>
                <select name="purchase_order_id" id="purchase_order_id" class="form-select" required>
                  <option value="">Select a purchase order...</option>
                  @foreach($purchaseOrders as $po)
                    <option value="{{ $po->id }}" {{ old('purchase_order_id') == $po->id ? 'selected' : '' }}>
                      #{{ str_pad($po->id, 6, '0', STR_PAD_LEFT) }} - {{ $po->rawMaterial->name ?? 'N/A' }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="invoice_number" class="form-label">
                  <i class="bi bi-receipt me-2"></i>Invoice Number
                </label>
                <input type="text" 
                       name="invoice_number" 
                       id="invoice_number" 
                       class="form-control" 
                       value="{{ old('invoice_number', 'INV-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT)) }}"
                       placeholder="Auto-generated invoice number"
                       required>
              </div>
            </div>
          </div>
        </div>

        <!-- Invoice Details Section -->
        <div class="form-section">
          <h5><i class="bi bi-card-text"></i>Invoice Details</h5>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="invoice_date" class="form-label">
                  <i class="bi bi-calendar me-2"></i>Invoice Date
                </label>
                <input type="date" 
                       name="invoice_date" 
                       id="invoice_date" 
                       class="form-control" 
                       value="{{ old('invoice_date', date('Y-m-d')) }}"
                       required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="due_date" class="form-label">
                  <i class="bi bi-calendar-check me-2"></i>Due Date
                </label>
                <input type="date" 
                       name="due_date" 
                       id="due_date" 
                       class="form-control" 
                       value="{{ old('due_date', date('Y-m-d', strtotime('+30 days'))) }}"
                       required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="quantity_delivered" class="form-label">
                  <i class="bi bi-123 me-2"></i>Quantity Delivered
                </label>
                <input type="number" 
                       name="quantity_delivered" 
                       id="quantity_delivered" 
                       class="form-control" 
                       min="1" 
                       value="{{ old('quantity_delivered') }}"
                       placeholder="Enter delivered quantity"
                       required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="unit_price" class="form-label">
                  <i class="bi bi-currency-exchange me-2"></i>Unit Price <span class="text-primary">(UGX)</span>
                </label>
                <div class="input-group">
                  <span class="currency-symbol">UGX</span>
                  <input type="number" 
                         name="unit_price" 
                         id="unit_price" 
                         class="form-control" 
                         min="0" 
                         step="0.01" 
                         value="{{ old('unit_price') }}"
                         placeholder="0.00"
                         required>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="description" class="form-label">
              <i class="bi bi-card-text me-2"></i>Description / Notes
            </label>
            <textarea name="description" 
                      id="description" 
                      class="form-control" 
                      rows="3"
                      placeholder="Additional details about the delivery or invoice...">{{ old('description') }}</textarea>
          </div>
        </div>

        <!-- File Upload Section -->
        <div class="form-section">
          <h5><i class="bi bi-cloud-upload"></i>Invoice Document</h5>
          
          <div class="form-group">
            <label for="invoice_file" class="form-label">
              <i class="bi bi-file-earmark-pdf me-2"></i>Upload Invoice Document
            </label>
            <div class="file-upload-area">
              <i class="bi bi-cloud-upload display-4 text-muted mb-3"></i>
              <h6>Drop your invoice file here or click to browse</h6>
              <p class="text-muted mb-3">Supported formats: PDF, JPG, JPEG, PNG (Max 10MB)</p>
              <input type="file" 
                     name="invoice_file" 
                     id="invoice_file" 
                     class="form-control" 
                     accept=".pdf,.jpg,.jpeg,.png"
                     required>
            </div>
          </div>
        </div>

        <!-- Invoice Summary -->
        <div class="invoice-summary">
          <h5><i class="bi bi-calculator me-2"></i>Invoice Summary</h5>
          <div class="summary-row">
            <span>Quantity:</span>
            <span id="summary-quantity">-</span>
          </div>
          <div class="summary-row">
            <span>Unit Price:</span>
            <span id="summary-unit-price">UGX 0.00</span>
          </div>
          <div class="summary-row">
            <span>Total Amount:</span>
            <span id="summary-total">UGX 0.00</span>
          </div>
        </div>

        <div class="action-buttons">
          <a href="{{ route('supplier.purchase_orders.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Cancel
          </a>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-receipt"></i>
            Create Invoice
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity_delivered');
    const priceInput = document.getElementById('unit_price');
    const summaryQuantity = document.getElementById('summary-quantity');
    const summaryUnitPrice = document.getElementById('summary-unit-price');
    const summaryTotal = document.getElementById('summary-total');

    function updateSummary() {
        const quantity = parseFloat(quantityInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        const total = quantity * price;

        summaryQuantity.textContent = quantity;
        summaryUnitPrice.textContent = 'UGX ' + price.toLocaleString('en-US', {minimumFractionDigits: 2});
        summaryTotal.textContent = 'UGX ' + total.toLocaleString('en-US', {minimumFractionDigits: 2});
    }

    quantityInput.addEventListener('input', updateSummary);
    priceInput.addEventListener('input', updateSummary);

    // File upload drag and drop
    const fileUploadArea = document.querySelector('.file-upload-area');
    const fileInput = document.getElementById('invoice_file');

    fileUploadArea.addEventListener('click', () => fileInput.click());

    fileUploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        fileUploadArea.classList.add('dragover');
    });

    fileUploadArea.addEventListener('dragleave', () => {
        fileUploadArea.classList.remove('dragover');
    });

    fileUploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        fileUploadArea.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
        }
    });
});
</script>
@endsection

@extends('layouts.app')

@section('content')
<style>
  /* Modern Professional Inventory Deduction Styling */
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

  /* Main Form Card */
  .form-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    border: none;
  }

  .form-card .card-body {
    padding: 2rem;
  }

  /* Form Styling */
  .form-label {
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
  }

  .form-control, .form-select {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 0.875rem 1rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    background: #fafafa;
  }

  .form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    background: white;
  }

  .form-control::placeholder {
    color: #9ca3af;
    font-style: italic;
  }

  /* Enhanced Form Groups */
  .form-group {
    margin-bottom: 1.5rem;
  }

  .form-group .form-text {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.375rem;
  }

  /* Reason Selection Styling */
  .reason-select option {
    padding: 0.5rem;
  }

  /* Alert Styling */
  .alert {
    border: none;
    border-radius: 0.75rem;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    font-size: 0.875rem;
  }

  .alert-success {
    background: #dcfce7;
    color: #166534;
    border-left: 4px solid #22c55e;
  }

  .alert-warning {
    background: #fef3c7;
    color: #92400e;
    border-left: 4px solid #f59e0b;
  }

  .alert-danger {
    background: #fee2e2;
    color: #991b1b;
    border-left: 4px solid #ef4444;
  }

  .alert-info {
    background: #dbeafe;
    color: #1e40af;
    border-left: 4px solid #3b82f6;
  }

  .alert i {
    margin-right: 0.5rem;
    font-size: 1rem;
  }

  .alert ul {
    margin: 0;
    padding-left: 1.25rem;
  }

  /* Warning Box */
  .warning-box {
    background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%);
    border: 1px solid #f59e0b;
    border-radius: 0.75rem;
    padding: 1.25rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .warning-box i {
    font-size: 1.25rem;
    color: #d97706;
  }

  .warning-box strong {
    color: #92400e;
  }

  .warning-box p {
    margin: 0;
    color: #92400e;
    font-size: 0.875rem;
  }

  /* Submit Button */
  .btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    border: none;
    border-radius: 0.5rem;
    padding: 0.875rem 2rem;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .btn-danger:hover {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
    transform: translateY(-2px);
  }

  .btn-danger i {
    margin-right: 0.5rem;
  }

  /* Dynamic Warnings */
  .quantity-warning {
    margin-top: 0.5rem;
    animation: slideIn 0.3s ease;
  }

  @keyframes slideIn {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Character Counter */
  .char-counter {
    display: block;
    margin-top: 0.375rem;
    font-size: 0.75rem;
    transition: color 0.2s ease;
  }

  /* Form Section Headers */
  .section-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f3f4f6;
  }

  .section-header i {
    font-size: 1.25rem;
    color: #6366f1;
  }

  .section-header h5 {
    margin: 0;
    color: #374151;
    font-weight: 600;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .page-header {
      padding: 1.5rem;
    }

    .page-header h4 {
      font-size: 1.25rem;
    }

    .form-card .card-body {
      padding: 1.5rem;
    }

    .btn-danger {
      width: 100%;
      padding: 1rem;
    }
  }

  /* Loading State */
  .btn-danger:disabled {
    background: #9ca3af;
    cursor: not-allowed;
    transform: none;
  }

  /* Focus States */
  .form-control:focus,
  .form-select:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
  }

  /* Form Icons */
  .input-group-text {
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    color: #6b7280;
  }
</style>

<div class="container-fluid py-4">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h4><i class="bi bi-dash-circle me-2"></i>Deduct Stock</h4>
        <p class="mb-0 opacity-75">Remove inventory from your stock with proper documentation</p>
      </div>
      <a href="{{ route('inventory.index') }}" class="btn">
        <i class="bi bi-arrow-left me-1"></i>Back to Inventory
      </a>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-8 col-xl-6">
      <!-- Main Form Card -->
      <div class="card form-card">
        <div class="card-body">
          <!-- Alerts Section -->
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
              <i class="bi bi-check-circle"></i> {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          @endif
          @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show">
              <i class="bi bi-exclamation-triangle"></i> {{ session('warning') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          @endif
          @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
              <i class="bi bi-exclamation-circle"></i>
              <ul class="mb-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          @endif

          <!-- Deduct Stock Form -->
          <form method="POST" action="{{ route('inventory.deduct') }}">
            @csrf

            <!-- Product Selection Section -->
            <div class="section-header">
              <i class="bi bi-cube"></i>
              <h5>Product Selection</h5>
            </div>

            <div class="form-group">
              <label for="product_id" class="form-label">Select Product <span class="text-danger">*</span></label>
              <select name="product_id" id="product_id" class="form-select reason-select" required>
                <option value="" disabled selected>Choose a product to deduct from</option>
                @foreach ($products as $product)
                  <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
              </select>
              <div class="form-text">Select the product you want to remove from inventory</div>
            </div>

            <div class="form-group">
              <label for="batch_id" class="form-label">Batch ID</label>
              <input type="text" name="batch_id" id="batch_id" class="form-control" placeholder="Leave empty to use oldest batch (FIFO)">
              <div class="form-text">If not specified, system will automatically select the oldest batch (First In, First Out)</div>
            </div>

            <!-- Quantity & Reason Section -->
            <div class="section-header">
              <i class="bi bi-123"></i>
              <h5>Deduction Details</h5>
            </div>

            <div class="form-group">
              <label for="quantity" class="form-label">Quantity to Deduct <span class="text-danger">*</span></label>
              <input type="number" name="quantity" id="quantity" class="form-control" min="1" required placeholder="Enter quantity">
              <div class="form-text">Quantities over 100 units require admin approval</div>
            </div>

            <div class="form-group">
              <label for="reason" class="form-label">Reason for Deduction <span class="text-danger">*</span></label>
              <select name="reason" id="reason" class="form-select reason-select" required>
                <option value="" disabled selected>Select a reason for this deduction</option>
                <option value="damaged">🔨 Damaged Inventory</option>
                <option value="expired">⏰ Expired Products</option>
                <option value="quality_control">🔍 Quality Control Rejection</option>
                <option value="adjustment">📊 Inventory Adjustment/Correction</option>
                <option value="shrinkage">📉 Inventory Shrinkage</option>
                <option value="theft">🚨 Theft/Loss</option>
                <option value="recall">⚠️ Product Recall</option>
                <option value="other">🔧 Other (specify in notes)</option>
              </select>
              <div class="form-text">Choose the most appropriate reason for documentation purposes</div>
            </div>

            <!-- Notes Section -->
            <div class="section-header">
              <i class="bi bi-chat-text"></i>
              <h5>Additional Information</h5>
            </div>

            <div class="form-group">
              <label for="notes" class="form-label">Additional Notes</label>
              <textarea name="notes" id="notes" class="form-control" rows="4" maxlength="500" placeholder="Provide additional details about this deduction..."></textarea>
              <div class="form-text">Maximum 500 characters. Include relevant details for audit purposes.</div>
            </div>

            <!-- Warning Box -->
            <div class="warning-box">
              <i class="bi bi-exclamation-triangle"></i>
              <div>
                <strong>Important Notice:</strong>
                <p>This action will permanently remove inventory and cannot be undone. Please verify all details are correct before proceeding.</p>
              </div>
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
              <button type="submit" class="btn btn-danger">
                <i class="bi bi-dash-circle"></i> Deduct Stock
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.querySelector('input[name="quantity"]');
    const reasonSelect = document.querySelector('select[name="reason"]');
    const notesTextarea = document.querySelector('textarea[name="notes"]');
    const submitButton = document.querySelector('button[type="submit"]');
    
    // Dynamic warnings based on quantity
    quantityInput.addEventListener('input', function() {
        const quantity = parseInt(this.value);
        const existingWarning = document.querySelector('.quantity-warning');
        
        if (existingWarning) {
            existingWarning.remove();
        }
        
        if (quantity > 100) {
            const warning = document.createElement('div');
            warning.className = 'alert alert-info quantity-warning mt-2';
            warning.innerHTML = '<strong>ℹ️ Notice:</strong> Large quantity deduction requires admin approval.';
            this.parentNode.appendChild(warning);
        }
    });
    
    // Auto-populate notes based on reason
    reasonSelect.addEventListener('change', function() {
        const reason = this.value;
        const suggestions = {
            'damaged': 'Specify damage type and cause (e.g., water damage, physical damage, etc.)',
            'expired': 'Include expiration date and disposal method',
            'theft': 'Reference incident report number if available',
            'recall': 'Include recall notice reference and batch numbers',
            'quality_control': 'Specify quality issue and inspection details',
            'adjustment': 'Explain the discrepancy found and correction needed'
        };
        
        if (suggestions[reason] && !notesTextarea.value) {
            notesTextarea.placeholder = suggestions[reason];
        }
    });
    
    // Character counter for notes
    notesTextarea.addEventListener('input', function() {
        const remaining = 500 - this.value.length;
        let counter = document.querySelector('.char-counter');
        
        if (!counter) {
            counter = document.createElement('small');
            counter.className = 'char-counter text-muted';
            this.parentNode.appendChild(counter);
        }
        
        counter.textContent = `${remaining} characters remaining`;
        counter.style.color = remaining < 50 ? '#dc3545' : '#6c757d';
    });
    
    // Confirmation dialog for large deductions
    submitButton.addEventListener('click', function(e) {
        const quantity = parseInt(quantityInput.value);
        const reason = reasonSelect.value;
        
        if (quantity > 50 || ['theft', 'recall'].includes(reason)) {
            const productName = document.querySelector('select[name="product_id"] option:checked').textContent;
            const confirmMessage = `Are you sure you want to deduct ${quantity} units of ${productName}? This action cannot be undone.`;
            
            if (!confirm(confirmMessage)) {
                e.preventDefault();
            }
        }
    });
});
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

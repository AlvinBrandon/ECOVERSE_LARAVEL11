@extends('layouts.app')

@section('content')
<style>
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
  }

  .voucher-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
  }

  .voucher-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    border: none;
    position: relative;
  }

  .voucher-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  }

  .voucher-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 2rem;
    text-align: center;
    position: relative;
  }

  .voucher-code-display {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 1.5rem;
    border-radius: 1rem;
    margin: 1.5rem 0;
    text-align: center;
    border: 3px dashed rgba(255, 255, 255, 0.3);
  }

  .voucher-code-text {
    font-size: 2rem;
    font-weight: bold;
    font-family: 'Courier New', monospace;
    letter-spacing: 2px;
  }

  .status-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-weight: 600;
    font-size: 0.875rem;
  }

  .status-active {
    background: #dcfce7;
    color: #166534;
  }

  .status-used {
    background: #fee2e2;
    color: #991b1b;
  }

  .qr-code {
    text-align: center;
    margin: 2rem 0;
  }

  .usage-instructions {
    background: #f8fafc;
    border-radius: 0.5rem;
    padding: 1.5rem;
    margin: 1.5rem 0;
  }
</style>

<div class="container-fluid py-4">
  <div class="voucher-container">
    <div class="card voucher-card">
      <div class="voucher-header">
        <div class="status-badge {{ $redemption->status === 'active' ? 'status-active' : 'status-used' }}">
          {{ ucfirst($redemption->status) }}
        </div>
        
        <div class="mb-3">
          @switch($redemption->reward->type)
            @case('shipping')
              <i class="bi bi-truck text-success" style="font-size: 4rem;"></i>
              @break
            @case('discount')
              <i class="bi bi-percent text-warning" style="font-size: 4rem;"></i>
              @break
            @case('voucher')
              <i class="bi bi-cash text-info" style="font-size: 4rem;"></i>
              @break
            @default
              <i class="bi bi-gift text-primary" style="font-size: 4rem;"></i>
          @endswitch
        </div>

        <h2 class="mb-2">{{ $redemption->reward->name }}</h2>
        <p class="text-muted mb-0">{{ $redemption->reward->description }}</p>
        
        <div class="voucher-code-display">
          <div class="voucher-code-text">{{ $redemption->voucher_code }}</div>
          <small class="opacity-75">Present this code at checkout</small>
        </div>

        <div class="row text-center">
          <div class="col-md-4">
            <h4 class="text-success">{{ $redemption->reward->value }}</h4>
            <small class="text-muted">Voucher Value</small>
          </div>
          <div class="col-md-4">
            <h4 class="text-primary">{{ number_format($redemption->points_used) }}</h4>
            <small class="text-muted">Points Used</small>
          </div>
          <div class="col-md-4">
            <h4 class="text-info">{{ $redemption->created_at->format('M j, Y') }}</h4>
            <small class="text-muted">Redeemed Date</small>
          </div>
        </div>
      </div>

      <div class="card-body">
        <!-- QR Code Section -->
        <div class="qr-code">
          <h5><i class="bi bi-qr-code me-2"></i>QR Code</h5>
          <div class="bg-light p-4 rounded">
            <div id="qrcode-{{ $redemption->voucher_code }}" style="text-align: center;"></div>
            <small class="text-muted d-block mt-2">Scan this QR code at participating stores</small>
          </div>
        </div>

        <!-- Usage Instructions -->
        <div class="usage-instructions">
          <h6><i class="bi bi-info-circle me-2"></i>How to Use This Voucher</h6>
          <ol class="mb-0">
            <li>Present this voucher code during checkout</li>
            <li>Scan the QR code or enter the code manually</li>
            <li>Discount will be applied automatically</li>
            @if($redemption->expires_at)
            <li><strong>Use before {{ $redemption->expires_at->format('M j, Y') }}</strong></li>
            @endif
          </ol>
        </div>

        <!-- Terms & Conditions -->
        @if($redemption->reward->conditions)
        <div class="usage-instructions">
          <h6><i class="bi bi-shield-check me-2"></i>Terms & Conditions</h6>
          <ul class="mb-0">
            @foreach($redemption->reward->conditions as $condition)
              <li>{{ $condition }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <!-- Expiry Warning -->
        @if($redemption->expires_at && $redemption->expires_at->diffInDays(now()) <= 7)
        <div class="alert alert-warning">
          <i class="bi bi-exclamation-triangle me-2"></i>
          <strong>Expiring Soon!</strong> This voucher expires on {{ $redemption->expires_at->format('M j, Y') }}.
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
          <button onclick="window.print()" class="btn btn-outline-primary">
            <i class="bi bi-printer me-1"></i>Print Voucher
          </button>
          <button onclick="copyVoucherCode()" class="btn btn-outline-success">
            <i class="bi bi-clipboard me-1"></i>Copy Code
          </button>
          <a href="{{ route('eco-points.history') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>Back to History
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- QR Code Generator -->
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generate QR code
    const voucherCode = '{{ $redemption->voucher_code }}';
    const qrCodeContainer = document.getElementById('qrcode-' + voucherCode);
    
    QRCode.toCanvas(qrCodeContainer, voucherCode, {
        width: 200,
        height: 200,
        margin: 2,
        color: {
            dark: '#10b981',
            light: '#ffffff'
        }
    }, function (error) {
        if (error) {
            qrCodeContainer.innerHTML = '<p class="text-muted">QR Code generation failed</p>';
        }
    });
});

function copyVoucherCode() {
    const voucherCode = '{{ $redemption->voucher_code }}';
    navigator.clipboard.writeText(voucherCode).then(function() {
        // Show success message
        const btn = event.target.closest('button');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check me-1"></i>Copied!';
        btn.classList.remove('btn-outline-success');
        btn.classList.add('btn-success');
        
        setTimeout(function() {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-success');
        }, 2000);
    });
}
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

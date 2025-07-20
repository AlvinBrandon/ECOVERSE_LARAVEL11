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

  .order-card {
    background: rgba(255,255,255,0.9);
    border-radius: 1rem;
    border: 1px solid rgba(226, 232, 240, 0.6);
    margin-bottom: 1.5rem;
    padding: 2rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(16, 185, 129, 0.08);
    backdrop-filter: blur(5px);
  }

  .order-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(16, 185, 129, 0.15);
    border-color: rgba(16, 185, 129, 0.3);
  }

  .order-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
  }

  .order-detail {
    padding: 0.75rem 0;
  }

  .order-detail strong {
    color: #1f2937;
    font-weight: 600;
    font-size: 0.95rem;
    display: block;
    margin-bottom: 0.25rem;
  }

  .order-detail span {
    color: #4b5563;
    font-weight: 400;
    font-size: 1rem;
  }

  .status-form {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: rgba(249, 250, 251, 0.8);
    border-radius: 0.75rem;
    border: 1px solid rgba(229, 231, 235, 0.6);
    margin-top: 1rem;
  }

  .form-select {
    font-family: 'Poppins', sans-serif !important;
    border: 1px solid #d1d5db;
    border-radius: 0.75rem;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    background: white;
    transition: all 0.3s ease;
    flex: 1;
    max-width: 250px;
  }

  .form-select:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
  }

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
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    cursor: pointer;
  }

  .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
  }

  .btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    font-size: 0.95rem;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
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

  .status-badge {
    display: inline-block;
    padding: 0.4rem 0.8rem;
    border-radius: 0.5rem;
    font-size: 0.85rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .status-order-placed {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
  }

  .status-processing {
    background: linear-gradient(135deg, #dbeafe 0%, #93c5fd 100%);
    color: #1e40af;
  }

  .status-out-for-delivery {
    background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
    color: #c2410c;
  }

  .status-delivered {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
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
    
    .order-card {
      padding: 1.5rem 1rem;
    }
    
    .order-info {
      grid-template-columns: 1fr;
      gap: 0.5rem;
    }

    .status-form {
      flex-direction: column;
      align-items: stretch;
      gap: 0.75rem;
    }

    .form-select {
      max-width: 100%;
    }
  }

  /* Professional spacing and layout */
  .container-fluid {
    padding: 0.5rem 1.5rem 2rem 1.5rem !important;
    margin-top: 0 !important;
  }
</style>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<div class="container-fluid">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center">
      <i class="bi bi-clipboard-check me-3" style="font-size: 2.5rem;"></i>
      <div>
        <h2>Staff - Manage Orders</h2>
        <p>Update order statuses and track customer purchases</p>
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

    @if($orders->count() > 0)
      @foreach($orders as $order)
        <div class="order-card">
          <div class="order-info">
            <div class="order-detail">
              <strong>Order ID</strong>
              <span>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="order-detail">
              <strong>Customer</strong>
              <span>{{ $order->user->name }}</span>
            </div>
            <div class="order-detail">
              <strong>Product</strong>
              <span>{{ $order->product->name ?? 'N/A' }}</span>
            </div>
            <div class="order-detail">
              <strong>Current Status</strong>
              <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $order->status)) }}">
                {{ $order->status }}
              </span>
            </div>
          </div>

          <div class="status-form">
            <form action="{{ route('staff.orders.updateStatus', $order->id) }}" method="POST" class="d-flex align-items-center gap-3 w-100">
              @csrf
              <div class="d-flex align-items-center gap-2">
                <label for="status-{{ $order->id }}" class="form-label mb-0" style="font-weight: 500; color: #374151; white-space: nowrap;">
                  Update Status:
                </label>
                <select name="status" id="status-{{ $order->id }}" class="form-select">
                  <option value="Order Placed" {{ $order->status == 'Order Placed' ? 'selected' : '' }}>Order Placed</option>
                  <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                  <option value="Out for Delivery" {{ $order->status == 'Out for Delivery' ? 'selected' : '' }}>Out for Delivery</option>
                  <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-arrow-clockwise me-2"></i>
                Update Status
              </button>
            </form>
          </div>
        </div>
      @endforeach
    @else
      <div class="text-center py-5">
        <i class="bi bi-inbox" style="font-size: 4rem; color: #9ca3af; margin-bottom: 1rem;"></i>
        <h4 style="color: #6b7280; font-weight: 500;">No orders found</h4>
        <p style="color: #9ca3af;">Orders will appear here when customers place them.</p>
      </div>
    @endif
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
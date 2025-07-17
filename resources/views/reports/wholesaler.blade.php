@extends('layouts.app')
@section('content')
<style>
  .dashboard-card {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    box-shadow: 0 4px 24px rgba(16, 185, 129, 0.08);
    padding: 2rem 1.5rem;
    margin-bottom: 2rem;
    transition: box-shadow 0.2s, transform 0.2s;
  }
  .dashboard-card:hover {
    box-shadow: 0 8px 32px rgba(99,102,241,0.18), 0 2px 8px rgba(16,185,129,0.10);
    transform: translateY(-4px) scale(1.025);
    z-index: 2;
    cursor: pointer;
  }
  .dashboard-header {
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
  .dashboard-icon {
    font-size: 2.5rem;
    margin-right: 1rem;
    vertical-align: middle;
  }
  .analytics-widget {
    background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%);
    border-radius: 1rem;
    box-shadow: 0 2px 12px rgba(16,185,129,0.08);
    padding: 1.5rem 1rem;
    margin-bottom: 1.5rem;
    text-align: center;
  }
  .analytics-value {
    font-size: 2rem;
    font-weight: bold;
    color: #10b981;
  }
  .analytics-label {
    color: #6366f1;
    font-size: 1.1rem;
    margin-top: 0.5rem;
  }
</style>
<div class="container py-4">
  <div class="dashboard-header">
    <i class="bi bi-bar-chart dashboard-icon"></i>
    <div>
      <h2 class="mb-0">Wholesaler Analytics & Retailer Orders</h2>
      <p class="mb-0" style="font-size:1.1rem;">Track retailer orders and view your analytics in style.</p>
    </div>
  </div>
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="analytics-widget">
        <div class="analytics-value">{{ $orders->count() }}</div>
        <div class="analytics-label">Pending Orders</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="analytics-widget">
        <div class="analytics-value">{{ $orders->where('status', 'approved')->count() }}</div>
        <div class="analytics-label">Approved Orders</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="analytics-widget">
        <div class="analytics-value">{{ $orders->where('status', 'rejected')->count() }}</div>
        <div class="analytics-label">Rejected Orders</div>
      </div>
    </div>
  </div>
  <div class="dashboard-card mb-4">
    <h5 class="mb-3"><i class="bi bi-clipboard-check text-info me-2"></i>Retailer Orders Pending Verification</h5>
    @if($orders->count())
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
          <thead class="bg-light">
            <tr>
              <th>Order ID</th>
              <th>Product</th>
              <th>Retailer</th>
              <th>Quantity</th>
              <th>Date</th>
            <th>Status</th>
            <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
            <tr>
              <td>{{ $order->id }}</td>
              <td>{{ $order->product->name ?? '-' }}</td>
              <td>{{ $order->user->name ?? '-' }}</td>
              <td>{{ $order->quantity }}</td>
              <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
              <td>
                @if($order->status === 'pending')
                  <span class="badge bg-warning text-dark">Pending</span>
                @elseif($order->status === 'approved')
                  <span class="badge bg-success">Approved</span>
                @elseif($order->status === 'rejected')
                  <span class="badge bg-danger">Rejected</span>
                @else
                  <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                @endif
              </td>
              <td>
                @if($order->status === 'pending')
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">Verify</button>
                  <form action="{{ route('orders.verify', $order->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    <div class="mb-2">
                      <label for="delivery_status_{{ $order->id }}" class="form-label">Delivery Status</label>
                      <select name="delivery_status" id="delivery_status_{{ $order->id }}" class="form-select form-select-sm">
                        <option value="pending" {{ $order->delivery_status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="dispatched" {{ $order->delivery_status == 'dispatched' ? 'selected' : '' }}>Dispatched</option>
                        <option value="delivered" {{ $order->delivery_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="pickup_arranged" {{ $order->delivery_status == 'pickup_arranged' ? 'selected' : '' }}>Pickup Arranged</option>
                      </select>
                    </div>
                    <div class="mb-2">
                      <label for="tracking_code_{{ $order->id }}" class="form-label">Tracking Code</label>
                      <input type="text" name="tracking_code" id="tracking_code_{{ $order->id }}" class="form-control form-control-sm" value="{{ $order->tracking_code }}">
                    </div>
                    <div class="mb-2">
                      <label for="dispatch_log_{{ $order->id }}" class="form-label">Dispatch Log</label>
                      <textarea name="dispatch_log" id="dispatch_log_{{ $order->id }}" class="form-control form-control-sm" rows="2">{{ $order->dispatch_log }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-success btn-sm">Verify & Update</button>
                  </form>
                  <form action="{{ route('orders.reject', $order->id) }}" method="POST" style="display:inline-block; margin-left:4px;">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                  </form>
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <div class="alert alert-info mb-0">No retailer orders to show.</div>
    @endif
  </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

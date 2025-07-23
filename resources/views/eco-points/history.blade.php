@extends('layouts.app')

@section('content')
<style>
  /* History Page Styling */
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
  }

  .page-header {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    color: white;
  }

  .history-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    border: none;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
  }

  .history-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
  }

  .redemption-item {
    border-left: 4px solid #10b981;
    padding: 1.5rem;
  }

  .voucher-code {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border: 2px dashed #10b981;
    border-radius: 0.5rem;
    padding: 1rem;
    text-align: center;
    margin: 1rem 0;
  }

  .voucher-code strong {
    font-size: 1.25rem;
    color: #10b981;
    font-family: 'Courier New', monospace;
  }

  .status-badge {
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 600;
  }

  .status-active {
    background: #dcfce7;
    color: #166534;
  }

  .status-used {
    background: #fee2e2;
    color: #991b1b;
  }

  .status-expired {
    background: #fef3c7;
    color: #92400e;
  }
</style>

<div class="container-fluid py-4">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h4><i class="bi bi-clock-history me-2"></i>Eco-Points Redemption History</h4>
        <p class="mb-0 opacity-75">Track your redeemed rewards and voucher codes</p>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('eco-points.rewards') }}" class="btn">
          <i class="bi bi-gift me-1"></i>Browse Rewards
        </a>
        <a href="{{ route('profile') }}" class="btn">
          <i class="bi bi-person-circle me-1"></i>Profile
        </a>
      </div>
    </div>
  </div>

  <!-- User Points Summary -->
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card history-card">
        <div class="card-body text-center">
          <h3 class="text-primary">{{ $user->eco_points ?? 0 }}</h3>
          <p class="text-muted mb-0">Current Eco-Points</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card history-card">
        <div class="card-body text-center">
          <h3 class="text-success">{{ $redemptions->total() }}</h3>
          <p class="text-muted mb-0">Total Redemptions</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card history-card">
        <div class="card-body text-center">
          <h3 class="text-info">{{ $redemptions->where('status', 'active')->count() }}</h3>
          <p class="text-muted mb-0">Active Vouchers</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Redemption History -->
  @if($redemptions->count() > 0)
    @foreach($redemptions as $redemption)
    <div class="card history-card">
      <div class="redemption-item">
        <div class="row align-items-center">
          <div class="col-md-8">
            <div class="d-flex align-items-center mb-2">
              <div class="me-3">
                @switch($redemption->reward->type)
                  @case('shipping')
                    <i class="bi bi-truck text-success" style="font-size: 2rem;"></i>
                    @break
                  @case('discount')
                    <i class="bi bi-percent text-warning" style="font-size: 2rem;"></i>
                    @break
                  @case('voucher')
                    <i class="bi bi-cash text-info" style="font-size: 2rem;"></i>
                    @break
                  @default
                    <i class="bi bi-gift text-primary" style="font-size: 2rem;"></i>
                @endswitch
              </div>
              <div>
                <h5 class="mb-1">{{ $redemption->reward->name }}</h5>
                <p class="text-muted mb-0">{{ $redemption->reward->description }}</p>
              </div>
            </div>
            
            <div class="voucher-code">
              <p class="mb-1"><strong>{{ $redemption->voucher_code }}</strong></p>
              <small class="text-muted">Use this code at checkout</small>
            </div>

            <div class="d-flex flex-wrap gap-2 align-items-center">
              <span class="status-badge {{ $redemption->status === 'active' ? 'status-active' : ($redemption->status === 'used' ? 'status-used' : 'status-expired') }}">
                {{ ucfirst($redemption->status) }}
              </span>
              <small class="text-muted">
                <i class="bi bi-calendar me-1"></i>Redeemed {{ $redemption->created_at->format('M j, Y') }}
              </small>
              @if($redemption->expires_at)
              <small class="text-muted">
                <i class="bi bi-clock me-1"></i>Expires {{ $redemption->expires_at->format('M j, Y') }}
              </small>
              @endif
            </div>
          </div>
          
          <div class="col-md-4 text-md-end">
            <div class="mb-2">
              <h4 class="text-success mb-0">{{ $redemption->reward->value }}</h4>
              <small class="text-muted">{{ number_format($redemption->points_used) }} points used</small>
            </div>
            
            <div class="d-grid gap-2">
              @if($redemption->status === 'active')
                <a href="{{ route('eco-points.voucher', $redemption->voucher_code) }}" class="btn btn-outline-primary btn-sm">
                  <i class="bi bi-eye me-1"></i>View Details
                </a>
              @endif
              
              @if($redemption->reward->conditions)
                <button class="btn btn-outline-info btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#conditions-{{ $redemption->id }}">
                  <i class="bi bi-info-circle me-1"></i>Conditions
                </button>
              @endif
            </div>
          </div>
        </div>

        @if($redemption->reward->conditions)
        <div class="collapse mt-3" id="conditions-{{ $redemption->id }}">
          <div class="card bg-light">
            <div class="card-body">
              <h6><i class="bi bi-info-circle me-1"></i>Terms & Conditions:</h6>
              <ul class="small mb-0">
                @foreach($redemption->reward->conditions as $condition)
                  <li>{{ $condition }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
    @endforeach

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
      {{ $redemptions->links() }}
    </div>

  @else
    <!-- No History -->
    <div class="text-center py-5">
      <i class="bi bi-clock-history" style="font-size: 4rem; color: #9ca3af;"></i>
      <h5 class="mt-3 text-muted">No Redemption History</h5>
      <p class="text-muted">You haven't redeemed any rewards yet. Start earning and redeeming eco-points!</p>
      <a href="{{ route('eco-points.rewards') }}" class="btn btn-success">
        <i class="bi bi-gift me-1"></i>Browse Rewards
      </a>
    </div>
  @endif
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

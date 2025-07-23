@extends('layouts.app')

@section('content')
<style>
  /* Rewards Catalog Styling */
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
  }

  .page-header {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    color: white;
    position: relative;
    overflow: hidden;
  }

  .page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    border-radius: 50%;
  }

  .reward-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    border: none;
    transition: all 0.3s ease;
    height: 100%;
  }

  .reward-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(16, 185, 129, 0.2);
  }

  .reward-card .card-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-bottom: 1px solid #e5e7eb;
    padding: 1.5rem;
    text-align: center;
  }

  .reward-icon {
    font-size: 3rem;
    margin-bottom: 0.5rem;
  }

  .reward-name {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.5rem;
  }

  .reward-points {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-weight: 600;
    display: inline-block;
  }

  .reward-description {
    color: #6b7280;
    font-size: 0.875rem;
    margin-bottom: 1rem;
  }

  .reward-conditions {
    background: #f8fafc;
    border-radius: 0.5rem;
    padding: 1rem;
    margin-bottom: 1rem;
  }

  .reward-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #10b981;
  }

  .btn-redeem {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 600;
    transition: all 0.2s ease;
  }

  .btn-redeem:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    color: white;
    transform: translateY(-2px);
  }

  .btn-redeem:disabled {
    background: #9ca3af;
    color: white;
    cursor: not-allowed;
    transform: none;
  }

  .user-points-card {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    text-align: center;
  }

  .stock-indicator {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: #ef4444;
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.75rem;
    font-weight: 600;
  }

  .stock-indicator.in-stock {
    background: #10b981;
  }
</style>

<div class="container-fluid py-4">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h4><i class="bi bi-gift me-2"></i>Eco-Points Rewards Catalog</h4>
        <p class="mb-0 opacity-75">Redeem your eco-points for amazing rewards and discounts</p>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('eco-points.history') }}" class="btn">
          <i class="bi bi-clock-history me-1"></i>History
        </a>
        <a href="{{ route('profile') }}" class="btn">
          <i class="bi bi-person-circle me-1"></i>Profile
        </a>
      </div>
    </div>
  </div>

  <!-- User Points Card -->
  <div class="user-points-card">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h3><i class="bi bi-trophy me-2"></i>{{ $user->eco_points ?? 0 }}</h3>
        <p class="mb-0">Total Eco-Points Available</p>
      </div>
      <div class="col-md-6">
        <h5><i class="bi bi-gift me-2"></i>{{ $user->eco_points >= 100 ? $user->eco_points : 0 }}</h5>
        <p class="mb-0">Points Ready to Redeem</p>
        @if($user->eco_points < 100)
          <small class="opacity-75">Minimum 100 points needed to start redeeming</small>
        @endif
      </div>
    </div>
  </div>

  <!-- Success/Error Messages -->
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <!-- Rewards Grid -->
  <div class="row">
    <div class="col-12 mb-4">
      <h5><i class="bi bi-star me-2"></i>Available Rewards</h5>
      <p class="text-muted">Choose from our eco-friendly rewards and start saving today!</p>
    </div>

    @foreach($rewards as $reward)
    <div class="col-lg-4 col-md-6 mb-4">
      <div class="card reward-card position-relative">
        <!-- Stock Indicator -->
        <div class="stock-indicator {{ ($reward->stock === null || $reward->stock > 0) ? 'in-stock' : '' }}">
          {{ $reward->stock === null ? 'Unlimited' : ($reward->stock > 0 ? 'In Stock' : 'Out of Stock') }}
        </div>

        <div class="card-header">
          <div class="reward-icon">
            @switch($reward->type)
              @case('shipping')
                <i class="bi bi-truck text-success"></i>
                @break
              @case('discount')
                <i class="bi bi-percent text-warning"></i>
                @break
              @case('voucher')
                <i class="bi bi-cash text-info"></i>
                @break
              @default
                <i class="bi bi-gift text-primary"></i>
            @endswitch
          </div>
          <h6 class="reward-name">{{ $reward->name }}</h6>
          <span class="reward-points">{{ number_format($reward->points_required) }} Points</span>
        </div>

        <div class="card-body">
          <div class="reward-value mb-2">{{ $reward->value }}</div>
          <p class="reward-description">{{ $reward->description }}</p>
          
          @if($reward->conditions)
          <div class="reward-conditions">
            <h6><i class="bi bi-info-circle me-1"></i>Conditions:</h6>
            <ul class="small mb-0">
              @foreach($reward->conditions as $condition)
                <li>{{ $condition }}</li>
              @endforeach
            </ul>
          </div>
          @endif

          <div class="d-grid">
            @if($reward->stock !== null && $reward->stock <= 0)
              <button class="btn btn-redeem" disabled>
                <i class="bi bi-x-circle me-1"></i>Out of Stock
              </button>
            @elseif($user->eco_points < $reward->points_required)
              <button class="btn btn-redeem" disabled>
                <i class="bi bi-lock me-1"></i>Need {{ number_format($reward->points_required - $user->eco_points) }} More Points
              </button>
            @else
              <form action="{{ route('eco-points.redeem', $reward->id) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-redeem w-100" onclick="return confirm('Are you sure you want to redeem {{ $reward->name }} for {{ number_format($reward->points_required) }} points?')">
                  <i class="bi bi-gift me-1"></i>Redeem Now
                </button>
              </form>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  @if($rewards->isEmpty())
  <div class="text-center py-5">
    <i class="bi bi-gift" style="font-size: 4rem; color: #9ca3af;"></i>
    <h5 class="mt-3 text-muted">No Rewards Available</h5>
    <p class="text-muted">Check back later for exciting eco-friendly rewards!</p>
    <a href="{{ route('profile') }}" class="btn btn-primary">
      <i class="bi bi-arrow-left me-1"></i>Back to Profile
    </a>
  </div>
  @endif

  <!-- How to Earn More Points -->
  <div class="row mt-5">
    <div class="col-12">
      <div class="card reward-card">
        <div class="card-header">
          <h5><i class="bi bi-lightbulb me-2"></i>How to Earn More Eco-Points</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <span><i class="bi bi-cart me-2 text-success"></i>Place an eco-friendly order</span>
                  <span class="badge bg-success rounded-pill">+10 points</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <span><i class="bi bi-people me-2 text-info"></i>Refer a friend</span>
                  <span class="badge bg-info rounded-pill">+50 points</span>
                </li>
              </ul>
            </div>
            <div class="col-md-6">
              <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <span><i class="bi bi-person-check me-2 text-warning"></i>Complete your profile</span>
                  <span class="badge bg-warning rounded-pill">+25 points</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <span><i class="bi bi-star me-2 text-secondary"></i>Write a product review</span>
                  <span class="badge bg-secondary rounded-pill">+5 points</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

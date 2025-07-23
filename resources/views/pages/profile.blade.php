@extends('layouts.app')

@section('content')
<style>
  /* Modern Professional Profile Styling */
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

  .page-header h4 {
    margin: 0;
    font-weight: 600;
    font-size: 1.5rem;
    position: relative;
    z-index: 2;
  }

  .page-header .btn {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    backdrop-filter: blur(10px);
    transition: all 0.2s ease;
    position: relative;
    z-index: 2;
  }

  .page-header .btn:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.3);
    color: white;
    transform: translateY(-2px);
  }

  /* Profile Header Card */
  .profile-header-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    border: none;
    margin-bottom: 2rem;
  }

  .profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 1rem;
    border: 4px solid white;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
  }

  .profile-name {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
  }

  .profile-role {
    color: #6b7280;
    font-size: 0.875rem;
    margin-bottom: 0;
  }

  /* Content Cards */
  .content-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    border: none;
    height: 100%;
  }

  .content-card .card-header {
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
    padding: 1.5rem;
  }

  .content-card .card-body {
    padding: 1.5rem;
  }

  .content-card h6 {
    color: #1f2937;
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 0;
  }

  /* Form Switches */
  .form-check-input {
    background-color: #e5e7eb;
    border-color: #d1d5db;
    border-radius: 1rem;
    width: 2.5rem;
    height: 1.25rem;
  }

  .form-check-input:checked {
    background-color: #3b82f6;
    border-color: #3b82f6;
  }

  .form-check-input:focus {
    border-color: #93c5fd;
    box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
  }

  .form-check-label {
    color: #374151;
    font-size: 0.875rem;
    margin-left: 0.75rem;
  }

  /* List Group Items */
  .list-group-item {
    border: none;
    padding: 0.75rem 0;
    background: transparent;
  }

  .list-group-item:not(:last-child) {
    border-bottom: 1px solid #f3f4f6;
  }

  /* Section Headers */
  .section-header {
    color: #6b7280;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 1rem;
    margin-top: 1.5rem;
  }

  .section-header:first-child {
    margin-top: 0;
  }

  /* Profile Details */
  .profile-detail {
    display: flex;
    align-items: center;
    font-size: 0.875rem;
    color: #374151;
  }

  .profile-detail strong {
    color: #1f2937;
    font-weight: 600;
    min-width: 100px;
  }

  /* Statistics Cards */
  .stat-card {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    border-radius: 1rem;
    padding: 1.5rem;
    color: white;
    text-align: center;
    position: relative;
    overflow: hidden;
    margin-bottom: 1.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(59, 130, 246, 0.4);
  }

  .stat-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    border-radius: 50%;
  }

  .stat-card h3 {
    margin: 0;
    font-weight: 700;
    font-size: 2rem;
    position: relative;
    z-index: 2;
  }

  .stat-card p {
    margin: 0;
    font-weight: 500;
    opacity: 0.9;
    position: relative;
    z-index: 2;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .page-header {
      padding: 1.5rem;
    }

    .page-header h4 {
      font-size: 1.25rem;
    }

    .profile-avatar {
      width: 80px;
      height: 80px;
    }

    .profile-name {
      font-size: 1.25rem;
    }

    .content-card .card-header,
    .content-card .card-body {
      padding: 1rem;
    }
  }
</style>

<div class="container-fluid py-4">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h4><i class="bi bi-person-circle me-2"></i>My Profile</h4>
        <p class="mb-0 opacity-75">Manage your eco-conscious profile and preferences</p>
      </div>
      <a href="{{ route('dashboard') }}" class="btn">
        <i class="bi bi-house-door me-1"></i>Home
      </a>
    </div>
  </div>

  <!-- Profile Header Card -->
  <div class="card profile-header-card">
    <div class="card-body p-4">
      <div class="d-flex flex-column flex-md-row align-items-center">
        <div class="text-center text-md-start mb-3 mb-md-0 me-md-4">
          <img src="{{ asset('assets') }}/img/bruce-mars.jpg" alt="profile_image" class="profile-avatar">
        </div>
        <div class="flex-grow-1 text-center text-md-start">
          <h5 class="profile-name">{{ Auth::user()->name }}</h5>
          <p class="profile-role">{{ ucfirst(Auth::user()->role) }} | Eco-Conscious Member</p>
          <p class="text-muted mb-0">Committed to sustainable living and environmental responsibility. Making conscious choices that contribute to a healthier planet for future generations.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Content Section -->
  <div class="row">
    <!-- Profile Information -->
    <div class="col-12 col-lg-6 mb-4">
      <div class="card content-card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6><i class="bi bi-person-badge me-2"></i>Profile Information</h6>
          <button type="button" class="btn btn-link text-primary p-0" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            <i class="bi bi-pencil-square"></i>
          </button>
        </div>
        <div class="card-body">
          <ul class="list-group">
            <li class="list-group-item profile-detail">
              <strong>Full Name:</strong> <span class="ms-auto">{{ Auth::user()->name }}</span>
            </li>
            <li class="list-group-item profile-detail">
              <strong>Email:</strong> <span class="ms-auto">{{ Auth::user()->email }}</span>
            </li>
            <li class="list-group-item profile-detail">
              <strong>Phone:</strong> <span class="ms-auto">{{ Auth::user()->phone ?? 'Not provided' }}</span>
            </li>
            <li class="list-group-item profile-detail">
              <strong>Location:</strong> <span class="ms-auto">{{ Auth::user()->location ?? 'Kampala, Uganda' }}</span>
            </li>
            <li class="list-group-item profile-detail">
              <strong>Role:</strong> <span class="ms-auto">{{ ucfirst(Auth::user()->role) }}</span>
            </li>
            <li class="list-group-item profile-detail">
              <strong>Member Since:</strong> <span class="ms-auto">{{ Auth::user()->created_at->format('M Y') }}</span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Eco-Preferences -->
    <div class="col-12 col-lg-6 mb-4">
      <div class="card content-card">
        <div class="card-header">
          <h6><i class="bi bi-sliders me-2"></i>Eco-Preferences</h6>
        </div>
        <div class="card-body">
          <div class="section-header">Notifications</div>
          <ul class="list-group">
            <li class="list-group-item">
              <div class="form-check form-switch d-flex align-items-center">
                <input class="form-check-input" type="checkbox" id="notif1" checked>
                <label class="form-check-label" for="notif1">
                  New eco-friendly products available
                </label>
              </div>
            </li>
            <li class="list-group-item">
              <div class="form-check form-switch d-flex align-items-center">
                <input class="form-check-input" type="checkbox" id="notif2">
                <label class="form-check-label" for="notif2">
                  Order status and delivery updates
                </label>
              </div>
            </li>
            <li class="list-group-item">
              <div class="form-check form-switch d-flex align-items-center">
                <input class="form-check-input" type="checkbox" id="notif3" checked>
                <label class="form-check-label" for="notif3">
                  Sustainability tips and insights
                </label>
              </div>
            </li>
          </ul>
          
          <div class="section-header">Sustainability Features</div>
          <ul class="list-group">
            <li class="list-group-item">
              <div class="form-check form-switch d-flex align-items-center">
                <input class="form-check-input" type="checkbox" id="feature1">
                <label class="form-check-label" for="feature1">
                  Carbon footprint tracking
                </label>
              </div>
            </li>
            <li class="list-group-item">
              <div class="form-check form-switch d-flex align-items-center">
                <input class="form-check-input" type="checkbox" id="feature2" checked>
                <label class="form-check-label" for="feature2">
                  Weekly sustainability reports
                </label>
              </div>
            </li>
            <li class="list-group-item">
              <div class="form-check form-switch d-flex align-items-center">
                <input class="form-check-input" type="checkbox" id="feature3">
                <label class="form-check-label" for="feature3">
                  Eco-newsletter subscription
                </label>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Statistics Section -->
  <div class="row">
    <div class="col-12 mb-4">
      <h5 class="mb-3"><i class="bi bi-graph-up me-2"></i>My Eco Impact</h5>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-4">
      <a href="{{ route('orders.index') }}" class="text-decoration-none">
        <div class="stat-card" data-stat="orders">
          <h3>{{ Auth::user()->orders()->count() }}</h3>
          <p>Orders Placed</p>
          <small class="mt-2 d-block opacity-75">
            <i class="bi bi-arrow-right me-1"></i>View Details
          </small>
        </div>
      </a>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-4">
      <div class="stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);" data-stat="ecopoints" onclick="showEcoPointsModal()">
        <h3>{{ Auth::user()->eco_points ?? 0 }}</h3>
        <p>Eco Points Earned</p>
        <small class="mt-2 d-block opacity-75">
          <i class="bi bi-arrow-right me-1"></i>View Details
        </small>
      </div>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-4">
      <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);" data-stat="carbon" onclick="showCarbonImpactModal()">
        <h3>0kg</h3>
        <p>CO₂ Saved</p>
        <small class="mt-2 d-block opacity-75">
          <i class="bi bi-arrow-right me-1"></i>View Details
        </small>
      </div>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-4">
      <div class="stat-card" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);" data-stat="membership" onclick="showMembershipModal()">
        <h3>{{ Auth::user()->created_at->format('M Y') }}</h3>
        <p>Member Since</p>
        <small class="mt-2 d-block opacity-75">
          <i class="bi bi-arrow-right me-1"></i>View Details
        </small>
      </div>
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="row">
    <div class="col-12">
      <div class="card content-card">
        <div class="card-header">
          <h6><i class="bi bi-lightning me-2"></i>Quick Actions</h6>
        </div>
        <div class="card-body">
          <div class="d-flex flex-wrap gap-3">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
              <i class="bi bi-house-door me-2"></i>Dashboard
            </a>
            <a href="{{ route('orders.index') }}" class="btn btn-outline-success">
              <i class="bi bi-cart me-2"></i>My Orders
            </a>
            <a href="{{ route('eco-points.rewards') }}" class="btn btn-outline-info">
              <i class="bi bi-gift me-2"></i>Redeem Points
            </a>
            <a href="{{ route('eco-points.history') }}" class="btn btn-outline-success">
              <i class="bi bi-clock-history me-2"></i>My Vouchers
            </a>
            <a href="{{ route('profile.settings') }}" class="btn btn-outline-warning">
              <i class="bi bi-gear me-2"></i>Settings
            </a>
            <a href="{{ route('support') }}" class="btn btn-outline-secondary">
              <i class="bi bi-question-circle me-2"></i>Help & Support
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Eco Points Modal -->
<div class="modal fade" id="ecoPointsModal" tabindex="-1" aria-labelledby="ecoPointsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="ecoPointsModalLabel">
          <i class="bi bi-leaf me-2"></i>Eco Points Details
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="card border-success mb-3">
              <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="bi bi-trophy me-2"></i>Current Points</h6>
              </div>
              <div class="card-body text-center">
                <h2 class="text-success">{{ Auth::user()->eco_points ?? 0 }}</h2>
                <p class="text-muted">Total Eco Points Earned</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card border-info mb-3">
              <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-gift me-2"></i>Rewards Available</h6>
              </div>
              <div class="card-body text-center">
                <h2 class="text-info">{{ Auth::user()->eco_points >= 100 ? Auth::user()->eco_points : 0 }}</h2>
                <p class="text-muted">Points Ready to Redeem</p>
                @if(Auth::user()->eco_points < 100)
                  <small class="text-muted">Minimum 100 points needed</small>
                @endif
              </div>
            </div>
          </div>
        </div>
        <h6><i class="bi bi-clock-history me-2"></i>How to Earn Points</h6>
        <ul class="list-group list-group-flush">
          <li class="list-group-item d-flex justify-content-between align-items-center">
            Place an eco-friendly order
            <span class="badge bg-success rounded-pill">+10 points</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            Refer a friend
            <span class="badge bg-success rounded-pill">+50 points</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            Complete profile
            <span class="badge bg-success rounded-pill">+25 points</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            Write product review
            <span class="badge bg-success rounded-pill">+5 points</span>
          </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="{{ route('eco-points.history') }}" class="btn btn-info">
          <i class="bi bi-clock-history me-1"></i>My Vouchers
        </a>
        <a href="{{ route('eco-points.rewards') }}" class="btn btn-success">
          <i class="bi bi-shop me-1"></i>Browse Rewards
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Carbon Impact Modal -->
<div class="modal fade" id="carbonImpactModal" tabindex="-1" aria-labelledby="carbonImpactModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title" id="carbonImpactModalLabel">
          <i class="bi bi-globe me-2"></i>Carbon Footprint Impact
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <div class="card border-warning mb-3">
              <div class="card-header bg-warning text-dark">
                <h6 class="mb-0"><i class="bi bi-cloud me-2"></i>CO₂ Saved</h6>
              </div>
              <div class="card-body text-center">
                <h2 class="text-warning">0kg</h2>
                <p class="text-muted">This Month</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card border-success mb-3">
              <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="bi bi-tree me-2"></i>Trees Equivalent</h6>
              </div>
              <div class="card-body text-center">
                <h2 class="text-success">0</h2>
                <p class="text-muted">Trees Planted</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card border-info mb-3">
              <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-speedometer2 me-2"></i>Your Impact</h6>
              </div>
              <div class="card-body text-center">
                <h2 class="text-info">0%</h2>
                <p class="text-muted">Above Average</p>
              </div>
            </div>
          </div>
        </div>
        <h6><i class="bi bi-info-circle me-2"></i>Environmental Impact Breakdown</h6>
        <div class="progress-stacked">
          <div class="progress" role="progressbar" aria-label="Packaging" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 30%">
            <div class="progress-bar bg-success">Eco Packaging</div>
          </div>
          <div class="progress" role="progressbar" aria-label="Transport" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 25%">
            <div class="progress-bar bg-warning">Local Transport</div>
          </div>
          <div class="progress" role="progressbar" aria-label="Products" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
            <div class="progress-bar bg-info">Sustainable Products</div>
          </div>
        </div>
        <p class="text-muted mt-2 small">Start making eco-friendly purchases to see your positive environmental impact!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="{{ route('dashboard') }}" class="btn btn-warning">
          <i class="bi bi-leaf me-1"></i>Shop Eco-Friendly
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Membership Modal -->
<div class="modal fade" id="membershipModal" tabindex="-1" aria-labelledby="membershipModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="membershipModalLabel">
          <i class="bi bi-person-badge me-2"></i>Membership Details
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="card border-primary mb-3">
              <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Member Since</h6>
              </div>
              <div class="card-body text-center">
                <h2 class="text-primary">{{ Auth::user()->created_at->format('M Y') }}</h2>
                <p class="text-muted">{{ Auth::user()->created_at->diffForHumans() }}</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card border-info mb-3">
              <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-star me-2"></i>Membership Level</h6>
              </div>
              <div class="card-body text-center">
                <h2 class="text-info">{{ ucfirst(Auth::user()->role) }}</h2>
                <p class="text-muted">Current Status</p>
              </div>
            </div>
          </div>
        </div>
        <h6><i class="bi bi-award me-2"></i>Membership Benefits</h6>
        <ul class="list-group list-group-flush">
          <li class="list-group-item d-flex align-items-center">
            <i class="bi bi-check-circle text-success me-2"></i>
            Access to eco-friendly marketplace
          </li>
          <li class="list-group-item d-flex align-items-center">
            <i class="bi bi-check-circle text-success me-2"></i>
            Exclusive sustainable product deals
          </li>
          <li class="list-group-item d-flex align-items-center">
            <i class="bi bi-check-circle text-success me-2"></i>
            Carbon footprint tracking
          </li>
          <li class="list-group-item d-flex align-items-center">
            <i class="bi bi-check-circle text-success me-2"></i>
            Community forums and support
          </li>
          <li class="list-group-item d-flex align-items-center">
            <i class="bi bi-check-circle text-success me-2"></i>
            Eco-points reward system
          </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="{{ route('profile.settings') }}" class="btn btn-primary">
          <i class="bi bi-gear me-1"></i>Account Settings
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProfileModalLabel">
          <i class="bi bi-person-gear me-2"></i>Edit Profile Information
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="name" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="email" class="form-label">Email Address</label>
              <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="phone" class="form-label">Phone Number</label>
              <input type="tel" class="form-control" id="phone" name="phone" value="{{ Auth::user()->phone }}">
            </div>
            <div class="col-md-6 mb-3">
              <label for="location" class="form-label">Location</label>
              <input type="text" class="form-control" id="location" name="location" value="{{ Auth::user()->location }}" placeholder="Kampala, Uganda">
            </div>
            <div class="col-12 mb-3">
              <label for="about" class="form-label">About Me</label>
              <textarea class="form-control" id="about" name="about" rows="3" placeholder="Tell us about your eco-conscious journey...">{{ Auth::user()->about }}</textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg me-1"></i>Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle eco-preference switches
    const switches = document.querySelectorAll('.form-check-input');
    
    switches.forEach(switch_ => {
        switch_.addEventListener('change', function() {
            const prefName = this.id;
            const isEnabled = this.checked;
            
            // Show a toast notification
            showToast(`${this.nextElementSibling.textContent.trim()} ${isEnabled ? 'enabled' : 'disabled'}`, 
                     isEnabled ? 'success' : 'info');
            
            // Here you can add AJAX call to save preferences
            // savePreference(prefName, isEnabled);
        });
    });
    
    // Toast notification function
    function showToast(message, type = 'info') {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        toast.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(toast);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (toast.parentNode) {
                toast.remove();
            }
        }, 3000);
    }
    
    // Stats cards click handlers for non-linked cards
    document.querySelectorAll('.stat-card:not([onclick])').forEach(card => {
        if (!card.closest('a')) {
            card.style.cursor = 'pointer';
            card.addEventListener('click', function() {
                const statType = this.querySelector('p').textContent.trim();
                showToast(`Viewing detailed ${statType} information`, 'info');
            });
        }
    });
});

// Modal functions for eco impact stats
function showEcoPointsModal() {
    const modal = new bootstrap.Modal(document.getElementById('ecoPointsModal'));
    modal.show();
}

function showCarbonImpactModal() {
    const modal = new bootstrap.Modal(document.getElementById('carbonImpactModal'));
    modal.show();
}

function showMembershipModal() {
    const modal = new bootstrap.Modal(document.getElementById('membershipModal'));
    modal.show();
}

// Function to save eco-preferences (you can implement AJAX here)
function savePreference(prefName, isEnabled) {
    // Example AJAX call structure
    /*
    fetch('/profile/preferences', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            preference: prefName,
            enabled: isEnabled
        })
    });
    */
}
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

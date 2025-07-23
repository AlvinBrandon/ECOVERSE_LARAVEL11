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
          <a href="javascript:;" class="text-primary">
            <i class="bi bi-pencil-square"></i>
          </a>
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
      <div class="stat-card">
        <h3>0</h3>
        <p>Orders Placed</p>
      </div>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-4">
      <div class="stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
        <h3>0</h3>
        <p>Eco Points Earned</p>
      </div>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-4">
      <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
        <h3>0kg</h3>
        <p>CO₂ Saved</p>
      </div>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-4">
      <div class="stat-card" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
        <h3>{{ Auth::user()->created_at->format('M Y') }}</h3>
        <p>Member Since</p>
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
            <a href="#" class="btn btn-outline-success">
              <i class="bi bi-cart me-2"></i>My Orders
            </a>
            <a href="#" class="btn btn-outline-info">
              <i class="bi bi-gear me-2"></i>Settings
            </a>
            <a href="#" class="btn btn-outline-warning">
              <i class="bi bi-question-circle me-2"></i>Help & Support
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

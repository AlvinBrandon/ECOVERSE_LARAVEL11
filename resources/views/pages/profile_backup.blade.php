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
                                        </li>
                                        <li class="list-group-item border-0 px-0">
                                            <div class="form-check form-switch ps-0">
                                                <input class="form-check-input ms-auto" type="checkbox"
                                                    id="flexSwitchCheckDefault1">
                                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                                    for="flexSwitchCheckDefault1">Order status and delivery updates</label>
                                            </div>
                                        </li>
                                        <li class="list-group-item border-0 px-0">
                                            <div class="form-check form-switch ps-0">
                                                <input class="form-check-input ms-auto" type="checkbox"
                                                    id="flexSwitchCheckDefault2" checked>
                                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                                    for="flexSwitchCheckDefault2">Sustainability tips and insights</label>
                                            </div>
                                        </li>
                                    </ul>
                                    <h6 class="text-uppercase text-body text-xs font-weight-bolder mt-4">Sustainability Features
                                    </h6>
                                    <ul class="list-group">
                                        <li class="list-group-item border-0 px-0">
                                            <div class="form-check form-switch ps-0">
                                                <input class="form-check-input ms-auto" type="checkbox"
                                                    id="flexSwitchCheckDefault3">
                                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                                    for="flexSwitchCheckDefault3">Carbon footprint tracking</label>
                                            </div>
                                        </li>
                                        <li class="list-group-item border-0 px-0">
                                            <div class="form-check form-switch ps-0">
                                                <input class="form-check-input ms-auto" type="checkbox"
                                                    id="flexSwitchCheckDefault4" checked>
                                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                                    for="flexSwitchCheckDefault4">Weekly sustainability reports</label>
                                            </div>
                                        </li>
                                        <li class="list-group-item border-0 px-0 pb-0">
                                            <div class="form-check form-switch ps-0">
                                                <input class="form-check-input ms-auto" type="checkbox"
                                                    id="flexSwitchCheckDefault5">
                                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                                    for="flexSwitchCheckDefault5">Eco-newsletter subscription</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-4">
                            <div class="card card-plain h-100">
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <h6 class="mb-0">Ecoverse Profile</h6>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <a href="javascript:;">
                                                <i class="fas fa-user-edit text-secondary text-sm"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Edit Profile"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <p class="text-sm">
                                        Hi, I’m Alec Thompson, Decisions: If you can’t decide, the answer is no. If
                                        two equally difficult paths, choose the one more painful in the short term
                                        (pain avoidance is creating an illusion of equality).
                                    </p>
                                    <hr class="horizontal gray-light my-4">
                                    <ul class="list-group">
                                        <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong
                                                class="text-dark">Full Name:</strong> &nbsp; {{ Auth::user()->name }}</li>
                                        <li class="list-group-item border-0 ps-0 text-sm"><strong
                                                class="text-dark">Phone:</strong> &nbsp; {{ Auth::user()->phone ?? '(+256) 123 456 789' }}</li>
                                        <li class="list-group-item border-0 ps-0 text-sm"><strong
                                                class="text-dark">Email:</strong> &nbsp; {{ Auth::user()->email }}</li>
                                        <li class="list-group-item border-0 ps-0 text-sm"><strong
                                                class="text-dark">Location:</strong> &nbsp; {{ Auth::user()->location ?? 'Kampala, Uganda' }}</li>
                                        <li class="list-group-item border-0 ps-0 text-sm"><strong
                                                class="text-dark">Member Since:</strong> &nbsp; {{ Auth::user()->created_at->format('M Y') }}</li>
                                        <li class="list-group-item border-0 ps-0 pb-0">
                                            <strong class="text-dark text-sm">Eco-Actions:</strong> &nbsp;
                                            <a class="btn btn-success btn-simple mb-0 ps-1 pe-2 py-0"
                                                href="javascript:;" title="Recycling Programs">
                                                <i class="fas fa-recycle fa-lg"></i>
                                            </a>
                                            <a class="btn btn-primary btn-simple mb-0 ps-1 pe-2 py-0"
                                                href="javascript:;" title="Green Initiatives">
                                                <i class="fas fa-leaf fa-lg"></i>
                                            </a>
                                            <a class="btn btn-warning btn-simple mb-0 ps-1 pe-2 py-0"
                                                href="javascript:;" title="Solar Energy">
                                                <i class="fas fa-solar-panel fa-lg"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-4">
                            <div class="card card-plain h-100">
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-0">Eco-Business Communications</h6>
                                </div>
                                <div class="card-body p-3">
                                    <ul class="list-group">
                                        <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2 pt-0">
                                            <div class="avatar me-3">
                                                <img src="{{ asset('assets') }}/img/kal-visuals-square.jpg" alt="kal"
                                                    class="border-radius-lg shadow">
                                            </div>
                                            <div class="d-flex align-items-start flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">EcoSupplier Uganda</h6>
                                                <p class="mb-0 text-xs">New sustainable packaging options available..</p>
                                            </div>
                                            <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto w-25 w-md-auto"
                                                href="javascript:;">Reply</a>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                                            <div class="avatar me-3">
                                                <img src="{{ asset('assets') }}/img/marie.jpg" alt="kal"
                                                    class="border-radius-lg shadow">
                                            </div>
                                            <div class="d-flex align-items-start flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Green Logistics Ltd</h6>
                                                <p class="mb-0 text-xs">Carbon-neutral shipping update..</p>
                                            </div>
                                            <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto w-25 w-md-auto"
                                                href="javascript:;">Reply</a>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                                            <div class="avatar me-3">
                                                <img src="{{ asset('assets') }}/img/ivana-square.jpg" alt="kal"
                                                    class="border-radius-lg shadow">
                                            </div>
                                            <div class="d-flex align-items-start flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Renewable Resources Co</h6>
                                                <p class="mb-0 text-xs">Solar panel installation quote..</p>
                                            </div>
                                            <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto w-25 w-md-auto"
                                                href="javascript:;">Reply</a>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                                            <div class="avatar me-3">
                                                <img src="{{ asset('assets') }}/img/team-4.jpg" alt="kal"
                                                    class="border-radius-lg shadow">
                                            </div>
                                            <div class="d-flex align-items-start flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Peterson</h6>
                                                <p class="mb-0 text-xs">Have a great afternoon..</p>
                                            </div>
                                            <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto w-25 w-md-auto"
                                                href="javascript:;">Reply</a>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center px-0">
                                            <div class="avatar me-3">
                                                <img src="{{ asset('assets') }}/img/team-3.jpg" alt="kal"
                                                    class="border-radius-lg shadow">
                                            </div>
                                            <div class="d-flex align-items-start flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Nick Daniel</h6>
                                                <p class="mb-0 text-xs">Hi! I need more information..</p>
                                            </div>
                                            <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto w-25 w-md-auto"
                                                href="javascript:;">Reply</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <div class="mb-5 ps-3">
                                <h6 class="mb-1">Sustainability Initiatives</h6>
                                <p class="text-sm">Architects design houses</p>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                                    <div class="card card-blog card-plain">
                                        <div class="card-header p-0 mt-n4 mx-3">
                                            <a class="d-block shadow-xl border-radius-xl">
                                                <img src="{{ asset('assets') }}/img/home-decor-1.jpg"
                                                    alt="img-blur-shadow" class="img-fluid shadow border-radius-xl">
                                            </a>
                                        </div>
                                        <div class="card-body p-3">
                                            <p class="mb-0 text-sm">Recycling Initiative #1</p>
                                            <a href="javascript:;">
                                                <h5>
                                                    Plastic-Free Packaging
                                                </h5>
                                            </a>
                                            <p class="mb-4 text-sm">
                                                Implementing biodegradable packaging solutions to reduce environmental impact across all product lines.
                                            </p>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <button type="button" class="btn btn-outline-primary btn-sm mb-0">View
                                                    Initiative</button>
                                                <div class="avatar-group mt-2">
                                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        title="Elena Morison">
                                                        <img alt="Image placeholder"
                                                            src="{{ asset('assets') }}/img/team-1.jpg">
                                                    </a>
                                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        title="Ryan Milly">
                                                        <img alt="Image placeholder"
                                                            src="{{ asset('assets') }}/img/team-2.jpg">
                                                    </a>
                                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        title="Nick Daniel">
                                                        <img alt="Image placeholder"
                                                            src="{{ asset('assets') }}/img/team-3.jpg">
                                                    </a>
                                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        title="Peterson">
                                                        <img alt="Image placeholder"
                                                            src="{{ asset('assets') }}/img/team-4.jpg">
                                                    </a>
  <!-- Content Section -->
  <div class="tab-content">
    <!-- Sustainability Tab -->
    <div class="tab-pane fade show active" id="sustainability">
      <div class="row">
        <!-- Eco-Preferences Card -->
        <div class="col-12 col-xl-4 mb-4">
          <div class="card content-card">
            <div class="card-header">
              <h6><i class="bi bi-sliders me-2"></i>Eco-Preferences</h6>
            </div>
            <div class="card-body">
              <div class="section-header">Notifications</div>
              <ul class="list-group">
                <li class="list-group-item">
                  <div class="form-check form-switch d-flex align-items-center">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" checked>
                    <label class="form-check-label" for="flexSwitchCheckDefault">
                      New eco-friendly products available
                    </label>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="form-check form-switch d-flex align-items-center">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault1">
                    <label class="form-check-label" for="flexSwitchCheckDefault1">
                      Order status and delivery updates
                    </label>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="form-check form-switch d-flex align-items-center">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault2" checked>
                    <label class="form-check-label" for="flexSwitchCheckDefault2">
                      Sustainability tips and insights
                    </label>
                  </div>
                </li>
              </ul>
              
              <div class="section-header">Sustainability Features</div>
              <ul class="list-group">
                <li class="list-group-item">
                  <div class="form-check form-switch d-flex align-items-center">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault3">
                    <label class="form-check-label" for="flexSwitchCheckDefault3">
                      Carbon footprint tracking
                    </label>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="form-check form-switch d-flex align-items-center">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault4" checked>
                    <label class="form-check-label" for="flexSwitchCheckDefault4">
                      Weekly sustainability reports
                    </label>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="form-check form-switch d-flex align-items-center">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault5">
                    <label class="form-check-label" for="flexSwitchCheckDefault5">
                      Eco-newsletter subscription
                    </label>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Profile Information Card -->
        <div class="col-12 col-xl-4 mb-4">
          <div class="card content-card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h6><i class="bi bi-person-badge me-2"></i>Profile Information</h6>
              <a href="javascript:;" class="text-primary">
                <i class="bi bi-pencil-square"></i>
              </a>
            </div>
            <div class="card-body">
              <p class="text-muted mb-4">
                Hi, I'm {{ Auth::user()->name }}. Decisions: If you can't decide, the answer is no. If two equally difficult paths, choose the one more painful in the short term (pain avoidance is creating an illusion of equality).
              </p>
              
              <ul class="list-group">
                <li class="list-group-item profile-detail">
                  <strong>Full Name:</strong> <span class="ms-auto">{{ Auth::user()->name }}</span>
                </li>
                <li class="list-group-item profile-detail">
                  <strong>Phone:</strong> <span class="ms-auto">{{ Auth::user()->phone ?? '(+256) 123 456 789' }}</span>
                </li>
                <li class="list-group-item profile-detail">
                  <strong>Email:</strong> <span class="ms-auto">{{ Auth::user()->email }}</span>
                </li>
                <li class="list-group-item profile-detail">
                  <strong>Location:</strong> <span class="ms-auto">{{ Auth::user()->location ?? 'Kampala, Uganda' }}</span>
                </li>
                <li class="list-group-item profile-detail">
                  <strong>Member Since:</strong> <span class="ms-auto">{{ Auth::user()->created_at->format('M Y') }}</span>
                </li>
                <li class="list-group-item">
                  <div class="d-flex align-items-center">
                    <strong class="text-dark">Eco-Actions:</strong>
                    <div class="ms-auto">
                      <button class="eco-action-btn btn-success" title="Recycling Programs">
                        <i class="bi bi-recycle"></i>
                      </button>
                      <button class="eco-action-btn btn-primary" title="Green Initiatives">
                        <i class="bi bi-leaf"></i>
                      </button>
                      <button class="eco-action-btn btn-warning" title="Solar Energy">
                        <i class="bi bi-sun"></i>
                      </button>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Eco-Business Communications Card -->
        <div class="col-12 col-xl-4 mb-4">
          <div class="card content-card">
            <div class="card-header">
              <h6><i class="bi bi-chat-dots me-2"></i>Eco-Business Communications</h6>
            </div>
            <div class="card-body">
              <div class="communication-item">
                <img src="{{ asset('assets') }}/img/kal-visuals-square.jpg" alt="EcoSupplier" class="communication-avatar">
                <div class="flex-grow-1 communication-content">
                  <h6>EcoSupplier Uganda</h6>
                  <p>New sustainable packaging options available..</p>
                </div>
                <button class="communication-reply">Reply</button>
              </div>
              
              <div class="communication-item">
                <img src="{{ asset('assets') }}/img/marie.jpg" alt="Green Logistics" class="communication-avatar">
                <div class="flex-grow-1 communication-content">
                  <h6>Green Logistics Ltd</h6>
                  <p>Carbon-neutral shipping update..</p>
                </div>
                <button class="communication-reply">Reply</button>
              </div>
              
              <div class="communication-item">
                <img src="{{ asset('assets') }}/img/ivana-square.jpg" alt="Renewable Resources" class="communication-avatar">
                <div class="flex-grow-1 communication-content">
                  <h6>Renewable Resources Co</h6>
                  <p>Solar panel installation quote..</p>
                </div>
                <button class="communication-reply">Reply</button>
              </div>
              
              <div class="communication-item">
                <img src="{{ asset('assets') }}/img/team-4.jpg" alt="Peterson" class="communication-avatar">
                <div class="flex-grow-1 communication-content">
                  <h6>Peterson</h6>
                  <p>Have a great afternoon..</p>
                </div>
                <button class="communication-reply">Reply</button>
              </div>
              
              <div class="communication-item">
                <img src="{{ asset('assets') }}/img/team-3.jpg" alt="Nick Daniel" class="communication-avatar">
                <div class="flex-grow-1 communication-content">
                  <h6>Nick Daniel</h6>
                  <p>Hi! I need more information..</p>
                </div>
                <button class="communication-reply">Reply</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Sustainability Initiatives Section -->
      <div class="row mt-4">
        <div class="col-12 mb-4">
          <div class="d-flex align-items-center mb-4">
            <div>
              <h5 class="mb-1"><i class="bi bi-lightbulb me-2"></i>Sustainability Initiatives</h5>
              <p class="text-muted mb-0">Projects and programs supporting environmental sustainability</p>
            </div>
          </div>
        </div>
        
        <!-- Initiative Cards -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card initiative-card">
            <img src="{{ asset('assets') }}/img/home-decor-1.jpg" alt="Plastic-Free Packaging" class="initiative-image">
            <div class="card-body">
              <p class="initiative-category">Recycling Initiative #1</p>
              <h5 class="initiative-title">
                <a href="javascript:;">Plastic-Free Packaging</a>
              </h5>
              <p class="initiative-description">
                Implementing biodegradable packaging solutions to reduce environmental impact across all product lines.
              </p>
              <div class="initiative-actions">
                <button class="btn-view-initiative">View Initiative</button>
                <div class="avatar-group">
                  <img src="{{ asset('assets') }}/img/team-1.jpg" alt="Elena" class="avatar" title="Elena Morison">
                  <img src="{{ asset('assets') }}/img/team-2.jpg" alt="Ryan" class="avatar" title="Ryan Milly">
                  <img src="{{ asset('assets') }}/img/team-3.jpg" alt="Nick" class="avatar" title="Nick Daniel">
                  <img src="{{ asset('assets') }}/img/team-4.jpg" alt="Peterson" class="avatar" title="Peterson">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card initiative-card">
            <img src="{{ asset('assets') }}/img/home-decor-2.jpg" alt="Solar Installation" class="initiative-image">
            <div class="card-body">
              <p class="initiative-category">Green Energy Project #1</p>
              <h5 class="initiative-title">
                <a href="javascript:;">Solar Installation</a>
              </h5>
              <p class="initiative-description">
                Installing solar panels and renewable energy systems to power sustainable operations.
              </p>
              <div class="initiative-actions">
                <button class="btn-view-initiative">View Initiative</button>
                <div class="avatar-group">
                  <img src="{{ asset('assets') }}/img/team-3.jpg" alt="Nick" class="avatar" title="Nick Daniel">
                  <img src="{{ asset('assets') }}/img/team-4.jpg" alt="Peterson" class="avatar" title="Peterson">
                  <img src="{{ asset('assets') }}/img/team-1.jpg" alt="Elena" class="avatar" title="Elena Morison">
                  <img src="{{ asset('assets') }}/img/team-2.jpg" alt="Ryan" class="avatar" title="Ryan Milly">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card initiative-card">
            <img src="{{ asset('assets') }}/img/home-decor-3.jpg" alt="Smart Irrigation" class="initiative-image">
            <div class="card-body">
              <p class="initiative-category">Water Conservation #1</p>
              <h5 class="initiative-title">
                <a href="javascript:;">Smart Irrigation</a>
              </h5>
              <p class="initiative-description">
                Implementing water-efficient systems and rainwater harvesting for sustainable agriculture.
              </p>
              <div class="initiative-actions">
                <button class="btn-view-initiative">View Initiative</button>
                <div class="avatar-group">
                  <img src="{{ asset('assets') }}/img/team-4.jpg" alt="Peterson" class="avatar" title="Peterson">
                  <img src="{{ asset('assets') }}/img/team-3.jpg" alt="Nick" class="avatar" title="Nick Daniel">
                  <img src="{{ asset('assets') }}/img/team-2.jpg" alt="Ryan" class="avatar" title="Ryan Milly">
                  <img src="{{ asset('assets') }}/img/team-1.jpg" alt="Elena" class="avatar" title="Elena Morison">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card initiative-card">
            <img src="https://images.unsplash.com/photo-1606744824163-985d376605aa?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Zero Emissions" class="initiative-image">
            <div class="card-body">
              <p class="initiative-category">Carbon Neutral Initiative</p>
              <h5 class="initiative-title">
                <a href="javascript:;">Zero Emissions</a>
              </h5>
              <p class="initiative-description">
                Achieving carbon neutrality through emission reduction and sustainable practices.
              </p>
              <div class="initiative-actions">
                <button class="btn-view-initiative">View Initiative</button>
                <div class="avatar-group">
                  <img src="{{ asset('assets') }}/img/team-4.jpg" alt="Peterson" class="avatar" title="Peterson">
                  <img src="{{ asset('assets') }}/img/team-3.jpg" alt="Nick" class="avatar" title="Nick Daniel">
                  <img src="{{ asset('assets') }}/img/team-2.jpg" alt="Ryan" class="avatar" title="Ryan Milly">
                  <img src="{{ asset('assets') }}/img/team-1.jpg" alt="Elena" class="avatar" title="Elena Morison">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Orders Tab -->
    <div class="tab-pane fade" id="orders">
      <div class="row">
        <div class="col-12">
          <div class="card content-card">
            <div class="card-header">
              <h6><i class="bi bi-cart me-2"></i>Recent Orders</h6>
            </div>
            <div class="card-body">
              <div class="text-center py-5">
                <i class="bi bi-cart-x text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-muted">Orders Coming Soon</h5>
                <p class="text-muted">Order management features will be available here.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Settings Tab -->
    <div class="tab-pane fade" id="settings">
      <div class="row">
        <div class="col-12">
          <div class="card content-card">
            <div class="card-header">
              <h6><i class="bi bi-gear me-2"></i>Account Settings</h6>
            </div>
            <div class="card-body">
              <div class="text-center py-5">
                <i class="bi bi-gear text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-muted">Settings Coming Soon</h5>
                <p class="text-muted">Account settings and preferences will be available here.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

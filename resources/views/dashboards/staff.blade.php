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
  }

  .dashboard-card {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.12);
    border: 1px solid rgba(255,255,255,0.2);
    padding: 2rem 1.5rem;
    margin-bottom: 2rem;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
  }

  .dashboard-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(16, 185, 129, 0.15);
  }

  .dashboard-header {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #10b981 100%) !important;
    color: #fff !important;
    border-radius: 1rem;
    padding: 2rem 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(99, 102, 241, 0.2);
    border: 1px solid rgba(255,255,255,0.1);
  }

  .dashboard-header h2 {
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }

  .dashboard-header h5 {
    font-weight: 600;
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }

  .dashboard-header p {
    font-weight: 400;
    opacity: 0.95;
    font-size: 1.1rem;
    margin-bottom: 0;
  }

  .welcome-section {
    background: rgba(255,255,255,0.9);
    border-radius: 1rem;
    padding: 1.5rem 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(16, 185, 129, 0.08);
    border: 1px solid rgba(255,255,255,0.3);
  }

  .welcome-section h5 {
    color: #374151;
    font-weight: 600;
    font-size: 1.25rem;
    margin-bottom: 0;
  }

  .dashboard-icon {
    font-size: 2.5rem;
    margin-right: 1rem;
    vertical-align: middle;
  }

  .ecoverse-logo {
    width: 52px;
    height: 52px;
    margin-right: 1.5rem;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid rgba(255,255,255,0.3);
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
  }

  /* Button Styling */
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
  }

  .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
  }

  .btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
  }

  .btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
  }

  .btn-info {
    background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
    color: white;
  }

  .btn-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
  }

  .btn-modern {
    border-radius: 0.75rem;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }

  .btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    text-decoration: none;
  }

  .btn-primary.btn-modern {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
  }

  .btn-success.btn-modern {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
  }

  .btn-warning.btn-modern {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
  }

  .btn-info.btn-modern {
    background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
    color: white;
  }

  /* Card Content Styling */
  .dashboard-card h5 {
    color: #1f2937;
    font-weight: 600;
    font-size: 1.25rem;
    margin-bottom: 0.75rem;
  }

  .dashboard-card h6 {
    color: #1f2937;
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
  }

  .dashboard-card p {
    color: #6b7280;
    font-weight: 400;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 1rem;
  }

  .dashboard-card i {
    margin-bottom: 1rem;
    opacity: 0.8;
  }

  /* Action Cards */
  .action-card {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    padding: 2rem 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    border: 1px solid rgba(255,255,255,0.2);
    height: 100%;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.12);
    backdrop-filter: blur(10px);
  }

  .action-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(16, 185, 129, 0.15);
  }

  .action-card i {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    opacity: 0.8;
  }

  .action-card h6 {
    color: #1f2937;
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
  }

  .action-card p {
    color: #6b7280;
    font-size: 0.95rem;
    margin-bottom: 1.5rem;
    line-height: 1.5;
  }

  /* Stats Cards */
  .stats-card {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    padding: 2rem 1.5rem;
    text-align: center;
    border: 1px solid rgba(255,255,255,0.2);
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.12);
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
  }

  .stats-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(16, 185, 129, 0.15);
  }

  .stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
  }

  .stat-label {
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  /* Badge Styling */
  .badge {
    border-radius: 0.5rem;
    font-weight: 500;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
  }

  .badge.bg-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
  }

  .badge.bg-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
  }

  .badge.bg-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .dashboard-header {
      padding: 1.5rem 1rem;
    }
    
    .dashboard-header h2 {
      font-size: 1.5rem;
    }
    
    .dashboard-header h5 {
      font-size: 1.25rem;
    }
    
    .dashboard-card {
      padding: 1.5rem 1rem;
    }
    
    .welcome-section {
      padding: 1rem 1.5rem;
    }

    .action-card {
      padding: 1.5rem 1rem;
    }

    .stats-card {
      padding: 1.5rem 1rem;
    }

    .action-card i {
      font-size: 2rem;
    }

    .stat-number {
      font-size: 1.5rem;
    }
  }

  /* Professional spacing and layout */
  .row {
    margin-left: -0.75rem;
    margin-right: -0.75rem;
  }

  .row > div {
    padding-left: 0.75rem;
    padding-right: 0.75rem;
  }
</style>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<div class="container-fluid" style="padding: 2rem 1.5rem;">
  <!-- Dashboard Header -->
  <div class="dashboard-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h5><i class="bi bi-people me-2"></i>Welcome, {{ Auth::user()->name }}</h5>
        <p>Staff Dashboard - Manage operations and support business processes</p>
      </div>
    </div>
  </div>
  @include('dashboard-parts.staff')
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

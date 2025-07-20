@extends('layouts.app')

@section('content')
<style>
  /* Modern Professional Dashboard Styling */
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
  }

  /* Dashboard Header */
  .dashboard-header {
    background: linear-gradient(90deg, #6366f1 0%, #10b981 100%) !important;
    color: #fff !important;
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
  }

  .dashboard-header h5 {
    margin: 0;
    font-weight: 600;
    font-size: 1.5rem;
  }

  .dashboard-header p {
    margin: 0;
    opacity: 0.75;
    font-size: 1rem;
  }

  /* Dashboard Cards */
  .dashboard-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    padding: 2rem;
    margin-bottom: 2rem;
    border: 1px solid #f3f4f6;
    transition: all 0.2s ease;
  }

  .dashboard-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
  }

  .dashboard-card h5 {
    color: #1f2937;
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 1.25rem;
  }

  .dashboard-card p {
    color: #6b7280;
    margin-bottom: 1.5rem;
    line-height: 1.6;
  }

  /* Action Cards */
  .action-card {
    background: white;
    border-radius: 0.75rem;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.2s ease;
    border: 1px solid #f3f4f6;
    height: 100%;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  }

  .action-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border-color: #e5e7eb;
  }

  .action-card i {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color: #3b82f6;
  }

  .action-card h6 {
    color: #1f2937;
    font-weight: 600;
    margin-bottom: 0.5rem;
  }

  .action-card p {
    color: #6b7280;
    font-size: 0.875rem;
    margin-bottom: 1.5rem;
  }

  /* Modern Buttons */
  .btn-modern {
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.2s ease;
    border: none;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  .btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
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

  /* Stats Cards */
  .stats-card {
    background: white;
    border-radius: 0.75rem;
    padding: 1.5rem;
    text-align: center;
    border: 1px solid #f3f4f6;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    transition: all 0.2s ease;
  }

  .stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
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

  /* Icon Styling */
  .dashboard-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color: #3b82f6;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .dashboard-header {
      padding: 1.5rem;
    }

    .dashboard-header h5 {
      font-size: 1.25rem;
    }

    .dashboard-card {
      padding: 1.5rem;
    }

    .action-card {
      padding: 1.25rem;
    }

    .action-card i {
      font-size: 2rem;
    }

    .stat-number {
      font-size: 1.5rem;
    }
  }

  /* Badge Styling */
  .badge {
    border-radius: 0.375rem;
    font-weight: 500;
    padding: 0.375rem 0.75rem;
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
</style>

<div class="container-fluid py-4">
  <!-- Dashboard Header -->
  <div class="dashboard-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h5><i class="bi bi-shop me-2"></i>Welcome, {{ Auth::user()->name }}</h5>
        <p>Retailer Dashboard - Manage your retail operations and customer orders</p>
      </div>
    </div>
  </div>
  @include('dashboard-parts.retailer')
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

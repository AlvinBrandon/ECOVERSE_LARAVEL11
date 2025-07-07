@extends('layouts.app')

@section('content')
<style>
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%) !important;
  }
  .dashboard-card {
    background: rgba(255,255,255,0.95);
    border-radius: 1rem;
    box-shadow: 0 4px 24px rgba(16, 185, 129, 0.08);
    padding: 2rem 1.5rem;
    margin-bottom: 2rem;
  }
  .dashboard-header {
    background: linear-gradient(90deg, #6366f1 0%, #10b981 100%) !important;
    color: #fff !important;
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
    padding: 1.5rem 1.5rem 1rem 1.5rem;
    margin-bottom: 2rem;
  }
  .dashboard-icon {
    font-size: 2.5rem;
    margin-right: 1rem;
    vertical-align: middle;
  }
  .ecoverse-logo {
    width: 48px;
    height: 48px;
    margin-right: 1rem;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #10b981;
    background: #fff;
  }
</style>
<div class="container-fluid py-4">
  <div class="dashboard-header d-flex align-items-center">
    <img src="/assets/img/ecoverse-logo.svg" alt="Ecoverse Logo" class="ecoverse-logo">
    <div>
      <h2 class="mb-0">Ecoverse Packaging System</h2>
      <p class="mb-0" style="font-size:1.1rem;">Redefining packaging: Circular, sustainable, and profitable.</p>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <i class="bi bi-box-seam text-primary" style="font-size:2rem;"></i>
        <h5 class="mt-2">Packaging Inventory</h5>
        <p>Manage, track, transfer, and analyze your packaging stock.</p>
        <a href="{{ route('inventory.index') }}" class="btn btn-primary mt-2"><i class="bi bi-archive me-1"></i> Go to Inventory</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <i class="bi bi-cart-check text-success" style="font-size:2rem;"></i>
        <h5 class="mt-2">Sales</h5>
        <p>Record sales, view sales history, and generate reports for resalable packaging.</p>
        <a href="{{ route('sales.index') }}" class="btn btn-success mt-2"><i class="bi bi-cash-coin me-1"></i> Go to Sales</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <i class="bi bi-bar-chart text-info" style="font-size:2rem;"></i>
        <h5 class="mt-2">Analytics</h5>
        <p>Visualize inventory and sales trends with interactive charts.</p>
        <a href="{{ route('inventory.analytics') }}" class="btn btn-info mt-2"><i class="bi bi-graph-up-arrow me-1"></i> View Analytics</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <i class="bi bi-person-lines-fill text-warning" style="font-size:2rem;"></i>
        <h5 class="mt-2">Customers</h5>
        <p>Manage your customers and link them to sales for better tracking.</p>
        <a href="{{ route('customers.index') }}" class="btn btn-warning mt-2"><i class="bi bi-people me-1"></i> Go to Customers</a>
      </div>
    </div>
  </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

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
      <h2 class="mb-0">Supplier Dashboard</h2>
      <p class="mb-0" style="font-size:1.1rem;">Waste input: Submit waste, track deliveries, view payments.</p>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="dashboard-card text-center">
        <i class="bi bi-recycle text-primary" style="font-size:2rem;"></i>
        <h5 class="mt-2">Raw Material Management</h5>
        <p>Submit, view, and manage your raw materials for processing.</p>
        <a href="{{ route('raw-materials.index') }}" class="btn btn-primary mt-2"><i class="bi bi-list-ul me-1"></i> Manage Raw Materials</a>
      </div>
    </div>
    <div class="col-md-6">
      <div class="dashboard-card text-center">
        <i class="bi bi-cash-coin text-success" style="font-size:2rem;"></i>
        <h5 class="mt-2">Payments</h5>
        <p>View your compensation and delivery status.</p>
        <a href="#" class="btn btn-success mt-2"><i class="bi bi-wallet2 me-1"></i> View Payments</a>
      </div>
    </div>
  </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

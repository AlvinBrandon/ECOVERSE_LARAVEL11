@extends('layouts.admin-full')

@push('styles')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

  * {
    font-family: 'Poppins', sans-serif;
  }

  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #10b981 100%) !important;
    font-family: 'Poppins', sans-serif;
    color: #ffffff;
    min-height: 100vh;
  }

  /* Dashboard Cards */
  .stat-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 1rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    padding: 2rem;
    text-align: center;
  }

  .stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #10b981, #059669);
  }
  
  .stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(16, 185, 129, 0.25);
    border-color: rgba(16, 185, 129, 0.4);
  }

  /* Content Grid System */
  .content-grid {
    display: grid;
    gap: 2rem;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  }

  .content-section {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 1rem;
    padding: 1.5rem;
    transition: all 0.3s ease;
  }

  .content-section:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.2);
    border-color: rgba(16, 185, 129, 0.3);
  }

  .section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #ffffff;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .section-title i {
    color: #10b981;
  }

  /* Stats Cards */
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
  }

  .stat-number {
    font-size: 3rem;
    font-weight: 800;
    color: #10b981;
    margin-bottom: 0.5rem;
    line-height: 1;
  }

  .stat-label {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1rem;
    font-weight: 500;
  }

  /* Action Buttons */
  .action-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
  }

  .action-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 1rem;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    text-decoration: none;
    color: #ffffff;
  }

  .action-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.2);
    border-color: rgba(16, 185, 129, 0.4);
    color: #ffffff;
    text-decoration: none;
  }

  .action-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #10b981, #059669);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
    color: white;
  }

  .action-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
  }

  .action-description {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.7);
  }

  /* Dashboard Header */
  .dashboard-header {
    background: rgba(255, 255, 255, 0.1) !important;
    backdrop-filter: blur(20px) !important;
    border: 1px solid rgba(16, 185, 129, 0.2) !important;
    color: #fff !important;
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.15);
  }

  .header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
  }

  .header-info h1 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 0.5rem;
    line-height: 1.2;
  }

  .header-info p {
    color: rgba(255, 255, 255, 0.8);
    margin: 0;
    font-size: 1.1rem;
  }

  .header-badges {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
  }

  .status-badge {
    background: rgba(16, 185, 129, 0.2);
    padding: 0.75rem 1.25rem;
    border-radius: 0.75rem;
    border: 1px solid rgba(16, 185, 129, 0.3);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #ffffff;
    font-size: 0.9rem;
    font-weight: 500;
  }

  .status-badge i {
    color: #10b981;
  }

  /* Activity and Status Lists */
  .activity-list, .status-list, .metrics-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .activity-item {
    padding: 1rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }

  .activity-item:last-child {
    border-bottom: none;
  }

  .activity-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .activity-title {
    font-weight: 500;
    color: rgba(255, 255, 255, 0.9);
  }

  .activity-time {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.6);
  }

  .status-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }

  .status-item:last-child {
    border-bottom: none;
  }

  .status-indicator {
    font-weight: 500;
    padding: 0.25rem 0.75rem;
    border-radius: 0.375rem;
    font-size: 0.8rem;
  }

  .status-indicator.operational {
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
    border: 1px solid rgba(16, 185, 129, 0.3);
  }

  .metric-item {
    margin-bottom: 1.5rem;
  }

  .metric-item:last-child {
    margin-bottom: 0;
  }

  .metric-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 500;
  }

  .metric-bar {
    background: rgba(255, 255, 255, 0.1);
    height: 8px;
    border-radius: 4px;
    overflow: hidden;
  }

  .metric-fill {
    height: 100%;
    border-radius: 4px;
    transition: width 0.3s ease;
  }
</style>
@endpush

@section('content')
<!-- Admin Dashboard Content -->
<div class="main-content-wrapper">
  <!-- Dashboard Header -->
  <section class="dashboard-header">
    <div class="header-content">
      <div class="header-info">
        <h1>Admin Dashboard</h1>
        <p>Welcome back, {{ Auth::user()->name }}. Here's your system overview.</p>
      </div>
      <div class="header-badges">
        <div class="status-badge">
          <i class="bi bi-check-circle"></i>
          System Active
        </div>
        <div class="status-badge">
          <i class="bi bi-clock"></i>
          {{ now()->format('M d, Y') }}
        </div>
      </div>
    </div>
  </section>

  <!-- Stats Overview -->
  <section class="section-grid">
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-number">{{ $totalUsers ?? '7' }}</div>
        <div class="stat-label">Total Users</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">{{ $totalProducts ?? '20' }}</div>
        <div class="stat-label">Products</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">{{ $activePOs ?? '0' }}</div>
        <div class="stat-label">Active Orders</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">{{ $pendingSalesCount ?? '1' }}</div>
        <div class="stat-label">Pending Sales</div>
      </div>
    </div>
  </section>

  <!-- Quick Actions Section -->
  <section class="content-section" style="margin-bottom: 2rem;">
    <h2 class="section-title">
      <i class="bi bi-lightning"></i>
      Quick Actions
    </h2>
    <div class="action-grid">
      <a href="{{ route('user-management') }}" class="action-card">
        <div class="action-icon">
          <i class="bi bi-people"></i>
        </div>
        <div class="action-title">User Management</div>
        <div class="action-description">Manage users, roles and permissions</div>
      </a>

      <a href="{{ route('inventory.index') }}" class="action-card">
        <div class="action-icon">
          <i class="bi bi-box-seam"></i>
        </div>
        <div class="action-title">Inventory Control</div>
        <div class="action-description">Monitor stock levels and analytics</div>
      </a>

      <a href="{{ route('admin.sales.pending') }}" class="action-card">
        <div class="action-icon">
          <i class="bi bi-truck"></i>
        </div>
        <div class="action-title">Sales Orders</div>
        <div class="action-description">Review and verify sales orders</div>
      </a>

      <a href="{{ route('admin.purchase_orders.index') }}" class="action-card">
        <div class="action-icon">
          <i class="bi bi-cart3"></i>
        </div>
        <div class="action-title">Purchase Orders</div>
        <div class="action-description">Manage supplier purchase orders</div>
      </a>

      <a href="{{ route('admin.analytics') }}" class="action-card">
        <div class="action-icon">
          <i class="bi bi-bar-chart"></i>
        </div>
        <div class="action-title">Analytics & Reports</div>
        <div class="action-description">View detailed system analytics</div>
      </a>

      <a href="{{ route('admin.predictions.dashboard') }}" class="action-card">
        <div class="action-icon">
          <i class="bi bi-robot"></i>
        </div>
        <div class="action-title">ML Predictions</div>
        <div class="action-description">AI-powered sales predictions</div>
      </a>

      <a href="{{ route('chat.index') }}" class="action-card">
        <div class="action-icon">
          <i class="bi bi-chat-dots"></i>
        </div>
        <div class="action-title">Chat System</div>
        <div class="action-description">Customer support and communication</div>
      </a>

      <a href="{{ route('admin.vendors') }}" class="action-card">
        <div class="action-icon">
          <i class="bi bi-building"></i>
        </div>
        <div class="action-title">Vendor Management</div>
        <div class="action-description">Approve and manage vendors</div>
      </a>
    </div>
  </section>

  <!-- Quick Create Section -->
  <section class="content-section" style="margin-bottom: 2rem;">
    <h2 class="section-title">
      <i class="bi bi-plus-circle"></i>
      Quick Create
    </h2>
    <div class="action-grid">
      <a href="{{ route('inventory.create') }}" class="action-card">
        <div class="action-icon">
          <i class="bi bi-plus-square"></i>
        </div>
        <div class="action-title">Add Inventory</div>
        <div class="action-description">Add new products to inventory</div>
      </a>

      <a href="{{ route('admin.purchase_orders.create') }}" class="action-card">
        <div class="action-icon">
          <i class="bi bi-cart-plus"></i>
        </div>
        <div class="action-title">New Purchase Order</div>
        <div class="action-description">Create purchase order for suppliers</div>
      </a>

      <a href="{{ route('inventory.deductForm') }}" class="action-card">
        <div class="action-icon">
          <i class="bi bi-dash-square"></i>
        </div>
        <div class="action-title">Deduct Inventory</div>
        <div class="action-description">Remove items from inventory</div>
      </a>

      <a href="{{ route('register') }}" class="action-card">
        <div class="action-icon">
          <i class="bi bi-person-plus"></i>
        </div>
        <div class="action-title">Add User</div>
        <div class="action-description">Register new system user</div>
      </a>
    </div>
  </section>

  <!-- Content Sections -->
  <section class="content-grid">
    <!-- Recent Activity -->
    <div class="content-section">
      <h3 class="section-title">
        <i class="bi bi-activity"></i>
        Recent Activity
      </h3>
      <div class="activity-list">
        <div class="activity-item">
          <div class="activity-content">
            <div class="activity-title">
              <a href="{{ route('user-management') }}" style="color: rgba(255, 255, 255, 0.9); text-decoration: none;">
                {{ $totalUsers ?? '7' }} registered users
              </a>
            </div>
            <div class="activity-time">Active</div>
          </div>
        </div>
        <div class="activity-item">
          <div class="activity-content">
            <div class="activity-title">
              <a href="{{ route('admin.sales.pending') }}" style="color: rgba(255, 255, 255, 0.9); text-decoration: none;">
                {{ $pendingSalesCount ?? '1' }} pending sales orders
              </a>
            </div>
            <div class="activity-time">Awaiting review</div>
          </div>
        </div>
        <div class="activity-item">
          <div class="activity-content">
            <div class="activity-title">
              <a href="{{ route('inventory.index') }}" style="color: rgba(255, 255, 255, 0.9); text-decoration: none;">
                {{ $totalProducts ?? '20' }} products in inventory
              </a>
            </div>
            <div class="activity-time">Current stock</div>
          </div>
        </div>
        <div class="activity-item">
          <div class="activity-content">
            <div class="activity-title">
              <a href="{{ route('admin.purchase_orders.index') }}" style="color: rgba(255, 255, 255, 0.9); text-decoration: none;">
                {{ $activePOs ?? '0' }} active purchase orders
              </a>
            </div>
            <div class="activity-time">In progress</div>
          </div>
        </div>
      </div>
    </div>

    <!-- System Status -->
    <div class="content-section">
      <h3 class="section-title">
        <i class="bi bi-shield-check"></i>
        System Status
      </h3>
      <div class="status-list">
        <div class="status-item">
          <a href="{{ route('inventory.index') }}" style="color: rgba(255, 255, 255, 0.9); text-decoration: none;">
            Inventory System
          </a>
          <span class="status-indicator operational">Operational</span>
        </div>
        <div class="status-item">
          <a href="{{ route('admin.sales.pending') }}" style="color: rgba(255, 255, 255, 0.9); text-decoration: none;">
            Sales Processing
          </a>
          <span class="status-indicator operational">Operational</span>
        </div>
        <div class="status-item">
          <a href="{{ route('chat.index') }}" style="color: rgba(255, 255, 255, 0.9); text-decoration: none;">
            Chat System
          </a>
          <span class="status-indicator operational">Operational</span>
        </div>
        <div class="status-item">
          <a href="{{ route('admin.predictions.dashboard') }}" style="color: rgba(255, 255, 255, 0.9); text-decoration: none;">
            ML Predictions
          </a>
          <span class="status-indicator operational">Operational</span>
        </div>
      </div>
    </div>

    <!-- Performance Metrics -->
    <div class="content-section">
      <h3 class="section-title">
        <i class="bi bi-graph-up"></i>
        Business Metrics
      </h3>
      <div class="metrics-list">
        <div class="metric-item">
          <div class="metric-header">
            <a href="{{ route('admin.sales.pending') }}" style="color: rgba(255, 255, 255, 0.9); text-decoration: none;">
              Sales Processing Rate
            </a>
            <span>{{ $pendingSalesCount > 0 ? '75%' : '100%' }}</span>
          </div>
          <div class="metric-bar">
            <div class="metric-fill" style="width: {{ $pendingSalesCount > 0 ? '75%' : '100%' }}; background: #10b981;"></div>
          </div>
        </div>
        <div class="metric-item">
          <div class="metric-header">
            <a href="{{ route('inventory.analytics') }}" style="color: rgba(255, 255, 255, 0.9); text-decoration: none;">
              Inventory Efficiency
            </a>
            <span>{{ $totalProducts > 15 ? '85%' : '60%' }}</span>
          </div>
          <div class="metric-bar">
            <div class="metric-fill" style="width: {{ $totalProducts > 15 ? '85%' : '60%' }}; background: #10b981;"></div>
          </div>
        </div>
        <div class="metric-item">
          <div class="metric-header">
            <a href="{{ route('user-management') }}" style="color: rgba(255, 255, 255, 0.9); text-decoration: none;">
              User Engagement
            </a>
            <span>{{ $totalUsers > 5 ? '92%' : '70%' }}</span>
          </div>
          <div class="metric-bar">
            <div class="metric-fill" style="width: {{ $totalUsers > 5 ? '92%' : '70%' }}; background: #10b981;"></div>
          </div>
        </div>
        <div class="metric-item">
          <div class="metric-header">
            <a href="{{ route('admin.analytics') }}" style="color: rgba(255, 255, 255, 0.9); text-decoration: none;">
              System Performance
            </a>
            <span>96%</span>
          </div>
          <div class="metric-bar">
            <div class="metric-fill" style="width: 96%; background: #10b981;"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

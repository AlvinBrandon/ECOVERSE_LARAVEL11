@extends('layouts.app')

@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
  
  * {
    font-family: 'Poppins', sans-serif;
  }
  
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #10b981 100%) !important;
    font-family: 'Poppins', sans-serif;
    color: #ffffff;
    min-height: 10vh;
  }

  
  /* Staff Dashboard Layout Structure */
  .staff-layout {
    display: flex;
    min-height: 10vh;
    position: relative;
  }
  
  .staff-sidebar {
    background: rgba(15, 23, 42, 0.95);
    backdrop-filter: blur(20px);
    border-right: 1px solid rgba(16, 185, 129, 0.2);
    width: 280px;
    position: fixed;
    left: 0;
    top: 0;
    height: 10vh;
    overflow-y: auto;
    z-index: 1000;
    display: flex;
    flex-direction: column;
  }
  
  .staff-main {
    flex: 1;
    margin-left: 280px;
    padding: 2rem;
    background: transparent;
  }
  
  /* Fix content organization */
  .main-content-wrapper {
    max-width: 1400px;
    margin: 0 auto;
  }
  
  .section-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
  }
  
  /* Sidebar Navigation */
  .sidebar-header {
    padding: 1.5rem;
    border-bottom: 1px solid rgba(16, 185, 129, 0.2);
  }
  
  .sidebar-content {
    flex: 1;
    padding: 1rem 0;
  }
  
  .sidebar-logo {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #ffffff;
    text-decoration: none;
  }
  
  .sidebar-logo:hover {
    color: #10b981;
    text-decoration: none;
  }
  
  .logo-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #10b981, #059669);
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
  }
  
  .nav-section {
    margin-bottom: 1.5rem;
    padding: 0 1rem;
  }
  
  .nav-section-title {
    font-size: 0.75rem;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.6);
    text-transform: uppercase;
    letter-spacing: 0.1em;
    padding: 0 0.5rem;
    margin-bottom: 0.75rem;
  }
  
  .nav-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: all 0.2s ease;
    border-radius: 0.5rem;
    margin-bottom: 0.25rem;
  }
  
  .nav-item:hover,
  .nav-item.active {
    background: rgba(16, 185, 129, 0.15);
    color: #10b981;
    text-decoration: none;
  }
  
  .nav-item i {
    width: 20px;
    margin-right: 0.75rem;
    text-align: center;
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
  
  .header-info h5 {
    font-size: 1.5rem;
    font-weight: 600;
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
  
  .stat-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 1rem;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
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
  
  /* Responsive Design */
  @media (max-width: 1024px) {
    .staff-layout {
      grid-template-columns: 1fr;
    }
    
    .staff-sidebar {
      transform: translateX(-100%);
      transition: transform 0.3s ease;
    }
    
    .staff-sidebar.open {
      transform: translateX(0);
    }
    
    .staff-main {
      margin-left: 0;
      width: 100%;
    }
  }
  
  /* Custom Scrollbar */
  .staff-sidebar::-webkit-scrollbar {
    width: 4px;
  }
  
  .staff-sidebar::-webkit-scrollbar-track {
    background: transparent;
  }
  
  .staff-sidebar::-webkit-scrollbar-thumb {
    background: rgba(16, 185, 129, 0.3);
    border-radius: 2px;
  }
  
  .staff-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(16, 185, 129, 0.5);
  }
</style>

<!-- Staff Dashboard Layout -->
<div class="staff-layout">
  <!-- Sidebar Navigation -->
  <nav class="staff-sidebar">
    <div class="sidebar-header">
      <a href="{{ route('dashboard') }}" class="sidebar-logo">
        <div class="logo-icon">
          <i class="bi bi-recycle"></i>
        </div>
        <div>
          <div style="font-weight: 700; font-size: 1.1rem;">Ecoverse</div>
          <div style="font-size: 0.8rem; opacity: 0.7;">Staff Panel</div>
        </div>
      </a>
    </div>
    
    <div class="sidebar-content">
      <div class="nav-section">
        <div class="nav-section-title">Overview</div>
        <a href="{{ route('dashboard') }}" class="nav-item active">
          <i class="bi bi-speedometer2"></i>
          Dashboard
        </a>
      </div>
      
      <div class="nav-section">
        <div class="nav-section-title">Operations</div>
        <a href="{{ route('inventory.index') }}" class="nav-item">
          <i class="bi bi-box-seam"></i>
          Inventory
        </a>
        <a href="{{ route('stock_transfer.create') }}" class="nav-item">
          <i class="bi bi-truck"></i>
          Stock Transfer
        </a>
        <a href="{{ route('staff.orders') }}" class="nav-item">
          <i class="bi bi-clipboard-data"></i>
          Manage Orders
        </a>
      </div>
      
      <div class="nav-section">
        <div class="nav-section-title">System</div>
        <a href="{{ route('profile') }}" class="nav-item">
          <i class="bi bi-person-gear"></i>
          Profile
        </a>
      </div>
    </div>
  </nav>
  
  <!-- Main Content -->
  <main class="staff-main">
    <div class="main-content-wrapper">
      
      <!-- Dashboard Header -->
      <section class="dashboard-header">
        <div class="header-content">
          <div class="header-info">
            <h1>Staff Dashboard</h1>
            <p>Welcome back, {{ Auth::user()->name }}. Collection & Processing: Add waste, update stock, handle logistics.</p>
          </div>
          <div class="header-badges">
            <div class="status-badge">
              <i class="bi bi-check-circle"></i>
              Operations Active
            </div>
            <div class="status-badge">
              <i class="bi bi-clock"></i>
              {{ now()->format('M d, Y') }}
            </div>
          </div>
        </div>
      </section>
      
      <!-- Quick Actions Section -->
      <section class="content-section" style="margin-bottom: 2rem;">
        <h2 class="section-title">
          <i class="bi bi-lightning"></i>
          Quick Operations
        </h2>
        <div class="action-grid">
          <a href="{{ route('inventory.index') }}" class="action-card">
            <div class="action-icon">
              <i class="bi bi-box-seam"></i>
            </div>
            <div class="action-title">Inventory Management</div>
            <div class="action-description">Manage and update inventory, process materials</div>
          </a>
          
          <a href="{{ route('stock_transfer.create') }}" class="action-card">
            <div class="action-icon">
              <i class="bi bi-truck"></i>
            </div>
            <div class="action-title">Logistics & Transfer</div>
            <div class="action-description">Handle stock transfers and logistics operations</div>
          </a>
          
          <a href="{{ route('staff.orders') }}" class="action-card">
            <div class="action-icon">
              <i class="bi bi-clipboard-data"></i>
            </div>
            <div class="action-title">Order Management</div>
            <div class="action-description">Track and manage waste orders placed by clients</div>
          </a>
        </div>
      </section>
      
      <!-- Quick Create Section -->
      <section class="content-section" style="margin-bottom: 2rem;">
        <h2 class="section-title">
          <i class="bi bi-plus-circle"></i>
          Quick Actions
        </h2>
        <div class="action-grid">
          <a href="{{ route('inventory.create') }}" class="action-card">
            <div class="action-icon">
              <i class="bi bi-plus-square"></i>
            </div>
            <div class="action-title">Add Inventory</div>
            <div class="action-description">Add new products to inventory system</div>
          </a>
          
          <a href="{{ route('inventory.deductForm') }}" class="action-card">
            <div class="action-icon">
              <i class="bi bi-dash-square"></i>
            </div>
            <div class="action-title">Deduct Stock</div>
            <div class="action-description">Remove items from inventory</div>
          </a>
          
          <a href="{{ route('stock_transfer.create') }}" class="action-card">
            <div class="action-icon">
              <i class="bi bi-arrow-left-right"></i>
            </div>
            <div class="action-title">New Transfer</div>
            <div class="action-description">Create new stock transfer</div>
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
                  <a href="{{ route('inventory.index') }}" style="color: rgba(255, 255, 255, 0.9); text-decoration: none;">
                    Inventory management available
                  </a>
                </div>
                <div class="activity-time">Active</div>
              </div>
            </div>
            <div class="activity-item">
              <div class="activity-content">
                <div class="activity-title">
                  <a href="{{ route('staff.orders') }}" style="color: rgba(255, 255, 255, 0.9); text-decoration: none;">
                    Order management system
                  </a>
                </div>
                <div class="activity-time">Available</div>
              </div>
            </div>
            <div class="activity-item">
              <div class="activity-content">
                <div class="activity-title">
                  <a href="{{ route('stock_transfer.create') }}" style="color: rgba(255, 255, 255, 0.9); text-decoration: none;">
                    Stock transfer operations
                  </a>
                </div>
                <div class="activity-time">Ready</div>
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
              <a href="{{ route('staff.orders') }}" style="color: rgba(255, 255, 255, 0.9); text-decoration: none;">
                Order Processing
              </a>
              <span class="status-indicator operational">Operational</span>
            </div>
            <div class="status-item">
              <a href="{{ route('stock_transfer.create') }}" style="color: rgba(255, 255, 255, 0.9); text-decoration: none;">
                Transfer System
              </a>
              <span class="status-indicator operational">Operational</span>
            </div>
          </div>
        </div>
        
        <!-- Performance Metrics -->
        <div class="content-section">
          <h3 class="section-title">
            <i class="bi bi-graph-up"></i>
            Operational Metrics
          </h3>
          <div class="metrics-list">
            <div class="metric-item">
              <div class="metric-header">
                <a href="{{ route('inventory.index') }}" style="color: rgba(255, 255, 255, 0.9); text-decoration: none;">
                  Inventory Processing
                </a>
                <span>95%</span>
              </div>
              <div class="metric-bar">
                <div class="metric-fill" style="width: 95%; background: #10b981;"></div>
              </div>
            </div>
            <div class="metric-item">
              <div class="metric-header">
                <a href="{{ route('staff.orders') }}" style="color: rgba(255, 255, 255, 0.9); text-decoration: none;">
                  Order Management
                </a>
                <span>88%</span>
              </div>
              <div class="metric-bar">
                <div class="metric-fill" style="width: 88%; background: #10b981;"></div>
              </div>
            </div>
            <div class="metric-item">
              <div class="metric-header">
                <a href="{{ route('stock_transfer.create') }}" style="color: rgba(255, 255, 255, 0.9); text-decoration: none;">
                  Transfer Efficiency
                </a>
                <span>92%</span>
              </div>
              <div class="metric-bar">
                <div class="metric-fill" style="width: 92%; background: #10b981;"></div>
              </div>
            </div>
          </div>
        </div>
      </section>
      
    </div>
  </main>
</div>

<style>
  /* Additional organized styles */
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

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

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
  
  /* Retailer Dashboard Layout Structure */
  .retailer-layout {
    display: flex;
    min-height: 100vh;
    position: relative;
    padding: 2rem;
  }
  
  .retailer-main {
    flex: 1;
    background: transparent;
    max-width: 1400px;
    margin: 0 auto;
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

  /* Action Cards */
  .action-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
  }
  
  .action-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 1rem;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    text-decoration: none;
    color: #ffffff;
    position: relative;
    overflow: hidden;
  }

  .action-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #10b981, #059669);
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
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #ffffff;
  }
  
  .action-description {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 1rem;
  }

  .action-badge {
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
    padding: 0.25rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.8rem;
    font-weight: 500;
    border: 1px solid rgba(16, 185, 129, 0.3);
  }

  /* Responsive Design */
  @media (max-width: 1024px) {
    .retailer-layout {
      padding: 1rem;
    }
    
    .header-content {
      flex-direction: column;
      text-align: center;
    }
    
    .header-info h1 {
      font-size: 2rem;
    }
    
    .action-grid {
      grid-template-columns: 1fr;
    }
    
    .stats-grid {
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }
  }

  /* Section Titles */
  .section-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #ffffff;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  
  .section-title i {
    color: #10b981;
  }
</style>

<!-- Retailer Dashboard Layout -->
<div class="retailer-layout">
  <main class="retailer-main">
    
    <!-- Dashboard Header -->
    <section class="dashboard-header">
      <div class="header-content">
        <div class="header-info">
          <h1>Retailer Dashboard</h1>
          <p>Welcome back, {{ Auth::user()->name }}. Manage your retail operations efficiently.</p>
        </div>
        <div class="header-badges">
          <div class="status-badge">
            <i class="bi bi-shop"></i>
            Store Active
          </div>
          <div class="status-badge">
            <i class="bi bi-clock"></i>
            {{ now()->format('M d, Y') }}
          </div>
        </div>
      </div>
    </section>
    
    <!-- Stats Overview -->
    <section class="stats-grid">
      <div class="stat-card">
        <div class="stat-number">{{ $salesToday ?? 0 }}</div>
        <div class="stat-label">Sales Today</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">{{ number_format($totalCustomers ?? 0) }}</div>
        <div class="stat-label">Total Customers</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">{{ $lowStockItems ?? 0 }}</div>
        <div class="stat-label">Low Stock Items</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">UGX {{ number_format($revenueToday ?? 0) }}</div>
        <div class="stat-label">Revenue Today</div>
      </div>
    </section>

    
    <!-- Core Business Operations -->
    <section>
      <h2 class="section-title">
        <i class="bi bi-lightning"></i>
        Core Operations
      </h2>
      <div class="action-grid">
        <a href="{{ route('retailer.customer-orders') }}" class="action-card">
          <div class="action-icon">
            <i class="bi bi-cart-check"></i>
          </div>
          <div class="action-title">Customer Orders</div>
          <div class="action-description">Process and manage customer orders efficiently with real-time tracking</div>
          <div class="action-badge">{{ $pendingOrders ?? 0 }} Pending</div>
        </a>
        
        <a href="{{ route('retailer.inventory') }}" class="action-card">
          <div class="action-icon">
            <i class="bi bi-box-seam"></i>
          </div>
          <div class="action-title">Inventory Management</div>
          <div class="action-description">Monitor stock levels and manage product availability for your store</div>
          <div class="action-badge">{{ $lowStockItems ?? 0 }} Low Stock</div>
        </a>
        
        <a href="{{ route('sales.index') }}" class="action-card">
          <div class="action-icon">
            <i class="bi bi-truck"></i>
          </div>
          <div class="action-title">Wholesale Procurement</div>
          <div class="action-description">Order products from wholesalers to restock your retail inventory</div>
          <div class="action-badge">{{ $totalOrders ?? 0 }} Total Orders</div>
        </a>
      </div>
    </section>

    <!-- Analytics & Management -->
    <section>
      <h2 class="section-title">
        <i class="bi bi-graph-up"></i>
        Analytics & Management
      </h2>
      <div class="action-grid">
        <a href="{{ route('retailer.reports') }}" class="action-card">
          <div class="action-icon">
            <i class="bi bi-bar-chart"></i>
          </div>
          <div class="action-title">Sales Analytics</div>
          <div class="action-description">Track sales performance and analyze customer purchasing patterns</div>
          <div class="action-badge">UGX {{ number_format($monthlyRevenue ?? 0, 0) }} This Month</div>
        </a>
        
        <a href="{{ route('customers.index') }}" class="action-card">
          <div class="action-icon">
            <i class="bi bi-people"></i>
          </div>
          <div class="action-title">Customer Management</div>
          <div class="action-description">Manage customer relationships and build loyalty through personalized service</div>
          <div class="action-badge">{{ $totalCustomers ?? 0 }} Active</div>
        </a>
        
        <a href="{{ route('chat.index') }}" class="action-card">
          <div class="action-icon">
            <i class="bi bi-chat-dots"></i>
          </div>
          <div class="action-title">Communication Center</div>
          <div class="action-description">Connect with wholesalers and suppliers for seamless business operations</div>
          <div class="action-badge">{{ $approvedOrders ?? 0 }} Approved Orders</div>
        </a>
      </div>
    </section>
    
  </main>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

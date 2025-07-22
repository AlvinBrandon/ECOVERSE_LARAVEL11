<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

* {
    font-family: 'Poppins', sans-serif !important;
}

body, .main-content, .container-fluid {
    font-family: 'Poppins', sans-serif !important;
}

.dashboard-card {
    background: rgba(255,255,255,0.95);
    border-radius: 1.5rem;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(20px);
    padding: 2rem 1.5rem;
    margin-bottom: 2rem;
    transition: all 0.3s ease;
    font-family: 'Poppins', sans-serif;
}

.dashboard-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(16, 185, 129, 0.15);
}

h1, h2, h3, h4, h5, h6 {
    font-family: 'Poppins', sans-serif !important;
}

p, span, div, label, input, button {
    font-family: 'Poppins', sans-serif !important;
}

.modern-button {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    border: none;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.modern-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.btn-primary-modern {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.btn-secondary-modern {
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: white;
}

.btn-accent-modern {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

/* Floating Elements - Welcome Page Style */
.floating-elements {
    position: fixed;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1;
}

.floating-icon {
    position: absolute;
    font-size: 1.5rem;
    color: rgba(16, 185, 129, 0.4);
    filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
}

.animate-float-1 {
    top: 15%;
    left: 5%;
    animation: float-1 8s ease-in-out infinite;
}

.animate-float-2 {
    top: 70%;
    right: 10%;
    animation: float-2 10s ease-in-out infinite;
}

.animate-float-3 {
    bottom: 25%;
    left: 15%;
    animation: float-3 9s ease-in-out infinite;
}

.animate-float-4 {
    top: 40%;
    right: 5%;
    animation: float-4 7s ease-in-out infinite;
}

@keyframes float-1 {
    0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.4; }
    50% { transform: translateY(-20px) rotate(180deg); opacity: 0.6; }
}

@keyframes float-2 {
    0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.3; }
    50% { transform: translateY(-30px) rotate(-180deg); opacity: 0.5; }
}

@keyframes float-3 {
    0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.4; }
    50% { transform: translateY(-25px) rotate(180deg); opacity: 0.6; }
}

@keyframes float-4 {
    0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.3; }
    50% { transform: translateY(-15px) rotate(-90deg); opacity: 0.5; }
}
</style>

<!-- Floating Elements for Visual Appeal -->
<div class="floating-elements">
    <div class="floating-icon animate-float-1">
        <i class="bi bi-recycle"></i>
    </div>
    <div class="floating-icon animate-float-2">
        <i class="bi bi-leaf"></i>
    </div>
    <div class="floating-icon animate-float-3">
        <i class="bi bi-globe"></i>
    </div>
    <div class="floating-icon animate-float-4">
        <i class="bi bi-lightning-charge"></i>
    </div>
</div>

<!-- ECOVERSE Admin Dashboard Title Banner -->
<div class="alert mb-4 d-flex align-items-center dashboard-header">
  <i class="bi bi-speedometer2 me-3 fs-2" style="color: #ffffff; filter: drop-shadow(0 4px 8px rgba(16, 185, 129, 0.3));"></i>
  <div>
    <strong class="admin-title" style="font-family: 'Poppins', sans-serif; text-transform: uppercase; letter-spacing: 1px; font-size: 1.8rem; font-weight: 800; background: linear-gradient(135deg, #10b981, #6366f1); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">ECOVERSE ADMIN CONTROL CENTER</strong>
    <div class="admin-subtitle" style="font-family: 'Poppins', sans-serif; font-size: 1rem; opacity: 0.95; font-weight: 400; color: rgba(255,255,255,0.9); margin-top: 0.5rem;">Sustainable system management & eco-analytics dashboard</div>
  </div>
</div>

<!-- ECOVERSE Professional Admin Header -->
<div class="dashboard-card mb-4" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(20px); border: 2px solid rgba(16, 185, 129, 0.3); color: #ffffff; border-radius: 1.5rem; box-shadow: 0 20px 60px rgba(16, 185, 129, 0.2);">
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <div class="me-3" style="background: linear-gradient(135deg, #10b981, #059669); color: #ffffff; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid rgba(16, 185, 129, 0.5); box-shadow: 0 8px 32px rgba(16, 185, 129, 0.4);">
                <i class="bi bi-shield-check" style="font-size: 2rem;"></i>
            </div>
            <div>
                <h4 class="mb-1" style="font-family: 'Poppins', sans-serif; color: #ffffff; font-weight: 700; font-size: 1.8rem;">ECOVERSE Supply Chain Control Center</h4>
                <p class="mb-0" style="font-family: 'Poppins', sans-serif; color: rgba(255,255,255,0.9); font-size: 1rem; font-weight: 400;">Welcome back, {{ Auth::user()->name }} | Pioneering sustainable administrative excellence</p>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <div class="me-3" style="background: rgba(16, 185, 129, 0.2); backdrop-filter: blur(10px); border: 1px solid rgba(16, 185, 129, 0.3); color: #6ee7b7; padding: 12px 20px; border-radius: 50px; font-family: 'Poppins', sans-serif; font-weight: 500;">
                <i class="bi bi-check-circle me-2"></i>
                Eco-System Active
            </div>
            <div style="background: rgba(16, 185, 129, 0.2); backdrop-filter: blur(10px); border: 1px solid rgba(16, 185, 129, 0.3); color: #6ee7b7; padding: 12px 20px; border-radius: 50px; font-family: 'Poppins', sans-serif; font-weight: 500;">
                <i class="bi bi-activity me-2"></i>
                {{ $totalUsers ?? '0' }} Green Users
            </div>
        </div>
    </div>
</div>

<!-- ECOVERSE Primary Metrics with Modern Design -->
<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="dashboard-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; border: none; border-radius: 1.5rem; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);">
            <div class="d-flex align-items-center">
                <div style="background: rgba(255,255,255,0.2); color: #ffffff; backdrop-filter: blur(10px); width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid rgba(255, 255, 255, 0.3);">
                    <i class="bi bi-people-fill" style="font-size: 1.8rem;"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <h3 style="font-family: 'Poppins', sans-serif; color: #ffffff; font-weight: 800; font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $totalUsers ?? 0 }}</h3>
                    <p style="font-family: 'Poppins', sans-serif; color: rgba(255,255,255,0.9); margin-bottom: 0.5rem; font-weight: 600; font-size: 1rem;">Eco-Champions</p>
                    <div style="color: rgba(255,255,255,0.8); font-family: 'Poppins', sans-serif; font-size: 0.9rem; font-weight: 500;">
                        <i class="bi bi-arrow-up me-1"></i>
                        <span>+12.5% Growth</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="dashboard-card" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: #ffffff; border: none; border-radius: 1.5rem; box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);">
            <div class="d-flex align-items-center">
                <div style="background: rgba(255,255,255,0.2); color: #ffffff; backdrop-filter: blur(10px); width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid rgba(255, 255, 255, 0.3);">
                    <i class="bi bi-box-seam-fill" style="font-size: 1.8rem;"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <h3 style="font-family: 'Poppins', sans-serif; color: #ffffff; font-weight: 800; font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $totalProducts ?? 0 }}</h3>
                    <p style="font-family: 'Poppins', sans-serif; color: rgba(255,255,255,0.9); margin-bottom: 0.5rem; font-weight: 600; font-size: 1rem;">Eco-Products</p>
                    <div style="color: rgba(255,255,255,0.8); font-family: 'Poppins', sans-serif; font-size: 0.9rem; font-weight: 500;">
                        <i class="bi bi-arrow-up me-1"></i>
                        <span>+8.3% Sustainable</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="dashboard-card" style="background: linear-gradient(135deg, #1e293b 0%, #475569 100%); color: #ffffff; border: none; border-radius: 1.5rem; box-shadow: 0 10px 30px rgba(30, 41, 59, 0.3);">
            <div class="d-flex align-items-center">
                <div style="background: rgba(255,255,255,0.2); color: #ffffff; backdrop-filter: blur(10px); width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid rgba(255, 255, 255, 0.3);">
                    <i class="bi bi-clipboard-check-fill" style="font-size: 1.8rem;"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <h3 style="font-family: 'Poppins', sans-serif; color: #ffffff; font-weight: 800; font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $activePOs ?? 0 }}</h3>
                    <p style="font-family: 'Poppins', sans-serif; color: rgba(255,255,255,0.9); margin-bottom: 0.5rem; font-weight: 600; font-size: 1rem;">Green Purchase Orders</p>
                    <div style="color: rgba(255,255,255,0.8); font-family: 'Poppins', sans-serif; font-size: 0.9rem; font-weight: 500;">
                        <i class="bi bi-arrow-up me-1"></i>
                        <span>+15.7% Eco-Growth</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="dashboard-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #ffffff; border: none; border-radius: 1.5rem; box-shadow: 0 10px 30px rgba(245, 158, 11, 0.3);">
            <div class="d-flex align-items-center">
                <div style="background: rgba(255,255,255,0.2); color: #ffffff; backdrop-filter: blur(10px); width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid rgba(255, 255, 255, 0.3);">
                    <i class="bi bi-graph-up-arrow" style="font-size: 1.8rem;"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <h3 style="font-family: 'Poppins', sans-serif; color: #ffffff; font-weight: 800; font-size: 2.5rem; margin-bottom: 0.5rem;">UGX 4.2M</h3>
                    <p style="font-family: 'Poppins', sans-serif; color: rgba(255,255,255,0.9); margin-bottom: 0.5rem; font-weight: 600; font-size: 1rem;">Eco-Revenue</p>
                    <div style="color: rgba(255,255,255,0.8); font-family: 'Poppins', sans-serif; font-size: 0.9rem; font-weight: 500;">
                        <i class="bi bi-arrow-up me-1"></i>
                        <span>+8.5% Green Impact</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ECOVERSE Main Action Cards with Artistic Design -->
<div class="row g-4 mb-4">
    <!-- Sustainable Sales Management -->
    <div class="col-xl-4 col-lg-6">
        <div class="scm-card scm-hover-earth ecoverse-fade-in-up enhanced-action-card" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(20px); border: 2px solid rgba(16, 185, 129, 0.3); animation-delay: 0.1s;">
            <div class="scm-card-header" style="background: var(--ecoverse-gradient-secondary); color: var(--ecoverse-white);">
                <div class="d-flex align-items-center">
                    <div class="scm-icon-wrapper me-3" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px);">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div>
                        <h5 class="scm-card-title mb-1" style="color: var(--ecoverse-white); font-weight: 700;">Sustainable Sales Management</h5>
                        <p class="scm-card-subtitle">Green logistics & eco-friendly operations</p>
                    </div>
                </div>
            </div>
                </div>
            </div>
            <div class="scm-card-body">
                <p class="scm-card-text mb-3">Review and verify sales orders, update delivery status and manage customer orders</p>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <small class="text-muted">Pending Approvals</small>
                    <span class="badge bg-warning">{{ $pendingSalesCount ?? '0' }} Orders</span>
                </div>
                <a href="{{ route('admin.sales.pending') }}" class="scm-btn scm-btn-danger w-100" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); border: none;">
                    <i class="bi bi-clipboard-check me-2"></i>Sales Verification
                </a>
            </div>
        </div>
    </div>

    <!-- User Management -->
    <div class="col-xl-4 col-lg-6">
        <div class="scm-card scm-hover-lift enhanced-action-card" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(20px); border: 2px solid rgba(16, 185, 129, 0.3);">
            <div class="scm-card-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-people-fill me-3 fs-4"></i>
                    <h5 class="scm-card-title mb-0" style="color: white; font-weight: 600;">User Management</h5>
                </div>
            </div>
            <div class="scm-card-body">
                <p class="scm-card-text mb-3" style="color: rgba(255, 255, 255, 0.8);">Manage all users, roles and permissions across the supply chain system</p>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <small class="text-muted" style="color: rgba(255, 255, 255, 0.7) !important;">Total System Users</small>
                    <span class="badge" style="background: rgba(16, 185, 129, 0.2); color: #6ee7b7; border: 1px solid rgba(16, 185, 129, 0.3);">{{ $totalUsers ?? '0' }} Users</span>
                </div>
                <a href="{{ route('user-management') }}" class="scm-btn scm-btn-success w-100" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none;">
                    <i class="bi bi-person-lines-fill me-2"></i>Manage Users
                </a>
            </div>
        </div>
    </div>

    <!-- Inventory Control -->
    <div class="col-xl-4 col-lg-6">
        <div class="scm-card scm-hover-lift enhanced-action-card" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(20px); border: 2px solid rgba(6, 182, 212, 0.3);">
            <div class="scm-card-header" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-box-seam-fill me-3 fs-4"></i>
                    <h5 class="scm-card-title mb-0" style="color: white; font-weight: 600;">Inventory Control</h5>
                </div>
            </div>
            <div class="scm-card-body">
                <p class="scm-card-text mb-3" style="color: rgba(255, 255, 255, 0.8);">Monitor stock levels, analytics and inventory management across all locations</p>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <small class="text-muted" style="color: rgba(255, 255, 255, 0.7) !important;">Active Products</small>
                    <span class="badge" style="background: rgba(6, 182, 212, 0.2); color: #67e8f9; border: 1px solid rgba(6, 182, 212, 0.3);">{{ $totalProducts ?? '0' }} Items</span>
                </div>
                <a href="{{ route('inventory.index') }}" class="scm-btn scm-btn-info w-100" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); border: none;">
                    <i class="bi bi-archive me-2"></i>View Inventory
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Enhanced Action Cards -->
<div class="row g-4 mb-4">
    <!-- Analytics & Reports -->
    <div class="col-xl-4 col-lg-6">
        <div class="scm-card scm-hover-lift enhanced-action-card" style="background: linear-gradient(135deg, rgba(243, 156, 18, 0.1) 0%, rgba(230, 126, 34, 0.1) 100%); border-left: 5px solid #f39c12;">
            <div class="scm-card-header" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-bar-chart-fill me-3 fs-4"></i>
                    <h5 class="scm-card-title mb-0" style="color: white; font-weight: 600;">Analytics & Reports</h5>
                </div>
            </div>
            <div class="scm-card-body">
                <p class="scm-card-text mb-3">Business insights, performance metrics and comprehensive reporting dashboard</p>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <small class="text-muted">This Month</small>
                    <span class="badge bg-warning">+15.3% Growth</span>
                </div>
                <a href="{{ route('admin.analytics') }}" class="scm-btn scm-btn-warning w-100" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); border: none;">
                    <i class="bi bi-graph-up-arrow me-2"></i>View Reports
                </a>
            </div>
        </div>
    </div>

    <!-- ML Predictions -->
    <div class="col-xl-4 col-lg-6">
        <div class="scm-card scm-hover-lift enhanced-action-card" style="background: linear-gradient(135deg, rgba(155, 89, 182, 0.1) 0%, rgba(142, 68, 173, 0.1) 100%); border-left: 5px solid #9b59b6;">
            <div class="scm-card-header" style="background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%); color: white;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-cpu-fill me-3 fs-4"></i>
                    <h5 class="scm-card-title mb-0" style="color: white; font-weight: 600;">ML Predictions</h5>
                </div>
            </div>
            <div class="scm-card-body">
                <p class="scm-card-text mb-3">AI-powered forecasting tools and predictive analytics for supply chain optimization</p>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <small class="text-muted">Model Accuracy</small>
                    <span class="badge bg-primary">94.7%</span>
                </div>
                <a href="{{ route('admin.predictions.dashboard') }}" class="scm-btn scm-btn-primary w-100" style="background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%); border: none;">
                    <i class="bi bi-robot me-2"></i>ML Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- System Health -->
    <div class="col-xl-4 col-lg-6">
        <div class="scm-card scm-hover-lift enhanced-action-card" style="background: linear-gradient(135deg, rgba(26, 188, 156, 0.1) 0%, rgba(22, 160, 133, 0.1) 100%); border-left: 5px solid #1abc9c;">
            <div class="scm-card-header" style="background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%); color: white;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-heart-pulse-fill me-3 fs-4"></i>
                    <h5 class="scm-card-title mb-0" style="color: white; font-weight: 600;">System Health</h5>
                </div>
            </div>
            <div class="scm-card-body">
                <p class="scm-card-text mb-3">Monitor system performance, server health and infrastructure status</p>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="bg-light p-2 rounded text-center">
                            <small class="text-muted d-block">Server</small>
                            <span class="badge bg-success">Online</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light p-2 rounded text-center">
                            <small class="text-muted d-block">Database</small>
                            <span class="badge bg-success">Healthy</span>
                        </div>
                    </div>
                </div>
                <button class="scm-btn scm-btn-info w-100" style="background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%); border: none;">
                    <i class="bi bi-activity me-2"></i>View Diagnostics
                </button>
            </div>
        </div>
    </div>
</div>

<!-- System Health Widget -->
{{-- <div class="row">
  <div class="col-md-4">
    <div class="dashboard-card">
      <h6><i class="bi bi-heart-pulse text-danger dashboard-icon"></i>System Health</h6>
      <ul class="list-unstyled mb-0">
        <li><strong>Server:</strong> <span class="text-success">{{ $systemHealth['server'] }}</span></li>
        <li><strong>Queue:</strong> <span class="text-success">{{ $systemHealth['queue'] }}</span></li>
        <li><strong>Storage:</strong> <span class="text-warning">{{ $systemHealth['storage'] }}</span></li>
        <li><strong>Last Backup:</strong> <span class="text-info">{{ $systemHealth['last_backup'] }}</span></li>
      </ul>
    </div>
  </div> --}}
  <!-- Notifications Panel -->
  {{-- <div class="col-md-4">
    <div class="dashboard-card">
      <h6><i class="bi bi-bell text-warning dashboard-icon"></i>Notifications</h6>
      <ul class="list-unstyled mb-0" style="max-height:120px;overflow:auto;">
        @foreach($notifications as $note)
          <li><i class="bi bi-{{ $note['icon'] }} text-{{ $note['type'] }}"></i> {{ $note['text'] }}</li>
        @endforeach
      </ul>
    </div>
  </div> --}}
<!-- Enhanced Management Section with Better Visual Design -->
<div class="row g-4 mb-4">
    <!-- Enhanced Quick Actions -->
    <div class="col-xl-4 col-lg-6">
        <div class="scm-card scm-hover-lift" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="scm-card-header" style="background: linear-gradient(135deg, #495057 0%, #343a40 100%); color: white;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-lightning-charge-fill me-3 fs-4"></i>
                    <h5 class="scm-card-title mb-0" style="color: white; font-weight: 600;">Quick Actions</h5>
                </div>
            </div>
            <div class="scm-card-body">
                <div class="quick-actions-grid">
                    <a href="{{ route('inventory.create') }}" class="enhanced-action-btn" style="background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); color: white; text-decoration: none; display: block; padding: 12px; border-radius: 8px; margin-bottom: 10px; transition: all 0.3s ease;">
                        <i class="bi bi-plus-circle-fill me-2"></i>Add Inventory
                    </a>
                    <a href="{{ route('admin.sales.pending') }}" class="enhanced-action-btn" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white; text-decoration: none; display: block; padding: 12px; border-radius: 8px; margin-bottom: 10px; transition: all 0.3s ease;">
                        <i class="bi bi-hourglass-split me-2"></i>Approve Sales
                    </a>
                    <a href="{{ route('admin.purchase_orders.create') }}" class="enhanced-action-btn" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white; text-decoration: none; display: block; padding: 12px; border-radius: 8px; margin-bottom: 0; transition: all 0.3s ease;">
                        <i class="bi bi-clipboard-plus me-2"></i>Create Purchase Order
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Purchase Orders Section -->
    <div class="col-xl-8 col-lg-6">
        <div class="scm-card scm-hover-lift" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="scm-card-header" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white;">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-clipboard-data-fill me-3 fs-4"></i>
                        <div>
                            <h5 class="scm-card-title mb-0" style="color: white; font-weight: 600;">Recent Purchase Orders</h5>
                            <small style="color: rgba(255,255,255,0.8);">Latest purchase order activities and status updates</small>
                        </div>
                    </div>
                    <a href="{{ route('admin.purchase_orders.index') }}" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-arrow-right me-1"></i>View All
                    </a>
                </div>
            </div>
            <div class="scm-card-body" style="padding: 0;">
                @forelse($adminPOs ?? [] as $po)
                    <div class="enhanced-po-item p-4 border-bottom" style="
                        background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(248,249,250,0.9) 100%);
                        border-left: 4px solid 
                        @if($po->status == 'complete') #2ecc71
                        @elseif($po->status == 'pending') #f39c12
                        @else #3498db @endif;
                        transition: all 0.3s ease;">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="po-id-section text-center p-3 rounded-3" style="background: rgba(255,255,255,0.8); border: 2px dashed #e9ecef;">
                                    <div class="fw-bold text-primary" style="font-size: 1.1rem;">#{{ $po->id }}</div>
                                    <small class="text-muted">PO ID</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="po-info">
                                    <h6 class="mb-2" style="color: #2c3e50; font-weight: 600;">
                                        <i class="bi bi-box-seam me-2 text-primary"></i>
                                        {{ $po->rawMaterial->name ?? 'N/A' }}
                                    </h6>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-light text-dark me-2">
                                            <i class="bi bi-building me-1"></i>
                                            {{ $po->supplier->name ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <span class="po-status-badge px-3 py-2 rounded-pill fw-semibold text-white d-inline-flex align-items-center" style="
                                        background: 
                                        @if($po->status == 'complete') linear-gradient(135deg, #2ecc71 0%, #27ae60 100%)
                                        @elseif($po->status == 'pending') linear-gradient(135deg, #f39c12 0%, #e67e22 100%)
                                        @else linear-gradient(135deg, #3498db 0%, #2980b9 100%) @endif;
                                        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                                        text-transform: uppercase;
                                        letter-spacing: 0.5px;
                                        font-size: 0.85rem;">
                                        <i class="bi bi-
                                            @if($po->status == 'complete') check-circle-fill
                                            @elseif($po->status == 'pending') clock-fill
                                            @else info-circle-fill @endif me-2"></i>
                                        {{ ucfirst($po->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <a href="{{ route('admin.purchase_orders.show', $po->id) }}" class="btn btn-outline-primary btn-sm px-3" style="border-radius: 8px;">
                                        <i class="bi bi-eye me-1"></i>View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                        <div class="empty-po-state">
                            <div class="scm-icon-wrapper mx-auto mb-4" style="width: 80px; height: 80px; background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white;">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                            </div>
                            <h6 class="text-muted mb-3">No Purchase Orders Found</h6>
                            <p class="text-muted mb-4">No recent purchase order activities to display</p>
                            <a href="{{ route('admin.purchase_orders.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Create New PO
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
  {{-- <div class="col-md-6">
    <div class="dashboard-card">
      <h6><i class="bi bi-truck dashboard-icon text-success"></i>Delivery Verification</h6>
      <ul class="list-unstyled mb-0" style="max-height:120px;overflow:auto;">
        @foreach($pendingDeliveries as $po)
          <li>
            <span class="badge bg-secondary">#{{ $po->id }}</span>
            {{ $po->rawMaterial->name ?? 'N/A' }} from {{ $po->supplier->name ?? 'N/A' }}
            <span class="badge bg-warning">Awaiting Verification</span>
            <a href="{{ route('admin.purchase_orders.show', $po->id) }}" class="btn btn-link btn-sm">Verify</a>
          </li>
        @endforeach
      </ul>
    </div>
  </div> --}}

<!-- Enhanced Analytics & Inventory Section -->
<div class="row g-4 mb-4">
    <!-- Enhanced Product Inventory Chart -->
    <div class="col-xl-6 col-lg-12">
        <div class="scm-card scm-hover-lift h-100" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="scm-card-header" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-pie-chart-fill me-3 fs-4"></i>
                    <div>
                        <h5 class="scm-card-title mb-0" style="color: white; font-weight: 600;">Product Inventory Distribution</h5>
                        <small style="color: rgba(255,255,255,0.8);">Inventory breakdown by product category</small>
                    </div>
                </div>
            </div>
            <div class="scm-card-body d-flex align-items-center justify-content-center" style="min-height: 300px;">
                <div class="chart-container">
                    <canvas id="batchAnalyticsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Raw Material Inventory -->
    <div class="col-xl-6 col-lg-12">
        <div class="scm-card scm-hover-lift h-100" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="scm-card-header" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-boxes me-3 fs-4"></i>
                    <div>
                        <h5 class="scm-card-title mb-0" style="color: white; font-weight: 600;">Raw Material Stock</h5>
                        <small style="color: rgba(255,255,255,0.8);">Current stock levels and alerts</small>
                    </div>
                </div>
            </div>
            <div class="scm-card-body" style="padding: 0; max-height: 350px; overflow-y: auto;">
                @forelse($rawMaterials ?? [] as $mat)
                    <div class="enhanced-inventory-item p-3 border-bottom" style="
                        background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(248,249,250,0.9) 100%);
                        transition: all 0.3s ease;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="bi bi-box-seam text-primary me-2"></i>
                                    <h6 class="mb-0" style="color: #2c3e50; font-weight: 600;">{{ $mat->name }}</h6>
                                </div>
                                <small class="text-muted">{{ $mat->type }}</small>
                            </div>
                            <div class="text-end">
                                <div class="quantity-display mb-2">
                                    <span class="fw-bold text-primary" style="font-size: 1.1rem;">{{ $mat->quantity }}</span>
                                    <span class="text-muted ms-1">{{ $mat->unit }}</span>
                                </div>
                                @if($mat->quantity <= ($mat->reorder_level ?? 10))
                                    <span class="badge bg-danger d-inline-flex align-items-center">
                                        <i class="bi bi-exclamation-triangle me-1"></i>Low Stock
                                    </span>
                                @else
                                    <span class="badge bg-success d-inline-flex align-items-center">
                                        <i class="bi bi-check-circle me-1"></i>In Stock
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <div class="empty-inventory-state">
                            <div class="scm-icon-wrapper mx-auto mb-4" style="width: 80px; height: 80px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white;">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                            </div>
                            <h6 class="text-muted mb-3">No Raw Materials</h6>
                            <p class="text-muted mb-4">No raw materials found in inventory</p>
                            <button class="btn btn-success">
                                <i class="bi bi-plus-circle me-2"></i>Add Materials
                            </button>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Financial & Operations Section -->
<div class="row g-4 mb-5">
    <!-- Supplier Payments -->
    <div class="col-xl-4 col-lg-6">
        <div class="info-card h-100">
            <div class="card-header-custom">
                <h6><i class="bi bi-cash-stack me-2"></i>Supplier Payments</h6>
                <small class="text-muted">Payment status</small>
            </div>
            <div class="card-body-custom">
                <div class="financial-list-container">
                    @forelse($supplierPayments ?? [] as $pay)
                        <div class="financial-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="item-title">{{ $pay['supplier'] }}</div>
                                    <div class="item-subtitle">Payment Record</div>
                                </div>
                                <div class="text-end">
                                    <div class="payment-amount">UGX {{ number_format($pay['amount'],0) }}</div>
                                    <span class="payment-status status-{{ $pay['status'] }}">
                                        <i class="bi bi-{{ $pay['status'] == 'paid' ? 'check-circle-fill' : 'clock-fill' }} me-1"></i>
                                        {{ ucfirst($pay['status']) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="bi bi-wallet2"></i>
                            <h6>No Payment Records</h6>
                            <p>No supplier payments found</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Management -->
    <div class="col-xl-4 col-lg-6">
        <div class="info-card h-100">
            <div class="card-header-custom">
                <h6><i class="bi bi-receipt me-2"></i>Recent Invoices</h6>
                <small class="text-muted">Invoice management</small>
            </div>
            <div class="card-body-custom">
                <div class="financial-list-container">
                    @forelse($invoices ?? [] as $inv)
                        <div class="financial-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="po-badge">#{{ $inv->po_id }}</span>
                                        <a href="{{ asset('storage/'.$inv->invoice_path) }}" target="_blank" class="invoice-link ms-2">
                                            <i class="bi bi-file-earmark-pdf me-1"></i>View PDF
                                        </a>
                                    </div>
                                    <div class="item-subtitle">Purchase Order Invoice</div>
                                </div>
                                <div class="text-end">
                                    <span class="invoice-status status-{{ $inv->status }}">
                                        <i class="bi bi-{{ $inv->status == 'approved' ? 'check-circle-fill' : ($inv->status == 'rejected' ? 'x-circle-fill' : 'clock-fill') }} me-1"></i>
                                        {{ ucfirst($inv->status) }}
                                    </span>
                                    <a href="{{ route('admin.purchase_orders.show', $inv->po_id) }}" class="review-btn">
                                        <i class="bi bi-eye me-1"></i>Review
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="bi bi-receipt-cutoff"></i>
                            <h6>No Invoices</h6>
                            <p>No invoices found</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Summary -->
    <div class="col-xl-4 col-lg-12">
        <div class="info-card h-100">
            <div class="card-header-custom">
                <h6><i class="bi bi-bar-chart-steps me-2"></i>Operations Summary</h6>
                <small class="text-muted">Monthly overview</small>
            </div>
            <div class="card-body-custom">
                <div class="analytics-metrics">
                    <div class="metric-item metric-success">
                        <div class="metric-icon">
                            <i class="bi bi-box-arrow-in-down"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-number">{{ $analytics['received_this_month'] ?? 0 }}</div>
                            <div class="metric-label">Received This Month</div>
                        </div>
                    </div>

                    <div class="metric-item metric-warning">
                        <div class="metric-icon">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-number">{{ $analytics['pending_pos'] ?? 0 }}</div>
                            <div class="metric-label">Pending POs</div>
                        </div>
                    </div>

                    <div class="metric-item metric-info">
                        <div class="metric-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-number">{{ $analytics['pending_deliveries'] ?? 0 }}</div>
                            <div class="metric-label">Pending Deliveries</div>
                        </div>
                    </div>

                    <div class="metric-item metric-danger">
                        <div class="metric-icon">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-number">{{ $analytics['unpaid'] ?? 0 }}</div>
                            <div class="metric-label">Unpaid Invoices</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<!-- Chart.js for analytics -->
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Batch Analytics Chart (Product Inventory Distribution)
  const ctx2 = document.getElementById('batchAnalyticsChart').getContext('2d');
  new Chart(ctx2, {
    type: 'doughnut',
    data: {
      labels: @json($batchLabels),
      datasets: [{
        data: @json($batchData),
        backgroundColor: [
          '#10b981', // Emerald
          '#6366f1', // Indigo  
          '#f59e42', // Orange
          '#f43f5e', // Rose
          '#0ea5e9', // Sky
          '#fbbf24', // Amber
          '#a3e635', // Lime
          '#8b5cf6', // Violet
          '#06b6d4', // Cyan
          '#f97316', // Orange-600
          '#84cc16', // Lime-500
          '#ec4899'  // Pink
        ],
        borderWidth: 2,
        borderColor: '#ffffff',
        hoverBorderWidth: 3,
        hoverBorderColor: '#ffffff'
      }]
    },
    options: { 
      responsive: true,
      maintainAspectRatio: false,
      cutout: '60%',
      plugins: { 
        legend: { 
          position: 'bottom',
          labels: {
            padding: 15,
            usePointStyle: true,
            pointStyle: 'circle',
            font: {
              size: 12,
              family: 'Poppins'
            },
            color: '#ffffff'
          }
        },
        tooltip: {
          backgroundColor: 'rgba(0, 0, 0, 0.8)',
          titleColor: '#ffffff',
          bodyColor: '#ffffff',
          cornerRadius: 8,
          callbacks: {
            label: function(context) {
              const label = context.label || '';
              const value = context.parsed;
              const total = context.dataset.data.reduce((a, b) => a + b, 0);
              const percentage = ((value / total) * 100).toFixed(1);
              return `${label}: ${value} pcs (${percentage}%)`;
            }
          }
        }
      }
    }
  });

  // Welcome page inspired animations for admin dashboard
  document.addEventListener('DOMContentLoaded', function() {
    // Animate cards on scroll
    const cards = document.querySelectorAll('.enhanced-action-card');
    cards.forEach((card, index) => {
      card.style.animationDelay = `${index * 0.1}s`;
    });

    // Add floating animation to icons
    const icons = document.querySelectorAll('.bi');
    icons.forEach(icon => {
      icon.addEventListener('mouseenter', function() {
        this.style.transform = 'scale(1.1) rotate(5deg)';
        this.style.transition = 'all 0.3s ease';
      });
      
      icon.addEventListener('mouseleave', function() {
        this.style.transform = 'scale(1) rotate(0deg)';
      });
    });

    // Add glow effect to cards on hover
    const allCards = document.querySelectorAll('.scm-card, .info-card, .dashboard-card');
    allCards.forEach(card => {
      card.addEventListener('mouseenter', function() {
        this.style.boxShadow = '0 20px 60px rgba(16, 185, 129, 0.3)';
      });
      
      card.addEventListener('mouseleave', function() {
        this.style.boxShadow = '';
      });
    });
  });
</script>

<!-- Google Fonts - Poppins -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
/* Ecoverse Admin Dashboard - Welcome Page Theme Integration */
body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #10b981 100%) !important;
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
    color: #ffffff;
    min-height: 100vh;
    position: relative;
    overflow-x: hidden;
}

/* Global text color overrides */
h1, h2, h3, h4, h5, h6 {
    color: #ffffff !important;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
}

p, span, div:not(.badge), label, small {
    color: rgba(255, 255, 255, 0.9) !important;
    font-family: 'Poppins', sans-serif;
}

/* Text gradient for headings */
.text-gradient {
    background: linear-gradient(135deg, #10b981, #6366f1);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Dashboard Container */
.admin-dashboard-container {
    max-width: 1600px;
    margin: 0 auto;
    padding: 1.5rem;
    position: relative;
}

/* Floating Particles Background Effect */
.admin-dashboard-container::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="1" fill="%2310b981" opacity="0.3"/><circle cx="80" cy="40" r="1.5" fill="%236366f1" opacity="0.4"/><circle cx="40" cy="80" r="1" fill="%23f59e0b" opacity="0.3"/><circle cx="70" cy="70" r="1.2" fill="%2310b981" opacity="0.5"/></svg>');
    animation: float-particles 20s infinite linear;
    pointer-events: none;
    z-index: -1;
}

@keyframes float-particles {
    0% { transform: translateY(100vh) rotate(0deg); }
    100% { transform: translateY(-100vh) rotate(360deg); }
}

@media (min-width: 1400px) {
    .admin-dashboard-container {
        padding: 2rem 3rem;
    }
}

@media (min-width: 1920px) {
    .admin-dashboard-container {
        padding: 2rem 5rem;
    }
}

/* Dashboard Header */
.dashboard-header {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 2px solid rgba(16, 185, 129, 0.3);
    border-radius: 1.5rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 20px 60px rgba(16, 185, 129, 0.2);
    position: relative;
    overflow: hidden;
    color: #ffffff;
}

.dashboard-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(16, 185, 129, 0.3) 0%, transparent 70%);
    border-radius: 50%;
}

.dashboard-logo-circle {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 4px 20px rgba(59, 130, 246, 0.3);
}

.dashboard-stats .stat-item {
    text-align: center;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
}

.stat-label {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.7);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Action Cards */
.action-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 1.5rem;
    padding: 2rem;
    height: 100%;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.15);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    color: #ffffff;
}

.action-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #10b981, #6366f1);
}

.action-card.card-primary { --card-color: #10b981; }
.action-card.card-success { --card-color: #10b981; }
.action-card.card-info { --card-color: #06b6d4; }
.action-card.card-warning { --card-color: #f59e0b; }
.action-card.card-danger { --card-color: #ef4444; }

.action-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 60px rgba(16, 185, 129, 0.25);
    border-color: rgba(16, 185, 129, 0.5);
    background: rgba(255, 255, 255, 0.15);
}

.action-card .card-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.4);
}

.action-card .card-content h5 {
    font-weight: 600;
    margin-bottom: 0.75rem;
    color: #ffffff;
    font-size: 1.5rem;
}

.action-card .card-content p {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.95rem;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.btn-modern {
    border-radius: 50px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    text-transform: none;
    border: none;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.3);
    transition: all 0.3s ease;
}

.btn-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 40px rgba(16, 185, 129, 0.4);
    color: white;
}

/* Info Cards */
.info-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 1.5rem;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.15);
    overflow: hidden;
    color: #ffffff;
    transition: all 0.3s ease;
}

.info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 60px rgba(16, 185, 129, 0.2);
    border-color: rgba(16, 185, 129, 0.4);
}

.card-header-custom {
    background: rgba(16, 185, 129, 0.2);
    backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    padding: 1.25rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header-custom h6 {
    margin: 0;
    font-weight: 600;
    color: #ffffff;
    display: flex;
    align-items: center;
}

.card-header-custom small {
    color: rgba(255, 255, 255, 0.7);
}

.card-body-custom {
    padding: 1.5rem;
}

/* Chart Container */
.chart-container {
    position: relative;
    height: 300px;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    overflow: hidden;
}

.chart-container canvas {
    max-height: 280px !important;
    max-width: 100% !important;
    width: auto !important;
    height: auto !important;
}

/* Enhanced Inventory & Financial Lists */
.inventory-list-container, .financial-list-container {
    max-height: 320px;
    overflow-y: auto;
    padding: 0.5rem 0;
}

.inventory-item, .financial-item {
    padding: 1rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.inventory-item:last-child, .financial-item:last-child {
    border-bottom: none;
}

.inventory-item:hover, .financial-item:hover {
    background: rgba(16, 185, 129, 0.1);
    margin: 0 -1rem;
    padding: 1rem;
    border-radius: 0.75rem;
    backdrop-filter: blur(20px);
}

.item-title {
    font-weight: 600;
    color: #ffffff;
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
}

.item-subtitle {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.7);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Quantity Display */
.quantity-display {
    display: flex;
    align-items: baseline;
    gap: 0.25rem;
    margin-bottom: 0.5rem;
}

.quantity-number {
    font-size: 1.1rem;
    font-weight: 700;
    color: #ffffff;
}

.quantity-unit {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.7);
    text-transform: uppercase;
}

/* Stock Status */
.stock-alert, .stock-ok {
    font-size: 0.75rem;
    font-weight: 500;
    padding: 0.25rem 0.5rem;
    border-radius: 0.5rem;
    display: inline-flex;
    align-items: center;
    backdrop-filter: blur(10px);
}

.stock-alert {
    background: rgba(239, 68, 68, 0.2);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: #fca5a5;
}

.stock-ok {
    background: rgba(16, 185, 129, 0.2);
    border: 1px solid rgba(16, 185, 129, 0.3);
    color: #6ee7b7;
}

/* Payment Amount */
.payment-amount {
    font-weight: 700;
    color: #6ee7b7;
    font-size: 1rem;
    margin-bottom: 0.5rem;
}

/* Status Badges */
.payment-status, .invoice-status {
    font-size: 0.75rem;
    font-weight: 500;
    padding: 0.25rem 0.5rem;
    border-radius: 0.5rem;
    display: inline-flex;
    align-items: center;
    backdrop-filter: blur(10px);
}

.status-paid, .status-approved {
    background: rgba(16, 185, 129, 0.2);
    border: 1px solid rgba(16, 185, 129, 0.3);
    color: #6ee7b7;
}

.status-pending {
    background: rgba(245, 158, 11, 0.2);
    border: 1px solid rgba(245, 158, 11, 0.3);
    color: #fbbf24;
}

.status-rejected {
    background: rgba(239, 68, 68, 0.2);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: #fca5a5;
}

/* PO Badge & Links */
.po-badge {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: #ffffff;
    padding: 0.25rem 0.5rem;
    border-radius: 0.5rem;
    font-size: 0.75rem;
    font-weight: 600;
}

.invoice-link {
    color: #6ee7b7;
    text-decoration: none;
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.invoice-link:hover {
    color: #10b981;
    text-decoration: underline;
}

.review-btn {
    background: rgba(16, 185, 129, 0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(16, 185, 129, 0.3);
    color: #6ee7b7;
    padding: 0.25rem 0.5rem;
    border-radius: 0.5rem;
    text-decoration: none;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    margin-top: 0.5rem;
    transition: all 0.3s ease;
}

.review-btn:hover {
    background: rgba(16, 185, 129, 0.3);
    color: #10b981;
    text-decoration: none;
    transform: translateY(-2px);
}

/* Enhanced Analytics Metrics */
.analytics-metrics {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    height: 100%;
}

.metric-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 0.75rem;
    border-left: 4px solid var(--metric-color);
    transition: all 0.3s ease;
}

.metric-item:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: translateX(4px);
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.2);
}

.metric-success { --metric-color: #10b981; }
.metric-warning { --metric-color: #f59e0b; }
.metric-info { --metric-color: #06b6d4; }
.metric-danger { --metric-color: #ef4444; }

.metric-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--metric-color);
    color: white;
    font-size: 1.1rem;
    margin-right: 1rem;
    flex-shrink: 0;
    box-shadow: 0 4px 20px rgba(16, 185, 129, 0.3);
}

.metric-content {
    flex-grow: 1;
}

.metric-number {
    font-size: 1.25rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 0.25rem;
}

.metric-label {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.7);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Empty States */
.empty-state {
    text-align: center;
    padding: 2rem 1rem;
    color: rgba(255, 255, 255, 0.7);
}

.empty-state i {
    font-size: 2.5rem;
    color: rgba(255, 255, 255, 0.4);
    margin-bottom: 1rem;
    display: block;
}

.empty-state h6 {
    color: #ffffff;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.empty-state p {
    font-size: 0.875rem;
    margin: 0;
    color: rgba(255, 255, 255, 0.6);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    padding: 0.5rem 0;
}

.action-btn {
    border-radius: 50px;
    padding: 0.875rem 1rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.3);
}

.action-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 40px rgba(16, 185, 129, 0.4);
    text-decoration: none;
    color: white;
}

/* List Items */
.list-group-item {
    padding: 1rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
    background: transparent !important;
    color: #ffffff;
}

.list-group-item:last-child {
    border-bottom: none !important;
}

/* Responsive Design */
@media (max-width: 1400px) {
    .dashboard-stats {
        display: none !important;
    }
}

@media (max-width: 1024px) {
    .analytics-metrics {
        gap: 0.75rem;
    }
    
    .metric-item {
        padding: 0.75rem;
    }
    
    .chart-container {
        height: 280px;
        padding: 0.75rem;
    }
    
    .chart-container canvas {
        max-height: 260px !important;
    }
}

@media (max-width: 768px) {
    .admin-dashboard-container {
        padding: 1rem;
    }
    
    .dashboard-header {
        padding: 1.5rem;
    }
    
    .action-card {
        padding: 1.5rem;
    }
    
    .card-body-custom {
        padding: 1rem;
    }
    
    .chart-container {
        height: 250px;
        padding: 0.5rem;
    }
    
    .chart-container canvas {
        max-height: 230px !important;
    }
    
    .analytics-metrics {
        gap: 0.5rem;
    }
    
    .metric-item {
        padding: 0.75rem;
        flex-direction: column;
        text-align: center;
    }
    
    .metric-icon {
        margin-right: 0;
        margin-bottom: 0.5rem;
    }
}

/* Enhanced Admin Dashboard Styles */
.enhanced-action-card {
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    animation: slideInUp 0.6s ease-out;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.enhanced-action-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 60px rgba(16, 185, 129, 0.25);
    border-color: rgba(16, 185, 129, 0.5);
}

.enhanced-action-card:hover::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
    pointer-events: none;
}

.enhanced-action-btn {
    transition: all 0.3s ease;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.enhanced-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    text-decoration: none;
    filter: brightness(1.1);
}

.enhanced-po-item {
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.enhanced-po-item:hover {
    background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(248,249,250,1) 100%) !important;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    transform: translateY(-3px);
}

.enhanced-po-item:hover::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(52, 152, 219, 0.05) 0%, rgba(41, 128, 185, 0.05) 100%);
    pointer-events: none;
}

.po-id-section, .po-status-badge {
    transition: all 0.3s ease;
}

.enhanced-po-item:hover .po-id-section {
    transform: scale(1.05);
    background: rgba(255,255,255,1) !important;
}

.enhanced-po-item:hover .po-status-badge {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(0,0,0,0.3) !important;
}

.enhanced-inventory-item {
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.enhanced-inventory-item:hover {
    background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(248,249,250,1) 100%) !important;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    transform: translateX(5px);
}

.enhanced-inventory-item:hover::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.05) 0%, rgba(32, 201, 151, 0.05) 100%);
    pointer-events: none;
}

.scm-metric-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.scm-fade-in {
    animation: slideInDown 0.8s ease-out;
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.empty-po-state, .empty-inventory-state {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Improved Scrollbars for Admin Dashboard */
.scm-card-body::-webkit-scrollbar {
    width: 8px;
}

.scm-card-body::-webkit-scrollbar-track {
    background: linear-gradient(135deg, #f1f1f1 0%, #e9ecef 100%);
    border-radius: 10px;
}

.scm-card-body::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    border-radius: 10px;
    transition: all 0.3s ease;
}

.scm-card-body::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #495057 0%, #343a40 100%);
}

/* Responsive enhancements for admin dashboard */
@media (max-width: 768px) {
    .enhanced-po-item .row {
        text-align: center;
    }
    
    .enhanced-po-item .col-md-2,
    .enhanced-po-item .col-md-3,
    .enhanced-po-item .col-md-4 {
        margin-bottom: 15px;
    }
    
    .po-id-section {
        margin: 0 auto 15px auto;
        max-width: 150px;
    }
    
    .scm-metric-card {
        margin-bottom: 20px;
    }
}

/* Custom Scrollbars */
.inventory-list-container::-webkit-scrollbar, 
.financial-list-container::-webkit-scrollbar {
    width: 6px;
}

.inventory-list-container::-webkit-scrollbar-track, 
.financial-list-container::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 3px;
}

.inventory-list-container::-webkit-scrollbar-thumb, 
.financial-list-container::-webkit-scrollbar-thumb {
    background: rgba(16, 185, 129, 0.6);
    border-radius: 3px;
}

.inventory-list-container::-webkit-scrollbar-thumb:hover, 
.financial-list-container::-webkit-scrollbar-thumb:hover {
    background: rgba(16, 185, 129, 0.8);
}
</style>

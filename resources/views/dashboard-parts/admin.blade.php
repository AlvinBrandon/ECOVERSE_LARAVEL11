<!-- ECOVERSE Admin Dashboard Title Banner -->
<div class="alert mb-4 d-flex align-items-center ecoverse-fade-in-up" style="background: var(--ecoverse-gradient-dark); border: none; color: var(--ecoverse-white); font-weight: 700; font-size: 1.2rem; border-radius: var(--ecoverse-radius-xl); padding: 24px; box-shadow: var(--ecoverse-shadow-lg); backdrop-filter: blur(10px);">
  <i class="bi bi-speedometer2 me-3 fs-3" style="color: var(--ecoverse-white);"></i>
  <div>
    <strong style="text-transform: uppercase; letter-spacing: 1px;">ECOVERSE ADMIN CONTROL CENTER</strong>
    <div style="font-size: 0.9rem; opacity: 0.95; font-weight: 400; color: rgba(255,255,255,0.9);">Sustainable system management & eco-analytics dashboard</div>
  </div>
</div>

<!-- ECOVERSE Professional Admin Header -->
<div class="scm-card mb-4 ecoverse-fade-in-up scm-hover-earth" style="background: var(--ecoverse-gradient-earth); color: var(--ecoverse-white); border: none; animation-delay: 0.1s;">
    <div class="scm-card-header" style="background: transparent; border: none;">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="scm-icon-wrapper me-3" style="background: rgba(255,255,255,0.2); color: var(--ecoverse-white); backdrop-filter: blur(10px);">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div>
                    <h4 class="scm-card-title mb-1" style="color: var(--ecoverse-white); font-weight: 700;">ECOVERSE Supply Chain Control Center</h4>
                    <p class="scm-card-subtitle" style="color: rgba(255,255,255,0.9); margin-bottom: 0;">Welcome back, {{ Auth::user()->name }} | Pioneering sustainable administrative excellence</p>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="scm-status-badge me-3 scm-floating-pulse" style="background: rgba(255,255,255,0.3); color: var(--ecoverse-white); border: 2px solid rgba(255,255,255,0.2); padding: 12px 20px; border-radius: var(--ecoverse-radius-full); backdrop-filter: blur(10px);">
                    <i class="bi bi-check-circle me-2"></i>
                    Eco-System Active
                </div>
                <div class="scm-status-badge" style="background: rgba(255,255,255,0.3); color: var(--ecoverse-white); border: 2px solid rgba(255,255,255,0.2); padding: 12px 20px; border-radius: var(--ecoverse-radius-full); backdrop-filter: blur(10px);">
                    <i class="bi bi-activity me-2"></i>
                    {{ $totalUsers ?? '0' }} Green Users
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ECOVERSE Primary Metrics with Earth Gradients -->
<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="scm-metric-card scm-hover-earth ecoverse-fade-in-up" style="background: var(--ecoverse-gradient-primary); color: var(--ecoverse-white); border: none; animation-delay: 0.1s;">
            <div class="d-flex align-items-center">
                <div class="scm-metric-icon" style="background: rgba(255,255,255,0.2); color: var(--ecoverse-white); backdrop-filter: blur(10px);">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <h3 class="scm-metric-value" style="color: var(--ecoverse-white); background: linear-gradient(135deg, var(--ecoverse-white) 0%, var(--ecoverse-fawn-light) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">{{ $totalUsers ?? 0 }}</h3>
                    <p class="scm-metric-label" style="color: rgba(255,255,255,0.9); margin-bottom: 0;">Eco-Champions</p>
                    <div class="scm-metric-trend positive" style="color: var(--ecoverse-fawn-light);">
                        <i class="bi bi-arrow-up"></i>
                        <span>+12.5% Growth</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="scm-metric-card scm-hover-earth ecoverse-fade-in-up" style="background: var(--ecoverse-gradient-accent); color: var(--ecoverse-ateneo-blue); border: none; animation-delay: 0.2s;">
            <div class="d-flex align-items-center">
                <div class="scm-metric-icon" style="background: rgba(7, 59, 109, 0.2); color: var(--ecoverse-ateneo-blue); backdrop-filter: blur(10px);">
                    <i class="bi bi-box-seam-fill"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <h3 class="scm-metric-value" style="color: var(--ecoverse-ateneo-blue); background: linear-gradient(135deg, var(--ecoverse-ateneo-blue) 0%, var(--ecoverse-bistre) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">{{ $totalProducts ?? 0 }}</h3>
                    <p class="scm-metric-label" style="color: var(--ecoverse-ateneo-blue); margin-bottom: 0; font-weight: 600;">Eco-Products</p>
                    <div class="scm-metric-trend positive" style="color: var(--ecoverse-bistre);">
                        <i class="bi bi-arrow-up"></i>
                        <span>+8.3% Sustainable</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="scm-metric-card scm-hover-earth ecoverse-fade-in-up" style="background: var(--ecoverse-gradient-dark); color: var(--ecoverse-white); border: none; animation-delay: 0.3s;">
            <div class="d-flex align-items-center">
                <div class="scm-metric-icon" style="background: rgba(255,255,255,0.2); color: var(--ecoverse-white); backdrop-filter: blur(10px);">
                    <i class="bi bi-clipboard-check-fill"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <h3 class="scm-metric-value" style="color: var(--ecoverse-white); background: linear-gradient(135deg, var(--ecoverse-white) 0%, var(--ecoverse-fawn-light) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">{{ $activePOs ?? 0 }}</h3>
                    <p class="scm-metric-label" style="color: rgba(255,255,255,0.9); margin-bottom: 0;">Green Purchase Orders</p>
                    <div class="scm-metric-trend positive" style="color: var(--ecoverse-fawn-light);">
                        <i class="bi bi-arrow-up"></i>
                        <span>+15.7% Eco-Growth</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="scm-metric-card scm-hover-earth ecoverse-fade-in-up" style="background: var(--ecoverse-gradient-secondary); color: var(--ecoverse-white); border: none; animation-delay: 0.4s;">
            <div class="d-flex align-items-center">
                <div class="scm-metric-icon" style="background: rgba(255,255,255,0.2); color: var(--ecoverse-white); backdrop-filter: blur(10px);">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <h3 class="scm-metric-value" style="color: var(--ecoverse-white); background: linear-gradient(135deg, var(--ecoverse-white) 0%, var(--ecoverse-fawn-light) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">UGX 4.2M</h3>
                    <p class="scm-metric-label" style="color: rgba(255,255,255,0.9); margin-bottom: 0;">Eco-Revenue</p>
                    <div class="scm-metric-trend positive" style="color: var(--ecoverse-fawn-light);">
                        <i class="bi bi-arrow-up"></i>
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
        <div class="scm-card scm-hover-earth ecoverse-fade-in-up enhanced-action-card" style="background: linear-gradient(135deg, rgba(205, 128, 106, 0.1) 0%, rgba(205, 128, 106, 0.05) 100%); border: 2px solid rgba(205, 128, 106, 0.2); animation-delay: 0.1s;">
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
        <div class="scm-card scm-hover-lift enhanced-action-card" style="background: linear-gradient(135deg, rgba(46, 204, 113, 0.1) 0%, rgba(39, 174, 96, 0.1) 100%); border-left: 5px solid #2ecc71;">
            <div class="scm-card-header" style="background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); color: white;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-people-fill me-3 fs-4"></i>
                    <h5 class="scm-card-title mb-0" style="color: white; font-weight: 600;">User Management</h5>
                </div>
            </div>
            <div class="scm-card-body">
                <p class="scm-card-text mb-3">Manage all users, roles and permissions across the supply chain system</p>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <small class="text-muted">Total System Users</small>
                    <span class="badge bg-success">{{ $totalUsers ?? '0' }} Users</span>
                </div>
                <a href="{{ route('user-management') }}" class="scm-btn scm-btn-success w-100" style="background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); border: none;">
                    <i class="bi bi-person-lines-fill me-2"></i>Manage Users
                </a>
            </div>
        </div>
    </div>

    <!-- Inventory Control -->
    <div class="col-xl-4 col-lg-6">
        <div class="scm-card scm-hover-lift enhanced-action-card" style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.1) 0%, rgba(41, 128, 185, 0.1) 100%); border-left: 5px solid #3498db;">
            <div class="scm-card-header" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-box-seam-fill me-3 fs-4"></i>
                    <h5 class="scm-card-title mb-0" style="color: white; font-weight: 600;">Inventory Control</h5>
                </div>
            </div>
            <div class="scm-card-body">
                <p class="scm-card-text mb-3">Monitor stock levels, analytics and inventory management across all locations</p>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <small class="text-muted">Active Products</small>
                    <span class="badge bg-info">{{ $totalProducts ?? '0' }} Items</span>
                </div>
                <a href="{{ route('inventory.index') }}" class="scm-btn scm-btn-info w-100" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); border: none;">
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
  // // Sales Trends Chart (real data)
  // const ctx1 = document.getElementById('salesTrendsChart').getContext('2d');
  // new Chart(ctx1, {
  //   type: 'line',
  //   data: {
  //     labels: @json($revenueTrendLabels),
  //     datasets: [{
  //       label: 'Sales',
  //       data: @json($revenueTrendData),
  //       borderColor: '#6366f1',
  //       backgroundColor: 'rgba(99,102,241,0.1)',
  //       tension: 0.4
  //     }]
  //   },
  //   options: { plugins: { legend: { display: false } } }
  // });
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
            }
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
              return `${label}: ${value} units (${percentage}%)`;
            }
          }
        }
      }
    }
  });
</script>

<!-- Google Fonts - Poppins -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
/* Modern Professional Dashboard Styling */
body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
}

/* Dashboard Container */
.admin-dashboard-container {
    max-width: 1600px;
    margin: 0 auto;
    padding: 1.5rem;
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
    background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.dashboard-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
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
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    height: 100%;
    border: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
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
    background: var(--card-color);
}

.action-card.card-primary { --card-color: #3b82f6; }
.action-card.card-success { --card-color: #10b981; }
.action-card.card-info { --card-color: #06b6d4; }
.action-card.card-warning { --card-color: #f59e0b; }
.action-card.card-danger { --card-color: #ef4444; }

.action-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.action-card .card-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, var(--card-color), color-mix(in srgb, var(--card-color) 80%, black));
    color: white;
    box-shadow: 0 8px 25px color-mix(in srgb, var(--card-color) 30%, transparent);
}

.action-card .card-content h5 {
    font-weight: 600;
    margin-bottom: 0.75rem;
    color: #1e293b;
}

.action-card .card-content p {
    color: #64748b;
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
}

.btn-modern {
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    text-transform: none;
    border: none;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

/* Info Cards */
.info-card {
    background: white;
    border-radius: 1rem;
    border: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.card-header-custom {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 1.25rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header-custom h6 {
    margin: 0;
    font-weight: 600;
    color: #1e293b;
    display: flex;
    align-items: center;
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
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.2s ease;
}

.inventory-item:last-child, .financial-item:last-child {
    border-bottom: none;
}

.inventory-item:hover, .financial-item:hover {
    background: #f8fafc;
    margin: 0 -1rem;
    padding: 1rem;
    border-radius: 0.5rem;
}

.item-title {
    font-weight: 600;
    color: #1e293b;
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
}

.item-subtitle {
    font-size: 0.8rem;
    color: #64748b;
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
    color: #1e293b;
}

.quantity-unit {
    font-size: 0.8rem;
    color: #64748b;
    text-transform: uppercase;
}

/* Stock Status */
.stock-alert, .stock-ok {
    font-size: 0.75rem;
    font-weight: 500;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    display: inline-flex;
    align-items: center;
}

.stock-alert {
    background: #fef2f2;
    color: #dc2626;
}

.stock-ok {
    background: #f0fdf4;
    color: #16a34a;
}

/* Payment Amount */
.payment-amount {
    font-weight: 700;
    color: #059669;
    font-size: 1rem;
    margin-bottom: 0.5rem;
}

/* Status Badges */
.payment-status, .invoice-status {
    font-size: 0.75rem;
    font-weight: 500;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    display: inline-flex;
    align-items: center;
}

.status-paid, .status-approved {
    background: #f0fdf4;
    color: #16a34a;
}

.status-pending {
    background: #fffbeb;
    color: #d97706;
}

.status-rejected {
    background: #fef2f2;
    color: #dc2626;
}

/* PO Badge & Links */
.po-badge {
    background: #e2e8f0;
    color: #475569;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    font-weight: 600;
}

.invoice-link {
    color: #3b82f6;
    text-decoration: none;
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.invoice-link:hover {
    color: #1d4ed8;
    text-decoration: underline;
}

.review-btn {
    background: #f1f5f9;
    color: #475569;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    text-decoration: none;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    margin-top: 0.5rem;
    transition: all 0.2s ease;
}

.review-btn:hover {
    background: #e2e8f0;
    color: #334155;
    text-decoration: none;
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
    background: #f8fafc;
    border-radius: 0.75rem;
    border-left: 4px solid var(--metric-color);
    transition: all 0.2s ease;
}

.metric-item:hover {
    background: #f1f5f9;
    transform: translateX(4px);
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
}

.metric-content {
    flex-grow: 1;
}

.metric-number {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.metric-label {
    font-size: 0.75rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Empty States */
.empty-state {
    text-align: center;
    padding: 2rem 1rem;
    color: #64748b;
}

.empty-state i {
    font-size: 2.5rem;
    color: #cbd5e1;
    margin-bottom: 1rem;
    display: block;
}

.empty-state h6 {
    color: #475569;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.empty-state p {
    font-size: 0.875rem;
    margin: 0;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    padding: 0.5rem 0;
}

.action-btn {
    border-radius: 0.5rem;
    padding: 0.875rem 1rem;
    font-weight: 500;
    text-decoration: none;
    border: none;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    text-decoration: none;
}

/* List Items */
.list-group-item {
    padding: 1rem 0;
    border-bottom: 1px solid #f1f5f9 !important;
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
}

.enhanced-action-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.enhanced-action-card:hover::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
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
    background: #f1f5f9;
    border-radius: 3px;
}

.inventory-list-container::-webkit-scrollbar-thumb, 
.financial-list-container::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.inventory-list-container::-webkit-scrollbar-thumb:hover, 
.financial-list-container::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>

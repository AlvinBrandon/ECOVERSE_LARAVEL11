<!-- ECOVERSE Retailer Dashboard Title Banner -->
<div class="alert alert-success mb-4 d-flex align-items-center ecoverse-fade-in-up" style="background: var(--ecoverse-gradient-earth); border: none; color: var(--ecoverse-white); font-weight: 700; font-size: 1.2rem; border-radius: var(--ecoverse-radius-xl); padding: 24px; box-shadow: var(--ecoverse-shadow-lg); backdrop-filter: blur(10px);">
  <i class="bi bi-shop me-3 fs-3" style="color: var(--ecoverse-white);"></i>
  <div>
    <strong style="text-transform: uppercase; letter-spacing: 1px;">ECOVERSE RETAILER DASHBOARD</strong>
    <div style="font-size: 0.9rem; opacity: 0.95; font-weight: 400; color: rgba(255,255,255,0.9);">Sustainable retail operations & eco-customer management</div>
  </div>
</div>

<!-- ECOVERSE Professional Retailer Header -->
<div class="scm-card mb-4 ecoverse-fade-in-up scm-hover-earth" style="animation-delay: 0.1s;">
  <div class="scm-card-header" style="background: var(--ecoverse-gradient-dark); color: var(--ecoverse-white);">
    <div class="d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center">
        <div class="scm-icon-wrapper me-3" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px);">
          <i class="bi bi-shop"></i>
        </div>
        <div>
          <h4 class="scm-card-title mb-1">ECOVERSE Retail Operations Center</h4>
          <p class="scm-card-subtitle">Welcome back, {{ Auth::user()->name }} | Pioneering sustainable retail excellence</p>
        </div>
      </div>
      <div class="scm-status-badge scm-floating-pulse" style="background: rgba(255,255,255,0.3); color: var(--ecoverse-white); padding: 12px 20px; border-radius: var(--ecoverse-radius-full); backdrop-filter: blur(10px); border: 2px solid rgba(255,255,255,0.2);">
        <i class="bi bi-check-circle me-2"></i>
        Eco-Store Active
      </div>
    </div>
  </div>
</div>

<!-- ECOVERSE Performance Metrics -->
<div class="row g-4 mb-4">
  <div class="col-lg-3 col-md-6">
    <div class="scm-metric-card scm-hover-earth ecoverse-fade-in-up" style="background: var(--ecoverse-gradient-primary); color: var(--ecoverse-white); animation-delay: 0.1s;">
      <div class="d-flex align-items-center">
        <div class="scm-metric-icon" style="background: rgba(255,255,255,0.2); color: var(--ecoverse-white); backdrop-filter: blur(10px);">
          <i class="bi bi-basket3"></i>
        </div>
        <div class="ms-3 flex-grow-1">
          <h3 class="scm-metric-value" style="color: var(--ecoverse-white); background: linear-gradient(135deg, var(--ecoverse-white) 0%, var(--ecoverse-fawn-light) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">524</h3>
          <p class="scm-metric-label" style="color: rgba(255,255,255,0.9);">Eco-Sales Today</p>
          <div class="scm-metric-trend positive" style="color: var(--ecoverse-fawn-light);">
            <i class="bi bi-arrow-up"></i>
            <span>+18.3% Green Growth</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6">
    <div class="scm-metric-card scm-hover-earth ecoverse-fade-in-up" style="background: var(--ecoverse-gradient-earth); color: var(--ecoverse-white); animation-delay: 0.2s;">
      <div class="d-flex align-items-center">
        <div class="scm-metric-icon" style="background: rgba(255,255,255,0.2); color: var(--ecoverse-white); backdrop-filter: blur(10px);">
          <i class="bi bi-people-fill"></i>
        </div>
        <div class="ms-3 flex-grow-1">
          <h3 class="scm-metric-value" style="color: var(--ecoverse-white); background: linear-gradient(135deg, var(--ecoverse-white) 0%, var(--ecoverse-fawn-light) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">1,247</h3>
          <p class="scm-metric-label" style="color: rgba(255,255,255,0.9);">Eco-Customers</p>
          <div class="scm-metric-trend positive" style="color: var(--ecoverse-fawn-light);">
            <i class="bi bi-arrow-up"></i>
            <span>+5.7% Conscious Growth</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6">
    <div class="scm-metric-card scm-hover-earth ecoverse-fade-in-up" style="background: var(--ecoverse-gradient-sunset); color: var(--ecoverse-white); animation-delay: 0.3s;">
      <div class="d-flex align-items-center">
        <div class="scm-metric-icon" style="background: rgba(255,255,255,0.2); color: var(--ecoverse-white); backdrop-filter: blur(10px);">
          <i class="bi bi-box-seam-fill"></i>
        </div>
        <div class="ms-3 flex-grow-1">
          <h3 class="scm-metric-value" style="color: var(--ecoverse-white); background: linear-gradient(135deg, var(--ecoverse-white) 0%, var(--ecoverse-fawn-light) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">43</h3>
          <p class="scm-metric-label" style="color: rgba(255,255,255,0.9);">Low Stock Items</p>
          <div class="scm-metric-trend negative" style="color: var(--ecoverse-fawn-light);">
            <i class="bi bi-arrow-down"></i>
            <span>-2.1% Restocking</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6">
    <div class="scm-metric-card scm-hover-earth ecoverse-fade-in-up" style="background: var(--ecoverse-gradient-ocean); color: var(--ecoverse-white); animation-delay: 0.4s;">
      <div class="d-flex align-items-center">
        <div class="scm-metric-icon" style="background: rgba(255,255,255,0.2); color: var(--ecoverse-white); backdrop-filter: blur(10px);">
          <i class="bi bi-currency-dollar"></i>
        </div>
        <div class="ms-3 flex-grow-1">
          <h3 class="scm-metric-value" style="color: var(--ecoverse-white); background: linear-gradient(135deg, var(--ecoverse-white) 0%, var(--ecoverse-fawn-light) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">UGX 847K</h3>
          <p class="scm-metric-label" style="color: rgba(255,255,255,0.9);">Green Revenue</p>
          <div class="scm-metric-trend positive" style="color: var(--ecoverse-fawn-light);">
            <i class="bi bi-arrow-up"></i>
            <span>+22.4% Eco-Profit</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- SCM Quick Actions & Management Grid -->
<div class="row g-4 mb-4">
  <div class="col-xl-4 col-lg-6">
    <div class="scm-card scm-hover-lift">
      <div class="scm-card-header" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">
        <div class="d-flex align-items-center">
          <i class="bi bi-cart-check-fill me-3 fs-4"></i>
          <h5 class="scm-card-title mb-0">Customer Orders</h5>
        </div>
      </div>
      <div class="scm-card-body">
        <p class="scm-card-text mb-3">Process and manage customer orders efficiently with real-time tracking</p>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <small class="text-muted">Today's Orders</small>
          <span class="badge" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">47 New</span>
        </div>
        <a href="{{ route('retailer.customer-orders') }}" class="scm-btn w-100" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; border: none; padding: 12px; border-radius: 8px; text-decoration: none; display: inline-block; text-align: center; font-weight: 600; transition: all 0.3s ease;">
          <i class="bi bi-bag-check me-2"></i>Manage Orders
        </a>
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-lg-6">
    <div class="scm-card scm-hover-lift">
      <div class="scm-card-header" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white;">
        <div class="d-flex align-items-center">
          <i class="bi bi-box-seam-fill me-3 fs-4"></i>
          <h5 class="scm-card-title mb-0">Inventory Management</h5>
        </div>
      </div>
      <div class="scm-card-body">
        <p class="scm-card-text mb-3">Monitor stock levels and manage product availability for your store</p>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <small class="text-muted">Low Stock Items</small>
          <span class="badge" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white;">43 Items</span>
        </div>
        <a href="{{ route('retailer.inventory') }}" class="scm-btn w-100" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; border: none; padding: 12px; border-radius: 8px; text-decoration: none; display: inline-block; text-align: center; font-weight: 600; transition: all 0.3s ease;">
          <i class="bi bi-boxes me-2"></i>Check Inventory
        </a>
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-lg-6">
    <div class="scm-card scm-hover-lift">
      <div class="scm-card-header" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">
        <div class="d-flex align-items-center">
          <i class="bi bi-truck me-3 fs-4"></i>
          <h5 class="scm-card-title mb-0">Wholesale Procurement</h5>
        </div>
      </div>
      <div class="scm-card-body">
        <p class="scm-card-text mb-3">Order products from wholesalers to restock your retail inventory</p>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <small class="text-muted">Pending Orders</small>
          <span class="badge" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">12 Active</span>
        </div>
        <a href="{{ route('sales.index') }}" class="scm-btn w-100" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; border: none; padding: 12px; border-radius: 8px; text-decoration: none; display: inline-block; text-align: center; font-weight: 600; transition: all 0.3s ease;">
          <i class="bi bi-bag-plus me-2"></i>Order from Wholesalers
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Additional Management Options -->
<div class="row g-4 mb-4">
  <div class="col-xl-4 col-lg-6">
    <div class="scm-card scm-hover-lift">
      <div class="scm-card-header" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white;">
        <div class="d-flex align-items-center">
          <i class="bi bi-graph-up-arrow me-3 fs-4"></i>
          <h5 class="scm-card-title mb-0">Sales Analytics</h5>
        </div>
      </div>
      <div class="scm-card-body">
        <p class="scm-card-text mb-3">Track sales performance and analyze customer purchasing patterns</p>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <small class="text-muted">Today's Revenue</small>
          <span class="badge" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white;">UGX 847K</span>
        </div>
        <a href="{{ route('retailer.reports') }}" class="scm-btn w-100" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white; border: none; padding: 12px; border-radius: 8px; text-decoration: none; display: inline-block; text-align: center; font-weight: 600; transition: all 0.3s ease;">
          <i class="bi bi-bar-chart me-2"></i>View Reports
        </a>
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-lg-6">
    <div class="scm-card scm-hover-lift">
      <div class="scm-card-header" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white;">
        <div class="d-flex align-items-center">
          <i class="bi bi-people-fill me-3 fs-4"></i>
          <h5 class="scm-card-title mb-0">Customer Management</h5>
        </div>
      </div>
      <div class="scm-card-body">
        <p class="scm-card-text mb-3">Manage customer relationships and build loyalty through personalized service</p>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <small class="text-muted">Total Customers</small>
          <span class="badge" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">1,247 Active</span>
        </div>
        <a href="{{ route('customers.index') }}" class="scm-btn w-100" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; border: none; padding: 12px; border-radius: 8px; text-decoration: none; display: inline-block; text-align: center; font-weight: 600; transition: all 0.3s ease;">
          <i class="bi bi-person-lines-fill me-2"></i>Manage Customers
        </a>
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-lg-6">
    <div class="scm-card scm-hover-lift">
      <div class="scm-card-header" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">
        <div class="d-flex align-items-center">
          <i class="bi bi-chat-square-dots-fill me-3 fs-4"></i>
          <h5 class="scm-card-title mb-0">Communication Center</h5>
        </div>
      </div>
      <div class="scm-card-body">
        <p class="scm-card-text mb-3">Connect with wholesalers and suppliers for seamless business operations</p>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <small class="text-muted">Active Conversations</small>
          <span class="badge" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white;">8 Online</span>
        </div>
        <a href="{{ route('chat.index') }}" class="scm-btn w-100" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; border: none; padding: 12px; border-radius: 8px; text-decoration: none; display: inline-block; text-align: center; font-weight: 600; transition: all 0.3s ease;">
          <i class="bi bi-chat-left-text me-2"></i>Open Chat
        </a>
      </div>
    </div>
  </div>
</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="scm-metric-card">
      <div class="d-flex align-items-center">
        <div class="scm-metric-icon bg-success">
          <i class="bi bi-people-fill"></i>
        </div>
        <div class="ms-3">
          <h3 class="scm-metric-value">456</h3>
          <p class="scm-metric-label">Active Customers</p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="scm-metric-card">
      <div class="d-flex align-items-center">
        <div class="scm-metric-icon bg-warning">
          <i class="bi bi-box-seam"></i>
        </div>
        <div class="ms-3">
          <h3 class="scm-metric-value">127</h3>
          <p class="scm-metric-label">Products Sourced</p>
        </div>
      </div>
<!-- Customer Order Verification & Management Section -->
<div class="row g-4 mb-4">
  <div class="col-xl-8 col-lg-12">
    <div class="scm-card scm-fade-in">
      <div class="scm-card-header" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">
        <div class="d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <div class="scm-icon-wrapper me-3" style="background: rgba(255,255,255,0.2); color: white;">
              <i class="bi bi-clipboard-check-fill"></i>
            </div>
            <div>
              <h5 class="scm-card-title mb-1">Customer Order Verification & Management</h5>
              <p class="scm-card-subtitle mb-0" style="color: rgba(255,255,255,0.9);">Review and approve customer orders for fulfillment</p>
            </div>
          </div>
          <div class="scm-status-badge" style="background: rgba(255,255,255,0.2); color: white; padding: 8px 16px; border-radius: 20px;">
            <i class="bi bi-clock me-1"></i>
            47 PENDING
          </div>
        </div>
      </div>
      <div class="scm-card-body">
        <!-- Filter Buttons -->
        <div class="row mb-4">
          <div class="col-md-8">
            <div class="d-flex flex-wrap gap-2">
              <button class="btn btn-sm" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; border: none;" onclick="filterOrders('all')">
                <i class="bi bi-list-ul me-1"></i>All Orders
              </button>
              <button class="btn btn-sm" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white; border: none;" onclick="filterOrders('pending')">
                <i class="bi bi-clock me-1"></i>Pending Approval
              </button>
              <button class="btn btn-sm" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; border: none;" onclick="filterOrders('approved')">
                <i class="bi bi-check-circle me-1"></i>Approved
              </button>
              <button class="btn btn-sm btn-outline-secondary" onclick="filterOrders('rejected')">
                <i class="bi bi-x-circle me-1"></i>Rejected
              </button>
            </div>
          </div>
          <div class="col-md-4">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search orders..." id="orderSearch">
              <button class="btn btn-outline-secondary" type="button">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sample Customer Order -->
        <div class="order-item mb-3 p-3" style="border: 1px solid #e3e6f0; border-radius: 8px; background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(248,249,250,1) 100%); transition: all 0.3s ease;" onmouseover="this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='none'">
          <div class="row align-items-center">
            <div class="col-md-2">
              <div class="customer-info d-flex align-items-center">
                <div class="customer-avatar me-2" style="width: 40px; height: 40px; background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                  JD
                </div>
                <div>
                  <div class="fw-semibold">John Doe</div>
                  <small class="text-muted">Customer</small>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div>
                <h6 class="mb-1">Eco-Friendly Water Bottle</h6>
                <small class="text-muted">ORDER #ORD001 • 5 Items</small><br>
                <small class="text-muted"><i class="bi bi-calendar me-1"></i>Jan 20, 2025 10:30 AM</small>
              </div>
            </div>
            <div class="col-md-2">
              <div class="fw-bold" style="color: #16a34a;">UGX 45,000</div>
              <small class="text-muted">Total Amount</small>
            </div>
            <div class="col-md-2">
              <span class="badge" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white; padding: 6px 12px;">
                <i class="bi bi-clock me-1"></i>Pending
              </span>
            </div>
            <div class="col-md-3">
              <div class="btn-group w-100" role="group">
                <button class="btn btn-sm" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; border: none;" onclick="approveOrder('ORD001')">
                  <i class="bi bi-check me-1"></i>Approve
                </button>
                <button class="btn btn-sm btn-outline-danger" onclick="rejectOrder('ORD001')">
                  <i class="bi bi-x me-1"></i>Reject
                </button>
                <button class="btn btn-sm btn-outline-info" onclick="viewOrderDetails('ORD001')">
                  <i class="bi bi-eye me-1"></i>View
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
          <small class="text-muted">Showing 1 of 47 orders</small>
          <div>
            <a href="{{ route('retailer.customer-orders') }}" class="btn" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; border: none; padding: 8px 20px; border-radius: 6px; text-decoration: none; font-weight: 600;">
              <i class="bi bi-list-ul me-2"></i>View All Orders
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Additional Quick Stats -->
  <div class="col-xl-4 col-lg-12">
    <div class="row g-3">
      <div class="col-12">
        <div class="scm-metric-card" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; padding: 20px; border-radius: 12px;">
          <div class="d-flex align-items-center">
            <div class="me-3">
              <i class="bi bi-people-fill fs-2"></i>
            </div>
            <div>
              <h3 class="mb-0">456</h3>
              <p class="mb-0">Active Customers</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="scm-metric-card" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white; padding: 20px; border-radius: 12px;">
          <div class="d-flex align-items-center">
            <div class="me-3">
              <i class="bi bi-box-seam fs-2"></i>
            </div>
            <div>
              <h3 class="mb-0">127</h3>
              <p class="mb-0">Products Sourced</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Enhanced Inventory Levels Section -->
<div class="row g-4 mb-4">
  <div class="col-12">
    <div class="scm-card scm-fade-in">
      <div class="scm-card-header" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white;">
        <div class="d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <div class="scm-icon-wrapper me-3" style="background: rgba(255,255,255,0.2); color: white;">
              <i class="bi bi-boxes"></i>
            </div>
            <div>
              <h5 class="scm-card-title mb-1">Inventory Level Monitoring</h5>
              <p class="scm-card-subtitle mb-0" style="color: rgba(255,255,255,0.9);">Track stock levels and manage product availability</p>
            </div>
          </div>
          <div class="scm-status-badge" style="background: rgba(255,255,255,0.2); color: white; padding: 8px 16px; border-radius: 20px;">
            <i class="bi bi-exclamation-triangle me-1"></i>
            43 Low Stock
          </div>
        </div>
      </div>
      <div class="scm-card-body">
        <div class="row mb-4">
          <div class="col-md-8">
            <div class="d-flex flex-wrap gap-2">
              <button class="btn btn-sm" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; border: none;" onclick="filterInventory('all')">
                <i class="bi bi-boxes me-1"></i>All Items
              </button>
              <button class="btn btn-sm" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white; border: none;" onclick="filterInventory('low')">
                <i class="bi bi-exclamation-triangle me-1"></i>Low Stock
              </button>
              <button class="btn btn-sm" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; border: none;" onclick="filterInventory('good')">
                <i class="bi bi-check-circle me-1"></i>Good Stock
              </button>
            </div>
          </div>
          <div class="col-md-4 text-end">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search products..." id="inventorySearch">
              <button class="btn btn-outline-secondary" type="button">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sample Inventory Items -->
        <div class="inventory-list">
          <div class="inventory-item mb-3 p-3" style="border: 1px solid #e3e6f0; border-radius: 8px; background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(248,249,250,1) 100%); transition: all 0.3s ease;" onmouseover="this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='none'">
            <div class="row align-items-center">
              <div class="col-md-3">
                <h6 class="mb-1">Eco-Friendly Water Bottles</h6>
                <small class="text-muted">SKU: ECO-WB-001</small>
              </div>
              <div class="col-md-2">
                <span class="stock-level text-danger fw-bold">12 Units</span><br>
                <small class="text-muted">Min: 50 units</small>
              </div>
              <div class="col-md-2">
                <span class="badge" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white; padding: 6px 12px;">
                  <i class="bi bi-exclamation-triangle me-1"></i>Low Stock
                </span>
              </div>
              <div class="col-md-2">
                <strong>UGX 15,000</strong><br>
                <small class="text-muted">per unit</small>
              </div>
              <div class="col-md-3">
                <div class="btn-group w-100" role="group">
                  <button class="btn btn-sm" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; border: none;" onclick="reorderProduct('ECO-WB-001')">
                    <i class="bi bi-plus-circle me-1"></i>Reorder
                  </button>
                  <button class="btn btn-sm btn-outline-info" onclick="viewProductDetails('ECO-WB-001')">
                    <i class="bi bi-eye me-1"></i>Details
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="inventory-item mb-3 p-3" style="border: 1px solid #e3e6f0; border-radius: 8px; background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(248,249,250,1) 100%); transition: all 0.3s ease;" onmouseover="this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='none'">
            <div class="row align-items-center">
              <div class="col-md-3">
                <h6 class="mb-1">Recycled Shopping Bags</h6>
                <small class="text-muted">SKU: REC-SB-002</small>
              </div>
              <div class="col-md-2">
                <span class="stock-level text-success fw-bold">156 Units</span><br>
                <small class="text-muted">Min: 30 units</small>
              </div>
              <div class="col-md-2">
                <span class="badge" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; padding: 6px 12px;">
                  <i class="bi bi-check-circle me-1"></i>Good Stock
                </span>
              </div>
              <div class="col-md-2">
                <strong>UGX 2,500</strong><br>
                <small class="text-muted">per unit</small>
              </div>
              <div class="col-md-3">
                <div class="btn-group w-100" role="group">
                  <button class="btn btn-sm btn-outline-success" disabled>
                    <i class="bi bi-check me-1"></i>Stocked
                  </button>
                  <button class="btn btn-sm btn-outline-info" onclick="viewProductDetails('REC-SB-002')">
                    <i class="bi bi-eye me-1"></i>Details
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="inventory-item mb-3 p-3" style="border: 1px solid #e3e6f0; border-radius: 8px; background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(248,249,250,1) 100%); transition: all 0.3s ease;" onmouseover="this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='none'">
            <div class="row align-items-center">
              <div class="col-md-3">
                <h6 class="mb-1">Biodegradable Food Containers</h6>
                <small class="text-muted">SKU: BIO-FC-003</small>
              </div>
              <div class="col-md-2">
                <span class="stock-level text-warning fw-bold">8 Units</span><br>
                <small class="text-muted">Min: 25 units</small>
              </div>
              <div class="col-md-2">
                <span class="badge" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white; padding: 6px 12px;">
                  <i class="bi bi-exclamation-triangle me-1"></i>Critical
                </span>
              </div>
              <div class="col-md-2">
                <strong>UGX 8,500</strong><br>
                <small class="text-muted">per unit</small>
              </div>
              <div class="col-md-3">
                <div class="btn-group w-100" role="group">
                  <button class="btn btn-sm" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%); color: white; border: none;" onclick="urgentReorder('BIO-FC-003')">
                    <i class="bi bi-exclamation-circle me-1"></i>Urgent
                  </button>
                  <button class="btn btn-sm btn-outline-info" onclick="viewProductDetails('BIO-FC-003')">
                    <i class="bi bi-eye me-1"></i>Details
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
          <small class="text-muted">Showing 3 of 127 products • 43 items need restocking</small>
          <div>
            <a href="{{ route('retailer.inventory') }}" class="btn" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; border: none; padding: 8px 20px; border-radius: 6px; text-decoration: none; font-weight: 600;">
              <i class="bi bi-boxes me-2"></i>Full Inventory Report
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Order Management Functions
function approveOrder(orderId) {
  if(confirm('Are you sure you want to approve order ' + orderId + '?')) {
    // AJAX call to approve order
    fetch('/retailer/orders/' + orderId + '/approve', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({action: 'approve'})
    })
    .then(response => response.json())
    .then(data => {
      if(data.success) {
        location.reload();
      } else {
        alert('Error approving order');
      }
    });
  }
}

function rejectOrder(orderId) {
  if(confirm('Are you sure you want to reject order ' + orderId + '?')) {
    // AJAX call to reject order
    fetch('/retailer/orders/' + orderId + '/reject', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({action: 'reject'})
    })
    .then(response => response.json())
    .then(data => {
      if(data.success) {
        location.reload();
      } else {
        alert('Error rejecting order');
      }
    });
  }
}

function viewOrderDetails(orderId) {
  window.location.href = '/orders/' + orderId;
}

// Inventory Management Functions
function reorderProduct(sku) {
  window.location.href = '/sales/create?reorder=' + sku;
}

function urgentReorder(sku) {
  if(confirm('This will create an urgent reorder request for ' + sku + '. Continue?')) {
    window.location.href = '/sales/create?urgent=true&reorder=' + sku;
  }
}

function viewProductDetails(sku) {
  window.location.href = '/inventory/' + sku;
}

// Filter Functions
function filterOrders(status) {
  // Implementation for filtering orders
  console.log('Filtering orders by: ' + status);
}

function filterInventory(status) {
  // Implementation for filtering inventory
  console.log('Filtering inventory by: ' + status);
}
</script>

<!-- SCM Customer Order Verification Section -->
<div class="row">
  <div class="col-12">
    <div class="scm-card scm-fade-in">
      <div class="scm-card-header" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">
        <div class="d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <div class="scm-icon-wrapper me-3" style="background: rgba(255,255,255,0.2); color: white;">
              <i class="bi bi-clipboard-check-fill"></i>
            </div>
            <div>
              <h5 class="scm-card-title mb-1">Customer Purchase Order Verification</h5>
              <p class="scm-card-subtitle mb-0" style="color: rgba(255,255,255,0.9);">Review and process incoming customer orders for fulfillment</p>
            </div>
          </div>
          <div class="scm-status-badge" style="background: rgba(255,255,255,0.2); color: white; padding: 8px 16px; border-radius: 20px;">
            <i class="bi bi-clock me-1"></i>
            47 Pending
          </div>
        </div>
      </div>
      <div class="scm-card-body">
        @include('partials.verify-orders', ['role' => 'retailer'])
      </div>
    </div>
  </div>
</div>

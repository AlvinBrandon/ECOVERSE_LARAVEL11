<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

.dashboard-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.1);
}

.dashboard-header h2 {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 2.5rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.dashboard-header p {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    opacity: 0.9;
    font-size: 1.1rem !important;
}

.ecoverse-logo {
    width: 60px;
    height: 60px;
    margin-right: 1.5rem;
}

.dashboard-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    margin-bottom: 1.5rem;
    font-family: 'Poppins', sans-serif;
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.dashboard-card h5 {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 1rem;
}

.dashboard-card p {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    color: #64748b;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.btn {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    border: none;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-info {
    background: linear-gradient(135deg, #06b6d4, #0891b2);
    color: white;
}

.btn-info:hover {
    background: linear-gradient(135deg, #0891b2, #0e7490);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(6, 182, 212, 0.3);
    color: white;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
    color: white;
}

.btn-success {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.btn-success:hover {
    background: linear-gradient(135deg, #059669, #047857);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    color: white;
}

.text-info {
    color: #06b6d4 !important;
}

.text-primary {
    color: #3b82f6 !important;
}

.text-success {
    color: #10b981 !important;
}

.text-warning {
    color: #f59e0b !important;
}

.row {
    margin: 0;
}

.col-md-4, .col-12 {
    padding-left: 0.75rem;
    padding-right: 0.75rem;
}

/* Override any Bootstrap spacing */
.py-4 {
    padding-top: 0 !important;
    padding-bottom: 0 !important;
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: #f8fafc;
}

/* Modern icon styling */
.bi {
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
}

/* Enhanced card sections */
.mt-4 .dashboard-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
}

.mt-4 .dashboard-card h5 {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    color: #1e293b;
    font-size: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
</style>

<div class="dashboard-header d-flex align-items-center">
    <img src="/assets/img/ecoverse-logo.svg" alt="Ecoverse Logo" class="ecoverse-logo">
    <div>
      <h2 class="mb-0">Retailer Dashboard</h2>
      <p class="mb-0" style="font-size:1.1rem;">Resale & networking: Community, product sourcing, connect with wholesalers.</p>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <i class="bi bi-bar-chart text-info" style="font-size:2rem;"></i>
        <h5 class="mt-2">Reports & Analytics</h5>
        <p>View customer orders and analytics.</p>
        <a href="{{ route('retailer.reports') }}" class="btn btn-info mt-2"><i class="bi bi-graph-up-arrow me-1"></i> Customer Orders & Analytics</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <i class="bi bi-people text-primary" style="font-size:2rem;"></i>
        <h5 class="mt-2">Community</h5>
        <p>Collaborate and post product needs.</p>
        <a href="#" class="btn btn-primary mt-2"><i class="bi bi-chat-dots me-1"></i> Community Forum</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <i class="bi bi-box-seam text-success" style="font-size:2rem;"></i>
        <h5 class="mt-2">Product Sourcing</h5>
        <p>Source products and connect with wholesalers.</p>
        <a href="{{ route('sales.index') }}" class="btn btn-success mt-2"><i class="bi bi-bag-check me-1"></i> Source Products</a>
      </div>
    </div>
</div>

<!-- Customer Orders Verification Section -->
<div class="row mt-4">
  <div class="col-12">
    <div class="dashboard-card">
      <h5 class="mb-3"><i class="bi bi-clipboard-check text-warning"></i> Verify Customer Purchase Orders</h5>
      @include('partials.verify-orders', ['role' => 'retailer'])
    </div>
  </div>
</div>
</div>

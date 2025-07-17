<div class="dashboard-header d-flex align-items-center">
    <img src="/assets/img/ecoverse-logo.svg" alt="Ecoverse Logo" class="ecoverse-logo">
    <div>
      <h2 class="mb-0">Customer Dashboard</h2>
      <p class="mb-0" style="font-size:1.1rem;">Buy finished recycled products, track orders.</p>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
      <div class="dashboard-card text-center">
        <i class="bi bi-cart-check text-primary" style="font-size:2rem;"></i>
        <h5 class="mt-2">Product Catalog</h5>
        <p>Browse and order recycled products.</p>
        <a href="{{ route('sales.index') }}" class="btn btn-primary mt-2"><i class="bi bi-bag-check me-1"></i> Shop Now</a>
      </div>
    </div>
    <div class="col-md-6">
      <div class="dashboard-card text-center">
        <i class="bi bi-truck text-success" style="font-size:2rem;"></i>
        <h5 class="mt-2">Order Tracking</h5>
        <p>Track your orders and delivery status.</p>
        <a href="{{ route('sales.status') }}" class="btn btn-success mt-2"><i class="bi bi-truck me-1"></i> Track Orders</a>
        <div class="mt-3">
          <a href="{{ route('sales.history') }}" class="btn btn-outline-secondary btn-sm mb-1"><i class="bi bi-clock-history me-1"></i> Order History</a>
          <a href="{{ route('sales.status') }}" class="btn btn-outline-secondary btn-sm mb-1"><i class="bi bi-info-circle me-1"></i> Order Status</a>
         
        </div>
      </div>
    </div>
     <div class="col-md-6">
      <div class="dashboard-card text-center">
        <i class="bi bi-chat text-success" style="font-size:2rem;"></i>
        <h5 class="mt-2">Chat Support</h5>
        <p>Need help? Chat with our support team.</p>
        <a href="{{ route('chat.index') }}" class="btn btn-success mt-2"><i class="bi bi-chat me-1"></i> Start Chat</a>
      </div>
    </div>
</div>

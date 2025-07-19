<nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                   href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}" 
                   href="{{ route('admin.users') }}">
                    <i class="fas fa-users"></i>
                    Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.predictions.dashboard') ? 'active' : '' }}" 
                   href="{{ route('admin.predictions.dashboard') }}">
                    <i class="fas fa-chart-line"></i>
                    Sales Predictions
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.sales-forecast') ? 'active' : '' }}" 
                   href="{{ route('admin.sales-forecast') }}">
                    <i class="fas fa-chart-bar"></i>
                    Sales Forecast
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" 
                   href="{{ route('admin.orders.index') }}">
                    <i class="fas fa-shopping-cart"></i>
                    Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" 
                   href="{{ route('admin.products.index') }}">
                    <i class="fas fa-box"></i>
                    Products
                </a>
            </li>
        </ul>
    </div>
</nav>

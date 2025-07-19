<nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('wholesaler.dashboard') ? 'active' : '' }}" 
                   href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('wholesaler.orders.*') ? 'active' : '' }}" 
                   href="{{ route('wholesaler.orders.index') }}">
                    <i class="fas fa-truck"></i>
                    Bulk Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('wholesaler.products.*') ? 'active' : '' }}" 
                   href="{{ route('wholesaler.products.index') }}">
                    <i class="fas fa-boxes"></i>
                    Products
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('wholesaler.retailers.*') ? 'active' : '' }}" 
                   href="{{ route('wholesaler.retailers.index') }}">
                    <i class="fas fa-store"></i>
                    Retailers
                </a>
            </li>
        </ul>
    </div>
</nav>

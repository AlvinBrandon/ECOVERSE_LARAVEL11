<nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('retailer.dashboard') ? 'active' : '' }}" 
                   href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('retailer.orders.*') ? 'active' : '' }}" 
                   href="{{ route('retailer.orders.index') }}">
                    <i class="fas fa-shopping-cart"></i>
                    Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('retailer.products.*') ? 'active' : '' }}" 
                   href="{{ route('retailer.products.index') }}">
                    <i class="fas fa-box"></i>
                    Products
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('retailer.inventory.*') ? 'active' : '' }}" 
                   href="{{ route('retailer.inventory.index') }}">
                    <i class="fas fa-warehouse"></i>
                    Inventory
                </a>
            </li>
        </ul>
    </div>
</nav>

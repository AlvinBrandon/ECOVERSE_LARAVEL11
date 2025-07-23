@props(['activePage'])

@php
    $user = auth()->user();
@endphp

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

.ecoverse-sidebar {
    width: 280px;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    background: linear-gradient(135deg, #1e293b 0%, #475569 25%, #10b981 100%);
    backdrop-filter: blur(20px);
    border-right: 1px solid rgba(255, 255, 255, 0.1);
    z-index: 1000;
    transition: all 0.3s ease;
    font-family: 'Poppins', sans-serif;
    overflow-y: auto;
    box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
}

.ecoverse-sidebar::-webkit-scrollbar {
    width: 6px;
}

.ecoverse-sidebar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
}

.ecoverse-sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 3px;
}

.sidebar-header {
    padding: 2rem 1.5rem 1.5rem;
    text-align: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.sidebar-logo {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    border: 2px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
}

.sidebar-logo i {
    font-size: 1.8rem;
    color: #ffffff;
}

.sidebar-brand {
    color: #ffffff;
    font-family: 'Poppins', sans-serif;
    font-weight: 800;
    font-size: 1.4rem;
    margin-bottom: 0.5rem;
    text-decoration: none;
}

.sidebar-subtitle {
    color: rgba(255, 255, 255, 0.7);
    font-family: 'Poppins', sans-serif;
    font-size: 0.85rem;
    font-weight: 400;
}

.sidebar-nav {
    padding: 1rem 0;
}

.nav-section {
    margin-bottom: 1.5rem;
}

.nav-section-title {
    color: rgba(255, 255, 255, 0.6);
    font-family: 'Poppins', sans-serif;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 0 1.5rem 0.5rem;
    margin-bottom: 0.5rem;
}

.nav-item {
    margin-bottom: 0.25rem;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 0.875rem 1.5rem;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    border-radius: 0;
    position: relative;
}

.nav-link:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    transform: translateX(4px);
}

.nav-link.active {
    background: rgba(255, 255, 255, 0.15);
    color: #ffffff;
    border-right: 3px solid #10b981;
}

.nav-link.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: #10b981;
}

.nav-icon {
    width: 24px;
    height: 24px;
    margin-right: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.nav-text {
    flex: 1;
}

.nav-badge {
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
    border-radius: 12px;
    font-weight: 600;
    margin-left: auto;
}

.sidebar-footer {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1.5rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(0, 0, 0, 0.1);
}

.sidebar-user {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    backdrop-filter: blur(10px);
}

.user-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #10b981, #059669);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 0.75rem;
    color: #ffffff;
    font-weight: 600;
    font-size: 0.9rem;
}

.user-info {
    flex: 1;
}

.user-name {
    color: #ffffff;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.user-role {
    color: rgba(255, 255, 255, 0.7);
    font-family: 'Poppins', sans-serif;
    font-size: 0.75rem;
    text-transform: capitalize;
}

.sidebar-toggle {
    position: fixed;
    top: 1rem;
    left: 290px;
    z-index: 1001;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #ffffff;
    border-radius: 8px;
    padding: 0.5rem;
    backdrop-filter: blur(10px);
    cursor: pointer;
    transition: all 0.3s ease;
}

.sidebar-toggle:hover {
    background: rgba(255, 255, 255, 0.2);
}

.main-content {
    margin-left: 280px;
    transition: all 0.3s ease;
}

.sidebar-collapsed .ecoverse-sidebar {
    transform: translateX(-280px);
}

.sidebar-collapsed .main-content {
    margin-left: 0;
}

.sidebar-collapsed .sidebar-toggle {
    left: 1rem;
}

@media (max-width: 768px) {
    .ecoverse-sidebar {
        transform: translateX(-280px);
    }
    
    .main-content {
        margin-left: 0;
    }
    
    .sidebar-toggle {
        left: 1rem;
    }
    
    .sidebar-mobile-open .ecoverse-sidebar {
        transform: translateX(0);
    }
}
</style>

<aside class="ecoverse-sidebar" id="ecoverse-sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <i class="bi bi-recycle"></i>
        </div>
        <a href="{{ route('dashboard') }}" class="sidebar-brand">ECOVERSE</a>
        <div class="sidebar-subtitle">Sustainable Supply Chain</div>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">
        <!-- Dashboard Section -->
        <div class="nav-section">
            <div class="nav-section-title">Dashboard</div>
            <div class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ $activePage == 'dashboard' ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="bi bi-speedometer2"></i>
                    </div>
                    <span class="nav-text">Overview</span>
                </a>
            </div>
        </div>

        <!-- Admin Section -->
        @if($user && $user->role === 'admin')
        <div class="nav-section">
            <div class="nav-section-title">Administration</div>
            <div class="nav-item">
                <a href="{{ route('admin.users') }}" class="nav-link {{ $activePage == 'admin-users' ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <span class="nav-text">User Management</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.sales.report') }}" class="nav-link {{ $activePage == 'admin-sales-report' ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <span class="nav-text">Sales Reports</span>
                </a>
            </div>
            @if(isset($activePOs) && $activePOs > 0)
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <div class="nav-icon">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                    <span class="nav-text">Purchase Orders</span>
                    <span class="nav-badge">{{ $activePOs }}</span>
                </a>
            </div>
            @endif
        </div>
        @endif

        <!-- Inventory Section -->
        @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'staff'))
        <div class="nav-section">
            <div class="nav-section-title">Inventory</div>
            <div class="nav-item">
                <a href="{{ route('inventory.index') }}" class="nav-link {{ $activePage == 'inventory' ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="bi bi-boxes"></i>
                    </div>
                    <span class="nav-text">Stock Management</span>
                </a>
            </div>
        </div>
        @endif

        <!-- Materials Section -->
        @if(auth()->check() && (in_array(auth()->user()->role, ['admin','staff','supplier'])))
        <div class="nav-section">
            <div class="nav-section-title">Materials</div>
            <div class="nav-item">
                <a href="{{ route('raw-materials.index') }}" class="nav-link {{ $activePage == 'raw-materials' ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <span class="nav-text">Raw Materials</span>
                </a>
            </div>
        </div>
        @endif

        <!-- Sales Section -->
        @if(auth()->check() && in_array(auth()->user()->role, ['admin','staff','retailer','wholesaler','customer']))
        <div class="nav-section">
            <div class="nav-section-title">Commerce</div>
            <div class="nav-item">
                <a href="{{ route('sales.index') }}" class="nav-link {{ $activePage == 'sales' ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="bi bi-cart-check"></i>
                    </div>
                    <span class="nav-text">Sales</span>
                </a>
            </div>
        </div>
        @endif

        <!-- Vendor Section -->
        <div class="nav-section">
            <div class="nav-section-title">Partnerships</div>
            <div class="nav-item">
                <a href="{{ route('vendor.apply') }}" class="nav-link">
                    <div class="nav-icon">
                        <i class="bi bi-shop"></i>
                    </div>
                    <span class="nav-text">Become Vendor</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('vendor.status') }}" class="nav-link {{ $activePage == 'vendor-status' ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="bi bi-info-circle"></i>
                    </div>
                    <span class="nav-text">Application Status</span>
                </a>
            </div>
        </div>

        <!-- Account Section -->
        <div class="nav-section">
            <div class="nav-section-title">Account</div>
            <div class="nav-item">
                <a href="{{ route('profile') }}" class="nav-link {{ $activePage == 'profile' ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <span class="nav-text">Profile</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <div class="nav-icon">
                        <i class="bi bi-gear"></i>
                    </div>
                    <span class="nav-text">Settings</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        @if($user)
        <div class="sidebar-user">
            <div class="user-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="user-info">
                <div class="user-name">{{ $user->name }}</div>
                <div class="user-role">{{ $user->role ?? 'User' }}</div>
            </div>
        </div>
        @endif
    </div>
</aside>

<!-- Sidebar Toggle Button -->
<button class="sidebar-toggle" id="sidebar-toggle">
    <i class="bi bi-list"></i>
</button>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('ecoverse-sidebar');
    const toggleBtn = document.getElementById('sidebar-toggle');
    const body = document.body;

    toggleBtn.addEventListener('click', function() {
        body.classList.toggle('sidebar-collapsed');
        
        // Update toggle icon
        const icon = toggleBtn.querySelector('i');
        if (body.classList.contains('sidebar-collapsed')) {
            icon.className = 'bi bi-layout-sidebar';
        } else {
            icon.className = 'bi bi-list';
        }
    });

    // Mobile responsiveness
    function handleResize() {
        if (window.innerWidth <= 768) {
            body.classList.add('sidebar-collapsed');
        } else {
            body.classList.remove('sidebar-collapsed');
        }
    }

    window.addEventListener('resize', handleResize);
    handleResize(); // Call on load

    // Mobile sidebar toggle
    if (window.innerWidth <= 768) {
        toggleBtn.addEventListener('click', function() {
            body.classList.toggle('sidebar-mobile-open');
        });
    }
});
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


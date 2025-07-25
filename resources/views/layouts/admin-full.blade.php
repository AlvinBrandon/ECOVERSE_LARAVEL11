<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Ecoverse - Professional Supply Chain Management')</title>
    
    <!-- Professional SCM Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Professional SCM CSS Framework -->
    <link href="{{ asset('css/scm-professional.css') }}" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 70px;
        }
        
        html {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #10b981 100%) !important;
            min-height: 100vh;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #10b981 100%) !important;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            min-height: 100vh;
        }
        
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            z-index: 1000;
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            transition: all 0.3s ease;
            overflow-x: hidden;
        }
        
        .admin-sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }
        
        .sidebar-toggle {
            position: absolute;
            top: 20px;
            right: -15px;
            background: #fff;
            border: 2px solid #dee2e6;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1001;
            transition: all 0.3s ease;
        }
        
        .sidebar-toggle:hover {
            background: #f8f9fa;
        }
        
        .admin-main {
            margin-left: var(--sidebar-width);
            margin-top: 70px;
            width: calc(100vw - var(--sidebar-width));
            min-height: calc(100vh - 70px);
            padding: 0;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #10b981 100%) !important;
            transition: all 0.3s ease;
        }
        
        .admin-main.expanded {
            margin-left: var(--sidebar-collapsed-width);
            width: calc(100vw - var(--sidebar-collapsed-width));
        }
        
        .admin-content {
            padding: 1.5rem;
            width: 100%;
            box-sizing: border-box;
        }
        
        /* Sidebar content visibility */
        .admin-sidebar .sidebar-text {
            opacity: 1;
            transition: opacity 0.3s ease;
        }
        
        .admin-sidebar.collapsed .sidebar-text {
            opacity: 0;
            pointer-events: none;
        }
        
        /* Admin Header Bar */
        .admin-header {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: 70px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #475569 100%);
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .admin-header.expanded {
            left: var(--sidebar-collapsed-width);
        }
        
        .admin-header .logo-section {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: white;
        }
        
        .admin-header .logo-section i {
            font-size: 1.5rem;
        }
        
        .admin-header .header-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0;
        }
        
        .admin-header .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .admin-header .chat-btn {
            background: rgba(255,255,255,0.2);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .admin-header .chat-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: scale(1.05);
        }
        
        .admin-header .sign-out-btn {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 25px;
            padding: 0.5rem 1.2rem;
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .admin-header .sign-out-btn:hover {
            background: rgba(255,255,255,0.3);
            color: white;
            text-decoration: none;
            transform: translateY(-1px);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    @auth
        <div class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-chevron-left" id="toggleIcon"></i>
            </div>
            @include('components.navbars.sidebar', ['activePage' => $activePage ?? ''])
        </div>
        
        <div class="admin-header" id="adminHeader">
            <div class="logo-section">
                <i class="bi bi-recycle"></i>
                <div>
                    <h4 class="header-title">Ecoverse</h4>
                    <small style="opacity: 0.8;">Admin Panel</small>
                </div>
            </div>
            <div class="header-actions">
                <button class="chat-btn" title="Chat Support">
                    <i class="bi bi-chat-dots"></i>
                </button>
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                   class="sign-out-btn">
                    <i class="bi bi-box-arrow-right"></i>
                    Sign Out
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
        
        <div class="admin-main" id="adminMain">
            <div class="admin-content">
                @yield('content')
            </div>
        </div>
    @else
        <main class="py-4 main-content">
            @yield('content')
        </main>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const adminSidebar = document.getElementById('adminSidebar');
            const adminMain = document.getElementById('adminMain');
            const adminHeader = document.getElementById('adminHeader');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (sidebarToggle && adminSidebar && adminMain) {
                sidebarToggle.addEventListener('click', function() {
                    adminSidebar.classList.toggle('collapsed');
                    adminMain.classList.toggle('expanded');
                    if (adminHeader) {
                        adminHeader.classList.toggle('expanded');
                    }
                    
                    // Toggle icon
                    if (adminSidebar.classList.contains('collapsed')) {
                        toggleIcon.className = 'fas fa-chevron-right';
                    } else {
                        toggleIcon.className = 'fas fa-chevron-left';
                    }
                });
            }
        });

        // Prevent back button access after logout
        window.addEventListener('pageshow', function(event) {
            // Check if the page is being loaded from cache (back button)
            if (event.persisted) {
                // Force page reload to check authentication
                window.location.reload();
            }
        });

        // Disable back button for authenticated pages
        history.pushState(null, null, location.href);
        window.addEventListener('popstate', function() {
            // Check if user is still authenticated by making a quick API call
            fetch('{{ route("auth.check") }}', {
                method: 'GET',
                credentials: 'same-origin'
            }).then(response => {
                if (response.status === 401 || response.status === 403) {
                    // User is not authenticated, redirect to login
                    window.location.href = '{{ route("login") }}';
                } else {
                    // User is authenticated, allow navigation
                    history.pushState(null, null, location.href);
                }
            }).catch(() => {
                // Error occurred, redirect to login for safety
                window.location.href = '{{ route("login") }}';
            });
        });
    </script>
    
    @yield('scripts')
    @stack('scripts')
</body>
</html>

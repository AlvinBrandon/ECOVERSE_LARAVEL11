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
    
    <!-- Professional SCM CSS Framework -->
    <link href="{{ asset('css/scm-professional.css') }}" rel="stylesheet">
    
    <!-- Base Body Styles -->
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8f9fa;
            color: var(--scm-text-primary);
            line-height: 1.6;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }
        
        .scm-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .scm-card {
            background: white;
            border-radius: var(--scm-radius);
            box-shadow: var(--scm-shadow);
            border: 1px solid var(--scm-border);
            overflow: hidden;
        }
        
        .scm-card-header {
            background: linear-gradient(135deg, var(--scm-primary) 0%, var(--scm-primary-dark) 100%);
            color: white;
            padding: 1.5rem;
            border-bottom: 1px solid var(--scm-border);
        }
        
        .scm-card-body {
            padding: 1.5rem;
        }
        
        .scm-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: var(--scm-radius);
            font-weight: 500;
            font-size: 0.875rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .scm-btn-primary {
            background: var(--scm-primary);
            color: white;
        }
        
        .scm-btn-primary:hover {
            background: var(--scm-primary-dark);
            transform: translateY(-1px);
            box-shadow: var(--scm-shadow-lg);
        }
        
        .scm-btn-secondary {
            background: var(--scm-secondary);
            color: white;
        }
        
        .scm-btn-outline {
            background: transparent;
            color: var(--scm-primary);
            border: 1px solid var(--scm-primary);
        }
        
        .scm-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--scm-border);
            border-radius: var(--scm-radius);
            font-size: 0.875rem;
            transition: border-color 0.2s ease;
        }
        
        .scm-input:focus {
            outline: none;
            border-color: var(--scm-primary);
            box-shadow: 0 0 0 3px rgb(30 64 175 / 0.1);
        }
        
        .scm-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        
        .scm-table th {
            background: var(--scm-bg-secondary);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--scm-text-primary);
            border-bottom: 2px solid var(--scm-border);
        }
        
        .scm-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--scm-border-light);
        }
        
        .scm-table tbody tr:hover {
            background: var(--scm-bg-primary);
        }
        
        .scm-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .scm-badge-success {
            background: rgb(34 197 94 / 0.1);
            color: rgb(22 163 74);
        }
        
        .scm-badge-warning {
            background: rgb(251 191 36 / 0.1);
            color: rgb(217 119 6);
        }
        
        .scm-badge-danger {
            background: rgb(239 68 68 / 0.1);
            color: rgb(220 38 38);
        }
        
        .scm-grid {
            display: grid;
            gap: 1.5rem;
        }
        
        .scm-grid-2 {
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }
        
        .scm-grid-3 {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        }
        
        .scm-grid-4 {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }
        
        .scm-metric {
            background: white;
            border-radius: var(--scm-radius);
            padding: 1.5rem;
            box-shadow: var(--scm-shadow);
            border: 1px solid var(--scm-border);
        }
        
        .scm-metric-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--scm-primary);
            margin-bottom: 0.5rem;
        }
        
        .scm-metric-label {
            color: var(--scm-text-secondary);
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .scm-navbar {
            background: white;
            border-bottom: 1px solid var(--scm-border);
            box-shadow: var(--scm-shadow);
            padding: 1rem 0;
        }
        
        .scm-sidebar {
            background: white;
            border-right: 1px solid var(--scm-border);
            min-height: 100vh;
            padding: 1.5rem 0;
        }
        
        .scm-content {
            padding: 2rem;
            min-height: calc(100vh - 80px);
        }
        
        @media (max-width: 768px) {
            .scm-container {
                padding: 0 0.5rem;
            }
            
            .scm-content {
                padding: 1rem;
            }
            
            .scm-grid-2,
            .scm-grid-3,
            .scm-grid-4 {
                grid-template-columns: 1fr;
            }
        }
    </style>
    
    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Global Sidebar Layout Fix - CRITICAL for consistent layout -->
    <link rel="stylesheet" href="{{ asset('resources/css/sidebar-layout-fix.css') }}">
    
    <style>
        /* Global Poppins Font */
        body, html, * {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif !important;
        }
        
        .unit-label { font-size: 0.95em; color: #6366f1; font-weight: 500; margin-left: 2px; }
        .promo-bar { background: linear-gradient(90deg, #ff9800 0%, #ff5722 100%); color: #fff; font-weight: 600; font-size: 1.05rem; padding: 0.4rem 0; letter-spacing: 1px; }
        .navbar-ecoverse { background: #fff; border-bottom: 1px solid #f3f3f3; box-shadow: 0 2px 8px #ff98001a; z-index: 1030; }
        .navbar-brand { font-weight: bold; color: #ff9800 !important; font-size: 1.7rem; letter-spacing: 1px; }
        .search-bar { max-width: 420px; min-width: 220px; }
        .user-greeting { font-weight: 500; color: #333; margin-right: 1.2rem; }
        .cart-badge { font-size: 0.85em; background: #ff5722; color: #fff; top: 0; right: -8px; }
        .navbar-icon-btn { background: none; border: none; color: #ff9800; font-size: 1.3rem; margin-right: 0.7rem; }
        .navbar-icon-btn:last-child { margin-right: 0; }
        
        /* Sidebar Layout Responsive CSS */
        .main-content {
            transition: margin-left 0.3s ease;
        }
        
        /* GLOBAL SIDEBAR FIX - Ultra High Specificity */
        /* This overrides ALL page-specific CSS that breaks the layout */
        
        /* Base rule for all authenticated users */
        body[data-user-id] .main-content,
        body[data-user-id] main.main-content,
        body[data-user-id] main.py-4,
        html body[data-user-id] .main-content {
            margin-left: 280px !important;
        }
        
        /* Override common problematic patterns */
        body[data-user-id] .main-content,
        body[data-user-id] .container-fluid {
            /* Reset only top, right, bottom margins - KEEP left margin for sidebar */
            margin-top: 0 !important;
            margin-right: 0 !important;
            margin-bottom: 0 !important;
            /* margin-left preserved for sidebar */
        }
        
        /* Material Dashboard compatibility */
        .g-sidenav-show body[data-user-id] .main-content,
        body.g-sidenav-show[data-user-id] .main-content {
            margin-left: 280px !important;
        }
        
        /* Mobile responsive - hide sidebar margin on smaller screens */
        @media (max-width: 1199.98px) {
            body[data-user-id] .main-content,
            body[data-user-id] main.main-content,
            body[data-user-id] main.py-4,
            html body[data-user-id] .main-content,
            .g-sidenav-show body[data-user-id] .main-content,
            body.g-sidenav-show[data-user-id] .main-content {
                margin-left: 0 !important;
            }
        }
        
        /* Ensure proper spacing on mobile */
        @media (max-width: 767.98px) {
            body[data-user-id] .main-content,
            body[data-user-id] main.main-content,
            body[data-user-id] main.py-4 {
                margin-left: 0 !important;
                padding-top: 1rem !important;
            }
        }
    </style>
    @stack('styles')
    @yield('head')
    @stack('head')
</head>
<body @auth data-user-id="{{ auth()->id() }}" data-user-role="{{ auth()->user()->role }}" @endauth>
    @auth
        @include('components.navbars.navs.auth', ['titlePage' => $titlePage ?? 'Dashboard'])
        @include('components.navbars.sidebar', ['activePage' => $activePage ?? ''])
    @else
        @include('components.navbars.navs.guest')
    @endauth

    @auth
        @if(request()->routeIs('dashboard') && auth()->user()->role_as == 1)
            <main class="main-content" style="margin-left: 280px; padding: 0; width: calc(100vw - 280px); min-height: calc(100vh - 120px); transition: all 0.3s ease;">
                @yield('content')
            </main>
        @else
            <main class="py-4 main-content" style="margin-left: 280px; transition: all 0.3s ease;">
                @yield('content')
            </main>
        @endif
    @else
        <main class="py-4 main-content">
            @yield('content')
        </main>
    @endauth

    <div class="text-center py-3" style="color: #000;">
        © 2025, built with 💚 by the Ecoverse Team — powering smarter, greener communities.
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
    @stack('scripts')

    <!-- Help Modal -->
    <div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="helpForm" method="POST" action="{{ route('help.request') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="helpModalLabel">Need Help?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="helpMessage" class="form-label">How can we assist you?</label>
                            <textarea class="form-control" id="helpMessage" name="message" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Help Success Toast -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 2000">
        <div id="helpSuccessToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Your help request has been sent successfully!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script>
        // Auto-complete for product search
        (function() {
            const input = document.getElementById('productSearchInput');
            const suggestions = document.getElementById('searchSuggestions');
            
            if (!input || !suggestions) return;
            
            let debounceTimeout;
            
            input.addEventListener('input', function() {
                clearTimeout(debounceTimeout);
                const query = this.value.trim();
                
                if (query.length < 2) {
                    suggestions.style.display = 'none';
                    return;
                }
                
                debounceTimeout = setTimeout(() => {
                    // Add your search logic here
                }, 200);
            });
            
            document.addEventListener('click', function(e) {
                if (!suggestions.contains(e.target) && e.target !== input) {
                    suggestions.style.display = 'none';
                }
            });
        })();

        // Help modal functionality
        document.getElementById('openHelpModalBtn')?.addEventListener('click', function() {
            var helpModal = new bootstrap.Modal(document.getElementById('helpModal'));
            helpModal.show();
        });

        document.getElementById('helpForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            var form = this;
            var data = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: data,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(res => res.ok ? res.json() : Promise.reject(res))
            .then(() => {
                form.reset();
                var helpModal = bootstrap.Modal.getInstance(document.getElementById('helpModal'));
                helpModal.hide();
                var toast = new bootstrap.Toast(document.getElementById('helpSuccessToast'));
                toast.show();
            })
            .catch(() => {
                alert('Could not send help request. Please try again.');
            });
        });
    </script>
    
    <!-- Role Change Notification System -->
    @auth
    <script>
        // Check for role changes periodically
        function checkRoleChange() {
            const currentRole = '{{ auth()->user()->role_as }}';
            const userId = '{{ auth()->id() }}';
            
            // Store current role in session storage
            const storedRole = sessionStorage.getItem('user_role_' + userId);
            
            if (storedRole && storedRole !== currentRole) {
                // Role has changed, show notification and redirect
                const toast = `
                    <div class="toast align-items-center text-white bg-success border-0 position-fixed top-0 start-50 translate-middle-x" style="z-index: 9999; margin-top: 20px;" role="alert">
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="bi bi-person-check me-2"></i>
                                Your role has been updated! Redirecting to your new dashboard...
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto"></button>
                        </div>
                    </div>
                `;
                
                document.body.insertAdjacentHTML('beforeend', toast);
                const toastElement = document.body.lastElementChild;
                const bsToast = new bootstrap.Toast(toastElement, { delay: 3000 });
                bsToast.show();
                
                // Redirect to dashboard after 2 seconds
                setTimeout(() => {
                    window.location.href = '{{ route('dashboard') }}';
                }, 2000);
            }
            
            // Always update stored role
            sessionStorage.setItem('user_role_' + userId, currentRole);
        }
        
        // Check role on page load
        document.addEventListener('DOMContentLoaded', checkRoleChange);
        
        // Check role periodically (every 10 seconds)
        setInterval(checkRoleChange, 10000);
    </script>
    @endauth
</body>
</html>

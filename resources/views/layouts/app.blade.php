<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Ecoverse')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .unit-label { font-size: 0.95em; color: #6366f1; font-weight: 500; margin-left: 2px; }
        .promo-bar { background: linear-gradient(90deg, #ff9800 0%, #ff5722 100%); color: #fff; font-weight: 600; font-size: 1.05rem; padding: 0.4rem 0; letter-spacing: 1px; }
        .navbar-ecoverse { background: #fff; border-bottom: 1px solid #f3f3f3; box-shadow: 0 2px 8px #ff98001a; z-index: 1030; }
        .navbar-brand { font-weight: bold; color: #ff9800 !important; font-size: 1.7rem; letter-spacing: 1px; }
        .search-bar { max-width: 420px; min-width: 220px; }
        .user-greeting { font-weight: 500; color: #333; margin-right: 1.2rem; }
        .cart-badge { font-size: 0.85em; background: #ff5722; color: #fff; top: 0; right: -8px; }
        .navbar-icon-btn { background: none; border: none; color: #ff9800; font-size: 1.3rem; margin-right: 0.7rem; }
        .navbar-icon-btn:last-child { margin-right: 0; }
    </style>
    @stack('styles')
    @yield('head')
    @stack('head')
</head>
<body @auth data-user-id="{{ auth()->id() }}" data-user-role="{{ auth()->user()->role }}" @endauth>
    @auth
        @include('components.navbars.navs.auth', ['titlePage' => $titlePage ?? 'Dashboard'])
    @else
        @include('components.navbars.navs.guest')
    @endauth

    <main class="py-4">
        @yield('content')
    </main>

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
</body>
</html>

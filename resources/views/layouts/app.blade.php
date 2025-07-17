<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Ecoverse')</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  
  @stack('styles')
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    /* Custom styling from main branch */
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

  @yield('head')
  @stack('head')
</head>
<body @auth data-user-id="{{ auth()->id() }}" data-user-role="{{ auth()->user()->role }}" @endauth>
  @auth
    <div style="position:fixed;top:10px;right:20px;z-index:2000;">
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-link">Logout</button>
      </form>
    </div>
  @endauth

  <nav class="navbar navbar-expand-lg navbar-ecoverse py-2">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="/dashboard">
        <span style="font-size:2rem;line-height:1;color:#10b981;">&#9733;</span>
        <span style="color:#10b981;">ECOVERSE</span>
      </a>
      <div class="d-flex align-items-center w-100" style="max-width: 700px; margin: 0 auto;">
        @if(auth()->user() && auth()->user()->role === 'customer')
        <form class="d-flex search-bar flex-grow-1 position-relative" role="search">
          <input class="form-control me-2" id="productSearchInput" type="search" placeholder="Search products, brands and categories" aria-label="Search" autocomplete="off">
          <button class="btn btn-warning text-white px-4" type="submit">Search</button>
          <div id="searchSuggestions" class="list-group position-absolute w-100" style="top:100%;z-index:2000;display:none;"></div>
        </form>
        <a href="/dashboard" class="btn btn-outline-success ms-2" title="Home"><i class="bi bi-house-door"></i></a>
        <button class="navbar-icon-btn ms-2" title="Help" id="openHelpModalBtn"><i class="bi bi-question-circle"></i></button>
        @endif
        @auth
        <span class="user-greeting ms-2">Hi, {{ Auth::user()->name ?? 'Customer' }}</span>
        @endauth
        @if(auth()->user() && auth()->user()->role === 'customer')
        <a href="{{ route('cart.view') }}" class="btn btn-outline-primary position-relative ms-2">
          <i class="bi bi-cart" style="font-size:1.5rem;"></i>
          @php $cartCount = session('cart') ? collect(session('cart'))->sum('quantity') : 0; @endphp
          @if($cartCount > 0)
            <span class="position-absolute cart-badge badge rounded-pill">{{ $cartCount }}</span>
          @endif
          <span class="ms-1">Cart</span>
        </a>
        @endif
      </div>
    </div>
  </nav>

  <main class="py-4">
    @yield('content')
  </main>

  <div class="text-center py-3" style="color: #000;">
    © 2025, built with 💚 by the Ecoverse Team — powering smarter, greener communities.
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  @yield('scripts')
  @stack('scripts')

  {{-- Auto-complete + Help modal --}}
  <script>
    // ... (preserve the full product search and help modal scripts from your main branch)
  </script>

  {{-- Include your help modal and toast HTML here (from the main branch) --}}
  <!-- (Keep the modal and toast HTML from the main branch exactly as it was) -->

</body>
</html>

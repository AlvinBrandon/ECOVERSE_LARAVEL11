<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Ecoverse')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
      .unit-label {
        font-size: 0.95em;
        color: #6366f1;
        font-weight: 500;
        margin-left: 2px;
      }
    </style>
    @yield('head')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/dashboard">Ecoverse</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        @if(Auth::user() && Auth::user()->role === 'staff')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('staff.orders') }}">Manage Orders</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    @include('components.navbars.navs.guest')
    @auth
    <div class="container text-end my-2">
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-link">Logout</button>
        </form>
    </div>
    @endauth
    <main class="py-4">
        @yield('content')
    </main>
    <div class="text-center py-3" style="color: #000;">
        © 2025, built with 💚 by the Ecoverse Team — powering smarter, greener communities.
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>

<x-layout bodyClass="">
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <x-navbars.navs.guest signup='register' signin='login'></x-navbars.navs.guest>
            </div>
        </div>
    </div>
    <div class="page-header justify-content-center min-vh-100 d-flex align-items-center futuristic-bg"
        style="position:relative;">
        <span class="mask bg-gradient-dark opacity-7"></span>
        <div class="container text-center position-relative" style="z-index:2;">
            <img src="/assets/img/ecoverse-logo.svg" alt="Ecoverse Logo"
                style="width:80px;height:80px;border-radius:50%;background:#fff;border:3px solid #10b981;box-shadow:0 4px 24px #10b98133;">
            <h1 class="display-4 fw-bold text-white mt-4 mb-3" style="letter-spacing:2px;">Welcome to <span
                    style="color:#10b981;">Ecoverse</span>
            </h1>
            <h3 class="fw-light text-white-50 mb-4"
                style="max-width:600px;margin:auto;">Empowering a circular economy—Ecoverse turns post-consumer waste into premium, eco-friendly packaging. Experience the future of sustainable packaging innovation and join us in closing the loop for a cleaner planet.
            </h3>
            <div class="d-flex justify-content-center gap-3 mt-4">
                <a href="{{ route('login') }}"
                    class="btn btn-lg btn-success px-5 shadow"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a>
                <a href="{{ route('register') }}"
                    class="btn btn-lg btn-outline-light px-5 shadow"><i class="bi bi-person-plus me-2"></i>Register</a>
            </div>
        </div>
        <div class="futuristic-circles"></div>
    </div>
    <x-footers.guest></x-footers.guest>
    <style>
        .futuristic-bg {
            background: linear-gradient(120deg, #0f172a 0%, #10b981 100%), url('https://images.unsplash.com/photo-1497294815431-9365093b7331?auto=format&fit=crop&w=1950&q=80');
            background-blend-mode: overlay;
            background-size: cover;
            background-position: center;
        }

        .futuristic-circles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .futuristic-circles::before,
        .futuristic-circles::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            opacity: 0.18;
        }

        .futuristic-circles::before {
            width: 600px;
            height: 600px;
            left: -200px;
            top: 20%;
            background: radial-gradient(circle, #10b981 0%, transparent 80%);
        }

        .futuristic-circles::after {
            width: 400px;
            height: 400px;
            right: -100px;
            bottom: 10%;
            background: radial-gradient(circle, #6366f1 0%, transparent 80%);
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</x-layout>

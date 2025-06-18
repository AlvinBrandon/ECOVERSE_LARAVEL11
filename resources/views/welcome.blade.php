<x-layout bodyClass="">
    <div class="page-header justify-content-center min-vh-100 d-flex align-items-center futuristic-bg"
        style="background: linear-gradient(135deg, #0f2027 0%, #2c5364 100%); position: relative; overflow: hidden;">
        <span class="mask bg-gradient-dark opacity-7 position-absolute w-100 h-100" style="z-index:1;"></span>
        <div class="container position-relative" style="z-index:2;">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="display-2 fw-bold text-light mb-4 animate__animated animate__fadeInDown">Welcome to
                        <span class="text-primary">Ecoverse</span>
                    </h1>
                    <p class="lead text-light mb-5 animate__animated animate__fadeInUp animate__delay-1s">
  A smart and sustainable platform for modern waste management and recycling.<br>
  Built on Laravel 11, Ecoverse empowers communities to track, trade, and transform waste — the future starts here.
</p>

                    <div class="d-flex justify-content-center gap-3 mt-4 animate__animated animate__fadeInUp animate__delay-2s">
                        <a href="{{ route('login') }}"
                            class="btn btn-lg btn-outline-light rounded-pill px-5 shadow">Login</a>
                        <a href="{{ route('register') }}"
                            class="btn btn-lg btn-primary rounded-pill px-5 shadow">Register</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Futuristic animated shapes -->
        <div class="futuristic-shapes position-absolute w-100 h-100"
            style="top:0;left:0;pointer-events:none;z-index:0;">
            <svg width="100%" height="100%" viewBox="0 0 1920 1080" fill="none"
                xmlns="http://www.w3.org/2000/svg" style="opacity:0.15;">
                <circle cx="1600" cy="200" r="180" fill="#00d2ff" />
                <circle cx="400" cy="900" r="120" fill="#3a7bd5" />
                <rect x="900" y="100" width="200" height="200" rx="40" fill="#fff"
                    fill-opacity="0.1" />
                <rect x="1200" y="800" width="150" height="150" rx="30" fill="#fff" fill-opacity="0.07" />
            </svg>
        </div>
    </div>
    <x-footers.guest></x-footers.guest>
    <style>
        .futuristic-bg {
            background: linear-gradient(135deg, #0f2027 0%, #2c5364 100%) !important;
        }

        .futuristic-shapes svg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .btn-primary {
            background: linear-gradient(90deg, #00d2ff 0%, #3a7bd5 100%);
            border: none;
        }

        .btn-outline-light {
            border: 2px solid #fff;
        }

        .animate__animated {
            animation-duration: 1s;
            animation-fill-mode: both;
        }

        .animate__fadeInDown {
            animation-name: fadeInDown;
        }

        .animate__fadeInUp {
            animation-name: fadeInUp;
        }

        .animate__delay-1s {
            animation-delay: 1s;
        }

        .animate__delay-2s {
            animation-delay: 2s;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translate3d(0, -50px, 0);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 50px, 0);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }
    </style>
</x-layout>

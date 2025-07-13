<x-layout bodyClass="bg-dark">
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <!-- Navbar -->
                {{-- <x-navbars.navs.guest signin='login' signup='register'></x-navbars.navs.guest> --}}
                <!-- End Navbar -->
            </div>
        </div>
    </div>
    <main class="main-content mt-0">
        <div class="page-header align-items-center min-vh-100 d-flex futuristic-bg"
            style="background: linear-gradient(135deg, #232526 0%, #414345 100%); position: relative; overflow: hidden;">
            <span class="mask bg-gradient-dark opacity-7 position-absolute w-100 h-100" style="z-index:1;"></span>
            <div class="container mt-5 position-relative" style="z-index:2;">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-8 col-12 mx-auto">
                        <div class="card glassmorphism border-0 shadow-lg">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg py-4 px-3 text-center">
                                    <h3
                                        class="text-white fw-bold mb-1 animate__animated animate__fadeInDown">
                                        Sign in to <span class="text-info">Ecoverse</span>
                                    </h3>
                                    <p
                                        class="text-white-50 mb-0 animate__animated animate__fadeInUp animate__delay-1s">
                                        Welcome back! Enter your credentials to access the future.
                                    </p>
                                </div>
                            </div>
                            <div class="card-body px-4 py-4">
                                <form role="form" method="POST" action="{{ route('login') }}" class="text-start">
                                    @csrf
                                    @if (Session::has('status'))
                                    <div class="alert alert-success alert-dismissible text-white" role="alert">
                                        <span class="text-sm">{{ Session::get('status') }}</span>
                                        <button type="button" class="btn-close text-lg py-3 opacity-10"
                                            data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif
                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ old('email', 'admin@material.com') }}" required autofocus>
                                    </div>
                                    @error('email')
                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password"
                                            value="{{ old('password', 'secret') }}" required>
                                    </div>
                                    @error('password')
                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                    <div class="form-check form-switch d-flex align-items-center my-3">
                                        <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                                        <label class="form-check-label mb-0 ms-2" for="rememberMe">Remember me</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit"
                                            class="btn btn-lg btn-gradient-futuristic w-100 my-4 mb-2 shadow">Sign
                                            in</button>
                                    </div>
                                    <p class="mt-4 text-sm text-center text-light">
                                        Don't have an account?
                                        <a href="{{ route('register') }}"
                                            class="text-info text-gradient font-weight-bold">Sign up</a>
                                    </p>
                                    <p class="text-sm text-center text-light">
                                        Forgot your password? Reset your password
                                        <a href="{{ route('verify') }}"
                                            class="text-info text-gradient font-weight-bold">here</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Futuristic animated shapes -->
            <div class="futuristic-shapes position-absolute w-100 h-100"
                style="top:0;left:0;pointer-events:none;z-index:0;">
                <svg width="100%" height="100%" viewBox="0 0 1920 1080" fill="none"
                    xmlns="http://www.w3.org/2000/svg" style="opacity:0.12;">
                    <circle cx="1700" cy="180" r="140" fill="#00d2ff" />
                    <circle cx="300" cy="950" r="100" fill="#3a7bd5" />
                    <rect x="900" y="200" width="180" height="180" rx="40" fill="#fff"
                        fill-opacity="0.08" />
                    <rect x="1200" y="800" width="120" height="120" rx="30" fill="#fff"
                        fill-opacity="0.05" />
                </svg>
            </div>
        </div>
        <x-footers.guest></x-footers.guest>
    </main>
    @push('js')
    <script src="{{ asset('assets') }}/js/jquery.min.js"></script>
    <script>
        $(function() {
            var text_val = $(".input-group input").val();
            if (text_val === "") {
                $(".input-group").removeClass('is-filled');
            } else {
                $(".input-group").addClass('is-filled');
            }
        });
    </script>
    @endpush
    <style>
        .futuristic-bg {
            background: linear-gradient(135deg, #232526 0%, #414345 100%) !important;
        }

        .glassmorphism {
            background: rgba(255, 255, 255, 0.10);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
            backdrop-filter: blur(8px);
            border-radius: 1.5rem;
        }

        .btn-gradient-futuristic {
            background: linear-gradient(90deg, #00d2ff 0%, #3a7bd5 100%);
            color: #fff;
            border: none;
            transition: box-shadow 0.2s;
        }

        .btn-gradient-futuristic:hover {
            box-shadow: 0 0 20px #00d2ff99, 0 0 40px #3a7bd599;
        }

        .futuristic-shapes svg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
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

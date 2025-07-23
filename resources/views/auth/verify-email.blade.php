@extends('layouts.user_type.guest')

@section('content')
<main class="main-content mt-0">
    <section>
        <div class="page-header min-vh-75">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card card-plain mt-8">
                            <div class="card-header pb-0 text-start bg-transparent">
                                <h3 class="font-weight-bolder text-info text-gradient">Verify Your Email</h3>
                                <p class="mb-0">We've sent a verification link to your email address</p>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible text-white" role="alert">
                                        <span class="text-sm">{{ session('success') }}</span>
                                        <button type="button" class="btn-close text-lg py-3 opacity-10"
                                            data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                        <span class="text-sm">{{ session('error') }}</span>
                                        <button type="button" class="btn-close text-lg py-3 opacity-10"
                                            data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <div class="text-center mb-4">
                                    <i class="fas fa-envelope-open text-info" style="font-size: 4rem;"></i>
                                </div>

                                <div class="text-center mb-4">
                                    <p class="text-sm">
                                        Before proceeding, please check your email for a verification link.
                                        If you didn't receive the email, click the button below to request another.
                                    </p>
                                    <p class="text-sm text-muted">
                                        Your email: <strong>{{ auth()->user()->email }}</strong>
                                    </p>
                                </div>

                                <form method="POST" action="{{ route('verification.send') }}">
                                    @csrf
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-info w-100 my-4 mb-2">
                                            <i class="fas fa-paper-plane me-2"></i>Resend Verification Email
                                        </button>
                                    </div>
                                </form>

                                <div class="text-center">
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-link text-primary text-gradient font-weight-bold">
                                            Sign out and try a different email
                                        </button>
                                    </form>
                                </div>

                                <div class="text-center mt-4">
                                    <p class="text-sm">
                                        Already verified? 
                                        <a href="{{ route('dashboard') }}" class="text-primary text-gradient font-weight-bold">
                                            Go to Dashboard
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                            <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" 
                                 style="background-image:url('{{ asset('img/curved-images/curved6.jpg') }}')"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('css')
<style>
    .card {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .btn:hover {
        transform: translateY(-1px);
    }
    
    .alert {
        border-radius: 0.75rem;
    }
</style>
@endpush

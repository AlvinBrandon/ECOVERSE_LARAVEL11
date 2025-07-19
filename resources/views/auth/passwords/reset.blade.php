@extends('layouts.app')

@section('content')
<div class="container position-sticky z-index-sticky top-0">
    <div class="row">
        <div class="col-12">
            @include('layouts.navbars.guest.navbar')
        </div>
    </div>
</div>
<main class="main-content mt-0">
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-start">
                                <h4 class="font-weight-bolder">Reset Password</h4>
                                <p class="mb-0">Enter your new password</p>
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                            name="email" id="email" placeholder="Email" value="{{ $email ?? old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">New Password</label>
                                        <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                            name="password" id="password" placeholder="New Password" required>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control form-control-lg" 
                                            name="password_confirmation" id="password_confirmation" 
                                            placeholder="Confirm Password" required>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">
                                            Reset Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                        <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                            style="background-image: url('{{ asset('img/signin-ill.jpg') }}'); background-size: cover;">
                            <span class="mask bg-gradient-primary opacity-6"></span>
                            <h4 class="mt-5 text-white font-weight-bolder position-relative">Reset Your Password</h4>
                            <p class="text-white position-relative">Choose a strong password to protect your account.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection 
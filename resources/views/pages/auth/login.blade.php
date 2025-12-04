@extends('layouts.auth.app')
@section('title_page', 'Login')
@section('content')

    <!-- Bagian Form Login -->

    <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
        <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">

            <div class="d-flex align-items-center justify-content-between mb-3">
                <p class="text-primary">Pengaduan dan Aspirasi Warga</p>
                <p>Login</p>
            </div>


            <!-- Form Login -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-floating mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        id="floatingEmail" placeholder="Masukkan Email Anda" value="{{ old('email') }}">
                    <label for="floatingEmail">Email</label>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-4">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <a href="">Forgot Password</a>
                </div>

                <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Log In</button>
            </form>

            <p class="text-center mb-0">
                Belum punya akun? <a href="{{ route('daftar') }}">Register</a>
            </p>

        </div>


    </div>

@endsection

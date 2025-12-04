@extends('layouts.auth.app')
@section('title_page', 'Register')
@section('content')


        <!-- Bagian Form Register -->
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <p class="text-primary">Pengaduan dan Aspirasi Warga</p>
                    <p>Register</p>
                </div>

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    {{-- Nama --}}
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="floatingNama" name="name" placeholder="Masukkan Nama Anda"
                            value="{{ old('name') }}">
                        <label for="floatingNama">Nama</label>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingEmail" name="email"
                            placeholder="Masukkan Email Anda" value="{{ old('email') }}">
                        <label for="floatingEmail">Email</label>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="floatingPassword" name="password"
                            placeholder="Password">
                        <label for="floatingPassword">Password</label>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="floatingConfirmPassword"
                            name="password_confirmation" placeholder="Konfirmasi Password">
                        <label for="floatingConfirmPassword">Konfirmasi Password</label>
                        @error('password_confirmation')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4">
                        Register
                    </button>
                </form>

                <p class="text-center mb-0">
                    Sudah punya akun?
                    <a href="{{ route('auth') }}">Log In</a>
                </p>

            </div>
        </div>

    </div>
</div>

@endsection

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>Register</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Font Awesome 6 Free -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-pV1Q8x2iF6jF+z6MfTF7P91GJd4zX+F3ZXxSp1L2Q2m/NxEuzU6Fd5ClV7vYrHzEj7c7dEsm57eX5I5lrzQfQA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!--Bootstrap Icons (boleh tetap dipakai untuk ikon lain) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap"
        rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-pZ8pZKz0+KJ2Wf4ZlV+M8zO4qvQvcp4u8hK2sVY8LtAbKXhyI4ZXHjpmF0y70M2zKfWUJ2s7UXZtQy1C1N8X5A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    {{-- End CSS --}}


    <!-- Include Font Awesome (FA5 compatible) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        /* Gambar latar mencakup seluruh halaman */
        body {
            background-image: url('{{ asset('img/ilustrasi-pengaduan.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        /* Overlay gelap biar teks dan form tetap jelas */
        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }

        /* Kontainer utama */
        .register-container {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Kotak form */
        .form-box {
            background-color: rgba(20, 20, 20, 0.85);
            padding: 2.5rem;
            border-radius: 12px;
            max-width: 400px;
            width: 100%;
            color: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }

        .form-box .btn-primary {
            background-color: #dc3545;
            border: none;
        }

        .form-box .btn-primary:hover {
            background-color: #b02a37;
        }

        h2 {
            color: #fff;
            font-weight: 700;
        }

        .subtitle {
            color: #ddd;
            text-align: center;
            margin-bottom: 2rem;
            max-width: 400px;
        }

        a {
            color: #ff4d4d;
        }

        a:hover {
            color: #fff;
        }
    </style>
</head>
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sign Up Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div
                    class="col-lg-7 col-md-6 d-none d-md-flex align-items-center justify-content-center position-relative bg-section text-white">
                    <div class="bg-overlay"></div>
                    <div class="content-wrapper d-flex flex-column align-items-center justify-content-center">
                        <h2>Bina Desa</h2>
                        <p style="max-width:400px;">
                            Website <strong>Pengaduan dan Aspirasi Warga</strong> untuk memudahkan warga menyampaikan
                            aspirasi
                            dan masalah di desa secara cepat, mudah, dan transparan.
                        </p>
                    </div>
                </div>
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html" class="">
                                <p class="text-primary" class="fa fa-user-edit me-2">Pengaduan dan Aspirasi Warga</p>
                            </a>
                            <p>Register</p>
                        </div>
                        {{-- Tampilkan Flash Data di sini --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif


                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            {{-- Nama --}}
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="floatingNama" name="name" placeholder="Masukkan Nama Anda"
                                    value="{{ old('name') }}">
                                <label for="floatingNama">Nama</label>
                                @error('name')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingEmail" name="email"
                                    placeholder="Masukkan Email Anda" value="{{ old('email') }}">
                                <label for="floatingEmail">Email</label>
                                @error('email')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="floatingPassword" name="password"
                                    placeholder="Password">
                                <label for="floatingPassword">Password</label>
                                @error('password')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="floatingConfirmPassword"
                                    name="password_confirmation" placeholder="Konfirmasi Password">
                                <label for="floatingConfirmPassword">Konfirmasi Password</label>
                                @error('password_confirmation')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Register</button>
                        </form>
                        <p class="text-center mb-0">Sudah punya akun? <a href="{{ route('auth') }}">Log In</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign Up End -->
    </div>

    {{-- JS Start --}}
    @include('layouts.js')
    {{-- JS End --}}
</body>

</html>

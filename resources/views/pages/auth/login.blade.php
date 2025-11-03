<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
<!-- Favicon -->
<link href="img/favicon.ico" rel="icon">

<!-- Google Web Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap"
    rel="stylesheet">

<!-- Icon Font Stylesheet -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

<!-- Bootstrap Stylesheet -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Template Stylesheet -->
<link href="css/style.css" rel="stylesheet">

<style>
    html, body {
        height: 100%;
    }

    .login-row {
        min-height: 100vh;
    }

    .bg-section {
        background-image: url('{{ asset('img/ilustrasi-pengaduan.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .bg-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
    }

    .content-wrapper {
        position: relative;
        z-index: 1;
        text-align: center;
    }

    .text-white {
        color: white !important;
    }
</style>


</head>

<body>
    <div class="container-fluid p-0">
        <div class="row g-0 login-row">
            <!-- KANAN: Ilustrasi Pengaduan -->
            <div class="col-lg-7 col-md-6 d-none d-md-flex align-items-center justify-content-center position-relative bg-section text-white">
                <div class="bg-overlay"></div>
                <div class="content-wrapper d-flex flex-column align-items-center justify-content-center">
                    <h2>Bina Desa</h2>
                    <p style="max-width:400px;">
                        Website <strong>Pengaduan dan Aspirasi Warga</strong> untuk memudahkan warga menyampaikan aspirasi
                        dan masalah di desa secara cepat, mudah, dan transparan.
                    </p>
                </div>
            </div>


        <!-- KIRI: Form Login -->
        <div class="col-lg-5 col-md-6 d-flex align-items-center justify-content-center bg-secondary">
            <div class="p-4 p-sm-5 w-100">
                <div class="text-center mb-4">
                    <h3 class="text-primary mb-2"><i class="fa fa-user-edit me-2"></i>Login</h3>
                    <p class="text-white mb-0">Masuk untuk mengelola Pengaduan dan Aspirasi Warga</p>
                </div>

                {{-- Flash Data --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif

                <!-- Form Login -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" id="floatingInput"
                            placeholder="Masukkan Email Anda">
                        <label for="floatingInput">Email</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" name="password" id="floatingPassword"
                            placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Remember me</label>
                        </div>
                        <a href="">Forgot Password</a>
                    </div>
                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Log In</button>
                </form>

                <p class="text-center mb-0 text-white">Belum punya akun? <a
                        href="{{ route('daftar') }}">Register</a></p>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

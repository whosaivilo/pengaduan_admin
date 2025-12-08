<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>@yield('title_page', 'Login')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    @include('layouts.auth.css')

</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">

        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">

                <!-- Bagian Kiri -->
                <div
                    class="col-lg-7 col-md-6 d-none d-md-flex align-items-center justify-content-center position-relative bg-section text-white">
                    <div class="bg-overlay"></div>

                    <div class="content-wrapper d-flex flex-column align-items-center justify-content-center">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Bina Desa"
                            style="width:300px; margin-bottom:20px;">

                        <h2>Bina Desa</h2>
                        <p style="max-width:400px;">
                            Website <strong>Pengaduan dan Aspirasi Warga</strong> untuk memudahkan warga menyampaikan
                            aspirasi dan masalah di desa secara cepat, mudah, dan transparan.
                        </p>
                    </div>
                </div>


                @yield('content')

</body>


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
            background-image: url("/assets/img/ilustrasi-pengaduan.jpg");
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

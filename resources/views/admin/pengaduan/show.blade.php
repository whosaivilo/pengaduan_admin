<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Pengaduan</title></title>
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

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
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


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>Pengaduan</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="{{ asset('img/user.jpg') }}" alt=""
                            style="width: 40px; height: 40px;">
                        <div
                            class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                        </div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">Theresa Olivia</h6>
                        <span>Admin</span>
                    </div>
                </div>

                <div class="navbar-nav w-100">
                    <a href="{{ route('dashboard') }}" class="nav-item nav-link "><i
                            class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="{{ route('pengaduan.index') }}" class="nav-item nav-link active"><i
                            class="fa fa-keyboard me-2"></i>Daftar Pengaduan</a>
                    <a href="{{ route('warga.index') }}" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Data
                        Warga</a>
                </div>
        </div>
        </nav>
    </div>
    <!-- Sidebar End -->


    <!-- Content Start -->
    <div class="content">
        <!-- Navbar Start -->
        <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
            <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
            </a>
            <a href="#" class="sidebar-toggler flex-shrink-0">
                <i class="fa fa-bars"></i>
            </a>
            <form class="d-none d-md-flex ms-4">
                <input class="form-control bg-dark border-0" type="search" placeholder="Search">
            </form>
            <div class="navbar-nav align-items-center ms-auto">

                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <img class="rounded-circle me-lg-2" src="{{ asset('img/user.jpg') }}" alt=""
                            style="width: 40px; height: 40px;">
                        <span class="d-none d-lg-inline-flex">Theresa Olivia</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                        <a href="#" class="dropdown-item">My Profile</a>
                        <a href="#" class="dropdown-item">Settings</a>
                        <a href="#" class="dropdown-item">Log Out</a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Navbar End -->


        <div class="container-fluid pt-4 px-4">
            <div class="row g-4 justify-content-center">

                <div class="col-sm-12 col-xl-10">

                    {{-- Tampilkan Flash Data di sini --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- KARTU DETAIL PENGADUAN --}}
                    <div class="bg-secondary rounded p-4 mb-4">
                        <h5 class="mb-3 text-primary">Detail Pengaduan #{{ $pengaduan->nomor_tiket }}</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Judul:</strong> {{ $pengaduan->judul }}</p>
                                <p><strong>Pelapor:</strong> {{ $pengaduan->warga->nama ?? 'N/A' }}</p>
                                <p><strong>Lokasi (RT/RW):</strong> {{ $pengaduan->lokasi_text }} (RT
                                    {{ $pengaduan->rt }}/RW {{ $pengaduan->rw }})</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <p><strong>Tanggal Diajukan:</strong> {{ $pengaduan->created_at->format('d F Y H:i') }}
                                </p>
                                <p><strong>Kategori:</strong> {{ $pengaduan->kategori_id }}</p>
                                <p><strong>Status:</strong>
                                    @php
                                        $badgeClass = match ($pengaduan->status) {
                                            'Baru' => 'bg-danger',
                                            'Diproses' => 'bg-warning',
                                            'Selesai' => 'bg-success',
                                            default => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ $pengaduan->status }}</span>
                                </p>
                            </div>
                        </div>

                        <hr class="text-white-50">

                        {{-- DESKRIPSI (Textarea non-editable) --}}
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Lengkap</label>
                            <textarea class="form-control bg-dark text-white" rows="4" readonly>{{ $pengaduan->deskripsi }}</textarea>
                        </div>

                        {{-- FOTO BUKTI --}}
                        @if ($pengaduan->lampiran_bukti)
                            <div class="mb-3">
                                <label class="form-label">Lampiran Bukti</label><br>
                                <img src="{{ asset($pengaduan->lampiran_bukti) }}" alt="Foto Bukti"
                                    style="max-width: 400px; height: auto; border-radius: 8px;">
                                <p class="form-text mt-2 text-white-50">Path: {{ $pengaduan->lampiran_bukti }}</p>
                            </div>
                        @endif

                    </div>


                    {{-- KARTU TINDAK LANJUT (Hanya Tampil Jika Status Belum Selesai) --}}
                    @if ($pengaduan->status == 'Baru' || $pengaduan->status == 'Diproses')
                        <div class="bg-secondary rounded p-4">
                            <h6 class="mb-4 text-warning">Tindak Lanjut / Perubahan Status</h6>

                            {{-- Form Tindak Lanjut (Asumsi kita update status dan catatan ke PengaduanController@update) --}}
                            <form action="{{ route('pengaduan.update.status', $pengaduan->pengaduan_id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="catatan_tindak_lanjut" class="form-label">Catatan Tindak Lanjut
                                        Petugas</label>
                                    <textarea class="form-control" name="catatan_tindak_lanjut" rows="3"
                                        placeholder="Masukkan detail tindakan yang sudah dilakukan...">{{ old('catatan_tindak_lanjut') }}</textarea>
                                    {{-- Anda perlu menambahkan kolom 'catatan_tindak_lanjut' di tabel pengaduan/tindak_lanjut --}}
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="status_baru" class="form-label">Ubah Status Menjadi:</label>
                                        <select class="form-select" name="status" id="status_baru" required>
                                            <option value="">-- Pilih Status Baru --</option>
                                            {{-- Opsi disesuaikan dengan status saat ini --}}
                                            <option value="Diproses"
                                                {{ $pengaduan->status == 'Diproses' ? 'selected' : '' }}>Diproses
                                            </option>
                                            <option value="Selesai">Selesai</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3 align-self-end">
                                        <button type="submit" class="btn btn-warning w-100">Simpan Tindak Lanjut &
                                            Ubah Status</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="bg-success rounded p-4 text-white">
                            <p class="mb-0">✅ Pengaduan ini sudah **Selesai Ditangani**.</p>
                        </div>
                    @endif

                    <div class="mt-4 text-end">
                        <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
                    </div>

                </div>
            </div>
        </div>
        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/chart/chart.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="lib/tempusdominus/js/moment.min.js"></script>
        <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
        <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

        <!-- Template Javascript -->
        <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>

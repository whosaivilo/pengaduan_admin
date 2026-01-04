@if (Auth::check())
    <div class="sidebar pe-4 pb-3">
        <nav class="navbar bg-secondary navbar-dark flex-column align-items-stretch">

            <div class="sidebar-logo text-center mb-4">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Bina Desa" class="img-fluid sidebar-logo-img">
                </a>
            </div>
            <div class="d-flex align-items-center ms-4 mb-4">
                <div class="position-relative">
                    <img class="rounded-circle" src="{{ Auth::user()->profile_picture_url }}" alt="Profile"
                        style="width:40px; height:40px; object-fit:cover;">

                    <div
                        class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                    </div>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                    <span>{{ Auth::user()->role }}</span>
                </div>
            </div>

            <div class="navbar-nav w-100">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-item nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fa fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pengaduan.index') }}"
                        class="nav-item nav-link {{ request()->routeIs('pengaduan.*') ? 'active' : '' }}">
                        <i class="far fa-file-alt me-2"></i>Daftar Pengaduan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kategori.index') }}"
                        class="nav-item nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                        <i class="fa fa-th me-2"></i>Data Kategori
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('penilaian.index') }}"
                        class="nav-item nav-link {{ request()->routeIs('penilaian.*') ? 'active' : '' }}">
                        <i class="fa fa-star me-2"></i>Penilaian Layanan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tindak_lanjut.index') }}"
                        class="nav-item nav-link {{ request()->routeIs('tindak_lanjut.*') ? 'active' : '' }}">
                        <i class="fa fa-cubes me-2"></i>Tindak Lanjut
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('warga.index') }}"
                        class="nav-item nav-link {{ request()->routeIs('warga.*') ? 'active' : '' }}">
                        <i class="fa fa-user me-2"></i>Data Warga
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.index') }}"
                        class="nav-item nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}">
                        <i class="fa fa-user me-2"></i>Data User
                    </a>
                </li>
            </div>
        </nav>
    </div>
@endif

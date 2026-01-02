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
                    <div class="nav-item">

                    </div>

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            @if (Auth::check())
                                <img class="rounded-circle" src="{{ Auth::user()->profile_picture_url }}" alt="Profile"
                                    style="width:40px; height:40px; object-fit:cover;">
                                <span class="d-none d-lg-inline-flex">
                                    {{ Auth::user()->name }}
                                </span>
                            @endif

                        </a>

                        @if (Auth::check())
                            <div
                                class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                                <a href="#" class="dropdown-item">Last login: {{ session('last_login') }}</a>

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item">Log Out</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

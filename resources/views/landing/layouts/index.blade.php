<!doctype html>
<html lang="en">

<head>
    <meta charset="ut-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dangau Studio')</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo_dangau.png') }}">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/auth/css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/lib/owlcarousel/assets/owl.carousel.min.css ') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-success" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Topbar Start -->
    <div class="container-fluid bg-light px-5 d-none d-lg-block">
        <div class="row gx-0">
            <div class="col-lg-8 text-center text-lg-start mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center" style="height: 45px;">
                    <small class="me-3 text-dark"><i class="fa fa-map-marker-alt me-2"></i>Jl. Simpang Akhirat, Kuranji, Kota Padang, Sumatera Barat</small>
                    <small class="me-3 text-dark"><i class="fa fa-phone-alt me-2"></i>+07 345 6789</small>
                    <small class="text-dark"><i class="fa fa-envelope-open me-2"></i>dangaustudio@gmail.com</small>
                </div>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <div class="d-inline-flex align-items-center" style="height: 45px;">
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href="https://www.tiktok.com/@dangaustudio?_t=8q2yUdMQMpV&_r=1"><i class="fab fa-tiktok text-dark"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href="https://www.instagram.com/dangaustudio/"><i class="fab fa-instagram text-dark"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle" href="#"><i class="fab fa-youtube text-dark"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <div class="container-fluid position-relative p-0">
        <nav class="navbar navbar-expand-lg bg-success navbar-light px-4 px-lg-5 py-lg-0 shadow-lg" >
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('assets/img/logo_dangau.png') }}" alt="Logo" width="40" height="auto" class="rounded-circle me-2">
                <p class="m-0 text-white fs-5" style="letter-spacing: 2px;">Dangau Studio</p>
            </a>
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            {{-- <div class="collapse navbar-collapse" id="navbarCollapse">
                <!-- Main Links -->
                <div class="navbar-nav ms-auto">
                    <a class="nav-item nav-link text-white @yield('menuBeranda')" href="/">Beranda</a>
                    <a class="nav-item nav-link text-white @yield('menuTentang')" href="/tentang">Tentang</a>
                    <!-- Kelompok Karya Seni -->
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white @yield('menuKaryaSeni')" href="#" id="navbarKaryaSeni" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Karya Seni
                        </a>
                        <div class="dropdown-menu m-0">
                            <a class="dropdown-item @yield('menuSeniman')" href="/seniman">Seniman</a>
                            <a class="dropdown-item @yield('menuPameran')" href="/artikel">Pameran</a>
                            <a class="dropdown-item @yield('menuGalery')" href="/galery">Galeri</a>
                        </div>
                    </div>
                    <a class="nav-item nav-link text-white @yield('menuEvent')" href="/event">Event</a>
                    <a class="nav-item nav-link text-white @yield('menuBerita')" href="/berita">Berita</a>
                </div>

                <!-- Cart and User Authentication -->
                <div class="navbar-nav ms-auto">
                    <!-- Cart Icon -->
                    <a class="nav-item nav-link rounded-circle text-white" href="#"><i class="fa fa-shopping-cart text-white me-2"></i> Cart</a>
                    <!-- User Authentication Dropdown -->
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                            @auth
                                @if(Auth::user()->foto_profile)
                                   <img src="{{ asset('storage/' . Auth::user()->foto_profile) }}" alt="Foto Profil" class="rounded-circle me-2" width="30" height="30">
                                @else
                                    <img src="{{ asset('assets/img/foto-profile.png') }}" alt="Foto Profil" class="rounded-circle me-2" width="30" height="30">
                                @endif
                                <span class="text-white">{{ Auth::user()->name }}</span>
                            @else
                                <i class="fa fa-user me-2 text-white"></i> Log In
                            @endauth
                        </a>
                        <div class="dropdown-menu m-0">
                            @auth
                                @if (auth()->user()->role == 'user')
                                    <a class="dropdown-item" href="/user/account"><i class="fa fa-cog me-3"></i> Setting</a>
                                @elseif (auth()->user()->role == 'admin')
                                    <a class="dropdown-item" href="/admin"><i class="fa fa-home-alt me-3"></i> Dashboard</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out-alt me-3"></i> Log out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @else
                                <a class="dropdown-item" href="{{ route('login') }}"><i class="fa fa-sign-in-alt me-3"></i> Login</a>
                                <hr class="dropdown-divider">
                                <a class="dropdown-item" href="{{ route('register') }}"><i class="fa fa-user-plus me-3"></i> Register</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <!-- Main Links -->
                <div class="navbar-nav ms-auto">
                    <a class="nav-item nav-link text-white @yield('menuBeranda')" href="/">Beranda</a>
                    <a class="nav-item nav-link text-white @yield('menuTentang')" href="/tentang">Tentang</a>
                    <a class="nav-item nav-link text-white @yield('menuSeniman')" href="/seniman">Seniman</a>
                    <a class="nav-item nav-link text-white @yield('menuGalery')" href="/galery">Galery</a>
                    <a class="nav-item nav-link text-white @yield('menuPameran')" href="/artikel">Pameran</a>
                    <a class="nav-item nav-link text-white @yield('menuEvent')" href="/event">Event</a>
                    <a class="nav-item nav-link text-white @yield('menuBerita')" href="/berita">Berita</a>
                </div>

                <!-- Cart and User Authentication -->
                <div class="navbar-nav ms-auto">
                    <!-- Cart Icon -->
                    <a class="nav-item nav-link rounded-circle text-white" href="#"><i class="fa fa-shopping-cart text-white me-2"></i> Cart</a>
                    <!-- User Authentication Dropdown -->
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                            @auth
                                @if(Auth::user()->foto_profile)
                                   <img src="{{ asset('storage/' . Auth::user()->foto_profile) }}" alt="Foto Profil" class="rounded-circle me-2" width="23" height="23">
                                @else
                                    <img src="{{ asset('assets/img/foto-profile.png') }}" alt="Foto Profil" class="rounded-circle me-2" width="23" height="23">
                                @endif
                                <span class="text-white">{{ Auth::user()->name }}</span>
                            @else
                                <i class="fa fa-user me-2 text-white"></i> Log In
                            @endauth
                        </a>
                        <div class="dropdown-menu m-0">
                            @auth
                                @if (auth()->user()->role == 'user')
                                    <a class="dropdown-item" href="/user/account"><i class="fa fa-cog me-3"></i> Setting</a>
                                @elseif (auth()->user()->role == 'admin')
                                    <a class="dropdown-item" href="/admin"><i class="fa fa-home-alt me-3"></i> Dashboard</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out-alt me-3"></i> Log out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @else
                                <a class="dropdown-item" href="{{ route('login') }}"><i class="fa fa-sign-in-alt me-3"></i> Login</a>
                                <hr class="dropdown-divider">
                                <a class="dropdown-item" href="{{ route('register') }}"><i class="fa fa-user-plus me-3"></i> Register</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->

    @yield('content')

    <!--MyFooterStart-->
    <div class="footer pt-5 border border-top bg-success border-white px-3" style="margin-top: 8rem">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <p class="mb-4 fs-6 fw-bold text-light" style="letter-spacing: 2px;">
                        <img src="{{ asset('assets/img/logo_dangau.png') }}" width="60" alt="Image" class="img-fluid me-2">
                        Dangau Studio
                    </p>
                    <div class="d-flex align-items-center">
                        <i class="fa fa-location-dot text-white fs-5 mx-3 mb-4"></i>
                        <a href="https://maps.app.goo.gl/7K98dC9SeptBvCCP8" class="mb-4 text-light" style="font-size: 14px">
                            Jl. Simpang Akhirat, Kuranji, Kota Padang, Sumatera Barat
                        </a>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fa fa-phone-alt text-white fs-5 mx-3 mb-4"></i>
                        <p class="mb-4 text-light" style="font-size: 14px">
                            +62 812 345 6789
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <p class="footer-header fs-6 fw-bold text-light mb-3 mt-3 mx-3">Tautan Cepat</p>
                    <ul class="list-unstyled py-3 ">
                        <li class="pb-2">
                            <a href="/" class="text-light">
                                <i class="fa fa-angle-right text-white fs-5 mx-3 mb-3"></i>
                                Beranda
                            </a>
                        </li>
                        <li class="pb-2">
                            <a href="#tentangKami"  class="text-light">
                                <i class="fa fa-angle-right text-white fs-5 mx-3 mb-3"></i>
                                Tentang Kami
                            </a>
                        </li>
                        <li class="pb-2">
                            <a href="/" class="text-light">
                                <i class="fa fa-angle-right text-white fs-5 mx-3 mb-3"></i>
                                Program
                            </a>
                        </li>
                        <li class="pb-2">
                            <a href="/" class="text-light">
                                <i class="fa fa-angle-right text-white fs-5 mx-3 mb-3"></i>
                                Layanan Kami
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-4">
                    <p class="footer-heading fs-6 fw-bold text-light my-3 mx-3">Ikuti Informasi Kami</p>
                    <ul class="list-unstyled py-3">
                        <li class="pb-3">
                            <a href="https://www.tiktok.com/@dangaustudio?_t=8q2yUdMQMpV&_r=1"  class="text-light">
                                <i class="fab fa-tiktok text-white fs-5 mx-3 mb-2"></i>
                                Dangau Studio
                            </a>
                        </li>
                        <li class="pb-3">
                            <a href="https://www.instagram.com/dangaustudio/" class="text-light">
                                <i class="fab fa-instagram text-white fs-5 mx-3 mb-2"></i>
                                dangaustudio
                            </a>
                        </li>
                        <li class="pb-3">
                            <a href="https://www.instagram.com/dangaustudio/" class="text-light">
                                <i class="fab fa-youtube text-white fs-5 mx-3 mb-2"></i>
                                Dangau Studio Channel
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row py-3">
                <div class="col-12">
                    <div class="copyright text-light border-top border-white pt-4 text-center">
                        <p>
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Include SweetAlert (Optional) -->
    @include('sweetalert::alert')

    <!-- JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script src="{{ asset('assets/auth/js/app.min.js') }}"></script> --}}
    <script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>

    <!-- CKEditor Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.querySelector('#editor'))
                .catch(error => {
                    console.error(error);
                });
        });
    </script>

    @stack('custom-script')
</body>

</html>

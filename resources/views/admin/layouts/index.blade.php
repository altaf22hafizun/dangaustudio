<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin | Dangau Studio')</title>
  <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}">
  <link rel="stylesheet" href="{{ asset('assets/auth/css/styles.min.css') }}" />
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div class="scroll-sidebar" data-simplebar>
        <div class="d-flex mb-4 align-items-center">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" width="40" height="auto" class="d-inline-block me-3 rounded-circle">
            <a class="navbar-brand d-flex d-lg-inline-block mx-auto mx-lg-0 text-center text-lg-start" href="/admin">
                <h5 class="me-3 fw-bold fs-4 fs-md-2 fs-lg-1" style="color: #1a5319;">
                    Dangau Studio
                </h5>
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
          <ul id="sidebarnav" class="mb-4 pb-2">
            <li class="sidebar-item">
                <a
                    class="sidebar-link sidebar-link @yield('menuDashboard')"
                    href="/admin"
                    aria-expanded="false"
                >
                    <span class="aside-icon p-2 bg-light-primary rounded-3">
                    <i class="ti ti-layout-dashboard fs-7 text-primary"></i>
                    </span>
                    <span class="hide-menu ms-2 ps-1">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a
                    class="sidebar-link sidebar-link @yield('menuBerita')"
                    href="/admin/berita"
                    aria-expanded="false"
                >
                    <span class="aside-icon p-2 bg-light-primary rounded-3">
                    <i class="ti ti-package fs-7 text-primary"></i>
                    </span>
                    <span class="hide-menu ms-2 ps-1">Berita</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a
                    class="sidebar-link sidebar-link @yield('menuEvent')"
                    href="/admin/event"
                    aria-expanded="false"
                >
                    <span class="aside-icon p-2 bg-light-primary rounded-3">
                    <i class="ti ti-calendar-event fs-7 text-primary"></i>
                    </span>
                    <span class="hide-menu ms-2 ps-1">Event</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a
                    class="sidebar-link sidebar-link @yield('menuGalery') "
                    href="/admin/galery"
                    aria-expanded="false"
                >
                    <span class="aside-icon p-2 bg-light-primary rounded-3">
                    <i class="ti ti-article fs-7 text-primary"></i>
                    </span>
                    <span class="hide-menu ms-2 ps-1">Galery</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a
                    class="sidebar-link sidebar-link @yield('menuIncome')"
                    href="/admin/income"
                    aria-expanded="false"
                >
                    <span class="aside-icon p-2 bg-light-primary rounded-3">
                    <i class="ti ti-plant fs-7 text-primary"></i>
                    </span>
                    <span class="hide-menu ms-2 ps-1">Income</span>
                </a>
            </li>
            <li class="sidebar-item">
              <a
                class="sidebar-link sidebar-link @yield('menuSeniman')"
                href="/admin/seniman"
                aria-expanded="false"
              >
                <span class="aside-icon p-2 bg-light-primary rounded-3">
                  <i class="ti ti-package fs-7 text-primary"></i>
                </span>
                <span class="hide-menu ms-2 ps-1">Seniman</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a
                class="sidebar-link sidebar-link @yield('menuPameran')"
                href="/admin/pameran"
                aria-expanded="false"
              >
                <span class="aside-icon p-2 bg-light-primary rounded-3">
                  <i class="ti ti-package fs-7 text-primary"></i>
                </span>
                <span class="hide-menu ms-2 ps-1">Pameran</span>
              </a>
            </li>
            <li class="sidebar-item">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a class="sidebar-link sidebar-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" aria-expanded="false">
                    <span class="aside-icon p-2 bg-light-primary rounded-3">
                        <i class="ti ti-logout fs-7 text-primary"></i>
                    </span>
                    <span class="hide-menu ms-2 ps-1">Logout</span>
                </a>
            </li>
          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <div class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse">
                <i class="ti ti-menu-2"></i>
              </div>
            </li>
          </ul>
          {{-- <div class="navbar-collapse justify-content-end px-0 mt-3" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <p class="btn me-4 text-light" style="background-color: #1a5319;">Admin</p>
            </ul>
          </div> --}}
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        @yield('content')
      </div>
    </div>
  </div>
  @include('sweetalert::alert')
  <script src="{{ asset('assets/auth/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/auth/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/auth/js/sidebarmenu.js') }}"></script>
  <script src="{{ asset('assets/auth/js/app.min.js') }}"></script>
  <script src="{{ asset('assets/auth/js/dashboard.js') }}"></script>
  <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
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

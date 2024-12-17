<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin | Dangau Studio')</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo_dangau.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/auth/css/styles.min.css') }}" />
    {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!--ApexJS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.50.0/apexcharts.min.css" integrity="sha512-YEwcgX5JXVXKtpXI4oXqJ7GN9BMIWq1rFa+VWra73CVrKds7s+KcOfHz5mKzddIOLKWtuDr0FzlTe7LWZ3MTXw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
        <!-- Sidebar scroll -->
        <div class="scroll-sidebar" data-simplebar>
          <!-- Logo Section -->
          <div class="d-flex mb-4 align-items-center">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" width="40" height="auto" class="d-inline-block me-3 rounded-circle">
            <a class="navbar-brand d-flex d-lg-inline-block mx-auto mx-lg-0 text-center text-lg-start" href="/admin">
              <h5 class="me-3 fw-bold fs-4 fs-md-2 fs-lg-1 text-success mt-2" style="letter-spacing: 2px;">
                Dangau Studio
              </h5>
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
              <i class="ti ti-x fs-8"></i>
            </div>
          </div>

          <hr class="fs-1">

          <!-- Sidebar navigation -->
          <nav class="sidebar-nav">
            <ul id="sidebarnav" class="mb-4 pb-2">
              <!-- Dashboard -->
              <li class="sidebar-item mb-4">
                <a class="sidebar-link @yield('menuDashboard')" href="{{ route('dashboard') }}" aria-expanded="false">
                  <span class="aside-icon p-2 bg-success rounded-3">
                    <i class="ti ti-layout-dashboard fs-5 text-light"></i>
                  </span>
                  <span class="hide-menu ms-2 ps-1">Dashboard</span>
                </a>
              </li>

              <!-- Berita -->
              <li class="sidebar-item mb-4">
                <a class="sidebar-link @yield('menuBerita')" href="/admin/berita" aria-expanded="false">
                  <span class="aside-icon p-2 bg-success rounded-3">
                    <i class="fa-solid fa-newspaper fs-5 text-light"></i>
                  </span>
                  <span class="hide-menu ms-2 ps-1">Berita</span>
                </a>
              </li>

              <!-- Event -->
              <li class="sidebar-item mb-4">
                <a class="sidebar-link @yield('menuEvent')" href="/admin/events" aria-expanded="false">
                  <span class="aside-icon p-2 bg-success rounded-3">
                    <i class="ti ti-calendar-event fs-5 text-light"></i>
                  </span>
                  <span class="hide-menu ms-2 ps-1">Event</span>
                </a>
              </li>

              <!-- Karya -->
              <li class="sidebar-item mb-4">
                <a class="sidebar-link @yield('menuKarya')" href="/admin/karya" aria-expanded="false">
                  <span class="aside-icon p-2 bg-success rounded-3">
                    <i class="ti ti-palette fs-5 text-light"></i>
                  </span>
                  <span class="hide-menu ms-2 ps-1">Karya</span>
                </a>
              </li>

              <!-- Income -->
              <li class="sidebar-item mb-4">
                <a class="sidebar-link @yield('menuIncome')" href="/admin/income" aria-expanded="false">
                  <span class="aside-icon p-2 bg-success rounded-3">
                    <i class="fas fa-chart-line fs-5 text-light"></i>
                  </span>
                  <span class="hide-menu ms-2 ps-1">Income</span>
                </a>
              </li>

              <!-- Seniman -->
              <li class="sidebar-item mb-4">
                <a class="sidebar-link @yield('menuSeniman')" href="/admin/seniman" aria-expanded="false">
                  <span class="aside-icon p-2 bg-success rounded-3">
                    <i class="ti ti-brush fs-5 text-light"></i>
                  </span>
                  <span class="hide-menu ms-2 ps-1">Seniman</span>
                </a>
              </li>

              <!-- Pameran -->
              <li class="sidebar-item mb-4">
                <a class="sidebar-link @yield('menuPameran')" href="/admin/pameran" aria-expanded="false">
                  <span class="aside-icon p-2 bg-success rounded-3">
                    <i class="ti ti-receipt fs-5 text-light"></i>
                  </span>
                  <span class="hide-menu ms-2 ps-1">Pameran</span>
                </a>
              </li>

              <!-- User -->
              <li class="sidebar-item mb-4">
                <a class="sidebar-link @yield('menuUser')" href="/admin/user" aria-expanded="false">
                  <span class="aside-icon p-2 bg-success rounded-3">
                    <i class="ti ti-user fs-5 text-light"></i>
                  </span>
                  <span class="hide-menu ms-2 ps-1">User</span>
                </a>
              </li>

              <!-- Logout -->
              <li class="sidebar-item mb-4">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
                <a class="sidebar-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" aria-expanded="false">
                  <span class="aside-icon p-2 bg-success rounded-3">
                    <i class="ti ti-logout fs-5 text-light"></i>
                  </span>
                  <span class="hide-menu ms-2 ps-1">Logout</span>
                </a>
              </li>
            </ul>
          </nav>
          <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll -->
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
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        @yield('content')
      </div>
    </div>
  </div>
  <!--ApexJS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.50.0/apexcharts.min.js" integrity="sha512-h3DSSmgtvmOo5gm3pA/YcDNxtlAZORKVNAcMQhFi3JJgY41j9G06WsepipL7+l38tn9Awc5wgMzJGrUWaeUEGA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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

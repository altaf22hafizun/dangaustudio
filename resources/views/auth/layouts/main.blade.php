<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>
  <link rel="shortcut icon" href="{{ asset('assets/img/logo_dangau.png') }}">
  <link rel="stylesheet" href="{{ asset('assets/auth/css/styles.min.css') }}" />
  <link href="{{ asset('assets/auth/css/bootstrap.css') }}" rel="stylesheet">
</head>

<body>
  <!-- Body Wrapper -->
  <div class="page-wrapper p-0" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center"
      style="background: #f0f0f0;">
      <div class="d-flex align-items-center justify-content-center w-100 py-5">
        <div class="card auth-card mb-0 mx-3" style="max-width: 35rem; width: 100%;">
          <div class="card-body">
            <a href="/" class="text-nowrap d-flex align-items-center justify-content-start w-100 mb-4"">
              <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" width="70" height="70" class="d-inline-block me-3 rounded-circle">
              <div class="text-start text-lg-start">
                <h5 class="m-0 fw-bold" style="color: #1a5319; letter-spacing: 3px;">
                  Dangau Studio
                </h5>
              </div>
            </a>
           @yield('content')
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('sweetalert::alert')
  <!-- JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/auth/js/main.js') }}"></script>
  <script src="{{ asset('assets/auth/libs/jquery/dist/jquery.min.js') }}"></script>
  @stack('custom-script')
</body>
</html>

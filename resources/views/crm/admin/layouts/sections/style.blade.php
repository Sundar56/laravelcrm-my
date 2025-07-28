  <!-- Bootstrap CSS -->
  <link href="{{ asset('assets/css/bootstrap.min.css'.Config::get('app.assets_version')) }}" rel="stylesheet">
  </link>
  <link href="{{ asset('assets/css/bootstrap-extended.css'.Config::get('app.assets_version')) }}" rel="stylesheet">
  </link>
  <link href="{{ asset('assets/css/app.css'.Config::get('app.assets_version')) }}" rel="stylesheet">
  </link>
  <link href="{{ asset('assets/css/icons.css'.Config::get('app.assets_version')) }}" rel="stylesheet">
  </link>
  <link rel="stylesheet" href="{{ asset('cdn/fonts/font.min.css').Config::get('app.assets_version') }}">
  <!--plugins-->
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.css'.Config::get('app.assets_version')) }}" rel="stylesheet">
  </link>

  <!-- loader-->
  <link href="{{ asset('assets/css/pace.min.css'.Config::get('app.assets_version')) }}" rel="stylesheet">
  </link>


  <!-- Vendor Styles -->
  @yield('vendor-style')


  <!-- Page Styles -->
  @yield('page-style')
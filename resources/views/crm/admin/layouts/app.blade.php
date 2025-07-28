<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link href="{{ asset('assets/img/cloudcrm_favicon.png').Config::get('app.assets_version') }}" rel="icon">
    </link>

    <title> @yield('title') | CRM </title>
    <!-- Include Styles -->
    @include('crm.admin.layouts.sections.style')

</head>

<body>
    <!-- Header Content -->
    @include('crm.admin.layouts.sections.header.header')
    <!-- Navbar Content -->
    @include('crm.admin.layouts.sections.navbar.navbar')
    <!-- Layout Content -->
    @yield('content')
    <!--/ Layout Content -->

    <!-- Footer Content -->
    @include('crm.admin.layouts.sections.footer.footer')
    <!-- Include Scripts -->
    @include('crm.admin.layouts.sections.script')
</body>

</html>
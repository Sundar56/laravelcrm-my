 <!-- Bootstrap JS -->
 <script src="{{ asset('assets/js/bootstrap.bundle.min.js'.Config::get('app.assets_version')) }}"></script>
 <!--plugins-->
 <script src="{{ asset('assets/js/jquery.min.js'.Config::get('app.assets_version')) }}"></script>
 <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.js'.Config::get('app.assets_version')) }}"></script>
 <!--app JS-->
 <script src="{{ asset('assets/js/app.js'.Config::get('app.assets_version')) }}"></script>
 <script src="{{ asset('assets/js/pace.min.js'.Config::get('app.assets_version')) }}"></script>
 <script src="{{ asset('cdn/jquery-validate/jquery.validate.min.js').Config::get('app.assets_version') }}"></script>
 <script src="{{ asset('cdn/jquery-validate/additional-methods.min.js').Config::get('app.assets_version') }}"></script>
 <script src="{{ asset('assets/js/commonvalidate.js'.Config::get('app.assets_version')) }}"></script>
 <script src="{{asset('assets/js/custom.js'.Config::get('app.assets_version')) }}"></script>


 @yield('vendor-script')
 <!-- END: Page Vendor JS-->

 <!-- BEGIN: Page JS-->
 @yield('page-script')
 <!-- END: Page JS-->
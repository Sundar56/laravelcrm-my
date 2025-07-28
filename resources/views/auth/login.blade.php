<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <!--favicon-->
     <link href="{{ asset('assets/img/cloudcrm_favicon.png').Config::get('app.assets_version') }}" rel="icon">
    </link>
    <!-- loader-->
    <link href="{{ asset('assets/css/pace.min.css'.Config::get('app.assets_version')) }}" rel="stylesheet">
    </link>
    <script src="{{ asset('assets/js/pace.min.js'.Config::get('app.assets_version')) }}"></script>
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
    <title> Login | CRM </title>
</head>

<body class="">
    <!--wrapper-->
    <div class="wrapper">
        <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5 mx-auto">
                        <div class="card mb-0">
                            <div class="card-body py-5 px-4">
                                <div class="text-center">
                                    <div class="mb-4">
                                        <img src="{{ asset('assets/img/cloud-crm-logo.png'.Config::get('app.assets_version')) }}" class="logo-icon" alt="logo icon">
                                    </div>
                                    <h5 class="heading-text-md mb-4">Please log in to your account
                                    </h5>
                                    <div class="form-body text-start">
                                        <form action="{{ route('admin.login.user') }}" method="POST" id="loginForm" novalidate="novalidate">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="inputEmailAddress" class="form-label login-page">Email<span class="required-field"></span></label>
                                                <input type="text" class="form-control" id="inputEmailAddress" name="username" placeholder="Enter Username" value="{{ old('username', Cookie::get('remembered_user')) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputChoosePassword" class="form-label login-page">Password<span class="required-field"></span></label>
                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password" class="form-control border-end-0" id="inputChoosePassword" name="password" value="{{Cookie::get('remembered_pass')}}" placeholder="***********">
                                                    <span class="input-group-text bg-transparent"><i class="bx bx-hide"></i></span>
                                                </div>
                                            </div>

                                            <div class="mb-3 mt-0">
                                                @if ($errors->has('password'))
                                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>

                                            <div class="mb-4 row">
                                                <div class="col-md-6">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="remember" value="1" {{ Cookie::get('remembered_user') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 text-end"> <a href="{{ route('admin.forgotpassword') }}">Forgot Password ?</a>
                                                </div>
                                            </div>

                                            <div class="">
                                                <button type="submit" class="btn btn-primary w-100" id="submitSignin">Sign in</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>
    <!--end wrapper-->
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js'.Config::get('app.assets_version')) }}"></script>
    <!--plugins-->
    <script src="{{ asset('assets/js/jquery.min.js'.Config::get('app.assets_version')) }}"></script>
    <!--Password show & hide js -->
    <script>
        $(document).ready(function() {
            $("#show_hide_password span").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
    </script>
    <!--app JS-->
    <!-- <script src="assets/js/app.js"></script> -->
    <script src="{{ asset('cdn/jquery-validate/jquery.validate.min.js').Config::get('app.assets_version') }}"></script>
    <script src="{{ asset('cdn/jquery-validate/additional-methods.min.js').Config::get('app.assets_version') }}"></script>
    <script src="{{ asset('assets/js/commonvalidate.js'.Config::get('app.assets_version')) }}"></script>
    <script src="{{ asset('assets/js/app.js'.Config::get('app.assets_version')) }}"></script>
</body>

</html>
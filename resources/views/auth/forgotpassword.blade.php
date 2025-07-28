<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link href="{{ asset('assets/img/favicon-32x32.png'.Config::get('app.assets_version')) }}" rel="icon" type="image/png">
    </link>
    <!--plugins-->
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css'.Config::get('app.assets_version')) }}" rel="stylesheet">
    </link>
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css'.Config::get('app.assets_version')) }}" rel="stylesheet">
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
                <div class="row  row-cols-1 row-cols-md-2 row-cols-lg-3">
                    <div class="col mx-auto">
                        <div class="card mb-0">
                            <div class="card-body">
                                @if(session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif
                                <div class="p-6">
                                    <div class="mt-4 text-center">
                                    <img src="{{ asset('assets/img/cloud-crm-logo.png'.Config::get('app.assets_version')) }}" class="logo-icon" alt="logo icon">
                                    </div>
                                    <div class="text-center mb-2 mt-3">
                                        <p class="mb-0">Enter your registered email ID to reset the password</p>
                                    </div>
                                    <div class="form-body">
                                        <form class="row g-5" action="{{ route('admin.auth.email') }}" method="POST" id="forgotPassword">
                                            @csrf
                                            <div class="col-12">
                                                <label for="inputEmailAddress" class="form-label">Email<span class="required-field"></span></label>
                                                <input type="text" class="form-control" id="inputEmailAddress" name="username" placeholder="Enter Email">
                                            </div>
                                            <div class="col-12">
                                                <div class="d-grid gap-2">
                                                    <button type="submit" class="btn btn-primary">Send Email</button>
                                                    <a href="{{route('admin.login')}}" class="btn btn-light"><i class='bx bx-arrow-back me-1'></i>Back to Login</a>
                                                </div>
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
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js'.Config::get('app.assets_version')) }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js'.Config::get('app.assets_version')) }}"></script>
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
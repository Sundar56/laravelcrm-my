@extends('crm.admin.layouts.app')

@section('title', 'Admin User')

@section('vendor-style')
<!-- Vendor Styles -->
<link
    href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css' . Config::get('app.assets_version')) }}"
    rel="stylesheet">
</link>
<link
    href="{{ asset('assets/plugins/datatable/css/responsive.bootstrap5.css' . Config::get('app.assets_version')) }}"
    rel="stylesheet">
</link>
<link rel="stylesheet" href="{{asset('cdn/intlTelInput/intlTelInput.css').Config::get('app.assets_version') }}" />
@endsection

@section('vendor-script')
<script
    src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js' . Config::get('app.assets_version')) }}"></script>
<script
    src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js' . Config::get('app.assets_version')) }}"></script>
<script src="{{ asset('cdn/intlTelInput/intlTelInput.js').Config::get('app.assets_version') }}"></script>
<script src="{{ asset('cdn/jquery-mask/jquery.mask.js').Config::get('app.assets_version') }}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/adminuser.js' . Config::get('app.assets_version')) }}"></script>
@endsection

@section('content')
<!-- Responsive Datatable -->
<div class="page-wrapper">
    <div class="page-content">
        <nav aria-label="breadcrumb" class="pageTop">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('crm.dashboard') }}" class="text-secondary">Dashboard</a>
                </li>
                <i class="bx bx-chevron-right"></i>
                <li class="breadcrumb-item active" aria-current="page">Admin Users</li>
            </ol>
        </nav>
        <div class="card">
            <div class="row">
                <div class="col-12">
                    <div class="card-header flex-column flex-md-row">
                        <div class="d-flex justify-content-between align-items-center mt-2 mb-0">
                                <h6 class="card-title mb-0"><span class="me-1 fs-5"><i class="bx bx-user"></i></span>Admin Users List</h6>
                            <div class="text-end">
                                <button class="dt-button btn btn-thin border" data-bs-toggle="offcanvas"
                                    data-bs-target="#createAdminuser" type="button" id="createCompany">
                                    <span><i class="bx bx-plus"></i> <span
                                            class="d-none d-sm-inline-block">Add User</span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-container">
                            <div class="table-responsive card-datatable">
                                <table class="table dt-responsive datatable" id="adminuser_list_table"
                                    style="width:100%">
                                    <thead>
                                        <tr class="table-secondary">
                                            <th scope="col">ID</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Admin Type</th>
                                            <th scope="col">Password Reset</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Create Adminuser offcanvas-->
<div class="offcanvas offcanvas-end" tabindex="-1" id="createAdminuser" aria-labelledby="offcanvasTopLabel" style="width:600px;">
    <div class="offcanvas-header border-bottom">
        <h6 class="offcanvas-title d-flex align-items-center"><i class="bx bx-edit me-1 fs-5"></i><span class="pt-1">Add User</span></h6>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="userResgisterform" enctype="multipart/form-data">
            @csrf
            <div>
                <div class="row mb-4">
                    <h6 class="mb-3 body-text-lg neutral-200">User Details</h6>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <label class="form-label">Name<span class="required-field ms-1 text-danger" title="required">*</span></label>
                        <input type="text" class="form-control" name="name"
                            placeholder="Name" aria-label="Name" />
                    </div>
                    </div>
                <div class="row mb-4">
                    <h6 class="mb-3 body-text-lg neutral-200">User Contacts</h6>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label">Phone<span class="required-field ms-1 text-danger" title="required">*</span></label>
                        <input type="text" class="form-control phone-mask" name="user_phone"
                            id="userPhone" aria-label="Phone" />
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label">Email<span class="required-field ms-1 text-danger" title="required">*</span></label>
                        <input type="text" class="form-control" name="email" placeholder="Email"
                            aria-label="email" />
                    </div>
                </div>
                <div class="row mb-4">
                    <h6 class="mb-3 body-text-lg neutral-200">User Type</h6>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <label class="form-label">Select Type<span class="required-field ms-1 text-danger" title="required">*</span></label>
                        <select class="form-select" name="user_type">
                            <option value="" selected disabled>All Usertype</option>
                            @if(!$roles->isEmpty())
                            @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->display_name}}</option>
                            @endforeach
                            @else
                            <option>No data Available</option>
                            @endif
                        </select>                       
                    </div>
                    </div>
                    <div class="row mb-4">
                    <h6 class="mb-3 body-text-lg neutral-200">Block User</h6>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 form-check form-switch d-flex justify-content-between" id="toggleBlock">
                        <p class="ms-0">Toggle the button to block user</p>
                        <input class="form-check-input" type="checkbox" role="switch" name="is_blocked">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="text-end m-4">
        <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Close</button>
        <button type="button" class="btn btn-primary submitUserregisterForm">Save Details</button>
    </div>
</div>
<!--/ Reset Adminuser Password offcanvas-->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel" style="width:600px;">
    <div class="offcanvas-header border-bottom">
        <!-- <h6 class="offcanvas-title d-flex align-items-center"><i class="bx bx-lock-open-alt me-1 fs-5"></i><span class="pt-1">Reset Password</span></h6> -->
        <div class="offcanvas-title d-flex align-items-center gap-2">
            <span class="me-1 fs-5 neutral-100">
            <i class="bx bx-lock-open-alt "></i>
            </span>
            <h6 class="heading-text-lg m-0"> Reset Password</h6>

        </div>
        <button type="button" class="btn-close text-reset neutral-300" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="resetPasswordForm" enctype="multipart/form-data">
            @csrf
            <div class="d-flex align-items-start mb-4">
                <div class="resetpass-icon bg-opacity-10 reset-password-name-logo">
                    <i class="bx bx-user text-primary"></i>
                </div>
                <div class="ms-2">
                    <h6 class="m-0 heading-text-lg" id="userName"></h6>
                    <div class="d-flex align-items-center mt-1">
                        <span class="mb-0 text-secondary body-text" style="font-size:13px" id="userType"></span>
                        <span class="text-secondary ms-3 fs-6 d-flex align-items-center" id="userEmail">
                            <i class="bx bx-envelope" style="font-size: 16px;"></i>
                            <span id="emailText" class="body-text ms-1"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 mb-2">
                    <label class="form-label body-text-sm">Reset Password<span class="required-field ms-1 text-danger" title="required">*</span></label>
                    <div class="input-group rounded">
                        <input type="text" class="form-control border-end-0 reset-password-input" placeholder="New Password" id="reset_password" name="reset_password" maxlength="10">
                        <span class="input-group-text bg-transparent rounded-end copy-reset-password" id="copyButton" style="cursor: pointer;">
                            <i class="bx bx-copy" title="Copy"></i>
                        </span>
                        <button class="dt-button btn btn-primary ms-3 rounded resetUserPassword" type="button">
                            <span><i class="bx bx-revision"></i> <span class="d-none d-sm-inline-block body-text">Reset</span></span>
                        </button>
                    </div>
                </div>
                <input type="hidden" id="userId" />
            </div>
            <div class="row">
                <p class="mt-1 body-text">Note: The password will be mailed to user. Click the icon inside field to copy password</p>
            </div>
        </form>
    </div>
    <div class="text-end m-4">
        <button type="button" class="btn btn-light gray-bg-200" data-bs-dismiss="offcanvas">Close</button>
    </div>
</div>
<!-- Offcanvas for Viewing User Details -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="userDetailOffcanvas" aria-labelledby="userDetailOffcanvasLabel" style="width:600px;">
    <div class="offcanvas-header border-bottom mb-0">
        <h6 class="offcanvas-title" id="userDetailOffcanvasLabel">User Details</h6>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="editUserForm" enctype="multipart/form-data">
            @csrf
            <!-- Status: Blocked or Active -->
            <div class="mb-1 d-flex justify-content-between align-items-center">
                <div>
                    <input class="form-control border-0 ps-0 fw-medium fs-2 neutral-100" type="text" placeholder="" value="" id="Name" name="name" aria-label="default input example">
                    <p><span class="neutral-300">Admin userId is : </span><span id="admin_user_id" class="neutral-200"></span></p>
                </div>
                <div class="cursor-pointer addDeleteIcon">
                    <div class="font-22 deleteUser"> <i class='bx bx-trash'></i>
                    </div>
                </div>
            </div>
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center neutral-300">
                    <div class="font-22 mt-1">
                        <i class="bx bx-envelope"></i>
                    </div>
                    <div class="ms-2">
                        <span>Email</span>
                    </div>
                </div>
                <div>
                    <input class="form-control border-0 text-end me-2" type="text" placeholder="" value="" id="Email" name="email" aria-label="default input example">
                </div>
            </div>
            <div class="mb-2 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center neutral-300">
                    <div class="font-22 mt-1">
                        <i class="bx bx-phone"></i>
                    </div>
                    <div class="ms-2">
                        <span>Phone Number</span>
                    </div>
                </div>
                <div>
                    <input class="form-control border-0 text-end" type="text" placeholder="" value="" id="Phone" name="phone" aria-label="default input example">
                </div>
            </div>
            <div class="mb-2 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center neutral-300">
                    <div class="font-22 mt-1">
                        <i class="bx bx-purchase-tag"></i>
                    </div>
                    <div class="ms-2">
                        <span>User Type</span>
                    </div>
                </div>
                <div class="selectRole" id="selectRole">
                    <select name="rolesSelect" id="rolesSelect" class="form-select mb-2 mt-2" aria-label="Default select example">
                    </select>
                </div>
            </div>
            <div class="mb-2 d-flex justify-content-between align-items-center form-switch p-0">
                <div class="d-flex align-items-center neutral-300">
                    <span class="font-22 me-2 mt-1"><i class="bx bx-block"></i></span>
                    <span class="mt-1">Toggle the button to block user</span>
                </div>
                <input class="form-check-input" type="checkbox" role="switch" name="is_blocked" id="is_blocked">
            </div>

            <input type="hidden" value="user_id" id="userID" name="user_id" />
        </form>
    </div>
    <div class="text-end m-4">
        <button type="button" class="btn btn-light resetUserList">Reset</button>
        <button type="button" class="btn btn-primary UpdateUserregisterForm">Update</button>
    </div>
</div>
@endsection
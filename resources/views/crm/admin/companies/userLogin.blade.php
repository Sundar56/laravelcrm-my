<div class="table-container">
    <div class="row">
        <div class="col-12">
            <div class="flex-column flex-md-row mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="head-label text-left">
                        <h6 class="card-title mb-0">
                            <span class="me-1 fs-5"><i class="bx bx-user"></i></span>User List
                        </h6>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-thin border" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAdduser" aria-controls="offcanvasRight" type="button" id="createUser">
                            <span><i class="bx bx-plus"></i> <span class="d-none d-sm-inline-block">Add User</span></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table" id="user_login_table"
                    style="width:100%">
                    <thead>
                        <tr class="table-secondary">
                            <th scope="col">
                                <input type="checkbox" id="select-all" />
                            </th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">User Type</th>
                            <th scope="col">MFA</th>
                            <th scope="col">Status</th>
                            <th scope="col">Last Login</th>                         
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
<!-- Offcanvas for Add User Details -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAdduser" aria-labelledby="offcanvasRightLabel" style="width:600px;">
    <div class="offcanvas-header border-bottom mb-0">
        <!-- <h6 id="offcanvasRightLabel"><i class="bx bx-edit me-1"></i>Add User</h6> -->
        <div class="offcanvas-title d-flex align-items-center gap-2 ">
            <span class="fs-5 neutral-100">
                <i class="bx bx-edit"></i>
            </span>
            <h1 class="heading-text-lg m-0" id="offcanvasRightLabel">
                Add Company User
            </h1>
        </div>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="userLoginForm" enctype="multipart/form-data">
            @csrf
            <div>
                <div class="row mb-4">
                    <h6 class="mb-2 body-text-lg">User Image</h6>
                    <div class="col-12 mb-2">
                        <div class="d-flex align-items-start">
                            <div class="mb-1 mt-3">
                                <img class="preview-user-image-before-upload preview-img add-campany-logo-pre"
                                    src="{{asset('/assets/img/user.jpg')}}" alt="preview image">
                            </div>
                            <div class="ms-2 mt-3">
                                <div class="d-flex align-items-center mt-1 mb-1">
                                    <!-- Removed the input-group div -->
                                    <label for="user_image" class="btn border">
                                        <i class='bx bx-upload'></i> Upload Image
                                    </label>
                                    <input type="file" name="user_image" id="user_image" class="form-control" style="display: none;">
                                </div>
                                <span class="ms-1 body-text-sm neutral-300">Upload file size below 4MB</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <h6 class="mb-3 body-text-lg">User Details</h6>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label body-text-sm m-0 neutral-300">Name<span class="required-field ms-1 text-danger" title="required">*</span></label>
                        <input type="text" class="form-control" name="name"
                            placeholder="Name" aria-label="Name" />
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label body-text-sm m-0 neutral-300">Username<span class="required-field"></span></label>
                        <input type="text" class="form-control" name="username"
                            placeholder="Username" aria-label="Username" />
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label body-text-sm m-0 neutral-300">Email<span class="required-field ms-1 text-danger" title="required">*</span></label>
                        <input type="text" class="form-control" name="email" placeholder="Email"
                            aria-label="email" />
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label body-text-sm m-0 neutral-300">User Type<span class="required-field ms-1 text-danger" title="required">*</span></label>
                        <select class="form-select" name="user_type">
                            <option value="" selected disabled>All Users</option>
                            <option value="1">User</option>
                            <option value="2">Supervisor</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                <div class="col-12">
                    <h6 class="mb-3 body-text-lg p-0">SiteAccess</h6>
                    <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" value="1" role="switch" name="is_Enabled[]">
                            <label class="form-check-label">
                                SSO
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" value="1" role="switch" name="is_Enabled[]">
                            <label class="form-check-label">
                                CRM
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" value="1" role="switch" name="is_Enabled[]">
                            <label class="form-check-label">
                                CMS
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" value="1" role="switch" name="is_Enabled[]">
                            <label class="form-check-label">
                                SHOP
                            </label>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                <div class="col-12">
                    <span class="body-text-lg p-0 mb-3 d-flex">Block Company</span>
                    <div class="form-check form-switch d-flex justify-content-between p-0" id="toggleBlock">
                        <p class="ms-0 text-secondary">Block the user from accessing the dashboard</p>
                        <input class="form-check-input me-2 fs-6" type="checkbox" role="switch" name="is_blocked">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="company_id" value="{{Crypt::encrypt($company_details->id)}}" />
            </div>
        </form>
    </div>
    <div class="text-end m-4">
        <button type="button" class="btn btn-label-secondary bg-secondary text-dark bg-opacity-10 me-2" data-bs-dismiss="offcanvas">Cancel</button>
        <button type="button" class="btn btn-primary submitAdduserForm">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
            <span class="btn-text">Save Details</span>
        </button>
    </div>
</div>
<!-- Offcanvas for Add User Details -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEdituser" aria-labelledby="offcanvasRightLabel" style="width:600px;">
    <div class="offcanvas-header border-bottom mb-0">
        <h6 id="offcanvasRightLabel"><i class="bx bx-edit me-1"></i>Edit Company User</h6>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="editUserLoginForm" enctype="multipart/form-data">
            @csrf
            <div>
                <div class="row mb-4">
                    <h6 class="mb-2 body-text-lg">User Image</h6>
                    <div class="col-12 mb-2">
                        <div class="d-flex align-items-start">
                            <div class="mb-1 mt-3">
                                <img class="preview-user-image-after-upload preview-img add-campany-logo-pre"
                                    src="{{asset('/assets/img/user.jpg')}}" alt="preview image">
                            </div>
                            <div class="ms-2 mt-3">
                                <div class="d-flex align-items-center mt-1 mb-1">
                                    <!-- Removed the input-group div -->
                                    <label for="edit_image" class="btn border">
                                        <i class='bx bx-upload'></i> Upload Image
                                    </label>
                                    <input type="file" name="edit_user_image" id="edit_image" class="form-control" style="display: none;">
                                </div>
                                <span class="ms-1">Upload file size below 4MB</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <h6 class="mb-3 body-text-lg">User Details</h6>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label">Name<span class="required-field"></span></label>
                        <input type="text" class="form-control" name="name"
                            placeholder="Name" aria-label="Name" />
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label">Username<span class="required-field"></span></label>
                        <input type="text" class="form-control" name="username"
                            placeholder="Username" aria-label="Username" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" placeholder="Email"
                            aria-label="email" />
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label">User Type<span class="required-field"></span></label>
                        <select class="form-select" name="user_type">
                            <option value="" selected disabled>All Users</option>
                            <option value="1">User</option>
                            <option value="2">Supervisor</option>
                        </select>
                    </div>
                </div>
                <!-- <div class="mb-3 d-flex align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-block text-info fs-5 me-2"></i>
                        <span>Status</span>
                    </div>
                    <span class="text-end ms-auto form-switch">
                        <input type="checkbox" role="switch" class="form-check-input" name="status" value="1" />
                    </span> -->

                    <div class="row mt-3">
                    <div class="col-12">
                        <span class="body-text-lg p-0 mb-3 d-flex">Block Company</span>
                        <div class=" form-check form-switch d-flex justify-content-between p-0" id="toggleBlock">
                            <p class="ms-0 text-secondary">Block the user from accessing the dashboard</p>
                            <input class="form-check-input me-2 fs-6" type="checkbox" name="status" role="switch" value="1">
                        </div>
                    </div>
                </div>
                <!-- <div class="row mb-3">
                    <h6 class="mb-3 body-text-lg">SiteAccess</h6>
                    <div class="col-md-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" value="1" id="checkbox1" role="switch" name="is_Enabled[]">
                            <label class="form-check-label" for="checkbox1">
                                SSO
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" value="1" id="checkbox2" role="switch" name="is_Enabled[]">
                            <label class="form-check-label" for="checkbox2">
                                CRM
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" value="1" id="checkbox3" role="switch" name="is_Enabled[]">
                            <label class="form-check-label" for="checkbox3">
                                CMS
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" value="1" id="checkbox4" role="switch" name="is_Enabled[]">
                            <label class="form-check-label" for="checkbox4">
                                SHOP
                            </label>
                        </div>
                    </div>
                </div> -->
                <input type="hidden" name="company_id" value="{{Crypt::encrypt($company_details->id)}}" />
                <input type="hidden" name="user_id" value="" />
            </div>
        </form>
    </div>
    <div class="text-end m-4">
        <button type="button" class="btn btn-label-secondary bg-secondary text-dark bg-opacity-10" data-bs-dismiss="offcanvas">Cancel</button>
        <button type="button" class="btn btn-primary submitEdituserForm">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
            <span class="btn-text">Update</span>
        </button>
    </div>
</div>
<!-- Offcanvas for Viewing User Details -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="userLoginOffcanvas" aria-labelledby="userDetailOffcanvasLabel" style="width:600px;">
    <div class="offcanvas-header border-bottom mb-0">
        <h6 class="offcanvas-title" id="userDetailOffcanvasLabel">User Details</h6>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <!-- Status: Blocked or Active -->
        <h6 id="userStatus" class="badge bg-light-danger d-none"><i class="bx bx-block"></i> Blocked</h6>
        <h6 id="userStatusActive" class="badge bg-light-success d-none"><i class="bx bx-check-circle"></i> Active</h6>

        <!-- User Details -->
        <h5 id="Name"></h5>
        <p>Admin userId is: <span id="userId"></span></p>

        <!-- Flexbox to align icons and text on the same line -->
        <div class="mb-3 d-flex align-items-center">
            <div class="d-flex align-items-center">
                <i class="bx bx-envelope text-info fs-5 me-2"></i>
                <span>Email</span>
            </div>
            <span class="text-end ms-auto" id="Email"></span>
        </div>
        <div class="mb-3 d-flex align-items-center">
            <div class="d-flex align-items-center">
                <i class="bx bx-purchase-tag-alt text-info fs-5 me-2"></i>
                <span>User Type</span>
            </div>
            <span class="text-end ms-auto" id="Type"></span>
        </div>
        <div class="mb-3 d-flex align-items-center">
            <div class="d-flex align-items-center">
                <i class="bx bx-block text-info fs-5 me-2"></i>
                <span>Status</span>
            </div>
            <span class="text-end ms-auto form-switch">
                <input type="checkbox" role="switch" class="form-check-input" id="userStatusSwitch" />
            </span>
        </div>
    </div>
    <div class="text-end m-4">
        <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Close</button>
    </div>
</div>
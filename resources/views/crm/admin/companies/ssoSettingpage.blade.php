<div class="table-container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="head-label text-left">
                        <h6 class="offcanvas-title d-flex align-items-center heading-text">
                            <span class="me-1 fs-5"><i class="bx bx-cog"></i></span>
                            <span class="pt-1">SSO Settings</span>
                        </h6>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <!-- Account Settings Column -->
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3 border-end">
                    <span class="mb-3 heading-text">Application Settings</span>
                    <div class="row mt-3">
                        <span class="fw-medium mb-2">CRM Setting</span>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 form-check form-switch d-flex justify-content-between" id="toggleBlock">
                            <p class="ms-0 text-secondary">Activate the CRM Settings</p>
                            <input class="form-check-input me-2 fs-6" type="checkbox" role="switch" name="is_blocked">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <span class="fw-medium mb-2">CMS Setting</span>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 form-check form-switch d-flex justify-content-between" id="toggleBlock">
                            <p class="ms-0 text-secondary">Activate the CMS Settings</p>
                            <input class="form-check-input me-2 fs-6" type="checkbox" role="switch" name="is_blocked">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <span class="fw-medium mb-2">SHOP Setting</span>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 form-check form-switch d-flex justify-content-between" id="toggleBlock">
                            <p class="ms-0 text-secondary">Activate the SHOP Settings</p>
                            <input class="form-check-input me-2 fs-6" type="checkbox" role="switch" name="is_blocked">
                        </div>
                    </div>
                </div>
                <!-- Login Access Settings Column -->
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3 ms-md-2">
                    <span class="ms-0 heading-text">Login Access Settings</span>
                    <div class="d-flex align-items-start mt-3">
                        <div class="mt-1">
                            <img src="{{ asset('assets/img/Microsoft_logo.svg'.Config::get('app.assets_version')) }}" class="logo-icon" alt="logo icon" style="width:45px">
                        </div>
                        <div class="ms-3 flex-grow-1 mt-1">
                            <span class="m-0 fw-medium">Microsoft</span>
                            <div class="d-flex align-items-center mt-1">
                                <span class="mb-0 text-secondary me-5">Activate login using Microsoft ID</span>
                                <span class="text-secondary ms-3 fs-6 d-flex align-items-center ms-auto">
                                    <span class="form-check form-switch ms-3">
                                        <input class="form-check-input" type="checkbox" role="switch" name="is_blocked">
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mt-4">
                        <div class="mt-2">
                            <img src="{{ asset('assets/img/Google_logo.svg'.Config::get('app.assets_version')) }}" class="logo-icon" alt="logo icon" style="width:45px">
                        </div>
                        <div class="ms-3 flex-grow-1 mt-2">
                            <span class="m-0 fw-medium">Google</span>
                            <div class="d-flex align-items-center mt-1">
                                <span class="mb-0 text-secondary me-5">Activate login using Google ID</span>
                                <span class="text-secondary ms-3 fs-6 d-flex align-items-center ms-auto">
                                    <span class="form-check form-switch ms-3">
                                        <input class="form-check-input" type="checkbox" role="switch" name="is_blocked">
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!--/ Edit Company Offcanvas-->
<div class="offcanvas offcanvas-end" tabindex="-1" id="EditCompanyOffcanvas" aria-labelledby="offcanvasTopLabel" style="width:600px;">
    <div class="offcanvas-header border-bottom">
        <div class="offcanvas-title d-flex align-items-center gap-2">
            <span class="fs-5 neutral-100">
                <i class="bx bx-edit"></i>
            </span>
            <h1 class="heading-text-lg m-0">
                Edit Company
            </h1>
        </div>
        <button type="button" class="btn-close text-reset neutral-300" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="editcompanyInfoForm" enctype="multipart/form-data">
            @csrf
            <div>
                <div class="row mb-2">
                    <h6 class="mb-3 body-text-lg neutral-200">Company Details</h6>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                        <label class="form-label body-text-sm m-0 neutral-300">Company Name<span class="required-field ms-1 text-danger" title="required">*</span></label>
                        <input type="text" class="form-control" id="company_name" name="company_name"
                            placeholder="Company name" aria-label="Company name" />
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                        <label class="form-label body-text-sm m-0 neutral-300">ID</label>
                        <input type="text" class="form-control" name="company_id" placeholder="ID"
                            aria-label="ID" />
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                        <label class="form-label body-text-sm m-0 neutral-300">VAT ID</label>
                        <input type="text" class="form-control" name="vat_id" placeholder="VAT ID"
                            aria-label="VAT ID" />
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                        <label class="form-label body-text-sm m-0 neutral-300">EAN Number<span class="required-field"></span></label>
                        <input type="text" class="form-control" id="ean_number" name="ean_number"
                            placeholder="EAN Number" aria-label="EAN Number" />
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label body-text-sm m-0 neutral-300">Company Description</label>
                        <textarea class="form-control h-px-100 " name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="row mb-2">
                    <h6 class="mb-3 body-text-lg neutral-200">Company Contacts</h6>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                        <label class="form-label body-text-sm m-0 neutral-300">Company Phone<span class="required-field ms-1 text-danger" title="required">*</span></label>
                        <input type="text" class="form-control" id="editCompanyphone" name="company_phone"
                            placeholder="Company Phone" aria-label="Company Phone" />
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                        <label class="form-label body-text-sm m-0 neutral-300">Invoice Email<span class="required-field ms-1 text-danger" title="required">*</span></label>
                        <input type="email" class="form-control" name="invoice_email" id="invoice_email"
                            placeholder="Invoice Email" aria-label="Invoice Email" />
                    </div>
                </div>
                <div class="row mb-2">
                    <h6 class="mb-3 body-text-lg neutral-200">Company Address</h6>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                        <label class="form-label body-text-sm m-0 neutral-300">Address<span class="required-field"></span></label>
                        <input type="text" class="form-control" name="address" placeholder="Address"
                            aria-label="Address" />
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                        <label class="form-label body-text-sm m-0 neutral-300">Zipcode<span class="required-field"></span></label>
                        <input type="text" class="form-control" name="zipcode" placeholder="Zipcode"
                            aria-label="Zipcode" />
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                        <label class="form-label body-text-sm m-0 neutral-300">City<span class="required-field"></span></label>
                        <input type="text" class="form-control" name="city" placeholder="City" aria-label="City" />
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                        <label class="form-label body-text-sm m-0 neutral-300">Country<span class="required-field"></span></label>
                        <input type="text" class="form-control" name="country" placeholder="Country"
                            aria-label="Country" />
                    </div>
                </div>
                <div class="row mb-3">
                    <h6 class="mb-2 body-text-lg neutral-200">Block Company</h6>
                    <div class="col-12 d-flex justify-content-between align-items-center form-check form-switch" id="toggleBlock">
                        <p class="mb-0 body-text-sm neutral-300">Toggle the button to block company</p>
                        <input class="form-check-input" type="checkbox" role="switch" name="is_blocked">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class=" d-flex mb-2">
                        <h6 class="mb-2 body-text-lg neutral-200 flex-shrink-0">Company Banner</h6>
                        <span class="img-error-msg ms-1">( 1920px * 1080 px or greater & banner image format jpeg, webp)</span>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-2">
                        <div class="input-group hide-banner-img">
                            <input type="file" name="company_banner" id="edit_company_banner" class="form-control">
                        </div>
                        <div class="mb-2 text-center upload-company-banner ratio">
                            <img class="preview-edit-banner-before-upload preview-img"
                                src="{{asset('/assets/img/company.jpg')}}" alt="preview image">
                            <div class="upload-camera-icon" id="edit_upload_camera_icon">
                                <i class='bx bx-camera'></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class=" d-flex mb-2">
                        <h6 class="mb-2 body-text-lg neutral-200 flex-shrink-0">Company Logo</h6>
                        <span class="img-error-msg ms-1">( 500px X * 500px or greater & logo image format png, jpeg, svg)</span>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-2">
                        <div class="d-flex align-items-center">
                            <div class="ms-1 mb-1">
                                <img class="preview-edit-image-before-upload preview-img add-campany-logo-pre"
                                    src="{{asset('/assets/img/company.png')}}" alt="preview image">
                            </div>
                            <div class="ms-2">
                                <div class="d-flex align-items-center mt-1 mb-1">
                                    <!-- Removed the input-group div -->
                                    <label for="edit_company_logo" class="btn border">
                                        <i class='bx bx-upload'></i> Upload Image
                                    </label>
                                    <input type="file" name="company_logo" id="edit_company_logo" class="form-control" style="display: none;">
                                </div>
                                <span class="ms-1 body-text-sm neutral-300">Upload file size below 4MB</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" class="form-control" name="c_id" />
        </form>
    </div>
    <div class="text-end m-4">
        <button type="button" class="btn bg-secondary text-dark bg-opacity-10 me-2 body-text" data-bs-dismiss="offcanvas">Cancel</button>
        <!-- Button with spinner -->
        <button type="button" class="btn btn-primary UpdateCompanyInfoForm">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
            <span class="btn-text body-text">Save Details</span>
        </button>
    </div>
</div>
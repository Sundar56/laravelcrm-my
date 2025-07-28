<div class="table-container">
    <div class="row">
        <div class="col-12">
            <div class=" flex-column flex-md-row">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="head-label text-left">
                        <h6 class="d-flex align-items-center">
                            <span class="me-1 fs-5"><i class="bx bx-network-chart"></i></span><span class="pt-1">General Settings</span>
                        </h6>                  
                    </div>
                </div>
            </div>
            <div class="table-responsive mt-3">
                <table class="table" id="sso_settings_table"
                    style="width:100%">
                    <thead>
                        <tr class="table-secondary">
                            <th scope="col">Variable</th>
                            <th scope="col">Value</th>
                            <th scope="col">Description </th>
                            <th scope="col">Type </th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
<!--/ Edit SSo Settings-->
<!-- <div class="modal modal-top fade left-to-right rounded" id="EditSsoSettingsyModal" tabindex="-1">
    <div class="modal-dialog  modal-lg modal-custom-width">
        <div class="modal-content" style="height:100vh">
            <form class="" id="ssoSettingEditModel">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTopTitle">Edit Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <label class="form-label">Variable<span class="required-field"></span></label>
                            <input type="text" class="form-control form-control-sm" name="sso_variable_name"
                                placeholder="Enter Variable" aria-label="Variable name" />
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <label class="form-label">Value<span class="required-field"></span></label>
                            <input type="text" class="form-control form-control-sm" name="sso_value_name"
                                placeholder="Enter Value" aria-label="Value name" />
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <label class="form-label">Description<span class="required-field"></span></label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name = "sso_description_name" rows="3"></textarea>
                        </div>
                        <input type="hidden" value="" name="sso_id"/>
                        <input type="hidden" value="" name="company_id"/>
                    </div>
                </div>
              
            </form>
            <div class="modal-footer text-end d-block sso-edit-save-bt" >
                    <button type="button" class="btn btn-label-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm UpdateSsoSettingsForm">Save Settings</button>
            </div>
        </div>
    </div> 
</div>-->
<!-- Edit the Crm preveliges -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="ssoUpdateOffcanvasRight" aria-labelledby="offcanvasRightLabel" style="width:auto;">
    <div class="offcanvas-header border-bottom">
        <!-- <h5 class="offcanvas-title" id="">Edit Settings</h5> -->
        <div class="offcanvas-title d-flex align-items-center gap-2 ">
        <span class="fs-5 neutral-100">
                <i class="bx bx-edit"></i>
            </span>
            <h1 class="heading-text-lg m-0">
            Edit General Settings
            </h1>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form class="" id="ssoSettingEditModel">
            @csrf
            <div class="row g-2">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <label class="form-label body-text-sm m-0 neutral-300">Variable<span class="required-field"></span></label>
                    <input type="text" class="form-control" name="sso_variable_name"
                        placeholder="Enter Variable" aria-label="Variable name" />
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <label class="form-label body-text-sm m-0 neutral-300">Value<span class="required-field"></span></label>
                    <input type="text" class="form-control" name="sso_value_name"
                        placeholder="Enter Value" aria-label="Value name" />
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <label class="form-label body-text-sm m-0 neutral-300">Description<span class="required-field"></span></label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" name="sso_description_name" rows="3"></textarea>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-3">
                    <label class="form-label body-text-sm m-0 neutral-300 me-2">Type<span class="required-field"></span></label>
                    <select class="form-select form-select-sm" name="company_type" style="width: 40%;display: inline-block;">
                        @foreach($types as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" value="" name="sso_id" />
                <input type="hidden" value="" name="company_id" />
            </div>
            <div class="modal-footer text-end d-block sso-edit-save-bt d-flex gap-3">
                <button type="button" class="btn btn-label-secondary btn-light gray-bg-200" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary UpdateSsoSettingsForm">Save Settings</button>
            </div>

        </form>
    </div>
</div>
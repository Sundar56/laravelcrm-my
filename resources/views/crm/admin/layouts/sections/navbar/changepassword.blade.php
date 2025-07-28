<div class="modal modal-right fade" id="changePassModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" id="changePasswordForm" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h6 class="modal-title d-flex align-items-center" id="modalTopTitle"><i class="bx bx-edit me-1 fs-5"></i><span class="pt-1">Change Password</span></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;" id="errorAlert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" name="auth_id" value="{{Auth::user()->id}}" />
                <div class="row">
                    <div class="col-12 mb-2">
                        <label class="form-label">Old Password<span class="required-field ms-1 text-danger" title="required">*</span></label>
                        <input type="password" class="form-control" name="old_password" id="oldPassword" placeholder="Old Password">
                        <i class="bx bx-low-vision toggle-password fs-6" id="toggleOldPwd" style="cursor: pointer; position: absolute; right: 35px; top: 17%;"></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2">
                        <label class="form-label">New Password<span class="required-field ms-1 text-danger" title="required">*</span></label>
                        <input type="password" class="form-control" name="new_password" id="newPassword" placeholder="New Password">
                        <i class="bx bx-low-vision toggle-password fs-6" id="toggleNewPwd" style="cursor: pointer; position: absolute; right: 35px; top: 40%;"></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2">
                        <label class="form-label">Confirm Password<span class="required-field ms-1 text-danger" title="required">*</span></label>
                        <input type="password" class="form-control" name="confirm_password" id="confirmPassword" placeholder="Confirm Password">
                        <i class="bx bx-low-vision toggle-password fs-6" id="toggleConfirmPwd" style="cursor: pointer; position: absolute; right: 35px; top: 63%;"></i>
                    </div>
                </div>
                <div class="text-end d-block mt-3">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" id="submitChangePassword">Change</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .toggle-password {
        color: #6c757d;
        /* Default Bootstrap text color */
    }

    .toggle-password:hover {
        color: black;
        /* Change color on hover */
    }
</style>
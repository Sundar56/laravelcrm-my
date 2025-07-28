(function () {
    $('#changePassModal').on('hidden.bs.modal', function (e) {
        $(this).find('form').trigger('reset');
        $(this).find('input[name="old_password"]').attr("placeholder", "Old Password ").removeClass('validation');
        $(this).find('input[name="new_password"]').attr("placeholder", "New Password").removeClass('validation');
        $(this).find('input[name="confirm_password"]').attr("placeholder", "Confirm Password").removeClass('validation');
    });
    

    //change password
    $('body').on('click', '#submitChangePassword', function (e) {
        e.preventDefault(); // Prevent default button behavior

        if ($("#changePasswordForm").valid()) {
            var formData = new FormData(document.getElementById("changePasswordForm"));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/crm/changepassword",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        $('#changePassModal').modal('hide');
                        Swal.fire({
                            title: "Good job!",
                            text: response.success,
                            icon: "success",
                            button: "Ok",
                        });
                    }
                },
                error: function (response) {
                   
                    if (response.old_password) {
                        // Display validation errors
                        $.each(response.responseJSON.error, function (key, value) {
                            $('#' + key).attr('placeholder', value).addClass('validation');
                        });
                    } else if (response.responseJSON.old_password) {
                        // Display specific error for old password mismatch
                        $('#oldPassword').attr('placeholder', response.responseJSON.old_password).addClass('validation');
                    }
                }
            });
        }
    });

    $('#toggleOldPwd').on('click', function () {
        const newPwdField = $('#oldPassword');
        const icon = $(this);
        if (newPwdField.attr('type') === 'password') {
            newPwdField.attr('type', 'text');
            icon.removeClass('bx bx-low-vision').addClass('bx bx-show-alt');
        } else {
            newPwdField.attr('type', 'password');
            icon.removeClass('bx bx-show-alt').addClass('bx bx-low-vision');
        }
    });
    $('#toggleNewPwd').on('click', function () {
        const newPwdField = $('#newPassword');
        const icon = $(this);
        if (newPwdField.attr('type') === 'password') {
            newPwdField.attr('type', 'text');
            icon.removeClass('bx bx-low-vision').addClass('bx bx-show-alt');
        } else {
            newPwdField.attr('type', 'password');
            icon.removeClass('bx bx-show-alt').addClass('bx bx-low-vision');
        }
    });
    $('#toggleConfirmPwd').on('click', function () {
        const confirmPwdField = $('#confirmPassword');
        const icon = $(this);
        if (confirmPwdField.attr('type') === 'password') {
            confirmPwdField.attr('type', 'text');
            icon.removeClass('bx bx-low-vision').addClass('bx bx-show-alt');
        } else {
            confirmPwdField.attr('type', 'password');
            icon.removeClass('bx bx-show-alt').addClass('bx bx-low-vision');
        }
    });
    //change password end

})();

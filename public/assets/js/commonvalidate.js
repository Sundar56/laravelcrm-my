(function () {
    //Create Login validation
    var loginFormValidator = {
        rules: {
            username: {
                required: true,
                email: true,
            },
            password: {
                required: true,
            },
        },
        messages: {
            username: {
                required: "Username required",
                email: "Must be a valid email",
            },
            password: {
                required: "Password required",
            },
        },
        highlight: function (element) {
            $(element).addClass('validation');
            $(element).next('span').addClass('validation');
        },
        unhighlight: function (element) {
            $(element).removeClass('validation');
            $(element).next('span').removeClass('validation');
        },
        errorPlacement: function (error, element) {
            // Set the error message as the input's placeholder
            element.attr("placeholder", error.text()).addClass('validation');
            element.next('span').addClass('validation');
        },
        debug: false,
        submitHandler: function (form) {
            form.submit();
        }
    };
    $("#loginForm").validate(loginFormValidator);

    //validation for change password
    var changePasswordValidator = {
        rules: {
            old_password: {
                required: true,
            },
            new_password: {
                required: true,
                minlength: 5,
                notEqual: "#oldPassword"
            },
            confirm_password: {
                required: true,
                equalTo: "#newPassword"
            },
        },
        messages: {
            old_password: {
                required: "Old password required",
            },
            new_password: {
                required: "New password required",
                minlength: "New password must be at least 5 characters.",
                notEqual: "New password cannot be the same as old password."
            },
            confirm_password: {
                required: "Confirm password required",
                equalTo: "Confirm password must match the new password."
            },
        },
        highlight: function (element) {
            $(element).addClass('validation');
            $(element).next('span').addClass('validation');
        },
        unhighlight: function (element) {
            $(element).removeClass('validation');
            $(element).next('span').removeClass('validation');
        },
        errorPlacement: function (error, element) {
            element.attr("placeholder", error.text()).addClass('validation');
            element.next('span').addClass('validation');
        },
        debug: false,
        submitHandler: function (form) {
            // Custom logic can be added here if needed before submitting
            form.submit();
        }
    };
    // Custom method to check if two passwords are equal
    $.validator.addMethod("notEqual", function (value, element, param) {
        return this.optional(element) || value !== $(param).val();
    });
    $("#changePasswordForm").validate(changePasswordValidator);

    //Create Company validation
    var companyFormValidator = {
        rules: {
            company_name: {
                required: true,

            },
            invoice_email: {
                required: true,
                email: true,

            },
            company_phone: {
                required: true
            }
        },
        messages: {
            company_name: {
                required: "Company name required",
            },
            invoice_email: {
                required: "Invoice Email required",
                email: "Must be a valid email",
            },
            company_phone: {
                required: "Phone number required"
            }
        },
        highlight: function (element) {
            // add a class "errorClass" to the element
            $(element).addClass('validation');
            // $(element).next('span').addClass('validation');
        },
        unhighlight: function (element) {
            // class "errorClass" remove from the element
            $(element).removeClass('validation');
            // $(element).next('span').removeClass('validation');
        },
        errorPlacement: function (error, element) {
            element.attr("placeholder", error.text()).addClass("validation");
            $(element).next('span').addClass('validation');
        },
        debug: false,
        submitHandler: function (form) {
            form.submit();
        }
    };
    $("#companyInfoForm").validate(companyFormValidator);

    //Edit Company validation
    var companyEditFormValidator = {
        rules: {
            company_name: {
                required: true,
            },
            invoice_email: {
                required: true,
                email: true,
            },
            company_phone: {
                required: true
            }
        },
        messages: {
            company_name: {
                required: "Company name required",
            },
            invoice_email: {
                required: "Invoice Email required",
                email: "Must be a valid email",
            },
            company_phone: {
                required: "Phone number required"
            }
        },
        highlight: function (element) {
            // add a class "errorClass" to the element
            $(element).addClass('validation');
            // $(element).next('span').addClass('validation');
        },
        unhighlight: function (element) {
            // class "errorClass" remove from the element
            $(element).removeClass('validation');
            // $(element).next('span').removeClass('validation');
        },
        errorPlacement: function (error, element) {
            //element.val(error[0].outerText);
            console.log('error', error.text());
            element.attr("placeholder", error.text()).addClass("validation");
            $(element).next('span').addClass('validation');
        },
        debug: false,
        submitHandler: function (form) {
            form.submit();
        }
    };
    $("#editcompanyInfoForm").validate(companyEditFormValidator);

    //Create Roles validation
    var rolesFormValidator = {
        rules: {
            role: {
                required: true,
            },
        },
        messages: {
            role: {
                required: "Role name required",
            },
        },
        highlight: function (element) {
            $(element).addClass('validation');
            // $(element).next('span').addClass('validation');
        },
        unhighlight: function (element) {
            $(element).removeClass('validation');
            // $(element).next('span').removeClass('validation');
        },
        errorPlacement: function (error, element) {
            // Set the error message as the input's placeholder
            element.attr("placeholder", error.text()).addClass('validation');
            element.next('span').addClass('validation');
        },
        debug: false,
        submitHandler: function (form) {
            form.submit();
        }
    };
    $("#roleregisterForm").validate(rolesFormValidator);
    //Create Roles validation
    var cmsRolesFormValidator = {
        rules: {
            cms_role: {
                required: true,
            },
        },
        messages: {
            cms_role: {
                required: "Role name required",
            },
        },
        highlight: function (element) {
            $(element).addClass('validation');
            // $(element).next('span').addClass('validation');
        },
        unhighlight: function (element) {
            $(element).removeClass('validation');
            // $(element).next('span').removeClass('validation');
        },
        errorPlacement: function (error, element) {
            // Set the error message as the input's placeholder
            element.attr("placeholder", error.text()).addClass('validation');
            element.next('span').addClass('validation');
        },
        debug: false,
        submitHandler: function (form) {
            form.submit();
        }
    };
    $("#CmsroleregisterForm").validate(cmsRolesFormValidator);

    //Cms role validate during edit the role and priviliges
    var cmsUpdateRolesFormValidator = {
        rules: {
            cms_update_role: {
                required: true,
            },
        },
        messages: {
            cms_update_role: {
                required: "Role name required",
            },
        },
        highlight: function (element) {
            $(element).addClass('validation');
            // $(element).next('span').addClass('validation');
        },
        unhighlight: function (element) {
            $(element).removeClass('validation');
            // $(element).next('span').removeClass('validation');
        },
        errorPlacement: function (error, element) {
            // Set the error message as the input's placeholder
            element.attr("placeholder", error.text()).addClass('validation');
            element.next('span').addClass('validation');
        },
        debug: false,
        submitHandler: function (form) {
            form.submit();
        }
    };
    $("#update_Cms_roleregisterForm").validate(cmsUpdateRolesFormValidator);

    //Crm role validate during edit the role and priviliges
    var crmUpdateRolesFormValidator = {
        rules: {
            update_role: {
                required: true,
            },
        },
        messages: {
            update_role: {
                required: "Role name required",
            },
        },
        highlight: function (element) {
            $(element).addClass('validation');
            // $(element).next('span').addClass('validation');
        },
        unhighlight: function (element) {
            $(element).removeClass('validation');
            // $(element).next('span').removeClass('validation');
        },
        errorPlacement: function (error, element) {
            // Set the error message as the input's placeholder
            element.attr("placeholder", error.text()).addClass('validation');
            element.next('span').addClass('validation');
        },
        debug: false,
        submitHandler: function (form) {
            form.submit();
        }
    };
    $("#update_Crm_roleregisterForm").validate(crmUpdateRolesFormValidator);

    //sso settings validation during the update
    var ssoSettingsUpdateFormValidator = {
        rules: {
            sso_variable_name: {
                required: true,
            },
        },
        messages: {
            update_role: {
                required: "Variable name required",
            },
        },
        highlight: function (element) {
            $(element).addClass('validation');
            // $(element).next('span').addClass('validation');
        },
        unhighlight: function (element) {
            $(element).removeClass('validation');
            // $(element).next('span').removeClass('validation');
        },
        errorPlacement: function (error, element) {
            // Set the error message as the input's placeholder
            element.attr("placeholder", error.text()).addClass('validation');
            element.next('span').addClass('validation');
        },
        debug: false,
        submitHandler: function (form) {
            form.submit();
        }
    };
    $("#ssoSettingEditModel").validate(ssoSettingsUpdateFormValidator);

    //Create Admin user validation
    var userFormValidator = {
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
            user_phone: {
                required: true
            },
            user_type: {
                required: true
            }
        },
        messages: {
            name: {
                required: "User name required",
            },
            email: {
                required: "Email required",
                email: "Must be a valid email",
            },
            user_phone: {
                required: "Phone number required"
            },
            user_type: {
                required: "Select Usertype"
            }
        },
        highlight: function (element) {
            // add a class "errorClass" to the element
            $(element).addClass('validation');
            // $(element).next('span').addClass('validation');
        },
        unhighlight: function (element) {
            // class "errorClass" remove from the element
            $(element).removeClass('validation');
            // $(element).next('span').removeClass('validation');
        },
        errorPlacement: function (error, element) {
            element.attr("placeholder", error.text()).addClass("validation");
            $(element).next('span').addClass('validation');
        },
        debug: false,
        submitHandler: function (form) {
            form.submit();
        }
    };
    $("#userResgisterform").validate(userFormValidator);

    //Edit Admin user validation
    var editUserFormValidator = {
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
            phone: {
                required: true
            },
            rolesSelect: {
                required: true
            }
        },
        messages: {
            name: {
                required: "User name required",
            },
            email: {
                required: "Email required",
                email: "Must be a valid email",
            },
            phone: {
                required: "Phone number required"
            },
            rolesSelect: {
                required: "Select Usertype"
            }
        },
        highlight: function (element) {
            // add a class "errorClass" to the element
            $(element).addClass('validation');
            // $(element).next('span').addClass('validation');
        },
        unhighlight: function (element) {
            // class "errorClass" remove from the element
            $(element).removeClass('validation');
            // $(element).next('span').removeClass('validation');
        },
        errorPlacement: function (error, element) {
            element.attr("placeholder", error.text()).addClass("validation");
            $(element).next('span').addClass('validation');
        },
        debug: false,
        submitHandler: function (form) {
            form.submit();
        }
    };
    $("#editUserForm").validate(editUserFormValidator);

    //Create User for company validation
    var UserLoginFormValidator = {
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
        },
        messages: {
            name: {
                required: "Username required",
            },
            email: {
                required: "Email required",
                email: "Must be a valid email",
            },
        },
        highlight: function (element) {
            $(element).addClass('validation');
        },
        unhighlight: function (element) {
            $(element).removeClass('validation');
        },
        errorPlacement: function (error, element) {
            element.attr("placeholder", error.text()).addClass("validation");
            $(element).next('span').addClass('validation');
        },
        debug: false,
        submitHandler: function (form) {
            form.submit();
        }
    };
    $("#userLoginForm").validate(UserLoginFormValidator);

    //Edit User for company validation
    var EditUserloginFormValidator = {
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
        },
        messages: {
            name: {
                required: "Username required",
            },
            email: {
                required: "Email required",
                email: "Must be a valid email",
            },
        },
        highlight: function (element) {
            $(element).addClass('validation');
        },
        unhighlight: function (element) {
            $(element).removeClass('validation');
        },
        errorPlacement: function (error, element) {
            element.attr("placeholder", error.text()).addClass("validation");
            $(element).next('span').addClass('validation');
        },
        debug: false,
        submitHandler: function (form) {
            form.submit();
        }
    };
    $("#editUserLoginForm").validate(EditUserloginFormValidator);

    //Forgot passowrd validation
    var forgotpasswordValidator = {
        rules: {
            username: {
                required: true,
            },
        },
        messages: {
            username: {
                required: "Username / Email required",
            },
        },
        highlight: function (element) {
            // add a class "errorClass" to the element
            $(element).addClass('validation');
            // $(element).next('span').addClass('validation');
        },
        unhighlight: function (element) {
            // class "errorClass" remove from the element
            $(element).removeClass('validation');
            // $(element).next('span').removeClass('validation');
        },
        errorPlacement: function (error, element) {
            element.attr("placeholder", error.text()).addClass("validation");
            $(element).next('span').addClass('validation');
        },
        debug: false,
        submitHandler: function (form) {
            form.submit();
        }
    };
    $("#forgotPassword").validate(forgotpasswordValidator);
    //Create Roles for Shop - validation
    var shopRolesFormValidator = {
        rules: {
            shop_role: {
                required: true,
            },
        },
        messages: {
            shop_role: {
                required: "Role name required",
            },
        },
        highlight: function (element) {
            $(element).addClass('validation');
            // $(element).next('span').addClass('validation');
        },
        unhighlight: function (element) {
            $(element).removeClass('validation');
            // $(element).next('span').removeClass('validation');
        },
        errorPlacement: function (error, element) {
            // Set the error message as the input's placeholder
            element.attr("placeholder", error.text()).addClass('validation');
            element.next('span').addClass('validation');
        },
        debug: false,
        submitHandler: function (form) {
            form.submit();
        }
    };
    $("#shopRoleregisterForm").validate(shopRolesFormValidator);

    //Shop role validate during edit the role and priviliges
    var shopUpdateRolesFormValidator = {
        rules: {
            shop_update_role: {
                required: true,
            },
        },
        messages: {
            shop_update_role: {
                required: "Role name required",
            },
        },
        highlight: function (element) {
            $(element).addClass('validation');
            // $(element).next('span').addClass('validation');
        },
        unhighlight: function (element) {
            $(element).removeClass('validation');
            // $(element).next('span').removeClass('validation');
        },
        errorPlacement: function (error, element) {
            // Set the error message as the input's placeholder
            element.attr("placeholder", error.text()).addClass('validation');
            element.next('span').addClass('validation');
        },
        debug: false,
        submitHandler: function (form) {
            form.submit();
        }
    };
    $("#update_Shop_roleregisterForm").validate(shopUpdateRolesFormValidator);


})();

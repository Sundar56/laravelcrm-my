(function () {
    // initializeIntlTelInput("#companyPhone");
    fetchCompanyList('initial', 'companyList_table');
    fetchCompanyList('initial', 'dashboard_companyList_table');
    // hidden bs for user login offcanvas // 
    $('#CreateCompanyOffcanvas').on('hidden.bs.offcanvas', function () {
        // Reset the form fields
        $('#companyInfoForm')[0].reset();
        $('#companyInfoForm').find('input[name="company_name"]').attr("placeholder", "Company name").removeClass('validation');
        $('#companyInfoForm').find('input[name="company_id"]').attr("placeholder", "ID").removeClass('validation');
        $('#companyInfoForm').find('input[name="vat_id"]').attr("placeholder", "VAT ID").removeClass('validation');
        $('#companyInfoForm').find('input[name="invoice_email"]').attr("placeholder", "Invoice Email").removeClass('validation');
        $('#companyInfoForm').find('input[name="company_phone"]').attr("placeholder", "Company Phone").removeClass('validation');
        $('#companyInfoForm').find('input[name="zipcode"]').attr("placeholder", "Zipcode").removeClass('validation');
        $('#companyInfoForm').find('input[name="city"]').attr("placeholder", "City").removeClass('validation');
        $('#companyInfoForm').find('input[name="country"]').attr("placeholder", "Country").removeClass('validation');
        $('#companyInfoForm').find('input[name="ean_number"]').attr("placeholder", "EAN Number").removeClass('validation');
        $('#companyInfoForm').find('input[name="address"]').attr("placeholder", "Address").removeClass('validation');
        $('#companyInfoForm').find('input[name="description"]').attr("placeholder", "").removeClass('validation');
        $('#companyInfoForm').find('input[name="company_logo"]').removeClass('validation');
        $('#companyInfoForm').find('.preview-create-image-before-upload').attr('src', "/assets/img/company.png");
        $('#companyInfoForm').find('input[name="company_banner"]').removeClass('validation');
        $('#companyInfoForm').find('.preview-create-banner-before-upload').attr('src', "/assets/img/company.jpg");
        $('.img-error-msg').css('color', 'black');
    });
    // hidden bs for user login offcanvas // 
    $('#EditCompanyOffcanvas').on('hidden.bs.offcanvas', function () {
        // Reset the form fields
        $('#editcompanyInfoForm')[0].reset();
        $('#editcompanyInfoForm').find('input[name="company_name"]').attr("placeholder", "Company name").removeClass('validation');
        $('#editcompanyInfoForm').find('input[name="company_id"]').attr("placeholder", "ID").removeClass('validation');
        $('#editcompanyInfoForm').find('input[name="vat_id"]').attr("placeholder", "VAT ID").removeClass('validation');
        $('#editcompanyInfoForm').find('input[name="invoice_email"]').attr("placeholder", "Invoice Email").removeClass('validation');
        $('#editcompanyInfoForm').find('input[name="company_phone"]').attr("placeholder", "Company Phone").removeClass('validation');
        $('#editcompanyInfoForm').find('input[name="zipcode"]').attr("placeholder", "Zipcode").removeClass('validation');
        $('#editcompanyInfoForm').find('input[name="city"]').attr("placeholder", "City").removeClass('validation');
        $('#editcompanyInfoForm').find('input[name="country"]').attr("placeholder", "Country").removeClass('validation');
        $('#editcompanyInfoForm').find('input[name="ean_number"]').attr("placeholder", "EAN Number").removeClass('validation');
        $('#editcompanyInfoForm').find('input[name="address"]').attr("placeholder", "Address").removeClass('validation');
        $('#editcompanyInfoForm').find('input[name="description"]').attr("placeholder", "").removeClass('validation');
        $('#editcompanyInfoForm').find('input[name="company_logo"]').removeClass('validation');
        $('#editcompanyInfoForm').find('.preview-create-image-before-upload').attr('src', "/assets/img/company.png");
        $('#editcompanyInfoForm').find('input[name="company_banner"]').removeClass('validation');
        $('#editcompanyInfoForm').find('.preview-create-banner-before-upload').attr('src', "/assets/img/company.png");
    });
    // hidden bs for user login offcanvas // 
    $('#offcanvasAdduser').on('hidden.bs.offcanvas', function () {
        // Reset the form fields
        $('#userLoginForm')[0].reset();
        $('#userLoginForm').find('input[name="name"]').attr("placeholder", "Name").removeClass('validation');
        $('#userLoginForm').find('input[name="username"]').attr("placeholder", "Username").removeClass('validation');
        $('#userLoginForm').find('input[name="email"]').attr("placeholder", "Email").removeClass('validation');
        $('#userLoginForm').find('input[name="user_image"]').removeClass('validation');
        $('#userLoginForm').find('.preview-user-image-before-upload').attr('src', "/assets/img/user.jpg");
    });
    $('#offcanvasEdituser').on('hidden.bs.offcanvas', function () {
        // Reset the form fields
        $('#editUserLoginForm')[0].reset();
        $('#editUserLoginForm').find('input[name="name"]').attr("placeholder", "Name").removeClass('validation');
        $('#editUserLoginForm').find('input[name="username"]').attr("placeholder", "Name").removeClass('validation');
        $('#editUserLoginForm').find('input[name="email"]').attr("placeholder", "Name").removeClass('validation');
        $('#editUserLoginForm').find('input[name="edit_user_image"]').removeClass('validation');
        $('#editUserLoginForm').find('.preview-user-image-after-upload').attr('src', "/assets/img/user.jpg");
    });
    // hidden bs for Shop offcanvas // 
    $('#shopOffcanvas').on('hidden.bs.offcanvas', function () {
        // Reset the form fields
        $('#shopRoleregisterForm')[0].reset();
        $('#shopRoleregisterForm').find('input[name="shop_role"]').attr("placeholder", "Role Name").removeClass('validation');
    });
    $('#shopUpdateOffcanvasRight').on('hidden.bs.offcanvas', function () {
        // Reset the form fields
        $('#update_Shop_roleregisterForm')[0].reset();
        $('#update_Shop_roleregisterForm').find('input[name="shop_update_role"]').attr("placeholder", "Enter Role Name").removeClass('validation');
    });
    $('#createCompany').on('click', function (e) {
        initializeIntlTelInput("#companyPhone");
    });
    /**Get companyLastRecord */
    $('#createCompany').on('click', function (e) {
        $.ajax({
            url: "/crm/admin/companies/getLastCompanyId",
            type: "GET",
            success: function (result) {
                if (result.success) {
                    const companyId = result.data ? (result.data.company_id + 1) : "1001";
                    $('#companyId').val(companyId);
                }
            },
            error: function (response) {

            }
        });
    });
    //company info store funtion start
    $('.SubmitCompanyInfoForm').on('click', function (e) {
        e.preventDefault();
        if ($('#companyInfoForm').valid()) {
            var formData = new FormData(document.getElementById("companyInfoForm"));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const $button = $(this);
            const $spinner = $button.find('.spinner-border');
            const $btnText = $button.find('.btn-text');
            const originalText = $btnText.text();

            // Show spinner and change button text
            $spinner.show();
            $btnText.text('Saving...');
            $button.prop('disabled', true);

            $.ajax({
                url: "/crm/admin/companies/store",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result.success) {
                        $('#CreateCompanyOffcanvas').offcanvas('hide');
                        // $('#CreateCompanyModal').modal('hide');
                        fetchCompanyList('update', 'companyList_table');
                    }
                },
                error: function (xhr) {
                    // Check for validation errors (status 422)
                    if (xhr.status === 422) {
                        // Collect all the error messages
                        let errorMessages = [];
                        // Loop through the error object and get all messages
                        for (let field in xhr.responseJSON.error) {
                            if (xhr.responseJSON.error.hasOwnProperty(field)) {
                                // Add the first error message for each field to the array
                                errorMessages.push(xhr.responseJSON.error[field][0]);
                            }
                        }
                        const errorMessage = errorMessages.join('/');
                        Swal.fire({
                            title: "Error",
                            text: errorMessage,
                            icon: "error",
                            confirmButtonText: "Ok"
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "An unexpected error occurred.",
                            icon: "error",
                            confirmButtonText: "Ok"
                        });
                    }
                    $spinner.hide();
                    $btnText.text(originalText);
                    $button.prop('disabled', false);
                },
                complete: function () {
                    // Hide spinner and restore button text
                    $spinner.hide();
                    $btnText.text(originalText);
                    $button.prop('disabled', false);
                }
            });
        }
    });
    // Setup previews for create
    setupImagePreview('#company_logo', '.preview-create-image-before-upload', 'logo');
    setupImagePreview('#company_banner', '.preview-create-banner-before-upload', 'banner');

    // Setup previews for edit
    setupImagePreview('#edit_company_logo', '.preview-edit-image-before-upload', 'logo');
    setupImagePreview('#edit_company_banner', '.preview-edit-banner-before-upload', 'banner');
    //edit company function start
    $('body').on('click', '.editCompanyForm', function (e) {
        // e.preventDefault();
        var id = $(this).data('id');
        editCompanyForm(id);
    });
    //deletecompany function
    $('body').on('click', '.deleteCompany', function () {
        var id = $(this).data('id');
        deleteCompany(id);
    })
    //SSO setting update funtion start
    $('.UpdateSsoSettingsForm').on('click', function (e) {
        e.preventDefault();

        let formData = new FormData(document.getElementById('ssoSettingEditModel'));
        if ($('#ssoSettingEditModel').valid()) {
            $('.UpdateSsoSettingsForm').prop('disabled', true);
            $.ajax({
                url: "/crm/admin/companies/ssosettings/update",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result.status) {
                        $('.UpdateSsoSettingsForm').prop('disabled', false);

                        // $('#EditSsoSettingsyModal').modal('hide');
                        $('#ssoUpdateOffcanvasRight').offcanvas('hide');
                        fetchSsoSettings('update', result.companyId);

                    }
                },
                error: function (error) {
                    $('.UpdateSsoSettingsForm').prop('disabled', false);
                    console.log(error)
                }
            });
        }
    });
    //company info update funtion start
    $('.UpdateCompanyInfoForm').on('click', function (e) {
        e.preventDefault();
        const $button = $(this);
        const $spinner = $button.find('.spinner-border');
        const $btnText = $button.find('.btn-text');
        const originalText = $btnText.text();

        // Show spinner and change button text
        $spinner.show();
        $btnText.text('Saving...');
        $button.prop('disabled', true);
        if ($('#editcompanyInfoForm').valid()) {
            var formData = new FormData(document.getElementById("editcompanyInfoForm"));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/crm/admin/companies/update",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result.success) {
                        $('#EditCompanyOffcanvas').offcanvas('hide');
                        fetchCompanyList('update', 'companyList_table');
                        updateCompanyDetails(result.updateCompanyData);
                    }
                    $spinner.hide();
                    $btnText.text(originalText);
                    $button.prop('disabled', false);
                },
                error: function (response) {
                    $spinner.hide();
                    $btnText.text(originalText);
                    $button.prop('disabled', false);
                },
                complete: function () {
                    // Hide spinner and restore button text
                    $spinner.hide();
                    $btnText.text(originalText);
                    $button.prop('disabled', false);
                }
            });
        }
    });

    $("#pills-SSO-tab").on('click', function (e) {
        let companyId = $(this).data('companyid');
        fetchSsoSettings('initial', companyId);
    })
    // Attach a change event listener using event delegation
    // $('body').on('change', '#companyTypeSelect', function () {
    //     let selectedValue = $(this).val(); // Get the selected value
    //     let companyId = $('#pills-tab .nav-link.active').data('companyid');
    //     fetchSsoSettings('update', companyId, selectedValue);

    // });

    $('body').on('click', '.general-settings .dropdown-item', function (e) {
        e.preventDefault(); // Prevent default link behavior
        const selectedText = $(this).text();
        const selectedId = $(this).data('id');
        let companyId = $('#pills-tab .nav-link.active').data('companyid');
        console.log('selectText', selectedText);
        $('#dropdownMenuButton').text(selectedText);
        fetchSsoSettings('update', companyId, selectedId, selectedText);
    });
    //edit sso settings function start
    $('body').on('click', '.editSsoSettings', function (e) {
        e.preventDefault();
        const ssoSettingsId = $(this).data('ssosettingid');
        const comapnyId = $(this).data('companyid');
        fetchSsoSeetingById(ssoSettingsId, comapnyId);
    });

    //edit sso settings function start
    $('body').on('click', '.deleteSsoSettings', function (e) {
        e.preventDefault();
        const ssoSettingsId = $(this).data('ssosettingid');
        const comapnyId = $(this).data('companyid');
        GeneralSettingsDelete(comapnyId, ssoSettingsId);
    });


    /************************ sso settings End************************/
    /************************ Crm settings start************************/

    $("#pills-crm-tab").on('click', function (e) {
        const companyId = $(this).data('companyid');
        fetch_crm_roles_data(companyId);
    });

    $('#crmResetPrivileges').on('click', function () {
        $('#privilege_table input[type="checkbox"]').prop('checked', false);
        toggleSaveButton();
    });
    $('#privilege_table').on('change', 'input[type="checkbox"]', toggleSaveButton);

    $(".crm_new_privilege_close").on('click', function (e) {
        clearCrmPrivileges();
    });
    $(".crm_update_privilege_close").on('click', function (e) {
        $('#update_Crm_roleregisterForm input[type="checkbox"]').prop('checked', false);
        $("#update_Crm_roleregisterForm").find('input[name="update_role"]').val('');
        $("#update_Crm_roleregisterForm").find('input[name="update_role"]').attr("placeholder", 'Enter Role Name').removeClass('validation');
    });

    $('.SubmitCrmUpdateRoleForm').on('click', function () {
        saveUpdateCrmPrivileges();
    });
    // role selection on crm settings
    $('body').on('click', '.role-selector_crm', function () {
        // toggleSaveButton();
        $('.saveCrmPrivileges').prop('disabled', true);
        const roleId = $(this).data('id');
        $('.role-item').removeClass('selected');
        $(this).closest('li').addClass('selected');

        fetchModulesForCrm(roleId);
    });

    $('.saveCrmPrivileges').on('click', saveCrmPrivileges);
    $('.SubmitCrmCreateRoleForm').on('click', submitCrmCreateRoleForm);
    $('body').on('click', '.EditRolesModal_crm', function () {
        $('#crmUpdateOffcanvasRight').offcanvas('show');

    });
    //delete Crm role function
    $('body').on('click', '.deleteRoles_crm', function () {
        var id = $(this).data('id');
        const companyId = $(this).data('companyid');
        deleteCrmRole(id, companyId);
    })

    // search modules in Crm settings function
    $('#searchPrivileges').on('keyup', function () {
        const searchTerm = $(this).val().toLowerCase();
        $('#privilege_table tbody tr').filter(function () {

            // Get the module name and check 
            $(this).toggle($(this).find('td').first().text().toLowerCase().indexOf(searchTerm) > -1);
        });
    });

    // "All" checkbox click function
    toggleRowPrivileges('#privilege_table');
    toggleRowPrivileges('#role_privilege_table');
    toggleRowPrivileges('#update_role_privilege_table');
    /************************ Crm settings End ************************/

    /************************ Cms settings start ************************/
    $("#pills-cms-tab").on('click', function (e) {
        const companyId = $(this).data('companyid');
        fetch_cms_roles_data(companyId);
    });
    $('#cmsResetPrivileges').on('click', function () {
        $('#cms_privilege_table input[type="checkbox"]').prop('checked', false);
        cmsToggleSaveButton();
    });
    $('#cms_privilege_table').on('change', 'input[type="checkbox"]', cmsToggleSaveButton);

    $('.SubmitCmsCreateRoleForm').on('click', submitCmsCreateRoleForm);
    $('.saveCmsPrivileges').on('click', saveCmsPrivileges);

    $('.SubmitCmsUpdateRoleForm').on('click', function () {
        saveUpdateCmsPrivileges();
    });

    $(".cms_new_privilege_close").on('click', function (e) {
        clearCmsPrivileges();
    });

    $(".cms_update_privilege_close").on('click', function (e) {
        $('#update_Cms_roleregisterForm input[type="checkbox"]').prop('checked', false);
        $("#update_Cms_roleregisterForm").find('input[name="cms_update_role"]').val('');
        $("#update_Cms_roleregisterForm").find('input[name="cms_update_role"]').attr("placeholder", 'Enter Role Name').removeClass('validation');
    });

    //delete Crm role function
    $('body').on('click', '.deleteRoles_cms', function () {
        var id = $(this).data('id');
        const companyId = $(this).data('companyid');
        deleteCmsRole(id, companyId);
    })

    // role selection on cms settings
    $('body').on('click', '.role-selector_cms', function () {
        $('.saveCrmPrivileges').prop('disabled', true);
        const roleId = $(this).data('id');
        $('.role-item').removeClass('selected');
        $(this).closest('li').addClass('selected');
        fetchModulesForCms(roleId);
    });

    $('body').on('click', '.EditRolesModal_cms', function () {
        $('#cmsUpdateOffcanvasRight').offcanvas('show');
    });

    // search modules in Crm settings function
    $('#cms_searchPrivileges').on('keyup', function () {
        const searchTerm = $(this).val().toLowerCase();
        $('#cms_privilege_table tbody tr').filter(function () {
            // Get the module name and check 
            $(this).toggle($(this).find('td').first().text().toLowerCase().indexOf(searchTerm) > -1);
        });
    });
    // "All" checkbox click function
    toggleRowPrivileges('#cms_privilege_table');
    toggleRowPrivileges('#cms_role_privilege_table');
    toggleRowPrivileges('#update_cms_role_privilege_table');

    /************************ Crm settings End / Shop setting Start ************************/
    $("#pills-shop-tab").on('click', function (e) {
        const companyId = $(this).data('companyid');
        fetch_shop_roles_data(companyId);
    });
    // role selection on Shop settings
    $('body').on('click', '.role-selector_shop', function () {
        // toggleSaveButton();
        $('.saveShopPrivileges').prop('disabled', true);
        const roleId = $(this).data('id');
        $('.role-item').removeClass('selected');
        $(this).closest('li').addClass('selected');
        fetchModulesForShop(roleId);
    });
    //Edit Shop role function
    $('body').on('click', '.EditRolesModal_shop', function () {
        $('#shopUpdateOffcanvasRight').offcanvas('show');
    });
    //delete Shop role function
    $('body').on('click', '.deleteRoles_shop', function () {
        var id = $(this).data('id');
        const companyId = $(this).data('companyid');
        deleteShopRole(id, companyId);
    })
    $('#shopResetPrivileges').on('click', function () {
        $('#shop_privilege_table input[type="checkbox"]').prop('checked', false);
        shopToggleSaveButton();
    });
    $('#shop_privilege_table').on('change', 'input[type="checkbox"]', shopToggleSaveButton);
    // search modules in Crm settings function
    $('#shopSearch').on('keyup', function () {
        const searchTerm = $(this).val().toLowerCase();
        $('#shop_privilege_table tbody tr').filter(function () {
            $(this).toggle($(this).find('td').first().text().toLowerCase().indexOf(searchTerm) > -1);
        });
    });
    $('.SubmitShopCreateRoleForm').on('click', submitShopCreateRoleForm);
    $('.saveShopPrivileges').on('click', saveShopPrivileges);
    $('.SubmitShopUpdateRoleForm').on('click', saveUpdateShopPrivileges);

    toggleRowPrivileges('#shop_privilege_table');
    toggleRowPrivileges('#shop_role_privilege_table');
    toggleRowPrivileges('#update_shop_privilege_table');
    /************************ Shop settings end ************************/
    //user login function
    $("#pills-user-tab").on('click', function (e) {
        let companyId = $(this).data('companyid');
        fetchuserLoginlist('initial', companyId);
    })
    //User Login store funtion start
    $('.submitAdduserForm').on('click', function (e) {
        e.preventDefault();
        // Collect the state of the checkboxes (checkboxes checked/unchecked)
        var switchStates = [];
        $('input[type="checkbox"].form-check-input:checked').each(function () {
            // For each checked checkbox, push '1'
            switchStates.push('1');
        });
        // Convert the array into a string separated by '-'
        var switchString = switchStates.join('-');
        // console.log(switchString);

        if ($('#userLoginForm').valid()) {
            var formData = new FormData(document.getElementById("userLoginForm"));
            // Append the switch string to FormData
            formData.append('switchData', switchString);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const $button = $(this);
            const $spinner = $button.find('.spinner-border');
            const $btnText = $button.find('.btn-text');
            const originalText = $btnText.text();

            // Show spinner and change button text
            $spinner.show();
            $btnText.text('Saving...');
            $button.prop('disabled', true);

            $.ajax({
                url: "/crm/admin/companies/storeuser",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result.success) {
                        var companyId = result.companyId;
                        $('#offcanvasAdduser').offcanvas('hide');
                        fetchuserLoginlist('update', companyId);
                    }

                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errorMessages = [];
                        // Loop through the error object and get all messages
                        for (let field in xhr.responseJSON.error) {
                            if (xhr.responseJSON.error.hasOwnProperty(field)) {
                                // Add the first error message for each field to the array
                                errorMessages.push(xhr.responseJSON.error[field][0]);
                            }
                        }
                        const errorMessage = errorMessages.join('/');
                        Swal.fire({
                            title: "Error",
                            text: errorMessage,
                            icon: "error",
                            confirmButtonText: "Ok"
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "An unexpected error occurred.",
                            icon: "error",
                            confirmButtonText: "Ok"
                        });
                    }
                    $spinner.hide();
                    $btnText.text(originalText);
                    $button.prop('disabled', false);
                },
                complete: function () {
                    // Hide spinner and restore button text
                    $spinner.hide();
                    $btnText.text(originalText);
                    $button.prop('disabled', false);
                }
            });
        }
    });
    //User Login store funtion start
    $('.submitEdituserForm').on('click', function (e) {
        e.preventDefault();

        if ($('#editUserLoginForm').valid()) {
            var formData = new FormData(document.getElementById("editUserLoginForm"));
            // Append the switch string to FormData
            // formData.append('switchData', switchString);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const $button = $(this);
            const $spinner = $button.find('.spinner-border');
            const $btnText = $button.find('.btn-text');
            const originalText = $btnText.text();

            // Show spinner and change button text
            $spinner.show();
            $btnText.text('Saving...');
            $button.prop('disabled', true);

            $.ajax({
                url: "/crm/admin/companies/updateUser",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result.success) {
                        Swal.fire("Success!", "User Details Updated.", "success").then(() => {
                            var companyId = result.companyId;
                            $('#offcanvasEdituser').offcanvas('hide');
                            fetchuserLoginlist('update', companyId);
                        });
                    }
                    $spinner.hide();
                    $btnText.text(originalText);
                    $button.prop('disabled', false);
                },
                error: function (xhr) {
                    // Check for validation errors (status 422)
                    if (xhr.status === 422) {
                        // Collect all the error messages
                        let errorMessages = [];
                        // Loop through the error object and get all messages
                        for (let field in xhr.responseJSON.error) {
                            if (xhr.responseJSON.error.hasOwnProperty(field)) {
                                // Add the first error message for each field to the array
                                errorMessages.push(xhr.responseJSON.error[field][0]);
                            }
                        }
                        const errorMessage = errorMessages.join('/');
                        Swal.fire({
                            title: "Error",
                            text: errorMessage,
                            icon: "error",
                            confirmButtonText: "Ok"
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "An unexpected error occurred.",
                            icon: "error",
                            confirmButtonText: "Ok"
                        });
                    }
                    $spinner.hide();
                    $btnText.text(originalText);
                    $button.prop('disabled', false);
                },
                complete: function () {
                    // Hide spinner and restore button text
                    $spinner.hide();
                    $btnText.text(originalText);
                    $button.prop('disabled', false);
                }
            });
        }
    });
    //User login View 
    $('body').on('click', '.viewUserlogin', function () {
        var userId = $(this).data('userloginid');
        const companyId = $(this).data('companyid');
        openUserDetails(userId, companyId);
    })

    $('body').on('click', '.editUserlogin', function (e) {
        // e.preventDefault();
        var userId = $(this).data('userloginid');
        const companyId = $(this).data('companyid');
        editUserlogin(userId, companyId);
    });
    $('body').on('click', '.deleteUserlogin', function (e) {
        // e.preventDefault();
        var userId = $(this).data('userloginid');
        const companyId = $(this).data('companyid');
        deleteUserlogin(userId, companyId);
    });

    $('#user_login_table tbody').on('dblclick', 'tr', function (e) {
        if ($(e.target).hasClass('deleteUserlogin') || $(e.target).closest('.deleteUserlogin').length) {
            // Do nothing if it's the Delete element
            return;
        }
        var userId = $(this).data('userid');
        const companyId = $(this).data('companyid');
        editUserlogin(userId, companyId);
    });

    setupImagePreview('#user_image', '.preview-user-image-before-upload', 'logo');
    setupImagePreview('#edit_image', '.preview-user-image-after-upload', 'logo');
    /************************  User login end ************************/
    $('#companyList_table tbody').on('dblclick', 'tr', function () {
        var companyId = $(this).data('id');
        var viewUrl = '/crm/admin/companies/view/' + companyId;
        window.location.href = viewUrl;
    });

    $('#sso_settings_table tbody').on('dblclick', '.generalListIteam', function (e) {

        if ($(e.target).hasClass('deleteSsoSettings') || $(e.target).closest('.deleteSsoSettings').length) {
            // Do nothing if it's the resetPassword element
            return;
        }
        let ssoSettingsId = $(this).data('id');
        let companyId = $(this).data('companyid');
        fetchSsoSeetingById(ssoSettingsId, companyId);
    })


})();

function fetchCompanyList(type, tableId) {
    // Check if the table exists
    if (document.getElementById(tableId)) {
        var useroptions = {
            "processing": true,
            "serverSide": true,
            "lengthMenu": [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            "iDisplayLength": 100,
            "order": [1, 'desc'],
            "responsive": true,
            "destroy": true,
            "stateSave": type === 'initial' ? false : true,
            "ajax": {
                "url": "/crm/admin/companies/getcompanylist",
                "dataType": "json",
                "type": "GET",
                "data": function (data) {
                    data._token = $('meta[name="csrf-token"]').attr('content');
                },
                "error": function (xhr, error, thrown) {
                    console.error("Error fetching data: ", error);
                    // alert("Failed to fetch company data.");
                }
            },
            "columns": [],
            "createdRow": function (row, data, dataIndex) {
                // Add custom classes
                $(row).addClass('companyList'); // Example class               
                // Add custom attributes
                $(row).attr('data-id', data.encryptedId); // Add data-id attribute
            },           
        };

        // Dynamically set columns based on tableId
        if (tableId === 'companyList_table') {
            useroptions.columns = [{
                    "data": "company_id"
                },
                {
                    "data": "company_name"
                },
                {
                    "data": "vat_id"
                },
                {
                    "data": "invoice_email"
                },
                {
                    "data": "company_phone"
                },
                {
                    "data": "zipcode"
                },
                {
                    "data": "city"
                },
                {
                    "data": "country"
                },
                {
                    "data": "is_blocked"
                },
            ];
        } else if (tableId === 'dashboard_companyList_table') {
            useroptions.columns = [{
                    "data": "company_id"
                },
                {
                    "data": "company_name"
                },
                {
                    "data": "vat_id"
                },
                {
                    "data": "invoice_email"
                },
                {
                    "data": "company_phone"
                },
                {
                    "data": "zipcode"
                },
                {
                    "data": "city"
                },
                {
                    "data": "country"
                },
                {
                    "data": "is_blocked"
                },
                {
                    "data": "created_at"
                }
            ];
        }

        var moduleTable = $('#' + tableId).DataTable(useroptions);
        // Double-click event on table row to navigate to the View page
        $('#dashboard_companyList_table tbody').on('dblclick', 'tr', function () {
            var data = moduleTable.row(this).data();
            var companyId = data['encryptedId']; // Get the encrypted company_id
            var viewUrl = '/crm/admin/companies/view/' + companyId;
            window.location.href = viewUrl;
        });
        moduleTable.on('draw', function () {
            $('#' + tableId + ' tbody tr').each(function () {
                // Add 'dtr-control' class to the first <td> (company_id column)
                $(this).find('td:first').addClass('dtr-control');
            });
        });
        $('#' + tableId + '_filter').html(`<div class="input-group position-relative float-end w-auto">
            <input type="text" class="form-control search-input rounded-1" placeholder="Search" aria-label="Search" style="padding-left: 30px;">
            <span class="input-group-text table-search-bar">
                <i class="bx bx-search fs-6"></i>
            </span>
        </div>
    `); 
        // Search functionality
        $('#' + tableId + '_filter input').unbind().bind('keyup', function (e) {
            if (e.keyCode == 13) {
                moduleTable.search(this.value).draw();
            }
        });

        $('#' + tableId).parent().addClass('table-responsive');
    }
}

function fetchSsoSettings(type, id, selectedType = 0, selectedText = 'All') {
    if (document.getElementById('sso_settings_table')) {
        var useroptions = {
            "processing": true,
            "serverSide": true,
            "lengthMenu": [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            "iDisplayLength": 100,
            "order": [1, 'desc'],
            responsive: true,
            "destroy": true,     
            "stateSave": type === 'initial' ? false : true,
            "ajax": {
                "url": "/crm/admin/companies/getSsoSttings",
                "dataType": "json",
                "type": "GET",
                "data": function (data) {
                    data._token = $('meta[name="csrf-token"]').attr('content');
                    data.companyId = id
                    data.type = selectedType
                },
                "dataSrc": function (response) {
                    let types = response.types;
                    if (types) {
                        // if ($('#companyTypeSelect').length === 0) {
                        //     console.log(1)
                        //     // Create select tag if it doesn't exist
                        //     let selectType = `<select class="form-select form-select-sm" name="select_company_type" id="companyTypeSelect" style="width:30%;display:inline-block">`;
                        //     $.each(types, function (key, value) {
                        //         selectType += `<option value="${key}" ${key == selectedType ? 'selected' : ''}>${value}</option>`;
                        //     });
                        //     selectType += `</select>`;
                        //     $('#sso_settings_table_filter').prepend(selectType);
                        // } else {
                        //     console.log(2)
                        //     // Update the existing select tag
                        //     let selectType = '';
                        //     $.each(types, function (key, value) {
                        //         selectType += `<option value="${key}" ${key == selectedType ? 'selected' : ''}>${value}</option>`;
                        //     });
                        //     $('#companyTypeSelect').html(selectType); // Update the options
                        // }
                    }
                    return response.data;
                },
                "error": function (xhr, error, thrown) {
                    let errorMessage = "Failed to fetch data. Please try again.";
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    }
                    console.error("Error fetching data: ", errorMessage);
                }
            },
            "columns": [{
                    "data": "Variable"
                },
                {
                    "data": "Value"
                },
                {
                    "data": "Description"
                },
                {
                    "data": "Type"
                },
                {
                    "data": "actions",
                    "bSortable": false
                },
            ],
            "createdRow": function (row, data, dataIndex) {
                // Add custom classes
                $(row).addClass('generalListIteam');
                
                $(row).attr('data-id', data.id); 
                $(row).attr('data-companyid', data.company_id);
            }
        };

        var moduleTable = $('#sso_settings_table').DataTable(useroptions);

        moduleTable.on('draw', function () {
            $('#sso_settings_table tbody tr').each(function () {
                // Add 'dtr-control' class to the first <td> (company_id column)
                $(this).find('td:first').addClass('dtr-control');
            });
        });
        $('#sso_settings_table_filter').html(`<div class="input-group position-relative float-end w-auto">
            <input type="text" class="form-control search-input rounded-1" placeholder="Search" aria-label="Search" style="padding-left: 30px;">
            <span class="input-group-text table-search-bar">
                <i class="bx bx-search fs-6"></i>
            </span>
        </div>
    `);  
        $('#sso_settings_table_filter input').unbind().bind('keyup', function (e) {
            if (e.keyCode == 13) {
                moduleTable.search(this.value).draw();
            }
        });
        //         let selectType = `<select class="form-select form-select-sm" name="select_company_type" id="companyTypeSelect" style="width:30%;display:inline-block">
        //         <option value="0" ${0 == selectedType ? 'selected' : ''}>All</option>
        //         <option value="1" ${1 == selectedType ? 'selected' : ''}>Crm</option>
        //         <option value="2" ${2 == selectedType ? 'selected' : ''}>Cms</option>
        //         <option value="3" ${3 == selectedType ? 'selected' : ''}>Wlanshop</option>                 
        // </select>`;
        let selectType =`<div class="dropdown general-settings" style="">
<button class="btn  type-btn btn-sm d-flex p-2" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
    <span>${selectedText}</span>
    <div class="ms-auto dropy-icon"><i class="bx bx-chevron-down"></i></div>
</button>

<ul class="dropdown-menu  menu-list" aria-labelledby="dropdownMenuButton">
    <li class="dropdown-li"><a class="dropdown-item body-text" href="#" data-value="all" data-id="0">All</a></li>
    <li class="dropdown-li"><a class="dropdown-item body-text" href="#" data-value="crm" data-id="1">Crm</a></li>
    <li class="dropdown-li"><a class="dropdown-item body-text" href="#" data-value="cms" data-id="2">Cms</a></li>
    <li class="dropdown-li"><a class="dropdown-item body-text" href="#" data-value="wlanshop" data-id="3">Wlanshop</a></li>
</ul>
</div>`
        $('#sso_settings_table_filter').prepend(selectType);

        $('#sso_settings_table').parent().addClass('table-responsive');
    }
}

function GeneralSettingsDelete(companyId, generalSettingId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You would like to delete!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4682b4',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Set the CSRF token for the AJAX request
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "DELETE",
                url: "/crm/admin/companies/deleteGeneralSettings/" + generalSettingId,
                data: {
                    companyId: companyId,
                    _token: $('input[name="_token"]').val()
                },
                success: function (data) {
                    if (data.status == 1) {
                        Swal.fire({
                            title: "Good job!",
                            text: "Deleted Successfully!",
                            icon: "success",
                            confirmButtonText: "Ok",
                        }).then(() => {
                            fetchSsoSettings('update', companyId);
                        });
                    } else {
                        // Handle unexpected status
                        Swal.fire({
                            title: "Error",
                            text: "Something went wrong!",
                            icon: "error",
                            confirmButtonText: "Ok",
                        });
                    }
                },
                error: function (xhr) {
                    // Handle errors
                    Swal.fire({
                        title: "Error",
                        text: xhr.responseJSON.message || "An error occurred.",
                        icon: "error",
                        confirmButtonText: "Ok",
                    });
                }
            });
        } else {
            Swal.fire({
                title: "Cancelled",
                text: "Your operation has been cancelled",
                icon: "error",
                confirmButtonText: "Ok",
            });
        }
    });
}

function fetchuserLoginlist(type, id) {
    if (document.getElementById('user_login_table')) {
        var useroptions = {
            "processing": true,
            "serverSide": true,
            "lengthMenu": [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            "iDisplayLength": 100,
            "order": [1, 'desc'],
            responsive: true,
            "destroy": true,      
            "stateSave": type === 'initial' ? false : true,
            "ajax": {
                "url": "/crm/admin/companies/getUserlogin",
                "dataType": "json",
                "type": "GET",
                "data": function (data) {
                    data._token = $('meta[name="csrf-token"]').attr('content');
                    data.companyId = id;
                },
                "error": function (xhr, error, thrown) {
                    let errorMessage = "Failed to fetch data. Please try again.";
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    }
                    console.error("Error fetching data: ", errorMessage);
                }
            },
            "columns": [{
                    "data": null,
                    "bSortable": false,
                    "render": function (data, type, row) {
                        return `<input type="checkbox" class="user-checkbox" value="${row.id}" />`; // Using row.id here
                    }
                },
                {
                    "data": "name"
                },
                {
                    "data": "email"
                },
                {
                    "data": "usertype"
                },
                {
                    "data": "mfa"
                },
                {
                    "data": "status"
                },
                {
                    "data": "lastlogin"
                },          
            ],
            "createdRow": function (row, data, dataIndex) {
                // Add custom classes
                $(row).addClass('companyUserlist'); // Example class               
                // Add custom attributes
                $(row).attr('data-userid', data.userId); // Add data-id attribute
                $(row).attr('data-companyid', data.companyId);
            }
        };
        var moduleTable = $('#user_login_table').DataTable(useroptions);
        moduleTable.on('draw', function () {
            $('#user_login_table tbody tr').each(function () {
                $(this).find('td:first').addClass('dtr-control');
            });
        });
        $('#user_login_table_filter').html(`<div class="input-group position-relative float-end w-auto">
                <input type="text" class="form-control search-input rounded-1" placeholder="Search" aria-label="Search" style="padding-left: 30px;">
                <span class="input-group-text table-search-bar">
                    <i class="bx bx-search fs-6"></i>
                </span>
            </div>
        `);
        // // Bind the search filter
        $('#user_login_table_filter_input').unbind().bind('keyup', function (e) {
            if (e.keyCode == 13) {
                moduleTable.search(this.value).draw();
            }
        });
        // Select/Deselect all checkboxes
        $('#select-all').on('change', function () {
            var isChecked = $(this).prop('checked');
            $('input[type="checkbox"].user-checkbox').prop('checked', isChecked);
            toggleBulkDeleteButton();
        });

        // Individual checkbox selection
        $('#user_login_table').on('change', 'input[type="checkbox"].user-checkbox', function () {
            updateSelectAllCheckbox(); // Update "Select All" checkbox state
            toggleBulkDeleteButton();
        });

        // Bulk Delete Button HTML
        var bulkDeleteButton = `
            <span id="bulkDelete" class="btn btn-thin border rounded-1">
                <span><i class="bx bx-trash-alt fs-6"></i> <span class="d-none d-sm-inline-block">Bulk Delete</span></span>
            </span>
        `;
        $('#user_login_table_filter').prepend(bulkDeleteButton); // Add button before the filter input  
        // Bulk delete action
        $('#bulkDelete').on('click', function () {
            var selectedIds = [];
            $('input[type="checkbox"].user-checkbox:checked').each(function () {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length > 0) {
                // Show a confirmation dialog before proceeding with the deletion
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4682b4',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete them!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with the deletion if the user confirms
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        // Make AJAX call to bulk delete
                        $.ajax({
                            url: '/crm/admin/companies/bulkDeleteUsers',
                            type: 'DELETE',
                            data: {
                                userIds: selectedIds,
                                companyId: id,
                                _token: $('input[name="_token"]').val() // CSRF token
                            },
                            success: function (response) {
                                if (response) {
                                    moduleTable.ajax.reload();
                                    // Reset the checkboxes
                                    $('input[type="checkbox"].user-checkbox').prop('checked', false); // Uncheck all checkboxes
                                    $('#select-all').prop('checked', false); // Uncheck the "Select All" checkbox
                                    // Disable the bulk delete button if no checkboxes are selected
                                    toggleBulkDeleteButton();
                                    Swal.fire("Success!", "Users Deleted", "success");
                                } else {
                                    Swal.fire("Error!", response.error || "An error occurred.", "error");
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error("Error:", error);
                                Swal.fire("Error!", "An error occurred while deleting the users.", "warning");
                            }
                        });
                    } else {
                        // If the user cancels, show a message
                        Swal.fire({
                            title: "Cancelled",
                            text: "Your operation has been cancelled",
                            icon: "error",
                            confirmButtonText: "Ok",
                        });
                    }
                });
            } else {
                Swal.fire("Warning!", "No users selected.", "warning");
            }
        });

        // Make table responsive
        $('#user_login_table').parent().addClass('table-responsive');
    }
}
// Function to update "Select All" checkbox based on individual checkbox states
function updateSelectAllCheckbox() {
    var totalCheckboxes = $('input[type="checkbox"].user-checkbox').length;
    var checkedCheckboxes = $('input[type="checkbox"].user-checkbox:checked').length;

    // If all checkboxes are checked, check the "Select All" checkbox
    if (totalCheckboxes === checkedCheckboxes) {
        $('#select-all').prop('checked', true);
    } else {
        $('#select-all').prop('checked', false);
    }
}
// Function to toggle the bulk delete button based on selection
function toggleBulkDeleteButton() {
    var selectedCount = $('input[type="checkbox"].user-checkbox:checked').length;
    $('#bulkDelete').prop('disabled', selectedCount === 0); // Disable if no checkboxes are selected
}
//fetchSsoSeetingById
function fetchSsoSeetingById(ssoSettingsId, companyId) {
    $.ajax({
        url: `/crm/admin/companies/ssosettings/edit/${ssoSettingsId}?companyId=${companyId}`,
        method: "GET",
        success: function (result) {
            if (result.status) {
                let res = result.data;
                let editModalBody = $('#ssoSettingEditModel');
                editModalBody.find('input[name="sso_variable_name"]').val(res.variabel);
                editModalBody.find('input[name="sso_value_name"]').val(res.vaerdi);
                editModalBody.find('textarea[name="sso_description_name"]').val(res.beskrivelse);
                editModalBody.find('input[name="sso_id"]').val(res.id);
                editModalBody.find('input[name="company_id"]').val(result.companyId);
                $('#ssoUpdateOffcanvasRight').offcanvas('show');
            }

        },
        error: function (error) {
            console.logo(error);
        }
    })
}
//edit company function
function editCompanyForm(id) {
    $.ajax({
        url: "/crm/admin/companies/edit/" + id,
        method: 'GET',
        success: function (result) {
            var editModalBody = $('#EditCompanyOffcanvas');
            editModalBody.find('input[name="company_name"]').val(result.data.company_name);
            editModalBody.find('input[name="company_id"]').val(result.data.company_id);
            editModalBody.find('input[name="vat_id"]').val(result.data.vat_id);
            editModalBody.find('input[name="invoice_email"]').val(result.data.invoice_email);
            editModalBody.find('input[name="company_phone"]').val(result.data.company_phone);
            editModalBody.find('input[name="zipcode"]').val(result.data.zipcode);
            editModalBody.find('input[name="city"]').val(result.data.city);
            editModalBody.find('input[name="country"]').val(result.data.country);
            editModalBody.find('input[name="ean_number"]').val(result.data.ean_number);
            editModalBody.find('textarea[name="description"]').text(result.data.description);
            editModalBody.find('input[name="c_id"]').val(result.data.id);
            editModalBody.find('input[name="address"]').val(result.data.address);
            // Update the image source for the company logo
            if (result.data.company_logo) {
                editModalBody.find('.preview-edit-image-before-upload').attr('src', result.data.company_logo);
            }
            // Update the image source for the company banner
            if (result.data.company_banner) {
                editModalBody.find('.preview-edit-banner-before-upload').attr('src', result.data.company_banner);
            }

            if (result.data.is_blocked == 1) {
                editModalBody.find('input[name="is_blocked"]').prop('checked', true);
            } else {
                editModalBody.find('input[name="is_blocked"]').prop('checked', false);
            }
            var companyPhone = initializeIntlTelInput('#EditCompanyOffcanvas input[name="company_phone"]');
            // Use setTimeout to ensure itiphone is initialized before setting the number
            setTimeout(function () {
                if (companyPhone) {
                    companyPhone.setNumber(result.data.company_phone.trim());
                }
            }, 500);
            $('.img-error-msg').css('color', 'black');
            $('#EditCompanyOffcanvas').offcanvas('show');
        }
    });
}

function updateCompanyDetails(company) {
    // Update the fields with the new values
    $("#company-vat-id").text(company.vat_id);
    $("#company-address").text(company.address);
    $("#company-zipcode").text(company.zipcode);
    $("#company-city").text(company.city);
    $("#company-country").text(company.country);
    $("#company-invoice-email").text(company.invoice_email);
    $("#company-ean-number").text(company.ean_number);
    $("#company-name").text(company.company_name);
    $("#company-description").text(company.description);
    // Check if company logo exists and update the image
    if (company.company_logo) {
        $(".preview-create-image-before-upload.preview-img").attr('src', company.company_logo);
    } else {
        $(".preview-create-image-before-upload.preview-img").attr('src', '/assets/img/company.png');
    }
}

function deleteCompany(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You would like to delete this Company!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4682b4',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Set the CSRF token for the AJAX request
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "DELETE",
                url: "/crm/admin/companies/delete/" + id,
                data: {
                    id: id,
                    _token: $('input[name="_token"]').val() // CSRF token
                },
                success: function (data) {
                    if (data.status == 200) {
                        Swal.fire({
                            title: "Good job!",
                            text: "Company Deleted Successfully!",
                            icon: "success",
                            confirmButtonText: "Ok",
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        // Handle unexpected status
                        Swal.fire({
                            title: "Error",
                            text: "Something went wrong!",
                            icon: "error",
                            confirmButtonText: "Ok",
                        });
                    }
                },
                error: function (xhr) {
                    // Handle errors
                    Swal.fire({
                        title: "Error",
                        text: xhr.responseJSON.message || "An error occurred.",
                        icon: "error",
                        confirmButtonText: "Ok",
                    });
                }
            });
        } else {
            Swal.fire({
                title: "Cancelled",
                text: "Your operation has been cancelled",
                icon: "error",
                confirmButtonText: "Ok",
            });
        }
    });
}
$('#upload-camera-icon').on('click', function () {
    $('#company_banner').click();
})

$('#edit_upload_camera_icon').on('click', function () {
    $('#edit_company_banner').click();
})
//set image preview function
function setupImagePreview(inputSelector, previewSelector, image) {
    $(inputSelector).on('change', function () {

        const file = this.files[0];
        const fileInput = $(this);
        const errorMsgElement = $(this).closest('.row').find('.img-error-msg');

        const config = {
            logo: {
                allowedTypes: ['image/jpeg', 'image/png', 'image/svg+xml'],
                minWidth: 500,
                minHeight: 500,
            },
            banner: {
                allowedTypes: ['image/jpeg', 'image/webp'],
                minWidth: 1920,
                minHeight: 1080,
            },
        };

        const imageType = image == 'logo' ? 'logo' : 'banner';
        const {
            allowedTypes,
            minWidth,
            minHeight
        } = config[imageType];

        errorMsgElement.css('color', 'black')

        // Check if a file is selected
        if (!file) {
            // alert('No file selected.');
            errorMsgElement.css('color', 'red')
            return;
        }

        if (!allowedTypes.includes(file.type)) {
            console.log('file_type')
            fileInput.val(''); // Clear the input
            errorMsgElement.css('color', 'red');
            return;
        }

        const img = new Image();
        img.onload = function () {
            console.log('image', image)
            if (this.width < minWidth || this.height < minHeight) {
                fileInput.val(''); // Clear the input
                errorMsgElement.css('color', 'red');
                return;
            }
            $(previewSelector).attr('src', img.src);
        };
        img.src = URL.createObjectURL(file);
    });
}
/**Crm Settings privileges */
function fetchModulesForCrm(roleId) {
    $.ajax({
        url: '/crm/admin/companies/get-modules-by-crm',
        type: 'GET',
        data: {
            role_id: roleId
        },
        success: function (response) {
            updateCrmModuleList(response);

        },
        error: function (err) {
            console.error("Error fetching modules:", err);
        }
    });
}

function updateCrmModuleList(response) {
    const tbody = $('#privilege_table tbody');
    const updateTbody = $('#update_role_privilege_table tbody');
    tbody.empty();
    updateTbody.empty();
    $("#update_Crm_roleregisterForm").find('input[name="update_role"]').val(response.role.display_name)

    // Handle modules and permissions from the response
    const modules = response.modules || [];
    const permissions = response.data || [];

    if (modules.length != 0) {
        modules.forEach(module => {
            const row = `
                <tr class="border-bottom">
                    <td data-id="${module.id}">${module.name}</td>
                    <td class="text-center" data-allid="${module.id}_all">
                        <input type="checkbox" class="row-select-all">
                    </td>
                     <td class="text-center" data-indexid="${module.id}_index">
                        <input type="checkbox" class="index" ${permissions.includes('crm.' + module.slug + '.index') ? 'checked' : ''}>
                    </td>
                    <td class="text-center" data-createid="${module.id}_create">
                        <input type="checkbox" class="create" ${permissions.includes('crm.' + module.slug + '.create') ? 'checked' : ''}>
                    </td>                 
                    <td class="text-center" data-editid="${module.id}_edit">
                        <input type="checkbox" class="edit" ${permissions.includes('crm.' + module.slug + '.edit') ? 'checked' : ''}>
                    </td>
                    <td class="text-center" data-deleteid="${module.id}_delete">
                        <input type="checkbox" class="delete" ${permissions.includes('crm.' + module.slug + '.delete') ? 'checked' : ''}>
                    </td>
                   <td class="text-center" data-blockid="${module.id}_block">
                        <input type="checkbox" class="block" ${module.is_blocked ? 'checked' : ''}>
                    </td>
                    <td class="text-center" data-enableid="${module.id}_enable">
                        <input type="checkbox" class="enable" ${module.is_enabled ? 'checked' : ''}>
                    </td>
                </tr>
            `;
            tbody.append(row);
            updateTbody.append(row);
        });
    }
    updateCrmPrivilegeCheckboxes();
}

function saveCrmPrivileges() {
    $('.saveCrmPrivileges').prop('disabled', true);
    const roleId = $('.role-item.selected').data('id');
    const permissions = extractPermissions('#privilege_table');
    $.ajax({
        url: '/crm/admin/companies/saveCrmPrivileges',
        type: 'POST',
        data: {
            _token: $('input[name="_token"]').val(),
            role_id: roleId,
            permission: permissions,
        },
        success: function (response) {
            Swal.fire({
                title: "Good job!",
                text: response.success,
                icon: "success",
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: 'alert-button-color'
                }
            });
        },
        error: function (err) {
            $('.saveCrmPrivileges').prop('disabled', false);
            if (xhr.status === 409 && xhr.responseJSON && xhr.responseJSON.error) {
                Swal.fire({
                    title: "Error",
                    text: xhr.responseJSON.error.roleName[0],
                    icon: "error",
                    confirmButtonText: "Ok",
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: "An unexpected error occurred.",
                    icon: "error",
                    confirmButtonText: "Ok",
                });
            }
        }
    });
}

function saveUpdateCrmPrivileges() {
    const roleId = $('.role-item.selected').data('id');
    const companyId = $('.role-item.selected').data('companyid');
    const permissions = extractPermissions('#update_role_privilege_table');
    const roleName = $('#update_Crm_roleregisterForm').find("input[name='update_role']").val();
    if ($('#update_Crm_roleregisterForm').valid()) {
        $('.SubmitCrmUpdateRoleForm').prop('disabled', true);
        $.ajax({
            url: '/crm/admin/companies/saveCrmPrivileges',
            type: 'POST',
            data: {
                _token: $('input[name="_token"]').val(),
                role_id: roleId,
                permission: permissions,
                roleName: roleName,
                companyId: companyId,
            },
            success: function (response) {
                $('.SubmitCrmUpdateRoleForm').prop('disabled', false);
                Swal.fire("Success!", "Role & Privileges updated.", "success").then(() => {
                    $('#crmUpdateOffcanvasRight').offcanvas('hide');
                    fetch_crm_roles_data(companyId);
                });
            },
            error: function (xhr) {
                $('.SubmitCrmUpdateRoleForm').prop('disabled', false);
                if (xhr.status === 409 && xhr.responseJSON && xhr.responseJSON.error) {
                    Swal.fire({
                        title: "Error",
                        text: xhr.responseJSON.error.roleName[0],
                        icon: "error",
                        confirmButtonText: "Ok",
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: "An unexpected error occurred.",
                        icon: "error",
                        confirmButtonText: "Ok",
                    });
                }
            }
        });
    }
}

//store role function
function submitCrmCreateRoleForm() {
    const roleName = $('input[name="role"]').val();
    const permissions = extractPermissions('#role_privilege_table');
    const companyId = $(this).data('companyid');
    if ($('#roleregisterForm').valid()) {
        $('.SubmitCrmCreateRoleForm').prop('disabled', true);
        $.ajax({
            url: "/crm/admin/companies/createCrmPrivileges",
            type: "POST",
            data: {
                _token: $('input[name="_token"]').val(),
                role: roleName,
                permission: permissions,
                companyId: companyId,
            },
            success: function (response) {
                if (response.status) {
                    // $('#CreateRolesModal').modal('hide');
                    $('#offcanvasRight').offcanvas('hide');
                    Swal.fire("Success!", "Role & Privileges updated.", "success").then(() => {
                        $('.SubmitCrmCreateRoleForm').prop('disabled', false);
                        clearCrmPrivileges();
                        fetch_crm_roles_data(companyId);
                    });
                } else {
                    $('.SubmitCrmCreateRoleForm').prop('disabled', false);
                    // $('#offcanvasRight').offcanvas('hide');
                    // Swal.fire(response.error).then(() => {
                    //     // fetch_crm_roles_data(companyId);
                    // });
                    Swal.fire({
                        title: "Error",
                        text: 'Something went wrong',
                        icon: "error",
                        confirmButtonText: "Ok",
                    });
                }
            },
            error: function (xhr) {
                $('.SubmitCrmCreateRoleForm').prop('disabled', false);
                if (xhr.status === 409 && xhr.responseJSON && xhr.responseJSON.error) {
                    Swal.fire({
                        title: "Error",
                        text: xhr.responseJSON.error.role[0],
                        icon: "error",
                        confirmButtonText: "Ok",
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: "An unexpected error occurred.",
                        icon: "error",
                        confirmButtonText: "Ok",
                    });
                }

            }


        });
    }
}

function extractPermissions(tableSelector) {
    const permissions = [];
    $(tableSelector + ' tbody tr').each(function () {
        const moduleId = $(this).find('td[data-id]').data('id');

        if ($(this).find('input.row-select-all').is(':checked')) {
            permissions.push(`${moduleId}_all`);
        }
        if ($(this).find('input.create').is(':checked')) {
            permissions.push(`${moduleId}_create`);
        }
        if ($(this).find('input.index').is(':checked')) {
            permissions.push(`${moduleId}_index`);
        }
        if ($(this).find('input.edit').is(':checked')) {
            permissions.push(`${moduleId}_edit`);
        }
        if ($(this).find('input.delete').is(':checked')) {
            permissions.push(`${moduleId}_delete`);
        }
        // Additional checks for block/unblock and enable/disable
        if ($(this).find('input.block, input.isBlocked').is(':checked')) {
            permissions.push(`${moduleId}_block`);
        }
        if ($(this).find('input.enable, input.isEnabled').is(':checked')) {
            permissions.push(`${moduleId}_enable`);
        }
    });
    return permissions;
}

function fetch_crm_roles_data(companyId) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/crm/admin/companies/getCrmroles/${companyId}`,
        type: "GET",
        success: function (result) {
            if (result.status_code == 200) {
                $('#roledata').html(result.html);
                const firstRole = $('.role-selector_crm').first();
                const roleId = firstRole.data('id');
                if (roleId) {

                    fetchModulesForCrm(roleId);
                }

            } else {
                $('#roledata').html("No roles data availabale.");
            }
        },
        error: function (response) {}
    });
}
// "All" checkbox click function
function toggleRowPrivileges(tableSelector) {
    $(tableSelector).on('change', '.row-select-all', function () {
        const isChecked = $(this).is(':checked');
        const $row = $(this).closest('tr');

        $row.find('input.create, input.index, input.edit, input.delete').prop('checked', isChecked);
    });

    $(tableSelector).on('change', 'input.create, input.index, input.edit, input.delete', function () {
        const $row = $(this).closest('tr');
        const allChecked = $row.find('input.create, input.index, input.edit, input.delete').length ===
            $row.find('input.create:checked, input.index:checked, input.edit:checked, input.delete:checked').length;

        $row.find('.row-select-all').prop('checked', allChecked);
    });
}

function deleteCrmRole(id, comapnyId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You would like to delete this Role!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4682b4',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Set the CSRF token for the AJAX request
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "DELETE",
                url: "/crm/admin/companies/deleteCrmroles/" + id,
                data: {
                    id: id,
                    _token: $('input[name="_token"]').val() // CSRF token
                },
                success: function (data) {
                    if (data.status == 200) {
                        Swal.fire({
                            title: "Good job!",
                            text: "Role Deleted Successfully!",
                            icon: "success",
                            confirmButtonText: "Ok",
                        }).then(() => {
                            // fetch_roles_data();
                            fetch_crm_roles_data(comapnyId);
                        });
                    } else {
                        // Handle unexpected status
                        Swal.fire({
                            title: "Error",
                            text: "Something went wrong!",
                            icon: "error",
                            confirmButtonText: "Ok",
                        });
                    }
                },
                error: function (xhr) {
                    // Handle errors
                    Swal.fire({
                        title: "Error",
                        text: xhr.responseJSON.message || "An error occurred.",
                        icon: "error",
                        confirmButtonText: "Ok",
                    });
                }
            });
        } else {
            Swal.fire({
                title: "Cancelled",
                text: "Your operation has been cancelled",
                icon: "error",
                confirmButtonText: "Ok",
            });
        }
    });
}

function updateSelectAllCheckboxes(tableId) {
    $(`#${tableId} tbody tr`).each(function () {
        const $row = $(this);
        const totalCheckboxes = $row.find('input.create, input.index, input.edit, input.delete').length;
        const checkedCheckboxes = $row.find('input.create:checked, input.index:checked, input.edit:checked, input.delete:checked').length;

        const allChecked = totalCheckboxes > 0 && totalCheckboxes === checkedCheckboxes;
        $row.find('.row-select-all').prop('checked', allChecked);

        // Uncheck the "Select All" checkbox if not all checkboxes are selected
        if (checkedCheckboxes < totalCheckboxes) {
            $row.find('.row-select-all').prop('checked', false);
        }
    });
}
// Call the function for different tables
function updateCrmPrivilegeCheckboxes() {
    updateSelectAllCheckboxes('privilege_table');
    updateSelectAllCheckboxes('update_role_privilege_table');
}

function updateShopPrivilegeCheckboxes() {
    updateSelectAllCheckboxes('shop_privilege_table');
    updateSelectAllCheckboxes('update_shop_privilege_table');
}

function updateCmsPrivilegeCheckboxes() {
    updateSelectAllCheckboxes('cms_privilege_table');
    updateSelectAllCheckboxes('update_cms_role_privilege_table');
}

//if checkbox is empty Save button is disabled
function toggleSaveButton() {
    const isChecked = $('#privilege_table input[type="checkbox"]:checked').length > 0;
    $('.saveCrmPrivileges').prop('disabled', !isChecked);
}
/***********   crm end ****************/
/***********  Cms start **************/
function fetch_cms_roles_data(companyId) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/crm/admin/companies/getCmsroles/${companyId}`,
        type: "GET",
        success: function (result) {
            if (result.status_code == 200) {
                $('#CmsRoledata').html(result.html);
                const firstRole = $('.role-selector_cms').first();
                const roleId = firstRole.data('id');
                if (roleId) {

                    fetchModulesForCms(roleId);
                }

            } else {
                $('#Cmsroledata').html("No roles data availabale.");
            }
        },
        error: function (response) {}
    });
}

/**Crm Settings privileges */
function fetchModulesForCms(roleId) {
    $.ajax({
        url: '/crm/admin/companies/get-modules-by-cms',
        type: 'GET',
        data: {
            role_id: roleId
        },
        success: function (response) {
            updateCmsModuleList(response);

        },
        error: function (err) {
            console.error("Error fetching modules:", err);
        }
    });
}

function updateCmsModuleList(response) {
    const tbody = $('#cms_privilege_table tbody');
    const updateTbody = $('#update_cms_role_privilege_table tbody');
    tbody.empty();
    updateTbody.empty();
    $("#update_Cms_roleregisterForm").find('input[name="cms_update_role"]').val(response.role.display_name)

    // Handle modules and permissions from the response
    const modules = response.modules || [];
    const permissions = response.data || [];

    if (modules.length != 0) {
        modules.forEach(module => {
            const row = `
                <tr class="border-bottom">
                    <td data-id="${module.id}">${module.name}</td>
                    <td class="text-center" data-allid="${module.id}_all">
                        <input type="checkbox" class="row-select-all">
                    </td>
                     <td class="text-center" data-indexid="${module.id}_index">
                        <input type="checkbox" class="index" ${permissions.includes('cms.' + module.slug + '.index') ? 'checked' : ''}>
                    </td>
                    <td class="text-center" data-createid="${module.id}_create">
                        <input type="checkbox" class="create" ${permissions.includes('cms.' + module.slug + '.create') ? 'checked' : ''}>
                    </td>                 
                    <td class="text-center" data-editid="${module.id}_edit">
                        <input type="checkbox" class="edit" ${permissions.includes('cms.' + module.slug + '.edit') ? 'checked' : ''}>
                    </td>
                    <td class="text-center" data-deleteid="${module.id}_delete">
                        <input type="checkbox" class="delete" ${permissions.includes('cms.' + module.slug + '.delete') ? 'checked' : ''}>
                    </td>
                   <td class="text-center" data-blockid="${module.id}_block">
                        <input type="checkbox" class="block" ${module.is_blocked ? 'checked' : ''}>
                    </td>
                    <td class="text-center" data-enableid="${module.id}_enable">
                        <input type="checkbox" class="enable" ${module.is_enabled ? 'checked' : ''}>
                    </td>
                </tr>
            `;
            tbody.append(row);
            updateTbody.append(row);
        });
    }
    updateCmsPrivilegeCheckboxes();
}
/**User login start */
function openUserDetails(userId, companyId) {
    $.ajax({
        url: '/crm/admin/companies/getuserdetails/' + userId, // URL to get user details
        method: 'GET',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            userId: userId,
            companyId: companyId // Include CSRF token
        },
        success: function (result) {
            if (result && result.data) {
                const user = result.data;
                // Populate the offcanvas with the user details
                $('#Name').text(user.navn);
                $('#userId').text(user.id);
                $('#Email').text(user.email);
                if (user.userlevel == 1) {
                    $('#Type').text('User');
                } else if (user.userlevel == 2) {
                    $('#Type').text('Supervisor');
                }
                // Handle user status: Blocked or Active
                if (user.oensker_email_ved_specifik_sag == 0) {
                    $('#userStatusSwitch').prop('checked', false); // Set checkbox to unchecked (if needed)
                } else if (user.oensker_email_ved_specifik_sag == 1) {
                    $('#userStatusSwitch').prop('checked', true); // Set checkbox to checked (if needed)
                }


                // Show the offcanvas
                var myOffcanvas = new bootstrap.Offcanvas(document.getElementById('userLoginOffcanvas'));
                myOffcanvas.show();
            }
        },
        error: function () {
            Swal.fire("Error!", "error", "warning");
        }
    });
}

function editUserlogin(userId, companyId) {
    $.ajax({
        url: "/crm/admin/companies/editUserlogin/" + userId,
        method: 'GET',
        data: {
            userId: userId,
            companyId: companyId
        },
        success: function (result) {
            if (result && result.data) {
                var user = result.data;
                // Populate the form with the fetched user data
                $('#editUserLoginForm [name="name"]').val(user.navn);
                $('#editUserLoginForm [name="username"]').val(user.brugernavn);
                $('#editUserLoginForm [name="email"]').val(user.email);
                $('#editUserLoginForm [name="user_type"]').val(user.userlevel);
                $('#editUserLoginForm [name="user_id"]').val(userId);

                if (result.data.oensker_email_ved_specifik_sag == 1) {
                    $('#editUserLoginForm [name="status"]').prop('checked', true);
                } else {
                    $('#editUserLoginForm [name="status"]').prop('checked', false);
                }

                var myOffcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasEdituser'));
                myOffcanvas.show();
            }
        }
    });
}

function deleteUserlogin(id, companyId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You would like to delete this Role!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4682b4',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Set the CSRF token for the AJAX request
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "DELETE",
                url: "/crm/admin/companies/bulkDeleteUsers",
                data: {
                    userIds: id,
                    companyId: companyId,
                    _token: $('input[name="_token"]').val() // CSRF token
                },
                success: function (data) {
                    if (data.status == 200) {
                        Swal.fire({
                            title: "Good job!",
                            text: "User Deleted Successfully!",
                            icon: "success",
                            confirmButtonText: "Ok",
                        }).then(() => {
                            fetchuserLoginlist('update', companyId);
                        });
                    } else {
                        // Handle unexpected status
                        Swal.fire({
                            title: "Error",
                            text: "Something went wrong!",
                            icon: "error",
                            confirmButtonText: "Ok",
                        });
                    }
                },
                error: function (xhr) {
                    // Handle errors
                    Swal.fire({
                        title: "Error",
                        text: xhr.responseJSON.message || "An error occurred.",
                        icon: "error",
                        confirmButtonText: "Ok",
                    });
                }
            });
        } else {
            Swal.fire({
                title: "Cancelled",
                text: "Your operation has been cancelled",
                icon: "error",
                confirmButtonText: "Ok",
            });
        }
    });
}
/**User login end */

//store role function
function submitCmsCreateRoleForm() {
    const roleName = $('input[name="cms_role"]').val();
    const permissions = extractPermissions('#cms_role_privilege_table');
    const companyId = $(this).data('companyid');
    if ($('#CmsroleregisterForm').valid()) {
        $('.SubmitCmsCreateRoleForm').prop('disabled', true);
        $.ajax({
            url: "/crm/admin/companies/createCmsPrivileges",
            type: "POST",
            data: {
                _token: $('input[name="_token"]').val(),
                role: roleName,
                permission: permissions,
                companyId: companyId,
            },
            success: function (response) {
                if (response) {
                    // $('#CreateRolesModal').modal('hide');
                    $('#CmsoffcanvasRight').offcanvas('hide');
                    Swal.fire("Success!", "Role & Privileges updated.", "success").then(() => {
                        $('.SubmitCmsCreateRoleForm').prop('disabled', false);
                        clearCmsPrivileges();
                        fetch_cms_roles_data(companyId);
                    });
                }
            },
            error: function (xhr) {
                $('.SubmitCmsCreateRoleForm').prop('disabled', false);
                if (xhr.status === 409 && xhr.responseJSON && xhr.responseJSON.error) {
                    Swal.fire({
                        title: "Error",
                        text: xhr.responseJSON.error.role[0],
                        icon: "error",
                        confirmButtonText: "Ok",
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: "An unexpected error occurred.",
                        icon: "error",
                        confirmButtonText: "Ok",
                    });
                }

            }
        });
    }
}

function deleteCmsRole(id, comapnyId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You would like to delete this Role!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Set the CSRF token for the AJAX request
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "DELETE",
                url: "/crm/admin/companies/deleteCmsroles/" + id,
                data: {
                    id: id,
                    _token: $('input[name="_token"]').val() // CSRF token
                },
                success: function (data) {
                    if (data.status == 200) {
                        Swal.fire({
                            title: "Good job!",
                            text: "Role Deleted Successfully!",
                            icon: "success",
                            confirmButtonText: "Ok",
                        }).then(() => {
                            // fetch_roles_data();
                            fetch_cms_roles_data(comapnyId);
                        });
                    } else {
                        // Handle unexpected status
                        Swal.fire({
                            title: "Error",
                            text: "Something went wrong!",
                            icon: "error",
                            confirmButtonText: "Ok",
                        });
                    }
                },
                error: function (xhr) {
                    // Handle errors
                    Swal.fire({
                        title: "Error",
                        text: xhr.responseJSON.message || "An error occurred.",
                        icon: "error",
                        confirmButtonText: "Ok",
                    });
                }
            });
        } else {
            Swal.fire({
                title: "Cancelled",
                text: "Your operation has been cancelled",
                icon: "error",
                confirmButtonText: "Ok",
            });
        }
    });
}

function saveCmsPrivileges() {
    $('.saveCmsPrivileges').prop('disabled', true);
    const roleId = $('.role-item.selected').data('id');
    const permissions = extractPermissions('#cms_privilege_table');
    $.ajax({
        url: '/crm/admin/companies/saveCmsPrivileges',
        type: 'POST',
        data: {
            _token: $('input[name="_token"]').val(),
            role_id: roleId,
            permission: permissions,
        },
        success: function (response) {
            Swal.fire({
                title: "Good job!",
                text: response.success,
                icon: "success",
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: 'alert-button-color'
                }
            });
        },
        error: function (err) {
            $('.saveCmsPrivileges').prop('disabled', false);
            if (xhr.status === 409 && xhr.responseJSON && xhr.responseJSON.error) {
                Swal.fire({
                    title: "Error",
                    text: xhr.responseJSON.error.roleName[0],
                    icon: "error",
                    confirmButtonText: "Ok",
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: "An unexpected error occurred.",
                    icon: "error",
                    confirmButtonText: "Ok",
                });
            }
        }
    });
}

function saveUpdateCmsPrivileges() {
    const roleId = $('.role-item.selected').data('id');
    const companyId = $('.role-item.selected').data('companyid');
    const permissions = extractPermissions('#update_cms_role_privilege_table');
    const roleName = $('#update_Cms_roleregisterForm').find("input[name='cms_update_role']").val();
    if ($('#update_Cms_roleregisterForm').valid()) {
        $('.SubmitCmsUpdateRoleForm').prop('disabled', true);
        $.ajax({
            url: '/crm/admin/companies/saveCmsPrivileges',
            type: 'POST',
            data: {
                _token: $('input[name="_token"]').val(),
                role_id: roleId,
                permission: permissions,
                roleName: roleName,
                companyId: companyId,
            },
            success: function (response) {
                $('.SubmitCmsUpdateRoleForm').prop('disabled', false);
                Swal.fire("Success!", "Role & Privileges updated.", "success").then(() => {
                    $('#cmsUpdateOffcanvasRight').offcanvas('hide');
                    fetch_cms_roles_data(companyId);
                });
            },
            error: function (xhr) {
                // console.error("Error saving privileges:", err);
                $('.SubmitCmsUpdateRoleForm').prop('disabled', false);
                if (xhr.status === 409 && xhr.responseJSON && xhr.responseJSON.error) {
                    Swal.fire({
                        title: "Error",
                        text: xhr.responseJSON.error.roleName[0],
                        icon: "error",
                        confirmButtonText: "Ok",
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: "An unexpected error occurred.",
                        icon: "error",
                        confirmButtonText: "Ok",
                    });
                }
            }
        });
    }
}

//if checkbox is empty Save button is disabled
function cmsToggleSaveButton() {
    const isChecked = $('#cms_privilege_table input[type="checkbox"]:checked').length > 0;
    $('.saveCmsPrivileges').prop('disabled', !isChecked);
}

function shopToggleSaveButton() {
    const isChecked = $('#shop_privilege_table input[type="checkbox"]:checked').length > 0;
    $('.saveShopPrivileges').prop('disabled', !isChecked);
}

function initializeIntlTelInput(phoneInputField) {
    var phoneInput = document.querySelector(phoneInputField);
    if (!phoneInput || phoneInput.classList.contains('iti-initialized')) return null; // Return null if already initialized

    var intelInputPhone = window.intlTelInput(phoneInput, {
        initialCountry: "us", // Default country 
        formatOnDisplay: true,
        // separateDialCode: true,
        hiddenInput: "full_number",
        preferredCountries: ['us'], // Preferred countries
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.14/js/utils.js"
    });

    // Automatically update the placeholder and mask based on the selected country
    $(phoneInputField).on("countrychange", function (event) {
        var selectedCountryData = intelInputPhone.getSelectedCountryData();
        var newPlaceholder = intlTelInputUtils.getExampleNumber(selectedCountryData.iso2, true, intlTelInputUtils.numberFormat.INTERNATIONAL);
        intelInputPhone.setNumber(""); // Clear the phone number temporarily
        var mask = newPlaceholder.replace(/[1-9]/g, "0");
        $(this).mask(mask);
    });

    intelInputPhone.promise.then(function () {
        $(phoneInputField).trigger("countrychange");
    });

    phoneInput.classList.add('iti-initialized');

    return intelInputPhone;
}

function clearCmsPrivileges() {
    $('#CmsroleregisterForm input[type="checkbox"]').prop('checked', false);
    $("#CmsroleregisterForm").find('input[name="cms_role"]').val('');
    $("#CmsroleregisterForm").find('input[name="cms_role"]').attr("placeholder", 'Enter Role Name').removeClass('validation');
}

function clearCrmPrivileges() {
    $('#roleregisterForm input[type="checkbox"]').prop('checked', false);
    $("#roleregisterForm").find('input[name="role"]').val('');
    $("#roleregisterForm").find('input[name="role"]').attr("placeholder", 'Enter Role Name').removeClass('validation');
}
// Shop function start //
function updateShopModuleList(response) {
    const tbody = $('#shop_privilege_table tbody');
    const updateTbody = $('#update_shop_privilege_table tbody');
    tbody.empty();
    updateTbody.empty();
    $("#update_Shop_roleregisterForm").find('input[name="shop_update_role"]').val(response.role.display_name)

    // Handle modules and permissions from the response
    const modules = response.modules || [];
    const permissions = response.data || [];

    if (modules.length != 0) {
        modules.forEach(module => {
            const row = `
                <tr class="border-bottom">
                    <td data-id="${module.id}">${module.name}</td>
                    <td class="text-center" data-allid="${module.id}_all">
                        <input type="checkbox" class="row-select-all">
                    </td>
                     <td class="text-center" data-indexid="${module.id}_index">
                        <input type="checkbox" class="index" ${permissions.includes('crm.' + module.slug + '.index') ? 'checked' : ''}>
                    </td>
                    <td class="text-center" data-createid="${module.id}_create">
                        <input type="checkbox" class="create" ${permissions.includes('crm.' + module.slug + '.create') ? 'checked' : ''}>
                    </td>                 
                    <td class="text-center" data-editid="${module.id}_edit">
                        <input type="checkbox" class="edit" ${permissions.includes('crm.' + module.slug + '.edit') ? 'checked' : ''}>
                    </td>
                    <td class="text-center" data-deleteid="${module.id}_delete">
                        <input type="checkbox" class="delete" ${permissions.includes('crm.' + module.slug + '.delete') ? 'checked' : ''}>
                    </td>
                   <td class="text-center" data-blockid="${module.id}_block">
                        <input type="checkbox" class="block" ${module.is_blocked ? 'checked' : ''}>
                    </td>
                    <td class="text-center" data-enableid="${module.id}_enable">
                        <input type="checkbox" class="enable" ${module.is_enabled ? 'checked' : ''}>
                    </td>
                </tr>
            `;
            tbody.append(row);
            updateTbody.append(row);
        });
    }
    updateShopPrivilegeCheckboxes();
}

function fetchModulesForShop(roleId) {
    $.ajax({
        url: '/crm/admin/shop/get-modules-by-shop',
        type: 'GET',
        data: {
            role_id: roleId
        },
        success: function (response) {
            updateShopModuleList(response);
        },
        error: function (err) {
            console.error("Error fetching modules:", err);
        }
    });
}

function fetch_shop_roles_data(companyId) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/crm/admin/shop/getShopRoles/${companyId}`,
        type: "GET",
        success: function (result) {
            if (result.status_code == 200) {
                $('#shopRoledata').html(result.html);
                const firstRole = $('.role-selector_shop').first();
                const roleId = firstRole.data('id');
                if (roleId) {
                    fetchModulesForShop(roleId);
                }
            } else {
                $('#shopRoledata').html("No roles data availabale.");
            }
        },
        error: function (response) {}
    });
}

function submitShopCreateRoleForm() {
    const roleName = $('input[name="shop_role"]').val();
    const permissions = extractPermissions('#shop_role_privilege_table');
    const companyId = $(this).data('companyid');
    if ($('#shopRoleregisterForm').valid()) {
        $('.SubmitShopCreateRoleForm').prop('disabled', true);
        $.ajax({
            url: "/crm/admin/shop/createShopPrivileges",
            type: "POST",
            data: {
                _token: $('input[name="_token"]').val(),
                role: roleName,
                permission: permissions,
                companyId: companyId,
            },
            success: function (response) {
                if (response.status) {
                    $('#shopOffcanvas').offcanvas('hide');
                    Swal.fire("Success!", "Role & Privileges updated.", "success").then(() => {
                        $('.SubmitShopCreateRoleForm').prop('disabled', false);
                        fetch_shop_roles_data(companyId);
                    });
                } else {
                    $('.SubmitShopCreateRoleForm').prop('disabled', false);
                    Swal.fire({
                        title: "Error",
                        text: 'Something went wrong',
                        icon: "error",
                        confirmButtonText: "Ok",
                    });
                }
            },
            error: function (xhr) {
                $('.SubmitShopCreateRoleForm').prop('disabled', false);
                if (xhr.status === 409 && xhr.responseJSON && xhr.responseJSON.error) {
                    Swal.fire({
                        title: "Error",
                        text: xhr.responseJSON.error.role[0],
                        icon: "error",
                        confirmButtonText: "Ok",
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: "An unexpected error occurred.",
                        icon: "error",
                        confirmButtonText: "Ok",
                    });
                }
            }
        });
    }
}

function saveShopPrivileges() {
    $('.saveShopPrivileges').prop('disabled', true);
    const roleId = $('.role-item.selected').data('id');
    const permissions = extractPermissions('#shop_privilege_table');
    $.ajax({
        url: '/crm/admin/shop/saveShopPrivileges',
        type: 'POST',
        data: {
            _token: $('input[name="_token"]').val(),
            role_id: roleId,
            permission: permissions,
        },
        success: function (response) {
            Swal.fire({
                title: "Good job!",
                text: response.success,
                icon: "success",
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: 'alert-button-color'
                }
            });
        },
        error: function (err) {
            $('.saveShopPrivileges').prop('disabled', false);
            if (xhr.status === 409 && xhr.responseJSON && xhr.responseJSON.error) {
                Swal.fire({
                    title: "Error",
                    text: xhr.responseJSON.error.roleName[0],
                    icon: "error",
                    confirmButtonText: "Ok",
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: "An unexpected error occurred.",
                    icon: "error",
                    confirmButtonText: "Ok",
                });
            }
        }
    });
}

function saveUpdateShopPrivileges() {
    const roleId = $('.role-item.selected').data('id');
    const companyId = $('.role-item.selected').data('companyid');
    const permissions = extractPermissions('#update_shop_privilege_table');
    const roleName = $('#update_Shop_roleregisterForm').find("input[name='shop_update_role']").val();
    if ($('#update_Shop_roleregisterForm').valid()) {
        $('.SubmitShopUpdateRoleForm').prop('disabled', true);
        $.ajax({
            url: '/crm/admin/shop/saveShopPrivileges',
            type: 'POST',
            data: {
                _token: $('input[name="_token"]').val(),
                role_id: roleId,
                permission: permissions,
                roleName: roleName,
                companyId: companyId,
            },
            success: function (response) {
                $('.SubmitShopUpdateRoleForm').prop('disabled', false);
                Swal.fire("Success!", "Role & Privileges updated.", "success").then(() => {
                    $('#shopUpdateOffcanvasRight').offcanvas('hide');
                    fetch_shop_roles_data(companyId);
                });
            },
            error: function (xhr) {
                $('.SubmitShopUpdateRoleForm').prop('disabled', false);
                if (xhr.status === 409 && xhr.responseJSON && xhr.responseJSON.error) {
                    Swal.fire({
                        title: "Error",
                        text: xhr.responseJSON.error.roleName[0],
                        icon: "error",
                        confirmButtonText: "Ok",
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: "An unexpected error occurred.",
                        icon: "error",
                        confirmButtonText: "Ok",
                    });
                }
            }
        });
    }
}

function deleteShopRole(id, comapnyId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You would like to delete this Role!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Set the CSRF token for the AJAX request
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "DELETE",
                url: "/crm/admin/shop/deleteShoproles/" + id,
                data: {
                    id: id,
                    _token: $('input[name="_token"]').val() // CSRF token
                },
                success: function (data) {
                    if (data.status == 200) {
                        Swal.fire({
                            title: "Good job!",
                            text: "Role Deleted Successfully!",
                            icon: "success",
                            confirmButtonText: "Ok",
                        }).then(() => {
                            // fetch_roles_data();
                            fetch_shop_roles_data(comapnyId);
                        });
                    } else {
                        // Handle unexpected status
                        Swal.fire({
                            title: "Error",
                            text: "Something went wrong!",
                            icon: "error",
                            confirmButtonText: "Ok",
                        });
                    }
                },
                error: function (xhr) {
                    // Handle errors
                    Swal.fire({
                        title: "Error",
                        text: xhr.responseJSON.message || "An error occurred.",
                        icon: "error",
                        confirmButtonText: "Ok",
                    });
                }
            });
        } else {
            Swal.fire({
                title: "Cancelled",
                text: "Your operation has been cancelled",
                icon: "error",
                confirmButtonText: "Ok",
            });
        }
    });
}

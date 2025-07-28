(function () {
    fetchAdminuserList('initial');
    $('#createAdminuser').on('hidden.bs.offcanvas', function () {
        $('#userResgisterform')[0].reset();
        $('#userResgisterform').find('input[name="name"]').attr("placeholder", "Name").removeClass('validation');
        $('#userResgisterform').find('input[name="user_phone"]').attr("placeholder", "(201) 555-0123").removeClass('validation');
        $('#userResgisterform').find('input[name="email"]').attr("placeholder", "Email").removeClass('validation');
        $('#userResgisterform').find('select[name="user_type"]').attr("placeholder", "").removeClass('validation');
    });
    $('#editAdminuser').on('hidden.bs.offcanvas', function () {
        $('#editUserForm')[0].reset();
        $('#editUserForm').find('input[name="name"]').attr("placeholder", "Name").removeClass('validation');
        $('#editUserForm').find('input[name="user_phone"]').attr("placeholder", "(201) 555-0123").removeClass('validation');
        $('#editUserForm').find('input[name="email"]').attr("placeholder", "Email").removeClass('validation');
        $('#editUserForm').find('select[name="user_type"]').attr("placeholder", "").removeClass('validation');
    });
    $('#offcanvasTop').on('hidden.bs.offcanvas', function () {
        $('#resetPasswordForm')[0].reset();
        $('#reset_password').attr("placeholder", "New Password").removeClass('validation');
        $(".alert").hide()
    });
    $('body').on('click', '#createCompany', function () {
        initializeIntlTelInput("#userPhone");
    })
    //Adminuser info store funtion start
    $('.submitUserregisterForm').on('click', function (e) {
        e.preventDefault();
        // Disable the button to prevent multiple clicks during the request
        var submitButton = $(this);
        submitButton.prop('disabled', true).text('Saving...');
        return;
        if ($('#userResgisterform').valid()) {
            var formData = new FormData(document.getElementById("userResgisterform"));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/crm/admin/adminusers/store",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result.success) {
                        $('#createAdminuser').offcanvas('hide');
                        fetchAdminuserList('update');
                    }
                    resetSubmitButton();
                },
                error: function (xhr) {
                    if (xhr.status === 409 && xhr.responseJSON && xhr.responseJSON.error) {
                        Swal.fire({
                            title: "Error",
                            text: xhr.responseJSON.error,
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
                    resetSubmitButton();
                }
            });
        } else {
            resetSubmitButton();
        }

        function resetSubmitButton() {
            submitButton.prop('disabled', false).text('Save Details');
        }
    });
    //edit Adminuser function start
    $('body').on('click', '.editUser', function (e) {
        // e.preventDefault();
        var id = $(this).data('id');
        editUserForm(id);
    });
    //Adminuser details update function
    $('.UpdateUserregisterForm').on('click', function (e) {
        e.preventDefault();
        var submitButton = $(this);
        submitButton.prop('disabled', true).text('Saving...');
        if ($('#editUserForm').valid()) {
            var formData = new FormData(document.getElementById("editUserForm"));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/crm/admin/adminusers/update",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result.success) {
                        // $('#editAdminuser').offcanvas('hide');
                        $('#userDetailOffcanvas').offcanvas('hide');

                        fetchAdminuserList('update');
                    }
                    resetUpdateButton();
                },
                error: function (response) {
                    resetUpdateButton();
                }
            });
        } else {
            resetUpdateButton();
        }

        function resetUpdateButton() {
            submitButton.prop('disabled', false).text('Update');
        }
    });
    //deleteAdminuser function
    $('body').on('click', '.deleteUser', function () {
        var id = $(this).data('id');
        deleteUser(id);
        console.log(id)
    })
    //Adminuser details for reset password function start
    $('body').on('click', '.resetPassword', function (e) {
        // e.preventDefault();
        var id = $(this).data('id');
        resetUserpassword(id);
    });
    //Reset password store funtion start
    $('.resetUserPassword').on('click', function (e) {
        e.preventDefault();

        // Disable the button to prevent multiple clicks during the request
        var submitButton = $(this);
        submitButton.prop('disabled', true);
        submitButton.text('Processing...');

        const password = $('#reset_password').val();
        const id = $('#userId').val();
        const userEmail = $('#emailText').text();
        const userName = $('#userName').text();
        // Password validation
        const passwordPattern = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

        if (!passwordPattern.test(password)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Password',
                text: 'Password must be 10 characters long, contain one letter, one number, and one special character.'
            });
            submitButton.prop('disabled', false);
            submitButton.prop('disabled', false).html('<i class="bx bx-revision"></i> Reset');
            return;
        }
        // Show confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: "Reset password.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4682b4',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, reset it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Set the CSRF token for the AJAX request
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "/crm/admin/adminusers/resetpassword/" + id,
                    data: {
                        id: id,
                        password: password,
                        email: userEmail,
                        name: userName,
                        _token: $('input[name="_token"]').val() // CSRF token
                    },
                    success: function (data) {
                        if (data.status == 200) {
                            $('#offcanvasTop').find('.offcanvas-body').append(
                                '<div class="alert alert-success d-flex align-items-center gap-2" role="alert"><i class="bx bx-check-circle fs-4"></i><span>An example alert with an icon</span></div>'
                            );
                            // Set a timeout to hide the offcanvas after 3 seconds
                            setTimeout(function () {
                                $('#offcanvasTop').offcanvas('hide');
                            }, 2000);
                            // Re-enable the button after success                       
                        } else {
                            $('#offcanvasTop').offcanvas('hide');
                            // Handle unexpected status
                            Swal.fire({
                                title: "Error",
                                text: "Something went wrong!",
                                icon: "error",
                                confirmButtonText: "Ok",
                            });
                        }
                        submitButton.prop('disabled', false);
                        submitButton.html('<span><i class="bx bx-revision"></i> <span class="d-none d-sm-inline-block">Reset</span></span>');
                    },
                    error: function (xhr) {
                        // Handle errors
                        Swal.fire({
                            title: "Error",
                            text: xhr.responseJSON.message || "An error occurred.",
                            icon: "error",
                            confirmButtonText: "Ok",
                        });
                        // Re-enable the button after success
                        submitButton.prop('disabled', false);
                        submitButton.html('<span><i class="bx bx-revision"></i> <span class="d-none d-sm-inline-block">Reset</span></span>');
                    }
                });
            } else {
                Swal.fire({
                    title: "Cancelled",
                    text: "Your operation has been cancelled",
                    icon: "error",
                    confirmButtonText: "Ok",
                });
                submitButton.prop('disabled', false);
                submitButton.html('<span><i class="bx bx-revision"></i> <span class="d-none d-sm-inline-block">Reset</span></span>');
            }
        });
    });
    // Copy password functionality 
    $('#copyButton').on('click', function () {
        const passwordInput = $('#reset_password');
        const passwordValue = passwordInput.val();
        // Use the Clipboard API
        navigator.clipboard.writeText(passwordValue).then(() => {
            $('#copyButton').attr('data-bs-original-title', 'Copied to clipboard!').tooltip('show');
            setTimeout(() => {
                $('#copyButton').tooltip('hide');
            }, 1000);
        }).catch(err => {
            $('#copyButton').attr('data-bs-original-title', 'Failed to Copy').tooltip('show');
            setTimeout(() => {
                $('#copyButton').tooltip('hide');
            }, 1000);
        });
    });

})();

function fetchAdminuserList(type) {
    if (document.getElementById('adminuser_list_table')) {
        var useroptions = {
            "processing": true,
            "serverSide": true,
            "lengthMenu": [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            "iDisplayLength": 100,
            "order": [5, 'desc'],
            responsive: true,
            "destroy": true,
            "stateSave": type === 'initial' ? false : true,
            "ajax": {
                "url": "/crm/admin/adminusers/getuserslist",
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
            "columns": [{
                    "data": "id"
                },
                {
                    "data": "name"
                },
                {
                    "data": "email"
                },
                {
                    "data": "user_phone"
                },
                {
                    "data": "user_type"
                },
                {
                    "data": "actions",
                    "bSortable": false
                },
            ],
            "createdRow": function (row, data, dataIndex) {
                // Add custom classes
                $(row).addClass('userListIteam'); // Example class
                if (data.user_type === 'Super Admin') {
                    $(row).addClass('admin-row'); // Add a specific class based on user_type
                }
                // Add custom attributes
                $(row).attr('data-id', data.id); // Add data-id attribute

            }
        };

        var moduleTable = $('#adminuser_list_table').DataTable(useroptions);

        moduleTable.on('draw', function () {
            $('#adminuser_list_table tbody tr').each(function () {
                // Add 'dtr-control' class to the first <td> (company_id column)
                $(this).find('td:first').addClass('dtr-control');
            });
        });
        $('#adminuser_list_table_filter').html(`
            <div class="input-group position-relative float-end w-auto">
                <input type="text" class="form-control search-input rounded-1" placeholder="Search" aria-label="Search" style="padding-left: 30px;">
                <span class="input-group-text table-search-bar">
                    <i class="bx bx-search fs-6"></i>
                </span>
            </div>
        `);
        $('#adminuser_list_table_filter input').unbind().bind('keyup', function (e) {
            if (e.keyCode == 13) {
                moduleTable.search(this.value).draw();
            }
        });
        $('#adminuser_list_table').parent().addClass('table-responsive');
    }
}
$('#adminuser_list_table tbody').on('dblclick', '.userListIteam', function (e) {

    if ($(e.target).hasClass('resetPassword') || $(e.target).closest('.resetPassword').length) {
        // Do nothing if it's the resetPassword element
        return;
    }
    let userId = $(this).data('id');
    console.log('userId', userId);

    getUserDatails(userId)

})

$('.resetUserList').on('click', function (e) {
    console.log('testt');
    let userId = $(this).data('id');
    getUserDatails(userId)
})

function getUserDatails(userId) {
    $.ajax({
        url: '/crm/admin/adminusers/getuserdetails/' + userId, // URL to get user details
        method: 'GET',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
        },
        success: function (result) {
            console.log(result); // Check the result in console
            if (result && result.data) {
                $('#editUserForm input').prop('disabled', false);
                $('.addDeleteIcon').empty();
                $('.UpdateUserregisterForm').prop('disabled', false);
                $('.resetUserList').prop('disabled', false);
                const user = result.data;
                const roles = result.userRoles;
                console.log('user.id', user.id)
                $('#Name').val(user.name);
                $('#admin_user_id').text(user.id);
                $('#Email').val(user.email);
                $('#Phone').val(user.user_phone);
                $('#userID').val(user.id);

                $('.resetUserList').attr('data-id', user.id);
                // Set the user's admin type

                // Handle user block/unblock toggle button text
                if (user.is_blocked) {
                    $('#is_blocked').prop('checked', true);
                } else {
                    $('#is_blocked').prop('checked', false);
                }
                if (user.id == 1) {
                    $('#editUserForm input').prop('disabled', true);
                    let content = `<span>${user.display_name}</span>`
                    $('#selectRole').html(content);
                    $('.UpdateUserregisterForm').prop('disabled', true);
                    $('.resetUserList').prop('disabled', true);
                }
                if (user.id != 1) {

                    let AddDelelteICon = `<div class="font-22 deleteUser" data-id="${user.id}">	<i class='bx bx-trash' ></i>
                    </div>`;
                    $('.addDeleteIcon').append(AddDelelteICon);

                    let selectElementDiv = $('#selectRole');
                    selectElementDiv.empty();

                    const selectElement = $('<select>')
                        .attr('name', 'rolesSelect')
                        .attr('id', 'rolesSelect')
                        .addClass('form-select mb-2 mt-2')
                        .attr('aria-label', 'Default select example');
                    // Loop through the roles array
                    $.each(roles, function (index, role) {
                        // Append an option for each role
                        selectElement.append(`<option value="${role.id}" ${user.role_id == role.id ? 'selected' : ''}>${role.display_name}</option>`);
                    });
                    $('#selectRole').append(selectElement);
                }
                $('#userDetailOffcanvas').offcanvas('show');
            }
        },
        error: function () {
            alert('Error fetching user details.');
        }
    });
}
//edit Adminuser function
function editUserForm(id) {
    $.ajax({
        url: "/crm/admin/adminusers/edit/" + id,
        method: 'GET',
        success: function (result) {
            var editOffcanvas = $('#editAdminuser');
            editOffcanvas.find('input[name="name"]').val(result.data.name);
            editOffcanvas.find('input[name="email"]').val(result.data.email);
            // editOffcanvas.find('input[name="user_phone"]').val(result.data.user_phone);
            editOffcanvas.find('select[name="user_type"]').val(result.data.role_id).attr('selected', 'selected');
            editOffcanvas.find('input[name="user_id"]').val(result.data.id);
            if (result.data.is_blocked == 1) {
                editOffcanvas.find('input[name="is_blocked"]').prop('checked', true);
            } else {
                editOffcanvas.find('input[name="is_blocked"]').prop('checked', false);
            }
            // Initialize phone number input with the full number
            var userPhone = initializeIntlTelInput('#editAdminuser input[name="user_phone"]');
            console.log(userPhone)
            // Use setTimeout to ensure itiphone is initialized before setting the number
            setTimeout(function () {
                if (userPhone) {
                    userPhone.setNumber(result.data.user_phone.trim());
                }
            }, 500);
            $('#editAdminuser').offcanvas('show');
        }
    });
}
//Delete Adminuser function
function deleteUser(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You would like to delete this User!",
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
                url: "/crm/admin/adminusers/delete/" + id,
                data: {
                    id: id,
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
                            fetchAdminuserList('update');
                            $('#userDetailOffcanvas').offcanvas('hide');
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
//Reset password function
function resetUserpassword(id) {
    $.ajax({
        url: "/crm/admin/adminusers/getuserdetails/" + id,
        method: 'GET',
        success: function (result) {
            if (result && result.data) {
                var user = result.data;
                $('#userName').text(user.name || '');
                $('#userId').val(user.id || '');
                $('#userEmail').show();
                $('#emailText').text(user.email || '');
                $('#userType').text(user.display_name || '');

                // Show the off-canvas
                var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasTop'));
                offcanvas.show();
            }
        }
    });
}
// Function to open user details in offcanvas
function openUserDetails(id) {
    $.ajax({
        url: '/crm/admin/adminusers/getuserdetails/' + id, // URL to get user details
        method: 'GET',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
        },
        success: function (result) {
            console.log(result); // Check the result in console

            if (result && result.data) {
                const user = result.data; // Extract the user data

                $('#Name').text(user.name);
                $('#userId').text(user.id);
                $('#Email').text(user.email);
                $('#Phone').text(user.user_phone);
                // Set the user's admin type

                // Handle user block/unblock toggle button text
                if (user.is_blocked) {
                    $('#userBlockToggle').text('Unblock the user');
                } else {
                    $('#userBlockToggle').text('Block the user');
                }

                // Show the offcanvas
                var myOffcanvas = new bootstrap.Offcanvas(document.getElementById('userDetailOffcanvas'));
                myOffcanvas.show();
            }
        },
        error: function () {
            alert('Error fetching user details.');
        }
    });
}

function initializeIntlTelInput(phoneInputField) {
    console.log(phoneInputField)
  
    var phoneInput = $(phoneInputField).get(0); // Get the raw DOM element from the jQuery object
    if (!phoneInput || phoneInput.classList.contains('iti-initialized')) return null; // Return null if already initialized

    var intelInputPhone = window.intlTelInput(phoneInput, {
        initialCountry: "DK", // Default country 
        formatOnDisplay: true,
        // separateDialCode: true,
        hiddenInput: "full_number",
        preferredCountries: ['DK'], // Preferred countries
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

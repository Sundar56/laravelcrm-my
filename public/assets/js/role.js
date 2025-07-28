(function () {
    fetch_roles_data();
    $('#CreateRolesOffcanvas').on('hidden.bs.offcanvas', function () {
        // Reset the form fields
        $('#roleregisterForm')[0].reset();
        $('#roleregisterForm').find('input[name="role"]').attr("placeholder", "Enter Role Name").removeClass('validation');
    });
    $('#EditRolesOffcanvas').on('hidden.bs.offcanvas', function () {
        // Reset the form fields
        $('#editroleregisterForm')[0].reset();
        $('#editroleregisterForm').find('input[name="role"]').attr("placeholder", "Enter Role Name").removeClass('validation');
    });
    // role selection
    $('body').on('click', '.role-selector', function () {
        const roleId = $(this).data('id');
        $('.role-item').removeClass('selected');
        $(this).closest('li').addClass('selected');
        toggleSaveButton();
        fetchModulesForRole(roleId);
    });
    //store role & Privileges function 
    $('.savePrivileges').on('click', savePrivileges);
    $('.SubmitCreateRoleForm').on('click', submitCreateRoleForm);
    $('.UpdateRoleForm').on('click', UpdateRoleForm);

    // "All" checkbox click function
    toggleRowPrivileges('#privilege_table');
    toggleRowPrivileges('#edit_role_privilege_table');
    toggleRowPrivileges('#role_privilege_table');

    // Save button change function
    $('#privilege_table').on('change', 'input[type="checkbox"]', toggleSaveButton);

    // Reset button click event
    $('#resetPrivileges').on('click', function () {
        $('#privilege_table input[type="checkbox"]').prop('checked', false);
        toggleSaveButton();
    });
    // search function
    $('#searchPrivileges').on('keyup', function () {
        const searchTerm = $(this).val().toLowerCase();
        $('#privilege_table tbody tr').filter(function () {
            // Get the module name and check 
            $(this).toggle($(this).find('td').first().text().toLowerCase().indexOf(searchTerm) > -1);
        });
    });
    //deleterole function
    $('body').on('click', '.deleteRoles', function () {
        var id = $(this).data('id');
        deleteRole(id);
    })
    //Editrole function
    $('body').on('click', '.EditRolesModal', function () {
        var id = $(this).data('id');
        editRole(id);
    })

    //end role
})();
//***********************************************************//
//***********************************************************//

function fetchModulesForRole(roleId) {
    $.ajax({
        url: '/crm/admin/roles/get-modules-by-role',
        type: 'GET',
        data: {
            role_id: roleId
        },
        success: function (response) {
            console.log(response)
            updateModuleList(response);

        },
        error: function (err) {
            console.error("Error fetching modules:", err);
        }
    });
}

function extractPermissions(tableSelector) {
    const permissions = [];
    $(tableSelector + ' tbody tr').each(function () {
        const moduleId = $(this).find('td[data-id]').data('id');

        // Check if the "Select All" checkbox is checked
        if ($(this).find('input.row-select-all').is(':checked')) {
            permissions.push(`${moduleId}_all`);
        }

        // Check individual permissions
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
        if ($(this).find('input.block').is(':checked')) {
            permissions.push(`${moduleId}_block`);
        }
        if ($(this).find('input.enable').is(':checked')) {
            permissions.push(`${moduleId}_enable`);
        }
    });
    console.log(permissions)
    return permissions;
}
//store role function
function submitCreateRoleForm() {
    // Disable the button to prevent multiple clicks during the request
    var submitButton = $(this);
    submitButton.prop('disabled', true);
    submitButton.text('Saving...');
    const roleName = $('input[name="role"]').val();
    const permissions = extractPermissions('#role_privilege_table');
    if ($('#roleregisterForm').valid()) {
        $.ajax({
            url: "/crm/admin/roles/store",
            type: "POST",
            data: {
                _token: $('input[name="_token"]').val(),
                role: roleName,
                permission: permissions,
            },
            success: function (response) {
                if (response) {
                    $('#CreateRolesOffcanvas').offcanvas('hide');
                    Swal.fire("Success!", "Role & Privileges updated.", "success").then(() => {
                        fetch_roles_data();
                    });
                }
                // Re-enable the button after success
                submitButton.prop('disabled', false);
                submitButton.text('Add Role');
            },
            error: function (xhr) {
                // Handle error
                // Re-enable the button after success
                submitButton.prop('disabled', false);
                submitButton.text('Add Role');
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.error) {
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
    } else {
        // If the form is invalid, re-enable the button
        submitButton.prop('disabled', false);
        submitButton.text('Add Role');
    }
}
//store Privileges function
function savePrivileges() {
    // Disable the button to prevent multiple clicks during the request
    var submitButton = $(this);
    submitButton.prop('disabled', true);
    submitButton.text('Saving...');
    const roleId = $('.role-item.selected').data('id');
    const permissions = extractPermissions('#privilege_table');
    $.ajax({
        url: '/crm/admin/roles/savePrivileges',
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
            // Re-enable the button after success
            submitButton.prop('disabled', false);
            submitButton.text('Save Details');
        },
        error: function (xhr) {
            console.error("Error saving privileges:", err);
            // Re-enable the button after success
            submitButton.prop('disabled', false);
            submitButton.text('Save Details');
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.error) {
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
//Edit roles function
function editRole(id) {
    $.ajax({
        url: "/crm/admin/roles/edit/" + id,
        method: 'GET',
        success: function (result) {
            console.log(result)
            var editModalBody = $('#EditRolesOffcanvas');
            editModalBody.find('input[name="role_name"]').val(result.data.display_name);
            editModalBody.find('input[name="role_id"]').val(result.data.id);
            editPrivileges(result);
            // $('#EditRolesModal').modal('show');
            $('#EditRolesOffcanvas').offcanvas('show');
        }
    });
}
//if checkbox is empty Save button is disabled
function toggleSaveButton() {
    const isChecked = $('#privilege_table input[type="checkbox"]:checked').length > 0;
    $('.savePrivileges').prop('disabled', !isChecked);
}

function fetch_roles_data() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/crm/admin/roles/getroles",
        type: "GET",
        success: function (result) {
            if (result.status_code == 200) {
                $('#roledata').html(result.html);
                const firstRole = $('.role-selector').first();
                const roleId = firstRole.data('id');
                fetchModulesForRole(roleId);
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

function deleteRole(id) {
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
                url: "/crm/admin/roles/delete/" + id,
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
                            fetch_roles_data();
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
//store role function
function UpdateRoleForm() {
    // Disable the button to prevent multiple clicks during the request
    var submitButton = $(this);
    submitButton.prop('disabled', true);
    submitButton.text('Saving...');
    const roleName = $('#roleName').val();
    console.log(roleName);

    const roleId = $('#roleId').val();
    console.log(roleId);
    const permissions = extractPermissions('#edit_role_privilege_table');
    if ($('#editroleregisterForm').valid()) {
        $.ajax({
            url: "/crm/admin/roles/update",
            type: "POST",
            data: {
                _token: $('input[name="_token"]').val(),
                role: roleName,
                role_id: roleId,
                permission: permissions,
            },
            success: function (response) {
                if (response) {
                    $('#EditRolesOffcanvas').offcanvas('hide');
                    Swal.fire("Success!", "Role & Privileges updated.", "success").then(() => {
                        fetch_roles_data();
                    });
                }
                // Re-enable the button after success
                submitButton.prop('disabled', false);
                submitButton.text('Save Details');
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
                // Handle error
                // Re-enable the button after success
                submitButton.prop('disabled', false);
                submitButton.text('Save Details');
            }

        });
    } else {
        // If the form is invalid, re-enable the button
        submitButton.prop('disabled', false);
        submitButton.text('Save Details');
    }
}
// Function to check "All" checkbox if necessary
function updateSelectAllCheckboxes() {
    const tables = ['#privilege_table', '#edit_role_privilege_table'];

    tables.forEach(table => {
        $(`${table} tbody tr`).each(function () {
            const $row = $(this);
            const totalCheckboxes = $row.find('input.create, input.index, input.edit, input.delete').length;
            const checkedCheckboxes = $row.find('input.create:checked, input.index:checked, input.edit:checked, input.delete:checked').length;

            // Set the "Select All" checkbox based on whether all relevant checkboxes are checked
            const allChecked = totalCheckboxes > 0 && totalCheckboxes === checkedCheckboxes;
            $row.find('.row-select-all').prop('checked', allChecked);
        });
    });
}

function renderModuleRows(modules, permissions, tbody) {
    tbody.empty();

    if (modules.length !== 0) {
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
        });
    }
}

function updateModuleList(response) {
    const tbody = $('#privilege_table tbody');
    const modules = response.modules || [];
    const permissions = response.actions || [];

    renderModuleRows(modules, permissions, tbody);
    updateSelectAllCheckboxes();
}

function editPrivileges(response) {
    const tbody = $('#edit_role_privilege_table tbody');
    const modules = response.modules || [];
    const permissions = response.actions || [];

    console.log(permissions);
    console.log(modules);

    renderModuleRows(modules, permissions, tbody);
    updateSelectAllCheckboxes();
}

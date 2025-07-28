<div class="row">
    <div class="d-flex flex-column flex-md-row mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="head-label text-left">
                <h6 class="offcanvas-title d-flex align-items-center">
                    <span class="me-1 fs-5"><i class="bx bx-cog"></i></span><span class="pt-1">Shop Settings</span>
                </h6>
            </div>
        </div>
    </div>
    <hr>
    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
        <div class="mb-3 h-100 border rounded">
            <div class="card-header flex-column flex-md-row mt-2">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="head-label text-left">
                        <h6 class="card-title mb-0">Roles</h6>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#shopOffcanvas" aria-controls="shopOffcanvas">
                            <span><i class="bx bx-plus"></i><span class="d-none d-sm-inline-block">Add Roles</span></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body" id="shopRoledata">
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
        <div class="border rounded">
            <form id="privilegesForm">
                @csrf
                <div class="card-header flex-column flex-md-row mt-1">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div class="head-label text-left mt-1">
                            <h6 class="card-title mb-0">Privileges</h6>
                        </div>
                        <div class="text-end mt-2">
                            <div class="input-group position-relative w-auto float-end">
                                <input type="text" class="form-control rounded-1" id="shopSearch" placeholder="Search" aria-label="Search privileges" style="padding-left: 40px;">
                                <span class="input-group-text" style="position: absolute; left: 2px; top: 50%; transform: translateY(-50%); background: transparent; border: none; pointer-events: none;">
                                    <i class="bx bx-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless" id="shop_privilege_table">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-nowrap">Modules</th>
                                    <th class="text-nowrap text-center">All</th>
                                    <th class="text-nowrap text-center">View</th>
                                    <th class="text-nowrap text-center">Create</th>
                                    <th class="text-nowrap text-center">Edit</th>
                                    <th class="text-nowrap text-center">Delete</th>
                                    <th class="text-nowrap text-center">Block/Unblock</th>
                                    <th class="text-nowrap text-center">Enable/Disable</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-light" id="shopResetPrivileges">Reset</button>
                        <button type="button" class="btn btn-primary saveShopPrivileges" disabled="disabled">Save Privileges</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Roles Modal -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="shopOffcanvas" aria-labelledby="offcanvasRightLabel" style="width:auto;">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title"><i class="bx bx-edit mx-1"></i>Add Role and Privileges</h5>
        <button type="button" class="btn-close shop_new_privilege_close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="shopRoleregisterForm">
            @csrf
            <div class="row g-2">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <input type="text" class="form-control" name="shop_role" placeholder="Enter Role Name" aria-label="role" />
                </div>
            </div>
            <div class="row g-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless" id="shop_role_privilege_table">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-nowrap">Modules</th>
                                    <th class="text-nowrap text-center">All</th>
                                    <th class="text-nowrap text-center">View</th>
                                    <th class="text-nowrap text-center">Create</th>
                                    <th class="text-nowrap text-center">Edit</th>
                                    <th class="text-nowrap text-center">Delete</th>
                                    <th class="text-nowrap text-center">Block/Unblock</th>
                                    <th class="text-nowrap text-center">Enable/Disable</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($shop_modules as $module)
                                <tr class="border-bottom">
                                    <td data-id="{{$module->id}}">{{$module->name}}</td>
                                    <td class="text-center">
                                        <input type="checkbox" class="row-select-all">
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" class="index">
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" class="create">
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" class="edit">
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" class="delete">
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" class="isBlocked">
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" class="isEnabled">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-end mt-5">
                    <button type="button" class="btn btn-label-secondary shop_new_privilege_close btn-light" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
                    <button type="button" class="btn btn-primary SubmitShopCreateRoleForm" data-companyid='{{Crypt::encrypt($company_details->id)}}'>Add Role</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit the CRM Privileges -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="shopUpdateOffcanvasRight" aria-labelledby="offcanvasRightLabel" style="width:auto;">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title"><i class="bx bx-edit mx-1"></i>Edit Role and Privileges</h5>
        <button type="button" class="btn-close shop_update_privilege_close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="update_Shop_roleregisterForm">
            @csrf
            <div class="row g-2">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <input type="text" class="form-control" name="shop_update_role" placeholder="Enter Role Name" aria-label="role" />
                </div>
            </div>
            <div class="row g-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless" id="update_shop_privilege_table">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-nowrap">Modules</th>
                                    <th class="text-nowrap text-center">All</th>
                                    <th class="text-nowrap text-center">View</th>
                                    <th class="text-nowrap text-center">Create</th>
                                    <th class="text-nowrap text-center">Edit</th>
                                    <th class="text-nowrap text-center">Delete</th>
                                    <th class="text-nowrap text-center">Block/Unblock</th>
                                    <th class="text-nowrap text-center">Enable/Disable</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modules as $module)
                                <tr class="border-bottom">
                                    <td data-id="{{$module->id}}">{{$module->name}}</td>
                                    <td class="text-center">
                                        <input type="checkbox" class="row-select-all">
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" class="index">
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" class="create">
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" class="edit">
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" class="delete">
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" class="isBlocked">
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" class="isEnabled">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-end mt-5">
                    <button type="button" class="btn btn-label-secondary shop_update_privilege_close btn-light" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
                    <button type="button" class="btn btn-primary SubmitShopUpdateRoleForm" data-companyid='{{Crypt::encrypt($company_details->id)}}'>Update Role</button>
                </div>
            </div>
        </form>
    </div>
</div>
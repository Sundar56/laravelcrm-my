@extends('crm.admin.layouts.app')

@section('title', 'Roles')

@section('page-script')
<script src="{{asset('assets/js/role.js' . Config::get('app.assets_version')) }}"></script>
@endsection

@section('content')
<!-- Responsive Datatable -->
<div class="page-wrapper">
    <div class="page-content">
        <nav aria-label="breadcrumb" class="pageTop">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('crm.dashboard') }}" class="text-secondary">Dashboard</a>
                </li>
                <i class="bx bx-chevron-right"></i>
                <li class="breadcrumb-item active" aria-current="page">Roles & Privileges</li>
            </ol>
        </nav>
        <div class="row mt-4">
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                <div class="card mb-3 h-100 rounded">
                    <div class="card-header flex-column flex-md-row mt-2">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="head-label text-left">
                                <h6 class="card-title mb-0">Roles</h6>
                            </div>
                            <div class="text-end">
                                <button class="dt-button btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#CreateRolesOffcanvas" type="button">
                                    <span><i class="bx bx-plus"></i> <span class="d-none d-sm-inline-block">Add Roles</span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="roledata">
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                <div class="card mb-3 h-100 rounded">
                    <form id="privilegesForm">
                        @csrf
                        <div class="card-header flex-column flex-md-row mt-1">
                            <div class="d-flex justify-content-between align-items-center mb-2 mt-1">
                                <div class="head-label text-left mt-1">
                                    <h6 class="card-title mb-0">Privileges</h6>
                                </div>
                                <div class="text-end">
                                    <div class="input-group position-relative w-75 float-end">
                                        <input type="text" class="form-control rounded-1" id="searchPrivileges" placeholder="Search" aria-label="Search privileges" style="padding-left: 32px;">
                                        <span class="input-group-text" style="position: absolute; left: 2px; top: 50%; transform: translateY(-50%); background: transparent; border: none; pointer-events: none;">
                                            <i class="bx bx-search"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless" id="privilege_table">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-nowrap fw-medium">Modules</th>
                                            <th class="text-nowrap text-center fw-medium">All</th>
                                            <th class="text-nowrap text-center fw-medium">View</th>
                                            <th class="text-nowrap text-center fw-medium">Create</th>
                                            <th class="text-nowrap text-center fw-medium">Edit</th>
                                            <th class="text-nowrap text-center fw-medium">Delete</th>
                                            <th class="text-nowrap text-center fw-medium">Block/Unblock</th>
                                            <th class="text-nowrap text-center fw-medium">Enable/Disable</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-light" id="resetPrivileges">Reset</button>
                                <button type="button" class="btn btn-primary savePrivileges">Save Privileges</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Create Adminuser offcanvas-->
<div class="offcanvas offcanvas-end rounded" tabindex="-1" id="CreateRolesOffcanvas" aria-labelledby="offcanvasTopLabel" style="width:auto;">
    <div class="offcanvas-header border-bottom">
        <h6 class="offcanvas-title"><i class="bx bx-edit me-1"></i>Add Role and Privileges</h6>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="roleregisterForm" enctype="multipart/form-data">
            @csrf
            <div class="row g-1">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <input type="text" class="form-control" name="role" placeholder="Enter Role Name"
                        aria-label="role" />
                </div>
            </div>
            <div class="row g-4 mt-1">
                <div class="card-body mx-3">
                    <div class="table-responsive">
                        <table class="table table-borderless" id="role_privilege_table">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-nowrap fw-medium">Modules</th>
                                    <th class="text-nowrap text-center fw-medium">All</th>
                                    <th class="text-nowrap text-center fw-medium">View</th>
                                    <th class="text-nowrap text-center fw-medium">Create</th>
                                    <th class="text-nowrap text-center fw-medium">Edit</th>
                                    <th class="text-nowrap text-center fw-medium">Delete</th>
                                    <th class="text-nowrap text-center fw-medium">Block/Unblock</th>
                                    <th class="text-nowrap text-center fw-medium">Enable/Disable</th>
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
                    <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="button" class="btn btn-primary SubmitCreateRoleForm">Add Role</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--/ Create Adminuser offcanvas-->
<div class="offcanvas offcanvas-end rounded" tabindex="-1" id="EditRolesOffcanvas" aria-labelledby="offcanvasTopLabel" style="width:auto;">
    <div class="offcanvas-header border-bottom">
        <h6 class="offcanvas-title"><i class="bx bx-edit me-1"></i>Edit Role and Privileges</h6>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="editroleregisterForm" enctype="multipart/form-data">
            @csrf
            <div class="row g-1">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <input type="text" class="form-control" name="role_name" id="roleName" />
                    <input type="hidden" name="role_id" id="roleId" />
                </div>
            </div>
            <div class="row g-4 mt-1">
                <div class="card-body mx-3">
                    <div class="table-responsive">
                        <table class="table table-borderless" id="edit_role_privilege_table">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-nowrap fw-medium">Modules</th>
                                    <th class="text-nowrap text-center fw-medium">All</th>
                                    <th class="text-nowrap text-center fw-medium">View</th>
                                    <th class="text-nowrap text-center fw-medium">Create</th>
                                    <th class="text-nowrap text-center fw-medium">Edit</th>
                                    <th class="text-nowrap text-center fw-medium">Delete</th>
                                    <th class="text-nowrap text-center fw-medium">Block/Unblock</th>
                                    <th class="text-nowrap text-center fw-medium">Enable/Disable</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-end mt-5">
                    <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="button" class="btn btn-primary UpdateRoleForm">Save Details</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
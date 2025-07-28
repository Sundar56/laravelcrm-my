<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Models\RoleHasPermission;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Contracts\Role as ContractsRole;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::where('type', 0)->get();
        $modules = Module::where('module_type', 1)
            ->where('status', 1)
            ->get();
        return view('crm.admin.roles.index', compact('roles', 'modules'));
    }
    public function getRoles()
    {
        $roles = Role::where('type', 0)->get();
        $html = view('crm.admin.roles.roledata', compact('roles'))->render();
        $data = [
            'html' => $html,
            'status_code' => 200,
        ];
        return $data;
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'role' => 'required|unique:roles,name,NULL,id,type,' . 0,
            ], [
                'role.required' => 'Role required',
                'role.unique' => 'Role already exists',
            ]);

            if ($validator->fails())
                return response()->json(['error' => $validator->errors()], 422);

            $displayName = ucfirst($request->role);
            $name = strtolower(str_replace(' ', '', $request->role));
            // dd($name);
            if (Role::where('name', $name)->where('type', 0)->exists()) {
                return response()->json(["message" => "Role already exists.", "error" => array("role" => array("Role already exists."))], 422);
            }

            $role = new Role();
            $role->name = $name;
            $role->display_name = $displayName;
            $role->guard_name = 'web';
            $role->type = 0;
            $role->save();

            if (!isset($request->permission))
                return response()->json(['success' => 'Role Added Sccessfully', 'status' => 1], 201);
            // dd($request->permission);
            $permissions = $request->permission;
            $roleId = $role->id;
            // dd($permissions);
            $permissionData  = Permission::select('permissions.id', 'permissions.name', 'permissions.module_id')
                ->join('modules', function ($join) {
                    $join->on('modules.id', '=', 'permissions.module_id');
                    $join->where('modules.module_type', '=', 1);
                })->get();
            $permissionArray = [];
            $permissionInfo = [];
            $moduleInfo = [];
            foreach ($permissionData as $pdata) {
                $pmoduleid = $pdata['module_id'];
                if ($pmoduleid > 0) {
                    $permissionArray[$pmoduleid][] = $pdata['id'];
                    $permissionInfo[$pmoduleid][] = [
                        "id" => $pdata['id'],
                        "name" => $pdata['name'],
                        "module_id" => $pdata['module_id']
                    ];
                    if (!isset($moduleInfo[$pmoduleid])) {
                        $modulesplitData = explode('.', $pdata['name']);
                        $moduleInfo[$pmoduleid] = $modulesplitData[1];
                    }
                }
            }
            //Delete all inserted previous records
            // RoleHasPermission::where('role_id', $roleId)->delete();

            $insertArray = [];
            foreach ($permissions as $permission) {
                $splitData = explode('_', $permission);
                $moduleId = $splitData[0];
                $actionPart = $splitData[1];
                $actions = [];

                // Handle specific actions based on the action part
                if ($actionPart === 'all') {
                    $moduleinsertArray = $permissionArray[$moduleId] ?? [];
                    if ($role === 'superadmin') {
                        // No modifications needed for superadmin/appadmin
                    } else {
                        // Exclude specific dashboard privileges
                        $dashboardPrivileges = ['crm.privileges.dashboard', 'crm.privileges.fetchdashboard', 'crm.privileges.storedashboard'];
                        $moduleinsertArray = array_diff($moduleinsertArray, Permission::whereIn('permissions.name', $dashboardPrivileges)
                            ->pluck('id')->toArray());
                    }

                    foreach ($moduleinsertArray as $mdata) {
                        $insertArray[] = [
                            'permission_id' => $mdata,
                            'role_id' => $roleId,
                        ];
                    }
                } else {
                    $modulename = $moduleInfo[$moduleId] ?? '';
                    switch ($actionPart) {
                        case 'create':
                            $actions = [
                                "crm.$modulename.create",
                                "crm.$modulename.store",
                            ];
                            break;
                        case 'index':
                            $actions = [
                                "crm.$modulename.index",
                                "crm.$modulename.get",
                            ];
                            break;
                        case 'edit':
                            $actions = [
                                "crm.$modulename.edit",
                                "crm.$modulename.update",
                            ];
                            break;
                        case 'delete':
                            $actions = ["crm.$modulename.delete"];
                            break;
                    }

                    foreach ($actions as $action) {
                        $key = array_search($action, array_column($permissionInfo[$moduleId] ?? [], 'name'));
                        if ($key !== false) {
                            $insertArray[] = [
                                'permission_id' => $permissionInfo[$moduleId][$key]['id'],
                                'role_id' => $roleId,
                            ];
                        }
                    }
                }
            }
            // Remove duplicates
            $result = array_map("unserialize", array_unique(array_map("serialize", $insertArray)));
            // Insert default permissions if needed
            if (!empty($result)) {
                $defaultPermissions = [];
                $defaultPermissionIds = Permission::where('module_id', 0)->pluck('id');
                foreach ($defaultPermissionIds as $pid) {
                    $defaultPermissions[] = [
                        'permission_id' => $pid,
                        'role_id' => $roleId
                    ];
                }
                RoleHasPermission::insert(array_merge($defaultPermissions, $result));
            }

            return response()->json(['success' => 'Role & Privileges Updated']);
        } catch (\Exception $e) {
            // Directly return the error message
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getModulesByRole(Request $request)
    {
        $roleId = crypt::decrypt($request->input('role_id'));
        // dd($roleId);
        return $this->getRoleData($roleId);
    }
    private function getRoleData($roleId, $data = null)
    {
        // Get the permissions for the role
        $permissionIds = RoleHasPermission::where('role_id', $roleId)
            ->pluck('permission_id');

        $actions = [];
        $uniques = [];

        if ($permissionIds->isNotEmpty()) {
            $permissionArray = Permission::whereIn('id', $permissionIds)->pluck('name');

            foreach ($permissionArray as $permission) {
                $splitData = explode('.', $permission);
                if (count($splitData) === 3) {
                    $module = $splitData[1];
                    $actionPart = $splitData[2];
                    $uniques[$module] = $module;

                    // Build actions based on action part
                    if (in_array($actionPart, ['index', 'create', 'edit', 'delete'])) {
                        $actions[] = 'crm.' . $module . '.' . $actionPart;
                    }
                }
            }
        }
        $accessModules = Module::where('module_type', 1)
            ->where('status', 1)->get();
        // Return the response with data if provided, otherwise just actions and modules
        return response()->json([
            'data' => $data,
            'actions' => $actions,
            'access_modules' => $uniques,
            'modules' => $accessModules,
        ]);
    }
    public function savePrivileges(Request $request)
    {
        $roleId = crypt::decrypt($request->role_id);
        $permissions = $request->permission;

        // Default to an empty array if $blocked is not set
        // $blocked = $request->input('blocked', []);
        // $enabled = $request->input('enabled', []);
        $role = Role::where('id', $roleId)->pluck('name')->first();

        $permissionData  = Permission::select('permissions.id', 'permissions.name', 'permissions.module_id')
            ->join('modules', function ($join) {
                $join->on('modules.id', '=', 'permissions.module_id');
                $join->where('modules.module_type', '=', 1);
            })->get();

        $permissionArray = [];
        $permissionInfo = [];
        $moduleInfo = [];
        foreach ($permissionData as $pdata) {
            $pmoduleid = $pdata['module_id'];
            if ($pmoduleid > 0) {
                $permissionArray[$pmoduleid][] = $pdata['id'];
                $permissionInfo[$pmoduleid][] = [
                    "id" => $pdata['id'],
                    "name" => $pdata['name'],
                    "module_id" => $pdata['module_id']
                ];
                if (!isset($moduleInfo[$pmoduleid])) {
                    $modulesplitData = explode('.', $pdata['name']);
                    $moduleInfo[$pmoduleid] = $modulesplitData[1];
                }
            }
        }
        //Delete all inserted previous records
        $deleteRole = RoleHasPermission::where('role_id', $roleId)->delete();
        $insertArray = [];
        foreach ($permissions as $permission) {
            $splitData = explode('_', $permission);
            $moduleId = $splitData[0];
            $actionPart = $splitData[1];
            $actions = [];
            // Handle specific actions based on the action part
            if ($actionPart === 'all') {
                $moduleinsertArray = $permissionArray[$moduleId] ?? [];
                if ($role === 'superadmin') {
                    // No modifications needed for superadmin/appadmin
                } else {
                    // Exclude specific dashboard privileges
                    $dashboardPrivileges = ['crm.privileges.dashboard', 'crm.privileges.fetchdashboard', 'crm.privileges.storedashboard'];
                    $moduleinsertArray = array_diff($moduleinsertArray, Permission::whereIn('permissions.name', $dashboardPrivileges)
                        ->pluck('id')->toArray());
                }
                foreach ($moduleinsertArray as $mdata) {
                    $insertArray[] = [
                        'permission_id' => $mdata,
                        'role_id' => $roleId,
                    ];
                }
            } else {
                $modulename = $moduleInfo[$moduleId] ?? '';
                // dd($modulename);
                switch ($actionPart) {
                    case 'create':
                        $actions = [
                            "crm.$modulename.create",
                            "crm.$modulename.store",
                        ];
                        break;
                    case 'index':
                        $actions = [
                            "crm.$modulename.index",
                            "crm.$modulename.get",
                        ];
                        break;
                    case 'edit':
                        $actions = [
                            "crm.$modulename.edit",
                            "crm.$modulename.update",
                        ];
                        break;
                    case 'delete':
                        $actions = ["crm.$modulename.delete"];
                        break;
                    case 'block':
                        $actions = ["crm.$modulename.block"];
                        break;
                }
                // dd($roleId);
                foreach ($actions as $action) {
                    $key = array_search($action, array_column($permissionInfo[$moduleId] ?? [], 'name'));
                    // dd($key);
                    if ($key !== false) {
                        $insertArray[] = [
                            'permission_id' => $permissionInfo[$moduleId][$key]['id'],
                            'role_id' => $roleId,
                        ];
                    }
                }
            }
        }
        dd($insertArray);
        // Remove duplicates
        $result = array_map("unserialize", array_unique(array_map("serialize", $insertArray)));
       
        // Insert default permissions if needed
        if (!empty($result)) {
            $defaultPermissions = [];
            $defaultPermissionIds = Permission::where('module_id', 0)->pluck('id');
            foreach ($defaultPermissionIds as $pid) {
                $defaultPermissions[] = [
                    'permission_id' => $pid,
                    'role_id' => $roleId
                ];
            }
            RoleHasPermission::insert(array_merge($defaultPermissions, $result));
        }
        return response()->json(['success' => 'Privileges Updated']);
    }
    public function edit(Request $request)
    {
        $roleId = crypt::decrypt($request->id);
        $data = Role::find($roleId);
        // dd($data);
        return $this->getRoleData($roleId, $data);
    }
    public function update(Request $request)
    {
        try {
            // dd($request->role);
            $roleId = $request->role_id;
            $role = $request->role;
            $check_rolename_exist = Role::where([['type', 0], ['name', $request->role], ['id', '!=', $roleId]])->exists();
            // dd($check_rolename_exist);
            if ($check_rolename_exist)
                return response()->json(['error' => 'Role already exists', 'status' => 0], 409);
            // dd($role);       
            $displayName = ucfirst($request->role);
            $name = strtolower(str_replace(' ', '', $request->role));
            // dd($roleId);
            if (Role::where([['type', 0], ['name', $name], ['id', '!=', $roleId]])->exists()) {
                return response()->json(["message" => "Role already exists.", "error" => array("role" => array("Role already exists."))], 422);
            }
            Role::where('id', $roleId)->update([
                'name' => $name,
                'display_name' => $displayName,
            ]);
            if (!isset($request->permission))
                return response()->json(['success' => 'Role Added Sccessfully', 'status' => 1], 201);
            $permissions = $request->permission;
            // dd($permissions);
            $permissionData  = Permission::select('permissions.id', 'permissions.name', 'permissions.module_id')
                ->join('modules', function ($join) {
                    $join->on('modules.id', '=', 'permissions.module_id');
                    $join->where('modules.module_type', '=', 1);
                })->get();

            $permissionArray = [];
            $permissionInfo = [];
            $moduleInfo = [];
            foreach ($permissionData as $pdata) {
                $pmoduleid = $pdata['module_id'];
                if ($pmoduleid > 0) {
                    $permissionArray[$pmoduleid][] = $pdata['id'];
                    $permissionInfo[$pmoduleid][] = [
                        "id" => $pdata['id'],
                        "name" => $pdata['name'],
                        "module_id" => $pdata['module_id']
                    ];
                    if (!isset($moduleInfo[$pmoduleid])) {
                        $modulesplitData = explode('.', $pdata['name']);
                        $moduleInfo[$pmoduleid] = $modulesplitData[1];
                    }
                }
            }
            //Delete all inserted previous records
            RoleHasPermission::where('role_id', $roleId)->delete();

            $insertArray = [];
            foreach ($permissions as $permission) {
                $splitData = explode('_', $permission);
                $moduleId = $splitData[0];
                $actionPart = $splitData[1];
                $actions = [];

                // Handle specific actions based on the action part
                if ($actionPart === 'all') {
                    $moduleinsertArray = $permissionArray[$moduleId] ?? [];
                    if ($role === 'superadmin') {
                        // No modifications needed for superadmin/appadmin
                    } else {
                        // Exclude specific dashboard privileges
                        $dashboardPrivileges = ['crm.privileges.dashboard', 'crm.privileges.fetchdashboard', 'crm.privileges.storedashboard'];
                        $moduleinsertArray = array_diff($moduleinsertArray, Permission::whereIn('permissions.name', $dashboardPrivileges)
                            ->pluck('id')->toArray());
                    }

                    foreach ($moduleinsertArray as $mdata) {
                        $insertArray[] = [
                            'permission_id' => $mdata,
                            'role_id' => $roleId,
                        ];
                    }
                } else {
                    $modulename = $moduleInfo[$moduleId] ?? '';
                    switch ($actionPart) {
                        case 'create':
                            $actions = [
                                "crm.$modulename.create",
                                "crm.$modulename.store",
                            ];
                            break;
                        case 'index':
                            $actions = [
                                "crm.$modulename.index",
                                "crm.$modulename.get",
                            ];
                            break;
                        case 'edit':
                            $actions = [
                                "crm.$modulename.edit",
                                "crm.$modulename.update",
                            ];
                            break;
                        case 'delete':
                            $actions = ["crm.$modulename.delete"];
                            break;
                    }

                    foreach ($actions as $action) {
                        $key = array_search($action, array_column($permissionInfo[$moduleId] ?? [], 'name'));
                        if ($key !== false) {
                            $insertArray[] = [
                                'permission_id' => $permissionInfo[$moduleId][$key]['id'],
                                'role_id' => $roleId,
                            ];
                        }
                    }
                }
            }
            // Remove duplicates
            $result = array_map("unserialize", array_unique(array_map("serialize", $insertArray)));
            // Insert default permissions if needed
            if (!empty($result)) {
                $defaultPermissions = [];
                $defaultPermissionIds = Permission::where('module_id', 0)->pluck('id');
                foreach ($defaultPermissionIds as $pid) {
                    $defaultPermissions[] = [
                        'permission_id' => $pid,
                        'role_id' => $roleId
                    ];
                }
                RoleHasPermission::insert(array_merge($defaultPermissions, $result));
            }

            return response()->json(['success' => 'Role & Privileges Updated']);
        } catch (\Exception $e) {
            // Directly return the error message
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function delete(Request $request)
    {
        try {
            $role_id = Crypt::decrypt($request->id);
            Role::where('id', $role_id)->delete();
            return response()->json(['status' => 200, 'success' => 'Role Deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

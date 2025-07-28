<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Jobs\sendEmailJob;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class AdminuserController extends Controller
{
    public function index()
    {
        $roles = Role::whereNotIn('name', ['superadmin'])->where('type', 0)->get();
        return view('crm.admin.adminusers.index', compact('roles'));
    }
    public function getadminUserslist(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'users.name',
            2 => 'email',
            3 => 'user_phone',
            4 => 'roles.name',
            5 => 'users.created_at',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        // Use query builder for pagination and filtering
        $dbdata = User::leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id');

        // Apply search filter
        if (!empty($request->input('search.value'))) {
            $sSearch = $request->input('search.value');
            $dbdata->where(function ($q) use ($sSearch, $columns) {
                foreach ($columns as $key => $value) {
                    if ($key == 0) {
                        $q->where('users.id', 'like', '%' . $sSearch . '%');
                    } else {
                        $q->orWhere($value, 'like', '%' . $sSearch . '%');
                    }
                }
            });
        }
        // Get the total records before applying pagination
        $totalData = $dbdata->count();

        // Apply pagination (limit and offset)
        $UserData = $dbdata->select('users.id', 'users.name', 'users.email', 'users.user_phone')
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $totalFiltered = $totalData; // If search is applied, it will be filtered below

        $data = [];
        if ($UserData->isNotEmpty()) {
            foreach ($UserData as $user) {
                $roleName = $user->roles()->pluck('display_name')->first();

                $actions = null;
                if ($roleName !== 'Super Admin') {
                    $actions = '<a href="#" class="resetPassword text-dark" data-id="' . $user->id . '"><i class="bx bx-lock-open-alt" title="Reset Password"></i></a>';
                    // <a href="#" class="editUser text-dark" data-id="' . $user->id . '"><i class="bx bx-edit" title="Edit"></i></a> 
                    // <a href="#" class="text-dark deleteUser" data-id="' . $user->id . '"><i class="bx bx-trash-alt" title="Delete"></i></a>';
                }
                $nestedData = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'user_phone' => $user->user_phone,
                    'user_type' => $roleName,
                    'actions' => $actions,
                ];
                $data[] = $nestedData;
            }
        }
        // Return response as JSON
        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        ];

        return response()->json($json_data);
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'user_type' => 'required',
                'email' => 'required|email',
                'user_phone' => 'required',
            ], [
                'name.required' => 'User Name required',
                'email.required' => 'Email required',
                'email.email' => 'Must be a valid email address',
                'user_phone.required' => 'Phone required',
                'user_type.required' => 'User type is required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $check_email_exist = User::where([['email', $request->email]])->exists();

            if ($check_email_exist)
                return response()->json(['error' => 'Email already exists', 'status' => 0], 409);

            $password =  Str::random(10);
            $hashPassword = Hash::make($password);
            $displayName = ucfirst($request->name);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $hashPassword,
                'user_displayname' => $displayName,
                'user_phone' => $request->user_phone,
                'is_blocked' => $request->has('is_blocked') ? 1 : 0,
            ]);

            $role = Role::find($request->user_type);
            $user->assignRole([$role->name]);

            // Dispatch the job to send the email
            SendEmailJob::dispatch($request->email, $password, $request->name);

            return response()->json(['status' => 200, 'success' => 'User Created Successfully']);
        } catch (\Exception $e) {
            // Directly return the error message
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function edit(Request $request)
    {
        // $data = User::where('users.id', $request->id)->first();
        $data = User::leftjoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftjoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('users.*', 'model_has_roles.role_id')
            ->where('users.id', $request->id)->first();
        // dd($data);
        return response()->json(['data' => $data]);
    }
    public function delete(Request $request)
    {
        try {
            User::where('users.id', $request->id)->delete();
            return response()->json(['status' => 200, 'success' => 'User Deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function update(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ], [
            'name.required' => 'User Name required',
            'email.required' => 'Email required',
            'email.email' => 'Must be a valid email address',
            'phone.required' => 'Phone required',
        ]);

        // dd($request->c_id);
        $userId = $request->user_id;
        $displayName = ucfirst($request->name);
        User::where('id', $userId)->update([
            'name' => $request->name,
            'email' => $request->email,
            'user_displayname' => $displayName,
            'user_phone' => $request->phone,
            // 'user_type' => $request->user_type,
            'is_blocked' => $request->has('is_blocked') ? 1 : 0,
        ]);
        $role_id = $request->rolesSelect;

        DB::table('model_has_roles')
            ->where('model_id', $userId)
            ->update([
                'role_id' => $role_id,
            ]);

        return response()->json(['status' => 200, 'success' => 'User Updated Successfully']);
    }
    public function getUserdetails(Request $request)
    {
        $data = User::leftjoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftjoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('users.*', 'roles.display_name', 'roles.id as role_id')
            ->where('users.id', $request->id)->first();
        $userRoles = Role::where([['type', 0], ['id', '!=', 1]])->get();

        // dd($data);
        return response()->json(['data' => $data, 'userRoles' => $userRoles,]);
    }
    public function resetPassword(Request $request)
    {
        // dd($request->password);
        $userId = $request->id;
        $newPassword = $request->password;
        $hashedPassword = Hash::make($newPassword);
        User::where('id', $userId)->update([
            'password' => $hashedPassword
        ]);

        // Dispatch the job to send the email
        SendEmailJob::dispatch($request->email, $newPassword, $request->name);

        return response()->json(['status' => 200, 'success' => 'Password Reset Successfully']);
    }
}

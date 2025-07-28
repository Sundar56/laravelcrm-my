<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Userimage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Jobs\CreateCompanyDatabaseJob;
use Illuminate\Support\Facades\Crypt;
use App\Models\CompanyDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\Module;
use App\Models\RoleHasPermission;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\ApiHistory;
use Tymon\JWTAuth\Facades\JWTAuth;

class CompanyController extends Controller
{
    public function index()
    {
        // CreateCompanyDatabaseJob::dispatch(1, 'Mitech');
        return view('crm.admin.companies.index');
    }
    public function getSsoSttings(Request $request)
    {

        // dd($request->companyId);
        $company_id = crypt::decrypt($request->companyId);
        // $dbDetails =  CompanyDatabase::where('company_id', $company_id)->first();
        $dbDetails = $this->getDatabaseDetails($company_id);
        $general_settings_type = $request->type;
        if (!$dbDetails) {
            return response()->json(['error' => 'Database details not found.', 'status' => 0], 404);
        }
        $this->configureDatabaseConnection($dbDetails);
        // dd($dbDetails);
        if (!$this->databaseConnection($dbDetails->db_name)) {
            return response()->json(['error' => 'MySQL connection failed', 'status' => 0], 500);
        }
        $columns = array(
            0 => 'variabel',
            1 => 'vaerdi',
            2 => 'beskrivelse',
            3 => 'id',
            4 => 'company_type',
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $sSearch = $request->input('search.value');
        // Run the query on the configured dynamic connection
        $ssoSettingsData = DB::connection($dbDetails->db_name)
            ->table('cloud_variabler')
            ->select($columns)
            ->where('type', 1)
            ->when($general_settings_type == 0, function ($query) {
                return $query->whereIn('company_type', [1, 2, 3]);
            }, function ($query) use ($general_settings_type) {
                return $query->where('company_type', $general_settings_type);
            });
        // Apply search filter if a search term is provided
        if (!empty($sSearch)) {
            $ssoSettingsData->where(function ($q) use ($sSearch, $columns) {
                foreach ($columns as $key => $value) {
                    if ($key == 3) {
                        $q->where($value, 'like', '%' . $sSearch . '%');
                    } else {
                        $q->orWhere($value, 'like', '%' . $sSearch . '%');
                    }
                }
            });
        }
        // Clone the query before applying offset and limit for accurate total count
        $totalData = $ssoSettingsData->count();

        $ssoSettingsDatas = $ssoSettingsData->offset($start)
            ->limit($limit)
            ->get();
        // dd($companyData);
        // $totalData = $ssoSettingsData->count();
        $totalFiltered = $totalData;
        $types = config('app.type');

        $data = [];
        if ($ssoSettingsDatas->isNotEmpty()) {
            $company_type = config('app.type');
            foreach ($ssoSettingsDatas as $ssoSettings) {
                $ssoData = [
                    'Variable' => $ssoSettings->variabel,
                    'Value' => $ssoSettings->vaerdi,
                    'Description' => $ssoSettings->beskrivelse,
                    'Type' =>  $company_type[$ssoSettings->company_type],
                    'id' => Crypt::encrypt($company_id),
                    'company_id' => Crypt::encrypt($company_id),
                    'actions' => '
                    <a href="#" class="deleteSsoSettings" data-ssosettingid="' .  Crypt::encrypt($ssoSettings->id) . '" data-companyId="' . Crypt::encrypt($company_id) . '"><i class="bx bx-trash-alt" title="Delete"></i></a>'
                ];
                $data[] = $ssoData;
            }
        }
        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            'types' => $types,
        ];

        return response()->json($json_data); // Use Laravel's response helper
    }
    public function deleteGeneralSettings($settingId, Request $request)
    {

        $general_setting_id = crypt::decrypt($settingId);
        $company_id =  crypt::decrypt($request->companyId);

        if (empty($company_id)) {
            return response()->json(['error' => 'Invalid company ID.', 'status' => 0], 400);
        }

        $dbDetails = $this->getDatabaseDetails($company_id);
        if (!$dbDetails) {
            return response()->json(['error' => 'Database details not found.', 'status' => 0], 404);
        }
        $this->configureDatabaseConnection($dbDetails);
        // dd($dbDetails);
        if (!$this->databaseConnection($dbDetails->db_name)) {
            return response()->json(['error' => 'MySQL connection failed', 'status' => 0], 500);
        }


        try {

            // Handle delete for a single user
            DB::connection($dbDetails->db_name)->table('cloud_variabler')
                ->where('id', $general_setting_id)
                ->delete();

            return response()->json(['status' => 1, 'message' => 'Deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getUserlogin(Request $request)
    {
        $company_id = $request->companyId;
        $dbDetails = $this->getDatabaseDetails($company_id);
        // dd($dbDetails);
        if (!$dbDetails) {
            return response()->json(['error' => 'Database details not found.', 'status' => 0], 404);
        }
        $this->configureDatabaseConnection($dbDetails);
        // dd($dbDetails);

        if (!$this->databaseConnection($dbDetails->db_name)) {
            return response()->json(['error' => 'MySQL connection failed', 'status' => 0], 500);
        }

        $columns = array(
            0 => 'navn',
            1 => 'email',
            2 => 'userlevel',
            3 => 'oensker_email_ved_specifik_sag',
            4 => 'hideuser',
            5 => 'lastlogin',
            6 => 'id',
            7 => 'siteaccess',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $sSearch = $request->input('search.value');
        // Run the query on the configured dynamic connection
        $userLogindata = DB::connection($dbDetails->db_name)
            ->table('cloud_sso_users')
            ->select($columns);
        // Apply search filter if a search term is provided
        if (!empty($sSearch)) {
            $userLogindata->where(function ($q) use ($sSearch, $columns) {
                foreach ($columns as $key => $value) {
                    if ($key == 3) {
                        $q->where($value, 'like', '%' . $sSearch . '%');
                    } else {
                        $q->orWhere($value, 'like', '%' . $sSearch . '%');
                    }
                }
            });
        }
        // Clone the query before applying offset and limit for accurate total count
        $totalData = $userLogindata->count();
        $userLogindata = $userLogindata->offset($start)
            ->limit($limit)
            ->get();
        $totalFiltered = $totalData;

        $data = [];
        if ($userLogindata->isNotEmpty()) {
            foreach ($userLogindata as $userLogin) {

                // Set user type based on userlevel
                $userType = $userLogin->userlevel == 1 ? "user" : ($userLogin->userlevel == 2 ? "supervisor" : "");

                // Set status based on oensker_email_ved_specifik_sag
                $status = $userLogin->oensker_email_ved_specifik_sag == 0
                    ? '<span class="badge text-secondary bg-light-dark">In Active</span>'
                    : '<span class="badge text-success bg-light-success">Active</span>';
                $mfa = $userLogin->siteaccess == '1-1-1-1' ? 'Enabled' : 'Disabled';
                // Format last login timestamp
                $formattedDate = date('d M Y, H:i', strtotime($userLogin->lastlogin));
                $encrypted_Userid = Crypt::encrypt($userLogin->id);
                $encrypted_Companyid = Crypt::encrypt($company_id);

                $userloginData = [
                    'id' => $userLogin->id,
                    'name' => $userLogin->navn,
                    'email' => $userLogin->email,
                    'usertype' => $userType,
                    'mfa' => $mfa,
                    'status' => $status,
                    'lastlogin' => $formattedDate,
                    'companyId' => $encrypted_Companyid,
                    'userId' => $encrypted_Userid,
                    // 'actions' => '<a href="#" class="deleteUserlogin text-dark" data-userloginid="' .  $userLogin->id . '" data-companyId="' . $company_id . '"><i class="bx bx-trash-alt" title="Delete"></i></a>'
                ];

                $data[] = $userloginData;
            }
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        ];

        return response()->json($json_data); // Use Laravel's response helper
    }
    public function getCompanyList(Request $request)
    {
        $columns = array(
            0 => 'company_id',
            1 => 'companies.created_at',
            2 => 'vat_id',
            3 => 'invoice_email',
            4 => 'company_phone',
            5 => 'zipcode',
            6 => 'city',
            7 => 'country',
            8 => 'companies.id',
            9 => 'company_name',
            10 => 'is_blocked',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if ($order == 'created_at') {
            $order = 'companies.created_at';
        }

        $dbdata = Company::query(); // Use query builder for better performance

        if (!empty($request->input('search.value'))) {
            $sSearch = $request->input('search.value');

            $dbdata->where(function ($q) use ($sSearch, $columns) {
                foreach ($columns as $key => $value) {
                    if ($key == 0) {
                        $q->where($value, 'like', '%' . $sSearch . '%');
                    } else {
                        $q->orWhere($value, 'like', '%' . $sSearch . '%');
                    }
                }
            });
        }
        $totalData = $dbdata->count();
        $totalFiltered = $totalData;

        $companyData = $dbdata->select($columns) // Use $columns for selected fields
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = [];
        if ($companyData->isNotEmpty()) {
            foreach ($companyData as $company) {
                $formattedDate = date('d M Y, H:i', strtotime($company->created_at));
                $encryptCompanyId = Crypt::encrypt($company->id);
                if ($company->is_blocked == 1) {
                    $companyStatus = '<span class="badge text-danger" style="background-color:#ffcdd3;">Inactive</span>';
                } else {
                    $companyStatus = '<span class="badge text-success" style="background-color:#c5f2c7;">Active</span>';
                }
                $nestedData = [
                    'company_id' => $company->company_id,
                    'company_name' => $company->company_name,
                    'vat_id' => $company->vat_id,
                    'invoice_email' => $company->invoice_email,
                    'company_phone' => $company->company_phone,
                    'zipcode' => $company->zipcode,
                    'city' => $company->city,
                    'country' => $company->country,
                    'created_at' => $formattedDate,
                    'encryptedId' => $encryptCompanyId,
                    'is_blocked' => $companyStatus,
                    // 'view_action' =>'<a href="' . route('crm.companies.view', ['id' => Crypt::encrypt($company->id)]) . '" class="viewCompanyform text-dark" data-id="' . $company->id . '"><i class="bx bx-show-alt" title="View"></i></a>',
                    // 'actions' => '<a href="' . route('crm.companies.view', ['id' => Crypt::encrypt($company->id)]) . '" class="viewCompanyform text-dark" data-id="' . $company->id . '"><i class="bx bx-show-alt" title="View"></i></a>
                    // <a href="#" class="editCompanyForm text-dark" data-id="' . $company->id . '"><i class="bx bx-edit" title="Edit"></i></a>
                    //           <a href="#" class="text-dark deleteCompany" data-id="' . $company->id . '"><i class="bx bx-trash-alt" title="Delete"></i></a>'
                ];

                $data[] = $nestedData;
            }
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        ];

        return response()->json($json_data); // Use Laravel's response helper
    }
    public function store(Request $request)
    {
        // dd($request->has('is_blocked'));
        try {
            $validator = Validator::make($request->all(), [
                'company_name' => 'required|unique:companies,company_name',
                'invoice_email' => 'required|email|unique:companies,invoice_email',
                'company_phone' => 'required',
                'company_logo' => 'sometimes|file|mimetypes:image/jpeg,image/png,image/svg+xml',
                'company_banner' => 'sometimes|file|mimetypes:image/jpeg,image/webp',
            ], [
                'company_name.required' => 'Company name is required',
                'company_name.unique' => 'Company Name already exists',
                'invoice_email.required' => 'Invoice email is required',
                'invoice_email.email' => 'Must be a valid email address',
                'invoice_email.unique' => 'Email already exists',
                'company_phone.required' => 'Company phone is required',
                'company_logo.mimetypes' => 'Only JPEG, PNG, or SVG files are allowed',
                'company_banner.mimetypes' => 'Only JPEG, or WebP files are allowed',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }
            $apiKey = Str::random(20);
            $apiSecret = Str::random(32);
            $company = Company::create([
                'company_id' => $request->company_id,
                'company_name' => $request->company_name,
                'vat_id' => $request->vat_id,
                'invoice_email' => $request->invoice_email,
                'company_phone' => $request->company_phone,
                'zipcode' => $request->zipcode,
                'city' => $request->city,
                'country' => $request->country,
                'ean_number' => $request->ean_number,
                'address' => $request->address,
                'description' => $request->description,
                'company_logo' => $companyLogoPath ?? null,
                'company_banner' => $companyBannerPath ?? null,
                'apikey' => $apiKey,
                'apisecret' => $apiSecret,
                'is_blocked' => $request->has('is_blocked') ? 1 : 0,
            ]);

            // Handle file uploads
            $this->handleFileUploads($request, $company->id);

            // Dispatch the job to create the database
            CreateCompanyDatabaseJob::dispatch($company->id, $company->company_name);

            return response()->json(['status' => 200, 'success' => 'Company Created Successfully']);
        } catch (\Exception $e) {
            // Directly return the error message
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    private function handleFileUploads(Request $request, $companyId)
    {
        $path = "/uploadassets/company/{$companyId}/";

        // Ensure the directory exists
        if (!File::exists(public_path($path))) {
            File::makeDirectory(public_path($path), 0775, true);
        }

        // Handle company logo upload
        if ($request->hasFile('company_logo')) {
            $companyLogoPath = $this->uploadFile($request->file('company_logo'), $path, 'logo_');
            Company::where('id', $companyId)->update(['company_logo' => $companyLogoPath]);
        }

        // Handle company banner upload
        if ($request->hasFile('company_banner')) {
            $companyBannerPath = $this->uploadFile($request->file('company_banner'), $path, 'banner_');
            Company::where('id', $companyId)->update(['company_banner' => $companyBannerPath]);
        }
    }
    private function uploadFile($file, $path, $prefix)
    {
        $fileName = $prefix . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($path), $fileName);
        return $path . $fileName;
    }
    public function edit(Request $request)
    {
        $data = Company::where('companies.id', $request->id)->first();
        return response()->json(['data' => $data]);
    }
    public function view(Request $request)
    {
        $id = Crypt::decrypt($request->id);
        $company_details = Company::find($id);
        // $roles = Role::where('type', 1)->get();
        $roles = Role::where([
            ['type', 1],
            ['company_id', $company_details->id],
        ])->get();
        $cms_roles_type = 2;
        $modules = Module::where('module_type', 2)
            ->where('status', 1)
            ->get();
        $cms_modules = Module::where('module_type', 3)
            ->where('status', 1)
            ->get();
        $shop_modules = Module::where('module_type', 4)
            ->where('status', 1)
            ->get();
        $types = config('app.type');
        return view('crm.admin.companies.view', compact('company_details', 'roles', 'modules', 'cms_modules', 'cms_roles_type', 'types', 'shop_modules'));
    }
    public function delete(Request $request)
    {
        try {
            Company::where('id', $request->id)->delete();
            return response()->json(['status' => 200, 'success' => 'Company Deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getLastCompanyId(Request $request)
    {
        $lastRecord = Company::latest()->first();
        return response()->json(['status' => 200, 'success' => 1, 'data' => $lastRecord]);
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'invoice_email' => 'required|email',
            'company_phone' => 'required',
            'company_logo' => 'sometimes|file|mimetypes:image/jpeg,image/png,image/svg+xml,image/webp',
            'company_banner' => 'sometimes|file|mimetypes:image/jpeg,image/png,image/svg+xml,image/webp',
        ], [
            'company_name.required' => 'Company name is required',
            'invoice_email.required' => 'Invoice email is required',
            'invoice_email.email' => 'Must be a valid email address',
            'company_phone.required' => 'Company phone is required',
            'company_logo.mimetypes' => 'Only JPEG, PNG, SVG, or WebP files are allowed',
            'company_banner.mimetypes' => 'Only JPEG, PNG, SVG, or WebP files are allowed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // dd($request->c_id);
        $companyId = $request->c_id;
        Company::where('id', $companyId)->update([
            'company_name' => $request->company_name,
            'vat_id' => $request->vat_id,
            'invoice_email' => $request->invoice_email,
            'company_phone' => $request->company_phone,
            'zipcode' => $request->zipcode,
            'city' => $request->city,
            'country' => $request->country,
            'ean_number' => $request->ean_number,
            'address' => $request->address,
            'description' => $request->description,
            'is_blocked' => $request->has('is_blocked') ? 1 : 0,
        ]);

        // Handle file uploads
        $this->handleFileUploads($request, $companyId);
        //after updation send data 
        $updatedCompanyData = Company::find($companyId);

        return response()->json(['status' => 200, 'success' => 'Company Updated Successfully', 'updateCompanyData' => $updatedCompanyData]);
    }
    public function ssoSeetingById($ssoSettingsId, Request $request)
    {

        $sso_setting_id =  Crypt::decrypt($ssoSettingsId);
        if ($ssoSettingsId) {

            $company_id =  Crypt::decrypt($request->query('companyId'));


            $dbDetails =  CompanyDatabase::where('company_id', $company_id)->first();

            if (!$dbDetails) {
                return response()->json(['error' => 'Database details not found.', 'status' => 0], 404);
            }

            config([
                "database.connections.$dbDetails->db_name" => [
                    'driver' => 'mysql',
                    'host' => env('DB_ROOT_HOST', '127.0.0.1'),
                    'port' => env('DB_ROOT_PORT', '3306'),
                    'database' => $dbDetails->db_name,
                    'username' => $dbDetails->dbuser_name,
                    'password' => $dbDetails->db_password,
                    'charset' => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix' => '',
                    'strict' => true,
                    'engine' => null,
                ]
            ]);


            try {
                DB::connection($dbDetails->db_name)->getPdo();
                Log::info("Successfully connected to the database: " . $dbDetails->db_name);
            } catch (\Exception $e) {
                Log::error("MySQL connection failed: " . $e->getMessage());
                return response()->json(['error' => 'MySQL connection failed', 'status' => 0], 404);
            }

            $ssoSettingsData = DB::connection($dbDetails->db_name)
                ->table('cloud_variabler')
                ->where('id', $sso_setting_id)
                ->first();

            if ($ssoSettingsData) {
                $company_id =  Crypt::decrypt($request->query('companyId'));
                return response()->json(['data' => $ssoSettingsData, 'companyId' => $company_id,  'status' => 1], 200);
            } else {
                return response()->json(['error' => 'Data not fount', 'status' => 0], 404);
            }
        }
    }

    public function ssoSeetingUpdateById(Request $request)
    {
        // return dd($request);
        $sso_variable_name =  !empty($request->sso_variable_name) ? $request->sso_variable_name : '';
        $sso_value_name = !empty($request->sso_value_name) ? $request->sso_value_name : '';
        $sso_description_name = !empty($request->sso_description_name) ? $request->sso_description_name : '';
        $sso_company_type  = !empty($request->company_type) ? $request->company_type : '1';
        $sso_setting_id = $request->sso_id;
        $company_id = $request->company_id;

        // $dbDetails =  CompanyDatabase::where('company_id', $company_id)->first();
        $dbDetails = $this->getDatabaseDetails($company_id);

        if (!$dbDetails) {
            return response()->json(['error' => 'Database details not found.', 'status' => 0], 404);
        }

        $this->configureDatabaseConnection($dbDetails);

        if (!$this->databaseConnection($dbDetails->db_name)) {
            return response()->json(['error' => 'MySQL connection failed', 'status' => 0], 500);
        }
        $affectedRows = DB::connection($dbDetails->db_name)
            ->table('cloud_variabler')
            ->where('id', $sso_setting_id)
            ->update([
                'beskrivelse' => $sso_description_name,
                'variabel' => $sso_variable_name,
                'vaerdi' => $sso_value_name,
                'company_type' => $sso_company_type,
            ]);

        if ($affectedRows) {
            return response()->json(['message' => 'Update successful',  'companyId' => crypt::encrypt($company_id), 'status' => 1], 200);
        } else {
            return response()->json(['message' => "update failed.",  'status' => 0], 500);
        }
    }
    /**
     * Get database details for the given company ID.
     */
    private function getDatabaseDetails($company_id)
    {
        return CompanyDatabase::where('company_id', $company_id)->first();
    }
    /**
     * Configure database connection dynamically.
     */
    private function configureDatabaseConnection($dbDetails)
    {
        config([
            "database.connections.$dbDetails->db_name" => [
                'driver' => 'mysql',
                'host' => env('DB_ROOT_HOST', '127.0.0.1'),
                'port' => env('DB_ROOT_PORT', '3306'),
                'database' => $dbDetails->db_name,
                'username' => $dbDetails->dbuser_name,
                'password' => $dbDetails->db_password,
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ]
        ]);
    }
    /**
     * Test if the connection to the database is successful.
     */
    private function databaseConnection($dbName)
    {
        try {
            DB::connection($dbName)->getPdo();
            Log::info("Successfully connected to the database: " . $dbName);
            return true;
        } catch (\Exception $e) {
            Log::error("MySQL connection failed: " . $e->getMessage());
            return false;
        }
    }
    public function getModulesByCrm(Request $request)
    {
        $roleId = crypt::decrypt($request->input('role_id'));

        // Get the permissions for the role and client
        $permissionIds = RoleHasPermission::where([['role_id', $roleId], ['module_type', 2]])->pluck('permission_id');
        $role = Role::find($roleId);

        $permissionArray = [];
        if ($permissionIds->isNotEmpty()) {
            foreach ($permissionIds as $id) {
                $permissionArray[] = Permission::where('id', $id)->pluck('name')->first();
            }
        }

        $actions = [];
        $uniques = [];
        foreach ($permissionArray as $permission) {
            $splitData = explode('.', $permission);
            if (count($splitData) === 3) {
                $module = $splitData[1];
                $actionPart = $splitData[2];
                $uniques[$module] = $module;

                if ($actionPart === 'index') {
                    $actions[] = 'crm.' . $module . '.index';
                }
                if ($actionPart === 'create') {
                    $actions[] = 'crm.' . $module . '.create';
                }
                if ($actionPart === 'edit') {
                    $actions[] = 'crm.' . $module . '.edit';
                }
                if ($actionPart === 'delete') {
                    $actions[] = 'crm.' . $module . '.delete';
                }
            }
        }
        $accessModules = Module::where('module_type', 2)->where('status', 1)->get();

        return response()->json([
            'data' => $actions,
            'access_modules' => $uniques,
            'modules' => $accessModules,
            'role' => $role
        ]);
    }
    public function saveCrmPrivileges(Request $request)
    {
        $roleId = Crypt::decrypt($request->role_id);
        $permissions = $request->permission;
        // print_r($permissions);
        if (isset($request->roleName)) {
            $company_id = crypt::decrypt($request->companyId);
            $validator = Validator::make($request->all(), [
                'roleName' => 'required|unique:roles,name,' . $roleId . ',id,company_id,' . $company_id,
            ], [
                'roleName.required' => 'Role required',
                'roleName.unique' => 'Role already exists',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 409);
            }
            $name = strtolower(str_replace(' ', '', $request->roleName));
            $check_rolename_exist = Role::where([['company_id', $company_id], ['name', $name], ['id', '!=', $roleId]])->exists();
            if ($check_rolename_exist)
                return response()->json(["message" => "The role has already been taken.", "error" => array("roleName" => array("The role has already been taken."))], 409);

            $displayName = ucfirst($request->roleName);
            Role::where('id', $roleId)->update([
                'name' => $name,
                'display_name' => $displayName,
            ]);
        }
        if (!isset($permissions)) {
            RoleHasPermission::where([['role_id', $roleId], ['module_type', 2]])->delete();
            return response()->json(['success' => 'Privileges Updated']);
        }

        // Default to an empty array if $blocked is not set
        $blocked = $request->input('blocked', []);
        $enabled = $request->input('enabled', []);

        $role = Role::where('id', $roleId)->pluck('name')->first();


        $permissionData  = Permission::select('permissions.id', 'permissions.name', 'permissions.module_id')
            ->join('modules', function ($join) {
                $join->on('modules.id', '=', 'permissions.module_id');
                $join->where('modules.module_type', '=', 2);
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
        // echo '</pre>';
        // print_r($permissionArray);
        // echo '</pre>';

        //Delete all inserted previous records
        RoleHasPermission::where([['role_id', $roleId], ['module_type', 2]])->delete();
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
                        'module_type' => 2
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
                            'module_type' => 2
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
            // $defaultPermissionIds = Permission::where('module_id', 1)->pluck('id');
            // foreach ($defaultPermissionIds as $pid) {
            //     $defaultPermissions[] = [
            //         'permission_id' => $pid,
            //         'role_id' => $roleId
            //     ];
            // }
            RoleHasPermission::insert(array_merge($defaultPermissions, $result));
        }

        // Update the Module table
        foreach ($blocked as $moduleId => $isBlocked) {
            $module = Module::find($moduleId);
            if ($module) {
                // Convert blocked state to integer (1 for true, 0 for false)
                $module->is_blocked = $isBlocked === "true" ? 1 : 0;

                // Convert enabled state to integer (1 for true, 0 for false)
                if (isset($enabled[$moduleId])) {
                    $module->is_enabled = $enabled[$moduleId] === "true" ? 1 : 0;
                } else {
                    $module->is_enabled = 0; // Default to 0 if not set
                }
                $module->save();
            }
        }

        return response()->json(['success' => 'Privileges Updated']);

        // print_r($insertArray);
    }
    public function createCrmPrivileges(Request $request)
    {
        try {
            $company_id = Crypt::decrypt($request->companyId);
            $validator = Validator::make($request->all(), [
                'role' => 'required|unique:roles,name,NULL,id,company_id,' . $company_id,
            ], [
                'role.required' => 'Role required',
                'role.unique' => 'Role already exists',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 409);
            }
            $name = strtolower(str_replace(' ', '', $request->role));
            $check_rolename_exist = Role::where([['company_id', $company_id], ['name', $name]])->exists();
            if ($check_rolename_exist)
                return response()->json(["message" => "The role has already been taken.", "error" => array("role" => array("The role has already been taken."))], 409);

            $displayName = ucfirst($request->role);
            $role = new Role();
            $role->name = $name;
            $role->display_name = $displayName;
            $role->guard_name = 'web';
            $role->company_id = $company_id;
            $role->type = 1;
            $role->save();

            if (!isset($request->permission))
                return response()->json(['success' => 'Role Added Sccessfully', 'status' => 1], 201);

            $permissions = $request->permission;
            $roleId = $role->id;

            $permissionData  = Permission::select('permissions.id', 'permissions.name', 'permissions.module_id')
                ->join('modules', function ($join) {
                    $join->on('modules.id', '=', 'permissions.module_id');
                    $join->where('modules.module_type', '=', 2);
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
                            'module_type' => 2,
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
                                'module_type' => 2,
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
                // $defaultPermissionIds = Permission::where('module_id', 1)->pluck('id');
                // foreach ($defaultPermissionIds as $pid) {
                //     $defaultPermissions[] = [
                //         'permission_id' => $pid,
                //         'role_id' => $roleId
                //     ];
                // }
                RoleHasPermission::insert(array_merge($defaultPermissions, $result));
            }

            return response()->json(['success' => 'Role & Privileges Updated', 'status' => 1], 201);
        } catch (\Exception $e) {
            // Directly return the error message
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getCrmRoles($comapnyId, Request $request)
    {
        $company_id = Crypt::decrypt($comapnyId);
        $roles = Role::where([['company_id', $company_id]])->get();
        $role_settings = 'crm';
        $html = view('crm.admin.roles.roledata', compact('roles', 'role_settings'))->render();
        $data = [
            'html' => $html,
            'status_code' => 200,
        ];
        return $data;
    }
    public function deleteCrmRoles($delete_id)
    {
        $role_id = Crypt::decrypt($delete_id);
        try {
            Role::where('id', $role_id)->delete();
            return response()->json(['status' => 200, 'success' => 'Role Deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getCmsRoles($comapnyId, Request $request)
    {

        $company_id = Crypt::decrypt($comapnyId);
        $roles = Role::where([['company_id', $company_id]])->get();
        $module_type = 3;
        $role_settings = 'cms';
        $html = view('crm.admin.roles.roledata', compact('roles', 'module_type', 'role_settings'))->render();
        $data = [
            'html' => $html,
            'status_code' => 200,
        ];
        return $data;
    }
    public function getModulesByCms(Request $request)
    {
        $roleId = crypt::decrypt($request->input('role_id'));
        // Get the permissions for the role and client
        $permissionIds = RoleHasPermission::where([['role_id', $roleId], ['module_type', 3]])->pluck('permission_id');
        $role = Role::find($roleId);

        $permissionArray = [];
        if ($permissionIds->isNotEmpty()) {
            foreach ($permissionIds as $id) {
                $permissionArray[] = Permission::where('id', $id)->pluck('name')->first();
            }
        }
        $actions = [];
        $uniques = [];
        foreach ($permissionArray as $permission) {
            $splitData = explode('.', $permission);
            if (count($splitData) === 3) {
                $module = $splitData[1];
                $actionPart = $splitData[2];
                $uniques[$module] = $module;

                if ($actionPart === 'index') {
                    $actions[] = 'cms.' . $module . '.index';
                }
                if ($actionPart === 'create') {
                    $actions[] = 'cms.' . $module . '.create';
                }
                if ($actionPart === 'edit') {
                    $actions[] = 'cms.' . $module . '.edit';
                }
                if ($actionPart === 'delete') {
                    $actions[] = 'cms.' . $module . '.delete';
                }
            }
        }
        $accessModules = Module::where('module_type', 3)->where('status', 1)->get();

        return response()->json([
            'data' => $actions,
            'access_modules' => $uniques,
            'modules' => $accessModules,
            'role' => $role
        ]);
    }
    public function saveCmsPrivileges(Request $request)
    {
        $roleId = Crypt::decrypt($request->role_id);
        $permissions = $request->permission;
        // print_r($permissions);
        if (isset($request->roleName)) {
            $company_id = crypt::decrypt($request->companyId);
            $validator = Validator::make($request->all(), [
                'roleName' => 'required|unique:roles,name,' . $roleId . ',id,company_id,' . $company_id,
            ], [
                'roleName.required' => 'Role required',
                'roleName.unique' => 'Role already exists',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 409);
            }
            $name = strtolower(str_replace(' ', '', $request->roleName));
            $check_rolename_exist = Role::where([['company_id', $company_id], ['name', $name], ['id', '!=', $roleId]])->exists();
            if ($check_rolename_exist)
                return response()->json(["message" => "The role has already been taken.", "error" => array("roleName" => array("The role has already been taken."))], 409);
            $displayName = ucfirst($request->roleName);
            Role::where('id', $roleId)->update([
                'name' => $name,
                'display_name' => $displayName,
            ]);
        }


        if (!isset($permissions)) {
            RoleHasPermission::where([['role_id', $roleId], ['module_type', 3]])->delete();
            return response()->json(['success' => 'Privileges Updated']);
        }


        // Default to an empty array if $blocked is not set
        $blocked = $request->input('blocked', []);
        $enabled = $request->input('enabled', []);

        $role = Role::where('id', $roleId)->pluck('name')->first();


        $permissionData  = Permission::select('permissions.id', 'permissions.name', 'permissions.module_id')
            ->join('modules', function ($join) {
                $join->on('modules.id', '=', 'permissions.module_id');
                $join->where('modules.module_type', '=', 3);
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
        RoleHasPermission::where([['role_id', $roleId], ['module_type', 3]])->delete();
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
                        'module_type' => 3,
                    ];
                }
            } else {
                $modulename = $moduleInfo[$moduleId] ?? '';
                switch ($actionPart) {
                    case 'create':
                        $actions = [
                            "cms.$modulename.create",
                            "cms.$modulename.store",
                        ];
                        break;
                    case 'index':
                        $actions = [
                            "cms.$modulename.index",
                            "cms.$modulename.get",
                        ];
                        break;
                    case 'edit':
                        $actions = [
                            "cms.$modulename.edit",
                            "cms.$modulename.update",
                        ];
                        break;
                    case 'delete':
                        $actions = ["cms.$modulename.delete"];
                        break;
                }

                foreach ($actions as $action) {
                    $key = array_search($action, array_column($permissionInfo[$moduleId] ?? [], 'name'));
                    if ($key !== false) {
                        $insertArray[] = [
                            'permission_id' => $permissionInfo[$moduleId][$key]['id'],
                            'role_id' => $roleId,
                            'module_type' => 3,
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
            $defaultPermissionIds = Permission::where('module_id', 3)->pluck('id');
            // foreach ($defaultPermissionIds as $pid) {
            //     $defaultPermissions[] = [
            //         'permission_id' => $pid,
            //         'role_id' => $roleId
            //     ];
            // }
            //  print_r($defaultPermissions);exit;
            RoleHasPermission::insert(array_merge($defaultPermissions, $result));
        }

        // Update the Module table
        foreach ($blocked as $moduleId => $isBlocked) {
            $module = Module::find($moduleId);
            if ($module) {
                // Convert blocked state to integer (1 for true, 0 for false)
                $module->is_blocked = $isBlocked === "true" ? 1 : 0;

                // Convert enabled state to integer (1 for true, 0 for false)
                if (isset($enabled[$moduleId])) {
                    $module->is_enabled = $enabled[$moduleId] === "true" ? 1 : 0;
                } else {
                    $module->is_enabled = 0; // Default to 0 if not set
                }
                $module->save();
            }
        }

        return response()->json(['success' => 'Privileges Updated']);

        // print_r($insertArray);
    }
    public function createCmsPrivileges(Request $request)
    {
        try {
            $company_id = Crypt::decrypt($request->companyId);
            $validator = Validator::make($request->all(), [
                'role' => 'required|unique:roles,name,NULL,id,company_id,' . $company_id,
            ], [
                'role.required' => 'Role required',
                'role.unique' => 'Role already exists',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 409);
            }
            $name = strtolower(str_replace(' ', '', $request->role));
            $check_rolename_exist = Role::where([['company_id', $company_id], ['name', $name]])->exists();
            if ($check_rolename_exist)
                return response()->json(["message" => "The role has already been taken.", "error" => array("role" => array("The role has already been taken."))], 409);

            $displayName = ucfirst($request->role);

            $role = new Role();
            $role->name = $name;
            $role->display_name = $displayName;
            $role->guard_name = 'web';
            $role->company_id = $company_id;
            $role->type = 2;
            $role->save();

            if (!isset($request->permission))
                return response()->json(['success' => 'Role Added Sccessfully']);

            $permissions = $request->permission;
            $roleId = $role->id;



            $permissionData  = Permission::select('permissions.id', 'permissions.name', 'permissions.module_id')
                ->join('modules', function ($join) {
                    $join->on('modules.id', '=', 'permissions.module_id');
                    $join->where('modules.module_type', '=', 3);
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
                            'module_type' => 3,
                        ];
                    }
                } else {
                    $modulename = $moduleInfo[$moduleId] ?? '';
                    switch ($actionPart) {
                        case 'create':
                            $actions = [
                                "cms.$modulename.create",
                                "cms.$modulename.store",
                            ];
                            break;
                        case 'index':
                            $actions = [
                                "cms.$modulename.index",
                                "cms.$modulename.get",
                            ];
                            break;
                        case 'edit':
                            $actions = [
                                "cms.$modulename.edit",
                                "cms.$modulename.update",
                            ];
                            break;
                        case 'delete':
                            $actions = ["cms.$modulename.delete"];
                            break;
                    }

                    foreach ($actions as $action) {
                        $key = array_search($action, array_column($permissionInfo[$moduleId] ?? [], 'name'));
                        if ($key !== false) {
                            $insertArray[] = [
                                'permission_id' => $permissionInfo[$moduleId][$key]['id'],
                                'role_id' => $roleId,
                                'module_type' => 3,
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
                // $defaultPermissionIds = Permission::where('module_id', 1)->pluck('id');
                // foreach ($defaultPermissionIds as $pid) {
                //     $defaultPermissions[] = [
                //         'permission_id' => $pid,
                //         'role_id' => $roleId
                //     ];
                // }
                RoleHasPermission::insert(array_merge($defaultPermissions, $result));
            }

            return response()->json(['success' => 'Role & Privileges Updated']);
        } catch (\Exception $e) {
            // Directly return the error message
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function deleteCmsRoles($delete_id)
    {
        $role_id = Crypt::decrypt($delete_id);
        try {
            Role::where('id', $role_id)->delete();
            return response()->json(['status' => 200, 'success' => 'Role Deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function bulkDeleteUsers(Request $request)
    {
        $userIds = $request->input('userIds');

        if (empty($userIds)) {
            return response()->json(['status' => 0, 'error' => 'No users selected.'], 400);
        }
        try {
            $company_id = $request->input('companyId');
            $dbDetails = $this->getDatabaseDetails($company_id);

            if (!$dbDetails) {
                return response()->json(['status' => 0, 'error' => 'Database details not found.'], 404);
            }

            $this->configureDatabaseConnection($dbDetails);
            if (is_array($userIds)) {
                // Handle bulk delete for multiple users
                DB::connection($dbDetails->db_name)->table('cloud_sso_users')
                    ->whereIn('id', $userIds)
                    ->delete();
            } else {
                // Handle delete for a single user
                DB::connection($dbDetails->db_name)->table('cloud_sso_users')
                    ->where('id', $userIds)
                    ->delete();
            }
            return response()->json(['status' => 200, 'message' => 'Users deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function storeUser(Request $request)
    {
        // dd($request->all());
        $company_id = Crypt::decrypt($request->company_id);
        $switchData = $request->input('switchData');
        // dd($switchData);
        $dbDetails = $this->getDatabaseDetails($company_id);

        if (!$dbDetails) {
            return response()->json(['status' => 0, 'error' => 'Database details not found.'], 404);
        }

        $this->configureDatabaseConnection($dbDetails);
        // Check if the database connection is successful
        if (!$this->databaseConnection($dbDetails->db_name)) {
            return response()->json(['error' => 'MySQL connection failed', 'status' => 0], 500);
        }
        try {
            $validator = Validator::make($request->all(), [
                'name' => [
                    'required',
                ],
                'username' => [
                    function ($attribute, $value, $fail) use ($dbDetails) {
                        $exists = DB::connection($dbDetails->db_name)
                            ->table('cloud_sso_users')->where('brugernavn', $value)->exists();
                        if ($exists) {
                            $fail('Username already exists');
                        }
                    },
                ],
                'email' => [
                    'required',
                    'email',
                    function ($attribute, $value, $fail) use ($dbDetails) {
                        $exists = DB::connection($dbDetails->db_name)
                            ->table('cloud_sso_users')->where('email', $value)->exists();
                        if ($exists) {
                            $fail('Email already exists');
                        }
                    },
                ],
            ], [
                'name.required' => 'Name required',
                'username.unique' => 'Username Already Exist',
                'email.required' => 'Email required',
                'email.email' => 'Must be a valid Email',
                'email.unique' => 'Email Already Exist',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }
            $password =  Str::random(10);
            $hashPassword = md5($password);
            // dd($hashPassword);
            // Insert the user and get the ID of the inserted user
            $userId = DB::connection($dbDetails->db_name)
                ->table('cloud_sso_users')
                ->insertGetId([  // Use insertGetId to get the ID of the newly inserted user
                    'navn' => $request->name,
                    'brugernavn' => $request->username,
                    'password' => $hashPassword,
                    'email' => $request->email,
                    'userlevel' => $request->user_type,
                    'siteaccess' => $switchData,
                    'hideuser' => 0,
                    'lastlogin' => now(),
                    'usynlig' => 0,
                ]);

            // image upload for user
            $userImage = Userimage::create([
                'company_id' => $company_id,
                'user_id' => $userId,  // Use the $userId from the previous step
                'local_imagepath' => $userImagePath ?? null,
                'main_imagepath' => null,
                'status' => '1',
            ]);

            $this->userImageFileUpload($request, $company_id, $userId);

            return response()->json(['status' => 200, 'success' => 'User Created Successfully', 'companyId' => $company_id]);
        } catch (\Exception $e) {
            // Directly return the error message
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    private function userImageFileUpload(Request $request, $companyId, $userId)
    {
        $path = "/uploadassets/company/{$companyId}/users/{$userId}/";
        // Ensure the directory exists
        if (!File::exists(public_path($path))) {
            File::makeDirectory(public_path($path), 0775, true);
        }
        // Handle company logo upload
        if ($request->hasFile('user_image')) {
            $userImagePath = $this->uploadFile($request->file('user_image'), $path, 'logo_');
            Userimage::where('company_id', $companyId)
                ->where('user_id', $userId)->update(['local_imagepath' => $userImagePath]);
        }
    }
    public function getUserdetails(Request $request)
    {
        // Decrypting the company ID and user ID
        $company_id = Crypt::decrypt($request->companyId);
        $userId = Crypt::decrypt($request->userId);

        // Ensure $userId is an array, even if it's a single value
        $userId = is_array($userId) ? $userId : [$userId];

        // Get database details based on the company ID
        $dbDetails = $this->getDatabaseDetails($company_id);

        if (!$dbDetails) {
            return response()->json(['status' => 0, 'error' => 'Database details not found.'], 404);
        }

        // Configure database connection
        $this->configureDatabaseConnection($dbDetails);

        // Check if the database connection is successful
        if (!$this->databaseConnection($dbDetails->db_name)) {
            return response()->json(['error' => 'MySQL connection failed', 'status' => 0], 500);
        }

        $data = DB::connection($dbDetails->db_name)
            ->table('cloud_sso_users')->whereIn('id', $userId)->first();

        return response()->json(['data' => $data]);
    }
    public function editUserlogin(Request $request)
    {
        // Decrypting the company ID and user ID
        $company_id = Crypt::decrypt($request->companyId);
        $userId = Crypt::decrypt($request->userId);

        // Ensure $userId is an array, even if it's a single value
        $userId = is_array($userId) ? $userId : [$userId];

        // Get database details based on the company ID
        $dbDetails = $this->getDatabaseDetails($company_id);

        if (!$dbDetails) {
            return response()->json(['status' => 0, 'error' => 'Database details not found.'], 404);
        }

        // Configure database connection
        $this->configureDatabaseConnection($dbDetails);

        // Check if the database connection is successful
        if (!$this->databaseConnection($dbDetails->db_name)) {
            return response()->json(['error' => 'MySQL connection failed', 'status' => 0], 500);
        }

        $data = DB::connection($dbDetails->db_name)
            ->table('cloud_sso_users')->whereIn('id', $userId)->first();

        return response()->json(['data' => $data]);
    }
    public function updateUser(Request $request)
    {
        // dd($request->all());
        $company_id = Crypt::decrypt($request->company_id);
        $userId = Crypt::decrypt($request->user_id);
        // $switchData = $request->input('switchData');
        $dbDetails = $this->getDatabaseDetails($company_id);
        if (!$dbDetails) {
            return response()->json(['status' => 0, 'error' => 'Database details not found.'], 404);
        }
        $this->configureDatabaseConnection($dbDetails);
        // Check if the database connection is successful
        if (!$this->databaseConnection($dbDetails->db_name)) {
            return response()->json(['error' => 'MySQL connection failed', 'status' => 0], 500);
        }
        try {
            $validator = Validator::make($request->all(), [
                'name' => [
                    'required',
                ],
                'username' => [
                    function ($attribute, $value, $fail) use ($dbDetails, $userId) {
                        $exists = DB::connection($dbDetails->db_name)
                            ->table('cloud_sso_users')
                            ->where('brugernavn', $value)
                            ->where('id', '!=', $userId)
                            ->exists();
                        if ($exists) {
                            $fail('Username already exists');
                        }
                    },
                ],
                'email' => [
                    'required',
                    'email',
                    function ($attribute, $value, $fail) use ($dbDetails, $userId) {
                        $exists = DB::connection($dbDetails->db_name)
                            ->table('cloud_sso_users')
                            ->where('email', $value)
                            ->where('id', '!=', $userId)
                            ->exists();
                        if ($exists) {
                            $fail('Email already exists');
                        }
                    },
                ],
            ], [
                'name.required' => 'Name required',
                'username.unique' => 'Username Already Exist',
                'email.required' => 'Email required',
                'email.email' => 'Must be a valid Email',
                'email.unique' => 'Email Already Exist',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $updatedRows = DB::connection($dbDetails->db_name)
                ->table('cloud_sso_users')
                ->where('id', $userId)
                ->update([
                    'navn' => $request->name,
                    'brugernavn' => $request->username,
                    'email' => $request->email,
                    'userlevel' => $request->user_type,
                    'oensker_email_ved_specifik_sag' => $request->status,
                    // 'siteaccess' => $switchData,
                    // 'hideuser' => 0,
                    // 'lastlogin' => now(),
                    // 'usynlig' => 0,
                ]);

            return response()->json(['status' => 200, 'success' => 'User Updated Successfully', 'companyId' => $company_id]);
        } catch (\Exception $e) {
            // Directly return the error message
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function CheckCompanyModuleAccess(Request $request)
    {

        // $token = $request->token; // Get token from Authorization header
        // $decoded = JWTAuth::setToken($token)->getPayload();
        // return $decoded;

        $validator = Validator::make($request->all(), [
            'apiKey' => 'required',
            'apiSecret' => 'required',
            'siteType' => 'required',
            'module' => 'required',
            'userId' => 'required',
        ], [
            'apiKey.required' => 'apiKey is required',
            'apiSecret.required' => 'apiSecret is required',
            'siteType.required' => 'siteType is required',
            'module.required' => 'Module is required',
            'userId.required' => 'user is requireds',
        ]);

        if ($validator->fails()) {
            $this->logApiHistory($request, 422, ['error' => 'payload missing']);
            return response()->json(['error' => $validator->errors()], 422);
        }

        $api_key =  $request->apiKey;
        $api_secret = $request->apiSecret;
        $site_type = $request->siteType;
        $module = $request->module;
        $user_id = $request->userId;
        $sub_module = $request->subModule??null;

        $check_company_exist = Company::where([['apikey', $api_key], ['apisecret', $api_secret]])->first();
        if (!$check_company_exist) {

            $this->logApiHistory($request, 401, ['error' => 'Company does not exist']);
            return response()->json(['error' => 'Company does not exist', 'status' => 0], 401);
        }


        $company_id =  $check_company_exist->id;

        $dbDetails = $this->getDatabaseDetails($company_id);

        if (!$dbDetails) {
            $this->logApiHistory($request, 404, ['error' => 'Database details not found.']);
            return response()->json(['error' => 'Database details not found.', 'status' => 0], 404);
        }

        $this->configureDatabaseConnection($dbDetails);


        if (!$this->databaseConnection($dbDetails->db_name)) {
            $this->logApiHistory($request, 500, ['error' => 'MySQL connection failed']);
            return response()->json(['error' => 'MySQL connection failed', 'status' => 0], 500);
        }

        $user_details = DB::connection($dbDetails->db_name)
            ->table('cloud_sso_users')
            ->select('userlevel')
            ->where('id', $user_id)
            ->first();

        if (!$user_details) {
            $this->logApiHistory($request, 404, ['error' => 'User not found']);
            return response()->json(['error' => 'User not found', 'status' => 0], 404);
        }

        $user_role_id = $user_details->userlevel;
        $permission = $site_type . '.' . $module. ($sub_module ? "_$sub_module" : '')  . '.index';
        $permission_id = Permission::where('name', $permission)->pluck('id')->first();
        if (isset($permission_id)) {
            $hasPermission = RoleHasPermission::where('permission_id', $permission_id)->where('role_id', $user_role_id)->first();
            if (isset($hasPermission)) {
                $this->logApiHistory($request, 200, ['Message' => 'Access Granted', 'status' => 1]);
                $customClaims = [
                    'company_id' => $check_company_exist->id,
                    'company_name' => $check_company_exist->company_name, // optional
                    'iss' => 'crmsystem',
                    'iat' => now()->timestamp,
                    'permission' => 1
                ];
                $token = JWTAuth::claims($customClaims)->fromUser($check_company_exist);
                return response()->json(['token' => $token, 'Message' => 'Access Granted', 'status' => 1], 200);
            } else {
                $this->logApiHistory($request, 402, ['error' => 'Access Denied', 'status' => 0]);
                return response()->json(['error' => 'Access Denied', 'status' => 0], 402);
            }
        } else {
            $this->logApiHistory($request, 404, ['error' => 'Your requested module did not exist', 'status' => 0]);
            return response()->json(['error' => 'your request Module did not exist', 'status' => 0], 404);
        }

        $this->logApiHistory($request, 500, ['error' => 'Something went wrong', 'status' => 0]);
        return response()->json(['error' => 'Something Went Worng', 'status' => 0], 500);
    }
    private function logApiHistory(Request $request, $statusCode, $response)
    {
        $req = $request->header();
        ApiHistory::create([
            'user_agent' => $request->header('User-Agent') ?? null,
            'request_payload' => $request->all() ?? null,
            'status_code' => $statusCode ?? null,
            'response_payload' => is_array($response) || is_object($response) ? $response : null,
            'url' => $request->url() ?? null,
            'http_method' => $request->method() ?? null,
            'error_message' => $response['error'] ?? null,
            'x-forwarded-for' => isset($req["x-forwarded-for"]) ? $req["x-forwarded-for"][0] : '',
            'accept-encoding' => isset($req["accept-encoding"]) ? $req["accept-encoding"][0] : '',
            'accept' => isset($req["accept"]) ? $req["accept"][0] : '',
            'connection' => isset($req["connection"]) ? $req["connection"][0] : '',
            'x-forwarded-server' => isset($req["x-forwarded-server"]) ? $req["x-forwarded-server"][0] : '',
            'x-forwarded-host' => isset($req["x-forwarded-host"]) ? $req["x-forwarded-host"][0] : '',
            'host' => isset($req["host"]) ? $req["host"][0] : ''
        ]);
    }
    public function getShopRoles($comapnyId, Request $request)
    {
        $company_id = Crypt::decrypt($comapnyId);
        $roles = Role::where([['company_id', $company_id]])->get();
        $role_settings = 'shop';
        $html = view('crm.admin.roles.roledata', compact('roles', 'role_settings'))->render();
        $data = [
            'html' => $html,
            'status_code' => 200,
        ];
        return $data;
    }
    public function getModulesByShop(Request $request)
    {
        $roleId = crypt::decrypt($request->input('role_id'));
        // dd($roleId);
        // Get the permissions for the role and client
        $permissionIds = RoleHasPermission::where([['role_id', $roleId], ['module_type', 4]])->pluck('permission_id');
        $role = Role::find($roleId);

        $permissionArray = [];
        if ($permissionIds->isNotEmpty()) {
            foreach ($permissionIds as $id) {
                $permissionArray[] = Permission::where('id', $id)->pluck('name')->first();
            }
        }

        $actions = [];
        $uniques = [];
        foreach ($permissionArray as $permission) {
            $splitData = explode('.', $permission);
            if (count($splitData) === 3) {
                $module = $splitData[1];
                $actionPart = $splitData[2];
                $uniques[$module] = $module;

                if ($actionPart === 'index') {
                    $actions[] = 'crm.' . $module . '.index';
                }
                if ($actionPart === 'create') {
                    $actions[] = 'crm.' . $module . '.create';
                }
                if ($actionPart === 'edit') {
                    $actions[] = 'crm.' . $module . '.edit';
                }
                if ($actionPart === 'delete') {
                    $actions[] = 'crm.' . $module . '.delete';
                }
            }
        }
        $accessModules = Module::where('module_type', 4)->where('status', 1)->get();

        return response()->json([
            'data' => $actions,
            'access_modules' => $uniques,
            'modules' => $accessModules,
            'role' => $role
        ]);
    }
    public function createShopPrivileges(Request $request)
    {
        try {
            $company_id = Crypt::decrypt($request->companyId);
            $validator = Validator::make($request->all(), [
                'role' => 'required|unique:roles,name,NULL,id,company_id,' . $company_id,
            ], [
                'role.required' => 'Role required',
                'role.unique' => 'Role already exists',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 409);
            }
            $name = strtolower(str_replace(' ', '', $request->role));
            $check_rolename_exist = Role::where([['company_id', $company_id], ['name', $name]])->exists();
            if ($check_rolename_exist)
                return response()->json(["message" => "The role has already been taken.", "error" => array("role" => array("The role has already been taken."))], 409);

            $displayName = ucfirst($request->role);
            $role = new Role();
            $role->name = $name;
            $role->display_name = $displayName;
            $role->guard_name = 'web';
            $role->company_id = $company_id;
            $role->type = 1;
            $role->save();

            if (!isset($request->permission))
                return response()->json(['success' => 'Role Added Sccessfully', 'status' => 1], 201);

            $permissions = $request->permission;
            $roleId = $role->id;

            $permissionData  = Permission::select('permissions.id', 'permissions.name', 'permissions.module_id')
                ->join('modules', function ($join) {
                    $join->on('modules.id', '=', 'permissions.module_id');
                    $join->where('modules.module_type', '=', 4);
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
                        $dashboardPrivileges = ['shop.privileges.dashboard', 'shop.privileges.fetchdashboard', 'shop.privileges.storedashboard'];
                        $moduleinsertArray = array_diff($moduleinsertArray, Permission::whereIn('permissions.name', $dashboardPrivileges)
                            ->pluck('id')->toArray());
                    }

                    foreach ($moduleinsertArray as $mdata) {
                        $insertArray[] = [
                            'permission_id' => $mdata,
                            'role_id' => $roleId,
                            'module_type' => 4,
                        ];
                    }
                } else {
                    $modulename = $moduleInfo[$moduleId] ?? '';
                    $actions = [
                        'create' => ["shop.$modulename.create", "shop.$modulename.store"],
                        'index'  => ["shop.$modulename.index", "shop.$modulename.get"],
                        'edit'   => ["shop.$modulename.edit", "shop.$modulename.update"],
                        'delete' => ["shop.$modulename.delete"],
                    ];
                    $actions = $actions[$actionPart] ?? [];
                    foreach ($actions as $action) {
                        $key = array_search($action, array_column($permissionInfo[$moduleId] ?? [], 'name'));
                        if ($key !== false) {
                            $insertArray[] = [
                                'permission_id' => $permissionInfo[$moduleId][$key]['id'],
                                'role_id' => $roleId,
                                'module_type' => 4,
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
                RoleHasPermission::insert(array_merge($defaultPermissions, $result));
            }

            return response()->json(['success' => 'Role & Privileges Updated', 'status' => 1], 201);
        } catch (\Exception $e) {
            // Directly return the error message
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function saveShopPrivileges(Request $request)
    {
        $roleId = Crypt::decrypt($request->role_id);
        $permissions = $request->permission;
        // print_r($permissions);
        if (isset($request->roleName)) {
            $company_id = crypt::decrypt($request->companyId);
            $validator = Validator::make($request->all(), [
                'roleName' => 'required|unique:roles,name,' . $roleId . ',id,company_id,' . $company_id,
            ], [
                'roleName.required' => 'Role required',
                'roleName.unique' => 'Role already exists',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 409);
            }
            $name = strtolower(str_replace(' ', '', $request->roleName));
            $check_rolename_exist = Role::where([['company_id', $company_id], ['name', $name], ['id', '!=', $roleId]])->exists();
            if ($check_rolename_exist)
                return response()->json(["message" => "The role has already been taken.", "error" => array("roleName" => array("The role has already been taken."))], 409);

            $displayName = ucfirst($request->roleName);
            Role::where('id', $roleId)->update([
                'name' => $name,
                'display_name' => $displayName,
            ]);
        }
        if (!isset($permissions)) {
            RoleHasPermission::where([['role_id', $roleId], ['module_type', 4]])->delete();
            return response()->json(['success' => 'Privileges Updated']);
        }

        // Default to an empty array if $blocked is not set
        $blocked = $request->input('blocked', []);
        $enabled = $request->input('enabled', []);

        $role = Role::where('id', $roleId)->pluck('name')->first();


        $permissionData  = Permission::select('permissions.id', 'permissions.name', 'permissions.module_id')
            ->join('modules', function ($join) {
                $join->on('modules.id', '=', 'permissions.module_id');
                $join->where('modules.module_type', '=', 4);
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
        RoleHasPermission::where([['role_id', $roleId], ['module_type', 4]])->delete();
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
                        'module_type' => 4
                    ];
                }
            } else {
                $modulename = $moduleInfo[$moduleId] ?? '';
                switch ($actionPart) {
                    case 'create':
                        $actions = [
                            "shop.$modulename.create",
                            "shop.$modulename.store",
                        ];
                        break;
                    case 'index':
                        $actions = [
                            "shop.$modulename.index",
                            "shop.$modulename.get",
                        ];
                        break;
                    case 'edit':
                        $actions = [
                            "shop.$modulename.edit",
                            "shop.$modulename.update",
                        ];
                        break;
                    case 'delete':
                        $actions = ["shop.$modulename.delete"];
                        break;
                }

                foreach ($actions as $action) {
                    $key = array_search($action, array_column($permissionInfo[$moduleId] ?? [], 'name'));
                    if ($key !== false) {
                        $insertArray[] = [
                            'permission_id' => $permissionInfo[$moduleId][$key]['id'],
                            'role_id' => $roleId,
                            'module_type' => 4
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
            RoleHasPermission::insert(array_merge($defaultPermissions, $result));
        }

        // Update the Module table
        foreach ($blocked as $moduleId => $isBlocked) {
            $module = Module::find($moduleId);
            if ($module) {
                // Convert blocked state to integer (1 for true, 0 for false)
                $module->is_blocked = $isBlocked === "true" ? 1 : 0;

                // Convert enabled state to integer (1 for true, 0 for false)
                if (isset($enabled[$moduleId])) {
                    $module->is_enabled = $enabled[$moduleId] === "true" ? 1 : 0;
                } else {
                    $module->is_enabled = 0; // Default to 0 if not set
                }
                $module->save();
            }
        }

        return response()->json(['success' => 'Privileges Updated']);

        // print_r($insertArray);
    }
    public function deleteShopRoles($delete_id)
    {
        $role_id = Crypt::decrypt($delete_id);
        try {
            Role::where('id', $role_id)->delete();
            return response()->json(['status' => 200, 'success' => 'Role Deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

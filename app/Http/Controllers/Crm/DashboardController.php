<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        $companyCount = Company::count(); 
        $userCount = User::count(); 

        return view('crm.admin.dashboard', compact('companyCount', 'userCount'));
    }
}

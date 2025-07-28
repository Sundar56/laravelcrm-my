<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyDatabase;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    // public function test(){
    //     // $data =  CompanyDatabases::create([
    //     //     'company_id' => 1,
    //     //     'db_name' => 'test',
    //     //     'dbuser_name' => "test user",
    //     //     'db_password' => "423434",
    //     //     'collation' => '',
    //     // ]);

    //     // get single data
    //     $companyDatabase = CompanyDatabase::find(4);
    //     dd($companyDatabase->dbuser_name);
        
    //     // get all data
    //     $data =[];
    //     $companyDatabase = CompanyDatabase::all();
    //     foreach($companyDatabase as $company){
    //         $data[] = $company->dbuser_name;
    //     }
    //     dd($data);

    //     // create 
    //     $companyDatabase = new CompanyDatabases();
    //     $companyDatabase->company_id = 1;
    //     $companyDatabase->db_name = 'my_database';
    //     $companyDatabase->dbuser_name = 'admin';
    //     $companyDatabase->db_password = 'secret';
    //     $companyDatabase->collation = 'utf8_general_ci';
    //     $companyDatabase->save();
    //     dd($companyDatabase);
    // }
}

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Crm\CompanyController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('/CheckCompanyModuleAccess', [CompanyController::class, 'CheckCompanyModuleAccess'])->name('CheckCompanyModuleAccess');
  
});

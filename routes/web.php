<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

$proxy_enabled   = getenv('PROXY_ENABLED');
if (!empty($proxy_enabled) && $proxy_enabled == true) {
    $proxy_url    = getenv('PROXY_URL');
    $proxy_schema = getenv('PROXY_SCHEMA');

    if (!empty($proxy_url)) {
        URL::forceRootUrl($proxy_url);
    }

    if (!empty($proxy_schema)) {
        URL::forceScheme($proxy_schema);
    }
}

Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Route::get('/test', 'App\Http\Controllers\HomeController@test')->name('test');

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/crm/login', 'Crm\AuthController@index')->name('admin.login');
    Route::post('/crm/login', 'Crm\AuthController@userlogin')->name('admin.login.user');
    Route::get('/crm/dashboard', 'Crm\DashboardController@index')->name('crm.dashboard');
    Route::get('/crm/signout', 'Crm\AuthController@signOut')->name('admin.signout');
    Route::post('/crm/changepassword', 'Crm\AuthController@changePassword')->name('admin.changepassword');
    Route::get('/crm/forgotpassword', 'Crm\AuthController@forgotPassword')->name('admin.forgotpassword');
    Route::post('/email', 'Crm\AuthController@sendResetLink')->name('admin.auth.email');
    Route::get('/crm/resetpass', 'Crm\AuthController@resetpass')->name('admin.resetpass');
    Route::group(['prefix' => 'crm', 'namespace' => 'Crm', 'middleware' => [\App\Http\Middleware\PermissionMiddleware::class]], function () {
        Route::group(['prefix' => 'admin'], function () {
            Route::group(['prefix' => 'companies'], function () {
                Route::get('/', 'CompanyController@index')->name('crm.companies.index');
                Route::get('/create', 'CompanyController@create')->name('crm.companies.create');
                Route::get('/getcompanylist', 'CompanyController@getcompanylist')->name('crm.companies.get');
                Route::post('/store', 'CompanyController@store')->name('crm.companies.store');
                Route::get('/edit/{id}', 'CompanyController@edit')->name('crm.companies.edit');
                Route::get('/view/{id}', 'CompanyController@view')->name('crm.companies.view');
                Route::delete('/delete/{id}', 'CompanyController@delete')->name('crm.companies.delete');
                Route::post('/update', 'CompanyController@update')->name('crm.companies.update');
                Route::get('/getLastCompanyId', 'CompanyController@getlastcompanyid')->name('crm.companies.getlastcompanyid');
                Route::get('/getSsoSttings', 'CompanyController@getSsoSttings')->name('crm.companies.getSsoSttings');
                Route::get('ssosettings/edit/{id}', 'CompanyController@ssoSeetingById')->name('crm.companies.ssoSeetingById');
                Route::post('ssosettings/update', 'CompanyController@ssoSeetingUpdateById')->name('crm.companies.ssoSeetingUpdateById');
                Route::get('/get-modules-by-crm', 'CompanyController@getModulesByCrm')->name('crm.companies.getmodules');
                Route::post('/saveCrmPrivileges', 'CompanyController@saveCrmPrivileges')->name('crm.companies.saveCrmprivileges');
                Route::post('/createCrmPrivileges', 'CompanyController@createCrmPrivileges')->name('crm.companies.createCrmprivileges');
                Route::get('/getCrmroles/{id}', 'CompanyController@getCrmRoles')->name('crm.companies.getCrmRoles');
                Route::delete('/deleteCrmroles/{id}', 'CompanyController@deleteCrmRoles')->name('crm.companies.deleteCrmRoles');
                Route::get('/getUserlogin', 'CompanyController@getUserlogin')->name('crm.companies.getUserlogin');
                Route::delete('/bulkDeleteUsers', 'CompanyController@bulkDeleteUsers')->name('crm.companies.bulkdelete');
                Route::get('/getuserdetails/{id}', 'CompanyController@getUserdetails')->name('crm.companies.getuserdetails');
                Route::get('/getCmsroles/{id}', 'CompanyController@getCmsRoles')->name('crm.companies.getCmsRoles');
                Route::get('/get-modules-by-cms', 'CompanyController@getModulesByCms')->name('crm.companies.getmodulesByCms');
                Route::post('/saveCmsPrivileges', 'CompanyController@saveCmsPrivileges')->name('crm.companies.saveCmsprivileges');
                Route::post('/createCmsPrivileges', 'CompanyController@createCmsPrivileges')->name('crm.companies.createCmsprivileges');
                Route::delete('/deleteCmsroles/{id}', 'CompanyController@deleteCmsRoles')->name('crm.companies.deleteCmsRoles');
                Route::post('/storeuser', 'CompanyController@storeUser')->name('crm.companies.storeuser');
                Route::get('/editUserlogin/{id}', 'CompanyController@editUserlogin')->name('crm.companies.editUserlogin');
                Route::post('/updateUser', 'CompanyController@updateUser')->name('crm.companies.updateUser');
                Route::get('/check-company-name', 'CompanyController@checkCompanyName')->name('crm.companies.checkCompanyName');
                Route::get('/check-invoice-email', 'CompanyController@checkInvoiceEmail')->name('crm.companies.checkInvoiceEmail');
            });
            Route::group(['prefix' => 'roles'], function () {
                Route::get('/', 'RolesController@index')->name('crm.roles.index');
                Route::get('/create', 'RolesController@create')->name('crm.roles.create');
                Route::post('/store', 'RolesController@store')->name('crm.roles.store');
                Route::get('/get-modules-by-role', 'RolesController@getModulesByRole')->name('crm.roles.getmodules');
                Route::post('/savePrivileges', 'RolesController@savePrivileges')->name('crm.roles.saveprivileges');
                Route::get('/getroles', 'RolesController@getRoles')->name('crm.roles.getRoles');
                Route::delete('/delete/{id}', 'RolesController@delete')->name('crm.roles.delete');
                Route::get('/edit/{id}', 'RolesController@edit')->name('crm.roles.edit');
                Route::post('/update', 'RolesController@update')->name('crm.roles.update');
            });
            Route::group(['prefix' => 'adminusers'], function () {
                Route::get('/', 'AdminuserController@index')->name('crm.adminusers.index');
                Route::get('/create', 'AdminuserController@create')->name('crm.adminusers.create');
                Route::get('/getuserslist', 'AdminuserController@getadminUserslist')->name('crm.adminusers.get');
                Route::post('/store', 'AdminuserController@store')->name('crm.adminusers.store');
                Route::get('/edit/{id}', 'AdminuserController@edit')->name('crm.adminusers.edit');
                Route::get('/view', 'AdminuserController@view')->name('crm.adminusers.view');
                Route::delete('/delete/{id}', 'AdminuserController@delete')->name('crm.adminusers.delete');
                Route::post('/update', 'AdminuserController@update')->name('crm.adminusers.update');
                Route::get('/getuserdetails/{id}', 'AdminuserController@getUserdetails')->name('crm.adminusers.getuserdetails');
                Route::post('/resetpassword/{id}', 'AdminuserController@resetPassword')->name('crm.adminusers.reset');
            });
            Route::group(['prefix' => 'sso'], function () {
                Route::get('/', 'CompanyController@index')->name('crm.sso.index');
                Route::get('/create', 'CompanyController@create')->name('crm.sso.create');
                Route::get('/getcompanylist', 'CompanyController@getcompanylist')->name('crm.sso.get');
                Route::post('/store', 'CompanyController@store')->name('crm.sso.store');
                Route::get('/edit/{id}', 'CompanyController@edit')->name('crm.sso.edit');
                Route::get('/view', 'CompanyController@view')->name('crm.sso.view');
                Route::delete('/delete/{id}', 'CompanyController@delete')->name('crm.sso.delete');
            });
            Route::group(['prefix' => 'shop'], function () {
                Route::get('/', 'CompanyController@index')->name('crm.shop.index');
                Route::get('/getShopRoles/{id}', 'CompanyController@getShopRoles')->name('crm.shop.get');
                Route::get('/get-modules-by-shop', 'CompanyController@getModulesByShop')->name('crm.shop.getshopmodules');
                Route::post('/createShopPrivileges', 'CompanyController@createShopPrivileges')->name('crm.shop.create');
                Route::post('/saveShopPrivileges', 'CompanyController@saveShopPrivileges')->name('crm.shop.store');
                Route::delete('/deleteShoproles/{id}', 'CompanyController@deleteShopRoles')->name('crm.shop.delete');
                Route::get('/edit/{id}', 'CompanyController@edit')->name('crm.shop.edit');
                Route::get('/view', 'CompanyController@view')->name('crm.shop.view');
            });
            Route::group(['prefix' => 'companyuser'], function () {
                Route::get('/', 'CompanyController@index')->name('crm.companyuser.index');
                Route::get('/create', 'CompanyController@create')->name('crm.companyuser.create');
                Route::get('/getcompanylist', 'CompanyController@getcompanylist')->name('crm.companyuser.get');
                Route::post('/store', 'CompanyController@store')->name('crm.companyuser.store');
                Route::get('/edit/{id}', 'CompanyController@edit')->name('crm.companyuser.edit');
                Route::get('/view', 'CompanyController@view')->name('crm.companyuser.view');
                Route::delete('/delete/{id}', 'CompanyController@delete')->name('crm.companyuser.delete');
            });
            Route::group(['prefix' => 'cms'], function () {
                Route::get('/', 'CompanyController@index')->name('crm.cms.index');
                Route::get('/create', 'CompanyController@create')->name('crm.cms.create');
                Route::get('/getcompanylist', 'CompanyController@getcompanylist')->name('crm.cms.get');
                Route::post('/store', 'CompanyController@store')->name('crm.cms.store');
                Route::get('/edit/{id}', 'CompanyController@edit')->name('crm.cms.edit');
                Route::get('/view', 'CompanyController@view')->name('crm.cms.view');
                Route::delete('/delete/{id}', 'CompanyController@delete')->name('crm.cms.delete');
            });
            Route::group(['prefix' => 'crm'], function () {
                Route::get('/', 'CompanyController@index')->name('crm.crm.index');
                Route::get('/create', 'CompanyController@create')->name('crm.crm.create');
                Route::get('/getcompanylist', 'CompanyController@getcompanylist')->name('crm.crm.get');
                Route::post('/store', 'CompanyController@store')->name('crm.crm.store');
                Route::get('/edit/{id}', 'CompanyController@edit')->name('crm.crm.edit');
                Route::get('/view', 'CompanyController@view')->name('crm.crm.view');
                Route::delete('/delete/{id}', 'CompanyController@delete')->name('crm.crm.delete');
            });
            Route::group(['prefix' => 'passwordreset'], function () {
                Route::get('/', 'CompanyController@index')->name('crm.passwordreset.index');
                Route::get('/create', 'CompanyController@create')->name('crm.passwordreset.create');
                Route::get('/getcompanylist', 'CompanyController@getcompanylist')->name('crm.passwordreset.get');
                Route::post('/store', 'CompanyController@store')->name('crm.passwordreset.store');
                Route::get('/edit/{id}', 'CompanyController@edit')->name('crm.passwordreset.edit');
                Route::get('/view', 'CompanyController@view')->name('crm.passwordreset.view');
                Route::delete('/delete/{id}', 'CompanyController@delete')->name('crm.passwordreset.delete');
            });
        });
    });
});

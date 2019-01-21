<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', 'LoginController@getLogin');
Route::post('login', 'LoginController@postLogin');


Route::group(['prefix' => '', 'middleware' => ['auth.user']], function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::group(['prefix' => 'lib', 'namespace' => 'Lib'], function () {
        /// company categories 
        Route::group(['prefix' => 'company-cat'], function () {
            Route::get('/', 'LibCompanyCatController@getIndex')->middleware('can:list,App\Model\LibCompanyCat');
            Route::get('create', 'LibCompanyCatController@getCreate')->middleware('can:create,App\Model\LibCompanyCat');
            Route::post('create', 'LibCompanyCatController@postCreate')->middleware('can:create,App\Model\LibCompanyCat');
            Route::get('update/{item}', 'LibCompanyCatController@getUpdate')->middleware('can:update,item');
            Route::post('update/{item}', 'LibCompanyCatController@postUpdate')->middleware('can:update,item');
            Route::get('delete/{item}', 'LibCompanyCatController@getDelete')->middleware('can:delete,item');
        });

        // product categories 
        Route::group(['prefix' => 'product-cat'], function () {
            Route::get('/', 'LibProductCatController@getIndex')->middleware('can:list,App\Model\LibProductCat');
            Route::get('create', 'LibProductCatController@getCreate')->middleware('can:create,App\Model\LibProductCat');
            Route::post('create', 'LibProductCatController@postCreate')->middleware('can:create,App\Model\LibProductCat');
            Route::get('update/{item}', 'LibProductCatController@getUpdate')->middleware('can:update,item');
            Route::post('update/{item}', 'LibProductCatController@postUpdate')->middleware('can:update,item');
            Route::get('delete/{item}', 'LibProductCatController@getDelete')->middleware('can:delete,item');
        });

        // product type 
        Route::group(['prefix' => 'product-type'], function () {
            Route::get('/', 'LibProductTypeController@getIndex')->middleware('can:list,App\Model\LibProductType');
            Route::get('create', 'LibProductTypeController@getCreate')->middleware('can:create,App\Model\LibProductType');
            Route::post('create', 'LibProductTypeController@postCreate')->middleware('can:create,App\Model\LibProductType');
            Route::get('update/{item}', 'LibProductTypeController@getUpdate')->middleware('can:update,item');
            Route::post('update/{item}', 'LibProductTypeController@postUpdate')->middleware('can:update,item');
            Route::get('delete/{item}', 'LibProductTypeController@getDelete')->middleware('can:delete,item');
        });

        // product option 
        Route::group(['prefix' => 'product-option'], function () {
            Route::get('/', 'LibProductOptionController@getIndex')->middleware('can:list,App\Model\LibProductOption');
            Route::get('create', 'LibProductOptionController@getCreate')->middleware('can:create,App\Model\LibProductOption');
            Route::post('create', 'LibProductOptionController@postCreate')->middleware('can:create,App\Model\LibProductOption');
            Route::get('update/{item}', 'LibProductOptionController@getUpdate')->middleware('can:update,item');
            Route::post('update/{item}', 'LibProductOptionController@postUpdate')->middleware('can:update,item');
            Route::get('delete/{item}', 'LibProductOptionController@getDelete')->middleware('can:delete,item');
        });

        // company
        Route::group(['prefix' => 'company'], function () {
            Route::get('/', 'CompanyController@getIndex')->middleware('can:list,App\Model\Company');
            Route::get('create', 'CompanyController@getCreate')->middleware('can:create,App\Model\Company');
            Route::post('create', 'CompanyController@postCreate')->middleware('can:create,App\Model\Company');
            Route::get('update/{item}', 'CompanyController@getUpdate')->middleware('can:update,item');
            Route::post('update/{item}', 'CompanyController@postUpdate')->middleware('can:update,item');
            Route::get('delete/{item}', 'CompanyController@getDelete')->middleware('can:delete,item');
            Route::get('upgrade-tohalf/{item}', 'CompanyController@getUpgradeToHalfPermission')->middleware('can:upgradeToHalfPermission,item');
            Route::get('upgrade-tofull/{item}', 'CompanyController@getUpgradeToFullPermission')->middleware('can:upgradeToFullPermission,item');
        });

        // director
        Route::group(['prefix' => 'director'], function () {
            Route::get('/', 'DirectorController@getIndex')->middleware('can:list,App\Model\View\Director');
            Route::get('create', 'DirectorController@getCreate')->middleware('can:create,App\Model\View\Director');
            Route::post('create', 'DirectorController@postCreate')->middleware('can:create,App\Model\View\Director');
            Route::get('update/{item}', 'DirectorController@getUpdate')->middleware('can:update,item');
            Route::post('update/{item}', 'DirectorController@postUpdate')->middleware('can:update,item');
            Route::get('delete/{item}', 'DirectorController@getDelete')->middleware('can:delete,item');
        });

        // branch
        Route::group(['prefix' => 'branch'], function () {
            Route::get('/', 'BranchController@getIndex')->middleware('can:list,App\Model\Branch');
            Route::get('create', 'BranchController@getCreate')->middleware('can:create,App\Model\Branch');
            Route::post('create', 'BranchController@postCreate')->middleware('can:create,App\Model\Branch');
            Route::get('update/{item}', 'BranchController@getUpdate')->middleware('can:update,item');
            Route::post('update/{item}', 'BranchController@postUpdate')->middleware('can:update,item');
            Route::get('delete/{item}', 'BranchController@getDelete')->middleware('can:delete,item');
        });

        // company services
        Route::group(['prefix' => 'company-service'], function () {
            Route::get('/', 'CompanyServiceController@getIndex')->middleware('can:list,App\Model\CompanyService');
            Route::get('create', 'CompanyServiceController@getCreate')->middleware('can:create,App\Model\CompanyService');
            Route::post('create', 'CompanyServiceController@postCreate')->middleware('can:create,App\Model\CompanyService');
            Route::get('update/{item}', 'CompanyServiceController@getUpdate')->middleware('can:update,item');
            Route::post('update/{item}', 'CompanyServiceController@postUpdate')->middleware('can:update,item');
            Route::get('delete/{item}', 'CompanyServiceController@getDelete')->middleware('can:delete,item');
        });

        // manager
        Route::group(['prefix' => 'manager'], function () {
            Route::get('/', 'ManagerController@getIndex')->middleware('can:list,App\Model\View\Manager');
            Route::get('create', 'ManagerController@getCreate')->middleware('can:create,App\Model\View\Manager');
            Route::post('create', 'ManagerController@postCreate')->middleware('can:create,App\Model\View\Manager');
            Route::get('update/{item}', 'ManagerController@getUpdate')->middleware('can:update,item');
            Route::post('update/{item}', 'ManagerController@postUpdate')->middleware('can:update,item');
            Route::get('delete/{item}', 'ManagerController@getDelete')->middleware('can:delete,item');
        });

        // doctor
        Route::group(['prefix' => 'doctor'], function () {
            Route::get('/', 'DoctorController@getIndex')->middleware('can:list,App\Model\View\Doctor');
            Route::get('create', 'DoctorController@getCreate')->middleware('can:create,App\Model\View\Doctor');
            Route::post('create', 'DoctorController@postCreate')->middleware('can:create,App\Model\View\Doctor');
            Route::get('update/{item}', 'DoctorController@getUpdate')->middleware('can:update,item');
            Route::post('update/{item}', 'DoctorController@postUpdate')->middleware('can:update,item');
            Route::get('delete/{item}', 'DoctorController@getDelete')->middleware('can:delete,item');
        });
    });

    Route::get('profile', 'ProfileController@getIndex');
    Route::post('profile', 'ProfileController@postIndex');

    Route::get('logout', 'LoginController@getLogout');    
});


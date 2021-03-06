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
    Route::get('/', 'IndexController@getIndex');

    Route::group(['prefix' => 'order', 'namespace' => 'Order'], function () {

        Route::get('/', 'ListOrderController@getIndex')->middleware('can:list,App\Model\Order');

        Route::group(['prefix' => 'create'], function () {
            Route::get('{type}', 'CreateOrderController@getCreate')->middleware('can:create,App\Model\Order');
            Route::post('{type}', 'CreateOrderController@postCreate')->middleware('can:create,App\Model\Order');
        });

        Route::group(['prefix' => 'create-person'], function () {
            Route::get('/', 'CreateFizOrderController@getCreate')->middleware('can:createForFiz,App\Model\Order');
            Route::post('/', 'CreateFizOrderController@postCreate')->middleware('can:createForFiz,App\Model\Order');
        });

        Route::group(['prefix' => 'create-client-company'], function () {
            Route::get('/', 'CreateSimpleCompanyOrderController@getCreate')->middleware('can:createForCompanyClient,App\Model\Order');
            Route::post('/', 'CreateSimpleCompanyOrderController@postCreate')->middleware('can:createForCompanyClient,App\Model\Order');
        });

        Route::group(['prefix' => 'item'], function () {
            Route::get('view/{item}', 'ViewController@getView')->middleware('can:view,item');
            Route::post('get-positions/{item}', 'ViewController@getPositions')->middleware('can:view,item');
            Route::post('update/{item}', 'ViewController@postUpdate')->middleware('can:update,item');
        });

        Route::group(['prefix' => 'service'], function () {
            Route::post('add/{item}', 'ServiceOrderController@postAddService')->middleware('can:service,item');
            Route::get('delete/{item}/{order_service}', 'ServiceOrderController@getDeleteService')->middleware('can:service,item');
        });

        Route::group(['prefix' => 'product'], function () {
            Route::post('add/{item}', 'PositionOrderController@postAddProduct')->middleware('can:position,item');
            Route::post('add-basket/{item}', 'PositionOrderController@basketAddProduct')->middleware('can:position,item');
            Route::get('delete/{item}/{order_product}', 'PositionOrderController@getDeleteProduct')->middleware('can:position,item');
        });

        Route::group(['prefix' => 'status'], function () {
            Route::get('change/{item}/{status}', 'StatusOrderController@getChangeStatus')->middleware('can:status,item,status');
        });

    });

    Route::group(['prefix' => 'common', 'namespace' => 'Common'], function () {
        /// product
        Route::group(['prefix' => 'formula'], function () {
            Route::get('/', 'FormulaController@getIndex')->middleware('can:list,App\Model\Formula');
            Route::get('create/{user}', 'FormulaController@getCreate')->middleware('can:create,App\Model\Formula');
            Route::post('create/{user}', 'FormulaController@postCreate')->middleware('can:create,App\Model\Formula');
            Route::get('update/{user}/{item}', 'FormulaController@getUpdate')->middleware('can:update,item');
            Route::post('update/{user}/{item}', 'FormulaController@postUpdate')->middleware('can:update,item');
            Route::get('delete/{item}', 'FormulaController@getDelete')->middleware('can:delete,item');
        });

        /// external_doctor_salary
        Route::group(['prefix' => 'external-doctor-salary'], function () {
            Route::get('/', 'ExternalDoctorSalaryController@getIndex')->middleware('can:list,App\Model\ExternalDoctorSalary');
            Route::get('create', 'ExternalDoctorSalaryController@getCreate')->middleware('can:create,App\Model\ExternalDoctorSalary');
            Route::post('create', 'ExternalDoctorSalaryController@postCreate')->middleware('can:create,App\Model\ExternalDoctorSalary');
            Route::get('delete/{item}', 'ExternalDoctorSalaryController@getDelete')->middleware('can:delete,item');
        });

    });

    Route::group(['prefix' => 'stock', 'namespace' => 'Stock'], function () {
        /// product
        Route::group(['prefix' => 'product'], function () {
            Route::get('/', 'ProductController@getIndex')->middleware('can:list,App\Model\Product');
            Route::get('create/{cat}', 'ProductController@getCreate')->middleware('can:create,App\Model\Product');
            Route::post('create/{cat}', 'ProductController@postCreate')->middleware('can:create,App\Model\Product');
            Route::get('update/{item}', 'ProductController@getUpdate')->middleware('can:update,item');
            Route::post('update/{item}', 'ProductController@postUpdate')->middleware('can:update,item');
            Route::get('delete/{item}', 'ProductController@getDelete')->middleware('can:delete,item');
        });

        /// income-from-company
        Route::group(['prefix' => 'income-from-company'], function () {
            Route::get('/', 'IncomeFromCompanyController@getIndex')->middleware('can:list,App\Model\View\IncomeFromCompany');
            Route::get('create', 'IncomeFromCompanyController@getCreate')->middleware('can:create,App\Model\View\IncomeFromCompany');
            Route::post('create', 'IncomeFromCompanyController@postCreate')->middleware('can:create,App\Model\View\IncomeFromCompany');
            Route::get('delete/{item}', 'IncomeFromCompanyController@getDelete')->middleware('can:delete,item');
            Route::get('active-product/{item}', 'IncomeFromCompanyController@getActiveProduct')->middleware('can:create,App\Model\View\IncomeFromCompany');
            Route::get('view/{item}', 'IncomeFromCompanyController@getView')->middleware('can:view,item');

            Route::post('change-position/{item}', 'IncomeFromCompanyController@postChange')->middleware('can:create,App\Model\View\IncomeFromCompany');
            Route::post('add-position/{item}', 'IncomeFromCompanyController@postAdd')->middleware('can:create,App\Model\View\IncomeFromCompany');
        });

        /// product
        Route::group(['prefix' => 'position'], function () {
            Route::get('/', 'PositionController@getIndex')->middleware('can:list,App\Model\Position');
            Route::get('update/{item}', 'PositionController@getUpdate')->middleware('can:update,item');
            Route::post('update/{item}', 'PositionController@postUpdate')->middleware('can:update,item');
            Route::get('delete/{item}', 'PositionController@getDelete')->middleware('can:delete,item');
        });

        /// product
        Route::group(['prefix' => 'deletion'], function () {
            Route::get('list', 'DeletionController@getIndex')->middleware('can:list,App\Model\Deletion');
            Route::get('view/{item}', 'DeletionController@getView')->middleware('can:list,App\Model\Deletion');
            Route::get('confirm-item/{item}', 'DeletionController@confirm')->middleware('can:delete,App\Model\Deletion');
            Route::get('return/{item}', 'DeletionController@return')->middleware('can:delete,App\Model\Deletion');
            Route::get('create', 'DeletionController@getCreate')->middleware('can:delete,App\Model\Deletion');
            Route::post('confirm', 'DeletionController@postConfirm')->middleware('can:delete,App\Model\Deletion');
            Route::post('create', 'DeletionController@postCreate')->middleware('can:delete,App\Model\Deletion');
        });

        /// product
        Route::group(['prefix' => 'motion'], function () {
            Route::get('/', 'MotionController@getIndex')->middleware('can:list,App\Model\Motion');
            Route::get('create', 'MotionController@getCreate')->middleware('can:create,App\Model\Motion');
            Route::post('create', 'MotionController@postCreate')->middleware('can:create,App\Model\Motion');
            Route::get('update/{item}', 'MotionController@getUpdate')->middleware('can:update,item');
            Route::post('update/{item}', 'MotionController@postUpdate')->middleware('can:update,item');
            Route::get('unset-product/{item}/{motion_product}', 'MotionController@getUnsetProduct')->middleware('can:update,item');
            Route::get('confirm/{item}', 'MotionController@getConfirm')->middleware('can:update,item');
            Route::get('finish/{item}', 'MotionController@getFinish')->middleware('can:finish,item');
            Route::get('canceleld/{item}', 'MotionController@getCanceled')->middleware('can:cancel,item');
            Route::get('view/{item}', 'MotionController@getView')->middleware('can:view,item');
        });

        /// income-returned
        Route::group(['prefix' => 'income-returned'], function () {
            Route::get('/', 'IncomeReturnedController@getIndex')->middleware('can:list,App\Model\View\IncomeReturned');
            Route::get('view/{item}', 'IncomeReturnedController@getView')->middleware('can:view,item');
        });

        /// outcome
        Route::group(['prefix' => 'outcome'], function () {
            Route::get('/', 'OutcomeController@getIndex')->middleware('can:list,App\Model\Outcome');
            Route::get('view/{item}', 'OutcomeController@getView')->middleware('can:view,item');
        });

        /// outcome
        Route::group(['prefix' => 'product-count'], function () {
            Route::get('/', 'BranchProductController@getIndex')->middleware('can:list,App\Model\View\BranchProduct');
        });
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

        // manager
        Route::group(['prefix' => 'stock-manager'], function () {
            Route::get('/', 'StockManagerController@getIndex')->middleware('can:list,App\Model\View\StockManager');
            Route::get('create', 'StockManagerController@getCreate')->middleware('can:create,App\Model\View\StockManager');
            Route::post('create', 'StockManagerController@postCreate')->middleware('can:create,App\Model\View\StockManager');
            Route::get('update/{item}', 'StockManagerController@getUpdate')->middleware('can:update,item');
            Route::post('update/{item}', 'StockManagerController@postUpdate')->middleware('can:update,item');
            Route::get('delete/{item}', 'StockManagerController@getDelete')->middleware('can:delete,item');
        });

        // manager
        Route::group(['prefix' => 'accounter'], function () {
            Route::get('/', 'AccounterController@getIndex')->middleware('can:list,App\Model\View\Accounter');
            Route::get('create', 'AccounterController@getCreate')->middleware('can:create,App\Model\View\Accounter');
            Route::post('create', 'AccounterController@postCreate')->middleware('can:create,App\Model\View\Accounter');
            Route::get('update/{item}', 'AccounterController@getUpdate')->middleware('can:update,item');
            Route::post('update/{item}', 'AccounterController@postUpdate')->middleware('can:update,item');
            Route::get('delete/{item}', 'AccounterController@getDelete')->middleware('can:delete,item');
        });


        // individ
        Route::group(['prefix' => 'individ'], function () {
            Route::get('/', 'IndividController@getIndex')->middleware('can:list,App\Model\View\Individ');
            Route::get('create', 'IndividController@getCreate')->middleware('can:create,App\Model\View\Individ');
            Route::post('create', 'IndividController@postCreate')->middleware('can:create,App\Model\View\Individ');
            Route::get('update/{item}', 'IndividController@getUpdate')->middleware('can:update,item');
            Route::post('update/{item}', 'IndividController@postUpdate')->middleware('can:update,item');
            Route::get('delete/{item}', 'IndividController@getDelete')->middleware('can:delete,item');
        });

        // individ
        Route::group(['prefix' => 'external-doctor'], function () {
            Route::get('/', 'ExternalDoctorController@getIndex')->middleware('can:list,App\Model\View\ExternalDoctor');
            Route::get('create', 'ExternalDoctorController@getCreate')->middleware('can:create,App\Model\View\ExternalDoctor');
            Route::post('create', 'ExternalDoctorController@postCreate')->middleware('can:create,App\Model\View\ExternalDoctor');
            Route::get('update/{item}', 'ExternalDoctorController@getUpdate')->middleware('can:update,item');
            Route::post('update/{item}', 'ExternalDoctorController@postUpdate')->middleware('can:update,item');
            Route::get('delete/{item}', 'ExternalDoctorController@getDelete')->middleware('can:delete,item');
        });

        // simple_director
        Route::group(['prefix' => 'simple-director'], function () {
            Route::get('/{company}', 'SimpleDirectorController@getIndex')->middleware('can:list,App\Model\View\SimpleDirector');
            Route::get('create/{company}', 'SimpleDirectorController@getCreate')->middleware('can:create,App\Model\View\SimpleDirector');
            Route::post('create/{company}', 'SimpleDirectorController@postCreate')->middleware('can:create,App\Model\View\SimpleDirector');

            Route::get('update/{item}', 'SimpleDirectorController@getUpdate')->middleware('can:updatefull,item');
            Route::post('update/{item}', 'SimpleDirectorController@postUpdate')->middleware('can:updatefull,item');
            Route::get('delete/{item}', 'SimpleDirectorController@getDelete')->middleware('can:updatefull,item');
        });
    });

    Route::group(['prefix' => 'finance', 'namespace' => 'Finance'], function () {
        /// service
        Route::group(['prefix' => 'service'], function () {
            Route::get('/', 'FinanseServiceController@getIndex')->middleware('can:list,App\Model\FinanceService');
        });

         /// position
         Route::group(['prefix' => 'position'], function () {
            Route::get('/', 'FinancePositionController@getIndex')->middleware('can:list,App\Model\FinancePosition');
        });

    });

    Route::group(['prefix' => 'system', 'namespace' => 'System'], function () {
        /// service
        Route::group(['prefix' => 'auth-log'], function () {
            Route::get('/', 'AuthLogController@getIndex')->middleware('can:list,App\Model\FinanceService');
        });

    });

    Route::group(['prefix' => 'report', 'namespace' => 'Report'], function () {

        Route::group(['prefix' => 'sale'], function () {
            Route::get('/', 'SaleReportController@getIndex')->middleware('can:list,App\Model\Order');
            Route::get('excel', 'SaleReportController@getExcel')->middleware('can:list,App\Model\Order');
        });

        Route::group(['prefix' => 'profit'], function () {
            Route::get('/', 'ProfitReportController@getIndex')->middleware('can:list,App\Model\Order');
            Route::get('excel', 'ProfitReportController@getExcel')->middleware('can:list,App\Model\Order');
        });

        Route::group(['prefix' => 'income_returned'], function () {
            Route::get('/', 'IncomeReturnedReportController@getIndex')->middleware('can:list,App\Model\View\IncomeReturned');
            Route::get('excel', 'IncomeReturnedReportController@getExcel')->middleware('can:list,App\Model\View\IncomeReturned');
        });

        Route::group(['prefix' => 'cash'], function () {
            Route::get('/', 'CashReportController@getIndex')->middleware('can:list,App\Model\Order');
            Route::get('excel', 'CashReportController@getExcel')->middleware('can:list,App\Model\Order');
        });

        Route::group(['prefix' => 'product_count'], function () {
            Route::get('/', 'ProductCountReportController@getIndex')->middleware('can:list,App\Model\Order');
            Route::get('excel', 'ProductCountReportController@getExcel')->middleware('can:list,App\Model\Order');
        });

        Route::group(['prefix' => 'motion'], function () {
            Route::get('/', 'MotionReportController@getIndex')->middleware('can:list,App\Model\Order');
            Route::get('excel', 'MotionReportController@getExcel')->middleware('can:list,App\Model\Order');
        });

        Route::group(['prefix' => 'staff'], function () {
            Route::get('/', 'StaffReportController@getIndex')->middleware('can:list,App\Model\Order');
            Route::get('excel', 'StaffReportController@getExcel')->middleware('can:list,App\Model\Order');
        });

        Route::group(['prefix' => 'client'], function () {
            Route::get('/', 'ClientReportController@getIndex')->middleware('can:list,App\Model\Order');
            Route::get('excel', 'ClientReportController@getExcel')->middleware('can:list,App\Model\Order');
        });

        Route::group(['prefix' => 'income_from_company'], function () {
            Route::get('/', 'IncomeFromCompanyReportController@getIndex')->middleware('can:list,App\Model\View\IncomeFromCompany');
            Route::get('excel', 'IncomeFromCompanyReportController@getExcel')->middleware('can:list,App\Model\View\IncomeFromCompany');
        });

    });


    Route::get('profile', 'ProfileController@getIndex');
    Route::post('profile', 'ProfileController@postIndex');

    Route::get('logout', 'LoginController@getLogout');
});


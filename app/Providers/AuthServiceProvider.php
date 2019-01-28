<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model\Branch'                      => 'App\Policies\Lib\LibCommonPolicy',
        'App\Model\View\Director'               => 'App\Policies\Lib\LibCommonPolicy',
        'App\Model\LibProductCat'               => 'App\Policies\Lib\LibCommonPolicy',
        'App\Model\LibProductType'              => 'App\Policies\Lib\LibCommonPolicy',
        'App\Model\LibProductOption'            => 'App\Policies\Lib\LibCommonPolicy',
        'App\Model\LibCompanyCat'               => 'App\Policies\Lib\LibCommonPolicy',

        'App\Model\Company'                     => 'App\Policies\Lib\CompanyPolicy',

        'App\Model\CompanyService'              => 'App\Policies\Lib\DirectorPolicy',
        'App\Model\View\Manager'                => 'App\Policies\Lib\DirectorPolicy',
        'App\Model\View\Doctor'                 => 'App\Policies\Lib\DirectorPolicy',
        'App\Model\View\StockManager'           => 'App\Policies\Lib\DirectorPolicy',
        'App\Model\View\ExternalDoctor'         => 'App\Policies\Lib\DirectorPolicy',
        'App\Model\Product'                     => 'App\Policies\Lib\DirectorPolicy',
        'App\Model\View\IncomeFromCompany'      => 'App\Policies\Stock\StockCommonPolicy',
        'App\Model\Position'                    => 'App\Policies\Stock\PositionPolicy',
        'App\Model\Motion'                      => 'App\Policies\Stock\MotionPolicy',

        'App\Model\View\Individ'                => 'App\Policies\Lib\IndividPolicy',

        'App\Model\Formula'                     => 'App\Policies\Common\FormulaPolicy',
        'App\Model\ExternalDoctorSalary'        => 'App\Policies\Common\ExternalDoctorSalaryPolicy',

        'App\Model\SysAuthLog'                  => 'App\Policies\System\SystemCommonPolicy',

        'App\Model\Order'           => 'App\Policies\Order\OrderPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}

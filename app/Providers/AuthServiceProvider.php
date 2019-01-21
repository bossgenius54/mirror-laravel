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
        'App\Model\LibCompanyCat'       => 'App\Policies\MainPolicy',
        'App\Model\LibProductCat'       => 'App\Policies\MainPolicy',
        'App\Model\LibProductType'      => 'App\Policies\MainPolicy',
        'App\Model\LibProductOption'    => 'App\Policies\MainPolicy',
        'App\Model\Company'             => 'App\Policies\CompanyPolicy',
        'App\Model\CompanyData'         => 'App\Policies\CompanyPolicy',
        'App\Model\View\Director'       => 'App\Policies\MainPolicy',


        'App\Model\Branch'              => 'App\Policies\MainPolicy',
        'App\Model\Client'              => 'App\Policies\MainPolicy',
        'App\Model\CompanyService'      => 'App\Policies\MainPolicy',
        'App\Model\Finance'             => 'App\Policies\MainPolicy',
        'App\Model\FinancePosition'     => 'App\Policies\MainPolicy',
        'App\Model\FinanceService'      => 'App\Policies\MainPolicy',
        'App\Model\Income'              => 'App\Policies\MainPolicy',
        'App\Model\IncomingPosition'    => 'App\Policies\MainPolicy',
        'App\Model\Order'               => 'App\Policies\MainPolicy',
        'App\Model\OrderPosition'       => 'App\Policies\MainPolicy',
        'App\Model\OrderService'        => 'App\Policies\MainPolicy',
        'App\Model\Outcome'             => 'App\Policies\MainPolicy',
        'App\Model\OutcomingPosition'   => 'App\Policies\MainPolicy',
        'App\Model\Position'            => 'App\Policies\MainPolicy',
        'App\Model\Product'             => 'App\Policies\MainPolicy',
        'App\Model\User'                => 'App\Policies\MainPolicy'
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

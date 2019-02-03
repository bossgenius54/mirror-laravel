<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Model\Company;
use App\Observers\CompanyObserver;

use App\Model\View\Individ;
use App\Observers\IndividObserver;

use App\Model\Order;
use App\Observers\OrderObserver;

use App\Model\View\IncomeFromCompany;
use App\Observers\IncomeFromCompanyObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
        Company::observe(CompanyObserver::class);
        Individ::observe(IndividObserver::class);
        Order::observe(OrderObserver::class);
        //IncomeFromCompany::observe(IncomeFromCompanyObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

<?php  
namespace App\Observers;

use App\Model\View\IncomeFromCompany;
use App\Services\Finance\CreateFinanceModel;
use Auth;

class IncomeFromCompanyObserver{
   
    public function created(IncomeFromCompany $item){
        $user = Auth::user();
        CreateFinanceModel::createFromCompany($item, $user);
        
    }
}

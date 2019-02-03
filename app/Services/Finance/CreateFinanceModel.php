<?php  
namespace App\Services\Finance;

use Auth;
use App\Model\Finance;
use App\Model\SysFinanceType;

use App\Model\View\IncomeFromCompany;
use App\Services\Finance\CalcBeginIncome;

use App\Model\Outcome;
use App\Services\Finance\CalcSell;


class CreateFinanceModel {
    static function createBeginIncome(IncomeFromCompany $item){
        $user = Auth::user();

        $finance = Finance::create([
            'company_id' => $item->company_id, 
            'branch_id' => $item->branch_id, 
            'user_id' => $user->id, 
            'type_id' => SysFinanceType::FROM_COMPANY, 
            'income_id' => $item->id,
            'sum' => $item->related_cost, 
            'note' => 'Создано автоматом', 
            'is_active' => 0, 
            'is_retail' => 0
        ]);

        CalcBeginIncome::create($finance);
    }

    static function createSell(Outcome $item){
        $user = Auth::user();

        $type = SysFinanceType::TO_COMPANY;
        if ($item->to_user_id)
            $type = SysFinanceType::TO_PERSON;

        $finance = Finance::create([
            'company_id' => $item->company_id, 
            'branch_id' => $item->branch_id, 
            'user_id' => $user->id, 
            'type_id' => $type, 
            'outcome_id' => $item->id,
            'sum' => $item->related_cost, 
            'note' => 'Создано автоматом', 
            'is_active' => 0, 
            'is_retail' => $item->is_retail
        ]);

        CalcSell::create($finance);
    }
   
}

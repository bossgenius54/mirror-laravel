<?php  
namespace App\Services\Order;

use App\Model\Order;
use App\Model\SysOrderType;
use App\Model\Income;
use App\Model\SysIncomeType;

use App\Model\OutcomeService;
use App\Model\IncomeService;

use App\Model\Position;
use App\Model\OutcomePosition;
use App\Model\SysPositionStatus;
use App\Model\IncomePosition;


use App\Model\Outcome;
use App\Services\Finance\CreateFinanceModel;

class ReturnedOrder {
    private $item = false;
    private $income = false;

    function __construct(Order $item){
        $this->item = $item;
    }

    static function start(Order $item){
        $el = new ReturnedOrder($item);
        return $el->calc();
    }

    public function calc(){
        $this->createIncome();
        $this->createIncomeServices();
        $this->createIncomePosition();

        $outcome = Outcome::findOrFail($this->item->outcome_id); 
        CreateFinanceModel::createReturn($this->income, $outcome);
    }

    private function createIncome(){
        $el = new Income();

        if ($this->item->type_id == SysOrderType::PERSON){
            $el->type_id = SysIncomeType::RETURN_PERSON;
            $el->from_user_id = $this->item->from_user_id;
        }
        else  if ($this->item->type_id == SysOrderType::COMPANY){
            $el->type_id = SysIncomeType::RETURN_COMPANY;
            $el->from_company_id = $this->item->from_company_id;
        }

        $el->company_id = $this->item->company_id;
        $el->branch_id = $this->item->branch_id;
        $el->name = $this->item->name;
        $el->note = $this->item->note;
        $el->related_cost = $this->item->total_sum;
        $el->save();

        $this->income = $el;
    }

    private function createIncomeServices(){
        $services = OutcomeService::where('outcome_id', $this->item->outcome_id)->get();
        $ar = [];
        foreach ($services as $s) {
            $ar [] = [
                'income_id' => $this->income->id, 
                'service_id' => $s->service_id, 
                'service_count' => $s->service_count, 
                'service_cost' => $s->service_cost, 
                'total_sum' => $s->total_sum
            ];
        }
        
        if (count($ar) > 0)
            IncomeService::insert($ar);
    }

    private function createIncomePosition(){
        $positions = OutcomePosition::where('outcome_id', $this->item->outcome_id)->get();

        $ar_income_position = [];
        $ar = [];
        $ar_el = []; 
        $ar_el['branch_id'] = $this->income->branch_id;
        $ar_el['status_id'] = SysPositionStatus::ACTIVE;
        $ar_el['income_id'] = $this->income->id;
        foreach ($positions as $s) {

            $ar_el['product_id'] = $s->product_id;
            $ar_el['price_cost'] = $s->price_cost;
            $ar_el['expired_at'] = $s->expired_at;
            $ar_el['sys_num'] = $s->position_sys_num;
            $ar_el['created_at'] = date('Y-m-d h:i:s');
            $ar_el['updated_at'] = date('Y-m-d h:i:s');
            $ar [] = $ar_el;

            $ar_income_position[] = [
                'income_id' => $this->income->id,
                'position_sys_num' => $ar_el['sys_num']
            ];
        }
        
        if (count($ar) > 0)
            Position::insert($ar);
        
        if (count($ar_income_position) > 0)
            IncomePosition::insert($ar_income_position); 
    }

}

<?php  
namespace App\Services\Finance;

use App\Model\Finance;
use App\Model\FinancePosition;
use App\Model\FinanceService;
use App\Model\OutcomePosition;
use App\Model\OutcomeService;

class CalcReturn {
    private $item = false;
    private $outcome = false;

    function __construct(Finance $item) {
        $this->item = $item;
        $this->start();
    }

    static function create(Finance $item){
       $el = new CalcReturn($item);
    }

    private function start(){
        $this->calcIncome();
        $this->createPosition();
        $this->createServices();
    }
    
    private function calcIncome(){
        $this->outcome = $this->item->relOutcome;
    }

    private function createPosition(){
        $items = OutcomePosition::where('outcome_id', $this->outcome->id)->get();

        $ar = [];

        $ar_el = [];
        $ar_el['finance_id'] = $this->item->id;
        $ar_el['branch_id'] = $this->item->branch_id;
        foreach ($items as $i ) {
            $ar_el['product_id'] = $i->product_id;
            $ar_el['position_id'] = $i->position_id;
            $ar_el['position_sys_num'] = $i->position_sys_num;
            $ar_el['price_before'] =  $i->price_sell;
            $ar_el['price_after'] = 0;
            $ar_el['price_total'] = $ar_el['price_after'] - $ar_el['price_before'];

            $ar[]= $ar_el;
        }

        if (count($ar) > 0)
            FinancePosition::insert($ar);
    }

    private function createServices(){
        $items = OutcomeService::where('outcome_id', $this->outcome->id)->get();

        $ar = [];

        $ar_el = [];
        $ar_el['finance_id'] = $this->item->id;
        $ar_el['branch_id'] = $this->item->branch_id;
        foreach ($items as $i ) {
            $ar_el['service_id'] = $i->service_id;
            $ar_el['service_count'] = $i->service_count;
            $ar_el['service_cost'] = $i->service_cost;
            $ar_el['total_sum'] =  0 - $i->total_sum;

            $ar[] = $ar_el;
        }

        if (count($ar) > 0)
            FinanceService::insert($ar);
    }
}

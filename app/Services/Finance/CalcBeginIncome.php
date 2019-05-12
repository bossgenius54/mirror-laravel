<?php  
namespace App\Services\Finance;

use App\Model\Finance;
use App\Model\FinancePosition;
use App\Model\Position;

class CalcBeginIncome {
    private $item = false;
    private $income = false;

    function __construct(Finance $item) {
        $this->item = $item;
        $this->start();
    }

    static function create(Finance $item){
       $el = new CalcBeginIncome($item);
    }

    private function start(){
        $this->calcIncome();
        $this->createPosition();
    }
    
    private function calcIncome(){
        $this->income = $this->item->relIncome;
    }

    private function createPosition(){
        $items = Position::where('income_id', $this->income->id)->get();

        $ar = [];

        $ar_el = [];
        $ar_el['finance_id'] = $this->item->id;
        $ar_el['branch_id'] = $this->item->branch_id;
        $ar_el['created_at'] = date('Y-m-d h:i:s');
        $ar_el['updated_at'] = date('Y-m-d h:i:s');
        
        foreach ($items as $i ) {
            $ar_el['product_id'] = $i->product_id;
            $ar_el['position_id'] = $i->id;
            $ar_el['position_sys_num'] = $i->sys_num;
            $ar_el['price_before'] = $i->price_cost;
            $ar_el['price_after'] = 0;
            $ar_el['price_total'] = $ar_el['price_after'] - $ar_el['price_before'];

            $ar[]= $ar_el;
        }

        $ar = collect($ar);
        $ar = $ar->chunk(500);
        
        foreach ($ar as $a){
            FinancePosition::insert($a->toArray()); 
        }
    }
}

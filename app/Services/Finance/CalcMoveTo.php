<?php  
namespace App\Services\Finance;

use App\Model\Finance;
use App\Model\FinancePosition;
use App\Model\FinanceService;
use App\Model\Position;

class CalcMoveTo {
    private $item = false;
    private $move = false;

    function __construct(Finance $item) {
        $this->item = $item;
        $this->start();
    }

    static function create(Finance $item){
       $el = new CalcMoveTo($item);
    }

    private function start(){
        $this->calcMove();
        $this->createPosition();
    }
    
    private function calcMove(){
        $this->move = $this->item->relMove;
    }

    private function createPosition(){
        $items = Position::where('motion_id', $this->move->id)->get();

        $ar = [];
        
        $ar_el = [];
        $ar_el['finance_id'] = $this->item->id;
        $ar_el['branch_id'] = $this->item->branch_id;
        foreach ($items as $i ) {
            $ar_el['product_id'] = $i->product_id;
            $ar_el['position_id'] = $i->id;
            $ar_el['position_sys_num'] = $i->sys_num;
            $ar_el['price_before'] = $i->price_cost;
            $ar_el['price_after'] = 0;
            $ar_el['price_total'] = $ar_el['price_after'] - $ar_el['price_before'];

            $ar[]= $ar_el;
        }

        if (count($ar) > 0)
            FinancePosition::insert($ar);
    }

}

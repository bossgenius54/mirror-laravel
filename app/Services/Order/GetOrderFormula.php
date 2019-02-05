<?php  
namespace App\Services\Order;

use App\Model\Order;
use App\Model\SysOrderType;

use App\Model\Formula;


use App\Model\Outcome;
use App\Services\Finance\CreateFinanceModel;

class GetOrderFormula {
    private $item = false;
    private $formula = false;

    function __construct(Order $item){
        $this->item = $item;
    }

    static function start(Order $item){
        $el = new GetOrderFormula($item);
        return $el->calc();
    }

    public function calc(){
        if ($this->item->type_id == SysOrderType::COMPANY)
            return false;
        if (!$this->item->from_user_id)
            return false;

        $this->formula = Formula::where('user_id', $this->item->from_user_id)->orderBy('id', 'desc')->first();
        
        return $this->formula;
    }


}

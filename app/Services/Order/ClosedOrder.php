<?php  
namespace App\Services\Order;

use App\Model\Order;
use App\Model\SysOrderType;
use App\Model\Outcome;
use App\Model\SysOutcomeType;

use App\Model\OutcomeService;
use App\Model\OrderService;

use App\Model\Position;
use App\Model\OrderPosition;
use App\Model\OutcomePosition;

use App\Services\Finance\CreateFinanceModel;

class ClosedOrder {
    private $item = false;
    private $outcome = false;

    function __construct(Order $item){
        $this->item = $item;
    }

    static function start(Order $item){
        $el = new ClosedOrder($item);
        return $el->calc();
    }

    public function calc(){
        
        $this->createOutcome();
        $this->createOutcomeServices();
        $this->createOutcomePositions();

        CreateFinanceModel::createSell($this->outcome);
    }

    private function createOutcome(){
        $el = new Outcome();

        if ($this->item->type_id == SysOrderType::PERSON){
            $el->type_id = SysOutcomeType::TO_PERSON;
            $el->to_user_id = $this->item->from_user_id;
        }
        else  if ($this->item->type_id == SysOrderType::COMPANY){
            $el->type_id = SysOutcomeType::TO_COMPANY;
            $el->to_company_id = $this->item->from_company_id;
        }

        $el->company_id = $this->item->company_id;
        $el->branch_id = $this->item->branch_id;
        $el->name = $this->item->name;
        $el->note = $this->item->note;
        $el->related_cost = $this->item->total_sum;
        $el->is_retail = $this->item->is_retail;
        $el->save();

        $this->outcome = $el;
        
        Order::where('id', $this->item->id)->update([
            'outcome_id' => $el->id
        ]);


    }

    private function createOutcomeServices(){
        $order_services = OrderService::where('order_id', $this->item->id)->get();
        $ar = [];
        foreach ($order_services as $i) {
            $ar [] = [
                'outcome_id' => $this->outcome->id, 
                'service_id' => $i->service_id, 
                'service_count' => $i->service_count, 
                'service_cost' => $i->service_cost, 
                'total_sum' => $i->total_sum
            ];
        }
        if (count($ar) > 0)
            OutcomeService::insert($ar);
    }

    private function createOutcomePositions(){
        $positions = Position::where('order_id', $this->item->id)->get();

        $ar_product_price = OrderPosition::where('order_id', $this->item->id)->pluck('pos_cost', 'product_id')->toArray();

        $ar = [];
        foreach ($positions as $i) {
            $ar [] = [
                'outcome_id' => $this->outcome->id, 
                'product_id' => $i->product_id, 
                'position_id' => $i->id, 
                'branch_id' => $i->branch_id,  
                'position_sys_num' => $i->sys_num, 
                'price_cost' => $i->price_cost, 
                'price_sell' => (isset($ar_product_price[$i->product_id]) ? $ar_product_price[$i->product_id] : 0), 
                'expired_at' => $i->expired_at,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ];
        }
        
        if (count($ar) > 0)
            OutcomePosition::insert($ar);

        Position::where('order_id', $this->item->id)->delete();
    }
}

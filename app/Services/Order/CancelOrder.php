<?php  
namespace App\Services\Order;

use App\Model\Order;

use App\Model\SysPositionStatus;
use App\Model\Position;

class CancelOrder {
    private $item = false;

    function __construct(Order $item){
        $this->item = $item;
    }

    static function start(Order $item){
        $el = new CancelOrder($item);
        return $el->calc();
    }

    public function calc(){
        Position::where(['status_id' => SysPositionStatus::RESERVE, 'order_id'=> $this->item->id])
                ->update(['status_id' => SysPositionStatus::ACTIVE, 'order_id' =>null]);
    }

}

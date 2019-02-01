<?php  
namespace App\Observers;

use App\Model\Order;
use App\Model\SysOrderStatus;

use App\Services\Order\CancelOrder;
use App\Services\Order\ClosedOrder;

class OrderObserver{
   
    public function updated(Order $item){
        if ($item->status_id == SysOrderStatus::CANCELED)
            CancelOrder::start($item);
        
        if ($item->status_id == SysOrderStatus::CLOSED)
            ClosedOrder::start($item);

        
    }
}

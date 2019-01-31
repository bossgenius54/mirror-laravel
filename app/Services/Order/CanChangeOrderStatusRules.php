<?php  
namespace App\Services\Order;

use App\User;
use App\Model\Order;
use App\Model\SysOrderStatus;
use App\Model\SysOrderType;
use App\Model\SysUserType;


class CanChangeOrderStatusRules {
    private $item = false;
    private $user = false;

    function __construct(User $user, Order $item){
        $this->user = $user;
        $this->item = $item;
    }

    static function getArStatus(User $user, Order $item){
        $el = new CanChangeOrderStatusRules($user, $item);
        return $el->calc();
    }

    function calc(){
        if (!in_array($this->user->type_id, [SysUserType::MANAGER, SysUserType::DIRECTOR, SysUserType::FIZ]))
            return [];

        if ($this->user->type_id == SysUserType::FIZ)
            return $this->calcForFiz();

        
        return $this->calcForCompanySaler();
    }

    private function calcForFiz(){
        $ar = [];
        if (!$this->item->is_onlain)
            return [];

        if ($this->item->from_user_id != $this->user->id )
            return [];

        if ($this->item->status_id == SysOrderStatus::CREATED)
            $ar[] = SysOrderStatus::NEED_APPROVE;
        
        if ($this->item->status_id == SysOrderStatus::SENDED)
            $ar[] = SysOrderStatus::CLOSED;

        return $ar;
    }

    private function calcForCompanySaler(){
        $ar = [];

        if ($this->user->company_id != $this->item->company_id)
            return [];
        
        if (in_array($this->item->status_id, SysOrderStatus::getCanManagerUpdate())){
            if ($this->item->is_onlain){
                $ar = [
                    SysOrderStatus::CREATED, SysOrderStatus::NEED_APPROVE, SysOrderStatus::APPROVED, SysOrderStatus::WAIT_PAY, 
                    SysOrderStatus::MAKING, SysOrderStatus::READY_TO_SEND, SysOrderStatus::SENDED,  SysOrderStatus::CANCELED
                ];
            }
            else {
                $ar = [
                    SysOrderStatus::CREATED,
                    SysOrderStatus::MAKING,
                    SysOrderStatus::READY_TO_SEND,
                    SysOrderStatus::CLOSED,
                    SysOrderStatus::CANCELED
                ];
            }
        }
        else if ($this->item->status_id == SysOrderStatus::CLOSED)
            $ar = [
                SysOrderStatus::RETURNED
            ];


        
        if (in_array($this->item->status_id, $ar))
            unset($ar[array_search($this->item->status_id, $ar)]);

        return $ar;
    }
}

<?php

namespace App\Policies\Stock;

use App\User;
use App\Model\SysUserType;
use App\Model\SysMotionStatus;
use Illuminate\Auth\Access\HandlesAuthorization;


class MotionPolicy {
    use HandlesAuthorization;

    public function __construct(){
        
    }


    public function list($user){
        if (!in_array($user->type_id, [SysUserType::DIRECTOR, SysUserType::STOCK_MANAGER, SysUserType::ACCOUNTER, SysUserType::MANAGER]))
            return false;
        
        return true; 
    }

    public function create($user){
        if (!in_array($user->type_id, [SysUserType::DIRECTOR, SysUserType::STOCK_MANAGER, SysUserType::ACCOUNTER, SysUserType::MANAGER]))
            return false;
        
        return true; 
    }

    public function view($user, $item){
        if (!in_array($user->type_id, [SysUserType::DIRECTOR, SysUserType::STOCK_MANAGER, SysUserType::ACCOUNTER, SysUserType::MANAGER]))
            return false;

        return true;
    }

    
    public function update($user, $item){
        if ($item->status_id != SysMotionStatus::IN_WORK)
            return false;

        if (!in_array($user->type_id, [SysUserType::DIRECTOR, SysUserType::STOCK_MANAGER, SysUserType::MANAGER]))
            return false;

        return true;
    }
    
    public function finish($user, $item){
        if ($item->status_id != SysMotionStatus::IN_WORK)
            return false;

        if (!in_array($user->type_id, [SysUserType::DIRECTOR, SysUserType::STOCK_MANAGER, SysUserType::MANAGER]))
            return false;

        return true;
    }

    public function cancel($user, $item){
        if ($item->status_id != SysMotionStatus::IN_WORK)
            return false;

        if (!in_array($user->type_id, [SysUserType::DIRECTOR, SysUserType::STOCK_MANAGER]))
            return false;

        return true;
    }

}

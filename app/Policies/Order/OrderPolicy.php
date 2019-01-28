<?php

namespace App\Policies\Order;

use App\User;
use App\Model\SysUserType;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Model\SysOrderStatus;


class OrderPolicy {
    use HandlesAuthorization;

    public function __construct(){
        
    }

    public function list($user){
        if (!in_array($user->type_id, [SysUserType::DIRECTOR, SysUserType::MANAGER, SysUserType::ADMIN,  SysUserType::ACCOUNTER]))
            return false;
        
        return true; 
    }

    public function create($user){
        if (!in_array($user->type_id, [SysUserType::MANAGER]))
            return false;
        
        return true; 
    }

    public function view($user, $item){
        if (in_array($user->type_id, [SysUserType::ADMIN]))
            return true;
            
        if (!in_array($user->type_id, [SysUserType::DIRECTOR, SysUserType::MANAGER, SysUserType::ADMIN,  SysUserType::ACCOUNTER]))
            return false;
        
        if ($user->company_id != $item->company_id)
            return false;

        return true;
    }

    public function update($user, $item){
        if (in_array($user->type_id, [SysUserType::ADMIN]))
            return true;
            
        if (!in_array($user->type_id, [SysUserType::DIRECTOR, SysUserType::MANAGER, SysUserType::ADMIN,  SysUserType::ACCOUNTER]))
            return false;
        
        if ($user->company_id != $item->company_id)
            return false;
        
        if (in_array($item->status_id, [SysOrderStatus::CREATED, SysOrderStatus::FORMATION, SysOrderStatus::DONE_FORMATION, SysOrderStatus::WAIT_PAY]))

        return true;
    }
}

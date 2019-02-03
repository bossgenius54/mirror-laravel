<?php

namespace App\Policies\Stock;

use App\User;
use App\Model\SysUserType;
use Illuminate\Auth\Access\HandlesAuthorization;

use App\Model\SysPositionStatus;

class PositionPolicy {
    use HandlesAuthorization;

    public function __construct(){
        
    }
    
    public function list($user){
        if (!in_array($user->type_id, [SysUserType::DIRECTOR, SysUserType::MANAGER, SysUserType::STOCK_MANAGER, SysUserType::ACCOUNTER]))
            return false;
        
        return true; 
    }

    
    public function update($user, $item){
        if (!in_array($user->type_id, [SysUserType::DIRECTOR]))
            return false;

        if ($item->status_id == SysPositionStatus::DELETED)
            return false;

        return true;
    }

     
    public function delete($user, $item){
        if (!in_array($user->type_id, [SysUserType::DIRECTOR,  SysUserType::STOCK_MANAGER]))
            return false;
        
        if ($item->status_id == SysPositionStatus::DELETED)
            return false;

        return true;
    }

}

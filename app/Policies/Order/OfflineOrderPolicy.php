<?php

namespace App\Policies\Order;

use App\User;
use App\Model\SysUserType;
use Illuminate\Auth\Access\HandlesAuthorization;


class OfflineOrderPolicy {
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
}

<?php

namespace App\Policies\Stock;

use App\User;
use App\Model\SysUserType;
use Illuminate\Auth\Access\HandlesAuthorization;

class BranchProductPolicy {
    use HandlesAuthorization;

    public function __construct(){
        
    }

    private function mainCheck($user){
        if (!in_array($user->type_id, [SysUserType::DIRECTOR, SysUserType::STOCK_MANAGER, SysUserType::ACCOUNTER, SysUserType::MANAGER]))
            return false;
            
        return true;
    }

    public function list($user){
        if (!$this->mainCheck($user))
            return false;
        
        return true; 
    }
}

<?php

namespace App\Policies\Finance;

use App\User;
use App\Model\SysUserType;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommonFinancePolice {
    use HandlesAuthorization;

    public function __construct(){

    }

    private function mainCheck($user){
        if (!in_array($user->type_id, [SysUserType::DIRECTOR, SysUserType::MANAGER, SysUserType::STOCK_MANAGER, SysUserType::ACCOUNTER]))
            return false;

        return true;
    }

    public function list($user){
        if (!$this->mainCheck($user))
            return false;

        return true;
    }

    public function view($user, $item){
        if (!$this->mainCheck($user))
            return false;

        return true;
    }


    public function filterBranch($user){
        if (!in_array($user->type_id, [SysUserType::DIRECTOR, SysUserType::STOCK_MANAGER, SysUserType::ACCOUNTER]))
            return false;

        return true;
    }

}

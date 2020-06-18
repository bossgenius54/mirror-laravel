<?php

namespace App\Policies\Stock;

use App\User;
use App\Model\SysUserType;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeletionPolicy {
    use HandlesAuthorization;

    public function __construct(){

    }

    private function mainCheck($user){
        if (!in_array($user->type_id, [SysUserType::DIRECTOR, SysUserType::MANAGER]))
            return false;

        return true;
    }

    public function list($user){
        if (!$this->mainCheck($user))
            return false;

        return true;
    }

    public function delete($user){
        if (!$this->mainCheck($user))
            return false;

        if (!in_array($user->type_id, [SysUserType::DIRECTOR]))
            return false;

        return true;
    }

    public function return($user){
        if (!$this->mainCheck($user))
            return false;

        if (!in_array($user->type_id, [SysUserType::DIRECTOR]))
            return false;

        return true;
    }
}

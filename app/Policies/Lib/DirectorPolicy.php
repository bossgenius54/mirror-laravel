<?php

namespace App\Policies\Lib;

use App\User;
use App\Model\SysUserType;
use Illuminate\Auth\Access\HandlesAuthorization;

use App\Model\SysCompanyType;

class DirectorPolicy {
    use HandlesAuthorization;

    public function __construct(){
        
    }

    private function mainCheck($user){
        if (in_array($user->type_id, [SysUserType::ADMIN]))
            return true;

        if ($user->type_id != SysUserType::DIRECTOR)
            return false;
            
        return true;
    }

    private function checkItem($user, $item){
        if (in_array($user->type_id, [SysUserType::ADMIN]))
            return true;

        if ($user->company_id != $item->company_id)
            return false;

        return true;
    }

    public function list($user){
        if (!$this->mainCheck($user))
            return false;
        
        return true; 
    }

    public function view($user){
        if (!$this->mainCheck($user))
            return false;

        return true; 
    }

    public function create($user){
        if ( !$this->mainCheck($user))
            return false;

        return true;
    } 
    
    public function update($user, $item){
        if ( !$this->mainCheck($user))
            return false;

        if ( !$this->checkItem($user, $item))
            return false;

        return true;
    }

    public function delete($user, $item){
        if ( !$this->mainCheck($user))
            return false;

        if ( !$this->checkItem($user, $item))
            return false;

        return true;
    }

    public function upgradeToHalfPermission($user, $item){
        if ($item->type_id != SysCompanyType::EMPTY)
            return false;

        if ( !$this->mainCheck($user))
            return false;

        if ( !$this->checkItem($user, $item))
            return false;

        return true;
    }
    public function upgradeToFullPermission($user, $item){
        if ($item->type_id != SysCompanyType::HALF)
            return false;

        if ( !$this->mainCheck($user))
            return false;

        return true;
    }

    public function updatefull($user, $item){
        if (!in_array($user->type_id, [SysUserType::ADMIN]))
            return false;

        return true;
    }
}

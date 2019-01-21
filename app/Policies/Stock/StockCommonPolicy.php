<?php

namespace App\Policies\Stock;

use App\User;
use App\Model\SysUserType;
use Illuminate\Auth\Access\HandlesAuthorization;

use App\Model\SysCompanyType;

class StockCommonPolicy {
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

        return true;
    }

    public function delete($user, $item){
        if ( !$this->mainCheck($user))
            return false;

        return true;
    }

    public function upgradeToHalfPermission($user, $item){
        if ($item->type_id != SysCompanyType::EMPTY)
            return false;

        if ( !$this->mainCheck($user))
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
}

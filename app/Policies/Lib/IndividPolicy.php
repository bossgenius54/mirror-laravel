<?php

namespace App\Policies\Lib;

use App\User;
use App\Model\SysUserType;
use Illuminate\Auth\Access\HandlesAuthorization;


class IndividPolicy {
    use HandlesAuthorization;

    public function __construct(){
        
    }

    private function mainCheck($user){
        if (!in_array($user->type_id, [SysUserType::ADMIN, SysUserType::DIRECTOR, SysUserType::MANAGER, SysUserType::DOCTOR, SysUserType::EXTERNAL_DOCTOR]))
            return false;
            
        return true;
    }

    private function itemCheck($user, $item){
        
        if (in_array($user->type_id, [SysUserType::ADMIN]))
            return true;
        if ($item->had_enter != 0)
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

        if ( !$this->itemCheck($user, $item))
            return false;    
      

        return true;
    }

    public function delete($user, $item){
        if ( !$this->mainCheck($user))
            return false;

        if ( !$this->itemCheck($user, $item))
            return false; 

        return true;
    }

}

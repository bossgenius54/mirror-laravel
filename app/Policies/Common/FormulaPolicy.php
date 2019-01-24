<?php

namespace App\Policies\Common;

use App\User;
use App\Model\SysUserType;
use Illuminate\Auth\Access\HandlesAuthorization;

use App\Model\SysCompanyType;

class FormulaPolicy {
    use HandlesAuthorization;

    public function __construct(){
        
    }

    private function mainCheck($user){
        if (!in_array($user->type_id, [SysUserType::ADMIN, SysUserType::DIRECTOR, SysUserType::MANAGER, SysUserType::DOCTOR, SysUserType::FIZ]))
            return false;
            
        return true;
    }

    private function itemCheck($user, $item){
        if (in_array($user->type_id, [SysUserType::ADMIN, SysUserType::DIRECTOR, SysUserType::MANAGER, SysUserType::DOCTOR]))
            return true;
        
        if ($item->created_user_id != $user->id)
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

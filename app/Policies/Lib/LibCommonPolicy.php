<?php

namespace App\Policies\Lib;

use App\User;
use App\Model\SysUserType;
use Illuminate\Auth\Access\HandlesAuthorization;

use App\Model\SysCompanyType;

class LibCommonPolicy {
    use HandlesAuthorization;

    public function __construct(){
        
    }

    private function mainCheck($user){
        if ($user->type_id != SysUserType::ADMIN)
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

 
}

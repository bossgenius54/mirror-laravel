<?php

namespace App\Policies;

use App\User;
use App\Model\SysUserType;
use Illuminate\Auth\Access\HandlesAuthorization;

class MainPolicy {
    use HandlesAuthorization;

    public function __construct(){
        
    }

    private function mainCheck($user){
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

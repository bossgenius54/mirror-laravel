<?php

namespace App\Policies\Common;

use App\User;
use App\Model\SysUserType;
use Illuminate\Auth\Access\HandlesAuthorization;

use App\Model\SysCompanyType;

class ExternalDoctorSalaryPolicy  {
    use HandlesAuthorization;

    public function __construct(){
        
    }

    private function mainCheck($user){
        if (!in_array($user->type_id, [SysUserType::ADMIN, SysUserType::DIRECTOR, SysUserType::MANAGER, SysUserType::EXTERNAL_DOCTOR, SysUserType::ACCOUNTER]))
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
        if (!in_array($user->type_id, [SysUserType::ADMIN, SysUserType::DIRECTOR, SysUserType::MANAGER]))
            return false;

        return true;
    } 
    
    public function update($user, $item){
        if ( !$this->mainCheck($user))
            return false;
      

        return true;
    }

    public function delete($user, $item){
        if (!in_array($user->type_id, [SysUserType::ADMIN, SysUserType::DIRECTOR, SysUserType::MANAGER]))
            return false;

        return true;
    }
}

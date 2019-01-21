<?php  
namespace App\Observers;

use App\Model\Company;
use App\Model\SysUserType;
use Auth;

use App\Services\CreateCompanyClient;

class CompanyObserver{
   
    public function created(Company $item){
        $user = Auth::user();
        if (in_array($user->type_id, [SysUserType::DIRECTOR, SysUserType::MANAGER]))
            CreateCompanyClient::create($item, $user);
        
    }
}

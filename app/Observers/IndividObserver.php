<?php  
namespace App\Observers;

use App\Model\View\Individ;
use App\Model\SysUserType;
use Auth;

use App\Services\CreateIndividClient;

class IndividObserver{
   
    public function created(Individ $item){
        $user = Auth::user();
        if ($item->type_id == SysUserType::FIZ && $user->company_id) 
            CreateIndividClient::create($item, $user);
        
    }
}

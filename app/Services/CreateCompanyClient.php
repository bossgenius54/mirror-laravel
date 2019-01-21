<?php  
namespace App\Services;

use App\Model\Company;
use App\User;

use App\Model\Client;
use App\Model\SysClientType;

class CreateCompanyClient {

    static function create(Company $item, User $user){
        Client::create([
            'company_id' => $user->company_id, 
            'type_id' => SysClientType::COMPANY, 
            'client_company_id' => $item->id
        ]);
    }
   
}

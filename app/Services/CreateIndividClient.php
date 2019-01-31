<?php  
namespace App\Services;

use App\User;
use App\Model\View\Individ;

use App\Model\Client;
use App\Model\SysClientType;

class CreateIndividClient {
    static function create(Individ $item, User $user){
        Client::create([
            'company_id' => $user->company_id, 
            'type_id' => SysClientType::PERSON, 
            'client_user_id' => $item->id
        ]);
    }
   
}

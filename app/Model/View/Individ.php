<?php
namespace App\Model\View;

use App\User;

class Individ extends User{

    function relSeller(){
        return $this->hasMany('App\Model\Client', 'client_user_id');
    }
}

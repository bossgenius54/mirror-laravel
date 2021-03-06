<?php
namespace App\Model;

use App\Helper\Traits\DateHelper;
use Illuminate\Database\Eloquent\Model;

class SysAuthLog extends Model {
    protected $table = 'sys_auth_log';
    use DateHelper;
    
    static function createNote($user){
        $i = new SysAuthLog();
        $i->user_id = $user->id;
        $i->save();
        
    }

    function relUser(){
        return $this->belongsTo('App\User', 'user_id');
    }
}

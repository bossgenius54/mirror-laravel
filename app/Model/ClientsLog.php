<?php

namespace App\Model;

use App\Helper\Traits\DateHelper;
use Illuminate\Database\Eloquent\Model;

class ClientsLog extends Model
{
    protected $table = 'clients_logs';
    protected $fillable = [ 'company_id', 'client_id', 'user_id', 'type_id', 'order_id', 'receipt_id'];
    use DateHelper;

    public static function writeLog($vars){

        $log = new ClientsLog();
        $log->company_id = $vars['user']->company_id;
        $log->client_id = $vars['client']->id;
        $log->user_id = $vars['user']->id;
        $log->type_id = $vars['type_id'];

        if($vars['type_id'] == ClientsLogType::RECEIPT_WRITED){
            $log->receipt_id = $vars['receipt_id'];
        } elseif ($vars['type_id'] == ClientsLogType::CREATED_ORDER){
            $log->order_id = $vars['order']->id;
        } elseif ($vars['type_id'] == ClientsLogType::RETURN_ORDER){
            $log->order_id = $vars['order']->id;
        }

        $log->save();

        return $log;
    }

    function relCreatedUser(){
        return $this->belongsTo('App\User', 'user_id');
    }

    function relClient(){
        return $this->belongsTo('App\User', 'client_id');
    }

    function relOrder(){
        return $this->belongsTo('App\Model\Order', 'order_id');
    }

    function relFormula(){
        return $this->belongsTo('App\Model\Formula', 'receipt_id');
    }

    function relClientsLogType(){
        return $this->belongsTo('App\Model\ClientsLogType', 'type_id');
    }
}

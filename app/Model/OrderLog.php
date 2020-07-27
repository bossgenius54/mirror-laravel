<?php

namespace App\Model;

use App\Helper\Traits\DateHelper;
use Illuminate\Database\Eloquent\Model;

class OrderLog extends Model
{
    protected $table = 'order_logs';
    protected $fillable = [ 'company_id', 'branch_id', 'user_id', 'type_id', 'order_id', 'note'];
    use DateHelper;

    public static function writeLog($user, $type_id, $order, $note){

        $log = new OrderLog();
        $log->company_id = $order->company_id;
        $log->branch_id = $order->branch_id;
        $log->user_id = $user->id;
        $log->type_id = $type_id;
        $log->order_id = $order->id;
        $log->note = $note != '' ? $note : null;
        $log->save();

        return $log;
    }

    function relCreatedUser(){
        return $this->belongsTo('App\User', 'user_id');
    }

    function relOrder(){
        return $this->belongsTo('App\Model\Order', 'order_id');
    }

    function relOrderLogType(){
        return $this->belongsTo('App\Model\OrderLogType', 'type_id');
    }
}

<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class OrderService extends Model{
    protected $table = 'order_services';
    protected $fillable = ['order_id', 'service_id', 'service_count', 'service_cost', 'total_sum'];
    use DateHelper;


    function relService(){
        return $this->belongsTo('App\Model\CompanyService', 'service_id');
    }

    function relOrder(){
        return $this->belongsTo('App\Model\Order', 'order_id');
    }

}

<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class OrderService extends Model{
    protected $table = 'order_services';
    protected $fillable = ['order_id', 'service_id', 'total_sum'];
    use DateHelper;
    

}

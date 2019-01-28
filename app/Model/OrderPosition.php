<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class OrderPosition extends Model{
    protected $table = 'order_position';
    protected $fillable = ['product_id', 'order_id', 'pos_count', 'pos_cost', 'total_sum'];
    use DateHelper;
    
    function relProduct(){
        return $this->belongsTo('App\Model\Product', 'product_id');
    }

}

<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class Position extends Model{
    protected $table = 'positions';
    protected $fillable = ['product_id', 'branch_id', 'status_id', 'income_id', 'price_cost', 'expired_at', 'order_id'];
    use DateHelper;
    
    function relProduct(){
        return $this->belongsTo('App\Model\Product', 'product_id');
    }

    function relIncome(){
        return $this->belongsTo('App\Model\Income', 'income_id');
    }
}

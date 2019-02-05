<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class FinancePosition extends Model{
    protected $table = 'finanse_position';
    protected $fillable = ['finance_id', 'product_id', 'branch_id', 'position_id', 'position_sys_num', 'price_before', 'price_after', 'price_total'];
    use DateHelper;
    
    function relProduct(){
        return $this->belongsTo('App\Model\Product', 'product_id');
    }

}

<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;
use DB;

class FinancePosition extends Model{
    protected $table = 'finanse_position';
    protected $fillable = ['finance_id', 'product_id', 'branch_id', 'position_id', 'position_sys_num', 'price_before', 'price_after', 'price_total'];
    use DateHelper;
    
    function relProduct(){
        return $this->belongsTo('App\Model\Product', 'product_id');
    }

    function relBranch(){
        return $this->belongsTo('App\Model\Branch', 'branch_id');
    }

    function relFinance(){
        return $this->belongsTo('App\Model\Finance', 'finance_id');
    }


    static function getStatByPriceBefore($finanse_id){
        return FinancePosition::select(DB::raw('COUNT(id) AS product_count, sum(price_before) AS product_sum, price_before, product_id '))
                                ->where('finance_id', $finanse_id)
                                ->groupBy('product_id')
                                ->with('relProduct')->get();
    }

    static function getStatByPriceAfter($finanse_id){
        return FinancePosition::select(DB::raw('COUNT(id) AS product_count, sum(price_after) AS product_sum, price_after, product_id '))
                                ->where('finance_id', $finanse_id)
                                ->groupBy('product_id')
                                ->with('relProduct')->get();
    }
}

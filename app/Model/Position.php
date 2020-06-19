<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;
use DB;

class Position extends Model{
    protected $table = 'positions';
    protected $fillable = ['product_id', 'branch_id', 'status_id', 'income_id', 'price_cost', 'expired_at', 'order_id', 'sys_num', 'motion_id', 'group_num'];
    use DateHelper;

    function relProduct(){
        return $this->belongsTo('App\Model\Product', 'product_id');
    }

    function relIncome(){
        return $this->belongsTo('App\Model\Income', 'income_id');
    }

    function relStatus(){
        return $this->belongsTo('App\Model\SysPositionStatus', 'status_id');
    }

    function relBranch(){
        return $this->belongsTo('App\Model\Branch', 'branch_id');
    }

    static function getStatByIncome($income_id){
        return Position::selectRaw('COUNT(id) AS product_count, sum(price_cost) AS product_sum, price_cost, product_id, expired_at, group_num')
                                ->where('income_id', $income_id)
                                ->groupBy('group_num')
                                ->with('relProduct')->get();
    }

}

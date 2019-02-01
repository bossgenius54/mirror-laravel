<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class OutcomePosition extends Model{
    protected $table = 'outcome_position';
    protected $fillable = ['outcome_id', 'product_id', 'position_id', 'branch_id', 'position_sys_num', 'price_cost', 'price_sell', 'expired_at'];
    use DateHelper;

}

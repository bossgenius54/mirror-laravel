<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class IncomePosition extends Model{
    protected $table = 'income_position';
    protected $fillable = ['income_id', 'position_sys_num'];
    use DateHelper;

    function relPosition(){
        return $this->hasOne('App\Model\Position', 'sys_num', 'position_sys_num');
    }

    function relOutcomePosition(){
        return $this->hasOne('App\Model\OutcomePosition', 'position_sys_num', 'position_sys_num');
    }
}

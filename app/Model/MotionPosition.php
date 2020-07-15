<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class MotionPosition extends Model{
    protected $table = 'motion_positions';
    protected $fillable = ['motion_id', 'position_sys_num', 'motion_product_id'];
    use DateHelper;

    function relPosition(){
        return $this->belongsTo('App\Model\Position', 'position_sys_num');
    }
}

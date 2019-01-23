<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class MotionPosition extends Model{
    protected $table = 'motion_positions';
    protected $fillable = ['motion_id', 'position_id', 'motion_product_id'];
    

}

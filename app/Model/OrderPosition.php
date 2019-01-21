<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class OrderPosition extends Model{
    protected $table = 'order_position';
    protected $fillable = ['product_id', 'order_id', 'pos_count', 'pos_cost', 'total_sum'];
    

}

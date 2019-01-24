<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class MotionProduct extends Model{
    protected $table = 'motion_products';
    protected $fillable = ['motion_id', 'product_id', 'count_position'];
    use DateHelper;
    
    public function relProduct(){
        return $this->belongsTo('App\Model\Product', 'product_id');
    }

}

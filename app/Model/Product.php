<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Product extends Model{
    protected $table = 'products';
    protected $fillable = ['company_id', 'cat_id', 'artikul', 'sys_num', 'name', 'price_retail', 'price_opt', 'sale_percent', 'min_stock_count'];
    
    function relOptions(){
        return $this->hasMany('App\Model\ProductOption', 'product_id');
    }

    function relPositions(){
        return $this->hasMany('App\Model\Position', 'product_id');
    }
}

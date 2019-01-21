<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Product extends Model{
    protected $table = 'products';
    protected $fillable = ['company_id', 'cat_id', 'artikul', 'sys_num', 'name', 'price_retail', 'price_opt', 'sale_percent', 'expired_month'];
    
    function relOptions(){
        return $this->hasMany('App\Model\ProductOption', 'product_id');
    }

}

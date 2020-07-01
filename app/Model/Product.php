<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class Product extends Model{
    protected $table = 'products';
    protected $fillable = ['company_id', 'cat_id', 'artikul', 'sys_num', 'name', 'price_retail', 'price_opt', 'sale_percent', 'min_stock_count'];
    use DateHelper;

    function relOptions(){
        return $this->hasMany('App\Model\ProductOption', 'product_id');
    }

    function relPositions(){
        return $this->hasMany('App\Model\Position', 'product_id');
    }

    function relOrderPosition(){
        return $this->hasMany('App\Model\OrderPosition', 'product_id');
    }

    function relCategory(){
        return $this->belongsTo('App\Model\LibProductCat', 'cat_id');
    }
}

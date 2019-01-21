<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Product extends Model{
    protected $table = 'products';
    protected $fillable = ['company_id', 'cat_id', 'sys_name', 'name', 'price_retail', 'price_opt', 'sale_percent', 'expired_month'];
    

}

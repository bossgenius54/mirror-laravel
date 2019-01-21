<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model{
    protected $table = 'product_options';
    protected $fillable = ['product_id', 'option_id', 'label', 'name', 'val'];
    

}

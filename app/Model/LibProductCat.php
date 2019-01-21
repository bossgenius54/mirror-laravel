<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class LibProductCat extends Model{
    protected $table = 'lib_product_cat';
    protected $fillable = ['name'];
    
    static function getAr(){
        return static::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
    }
}

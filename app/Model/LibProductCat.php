<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class LibProductCat extends Model{
    protected $table = 'lib_product_cat';
    protected $fillable = ['name'];
    use DateHelper;
    
    static function getAr(){
        return static::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
    }
}

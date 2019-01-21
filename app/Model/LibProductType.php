<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Model\LibProductCat;

class LibProductType extends Model{
    protected $table = 'lib_product_type';
    protected $fillable = ['name', 'cat_id'];
    
    static function getAr(){
        return static::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
    }

    static function getArWithCat(){
        $items = static::orderBy('cat_id', 'asc')->get();
        $ar_cat = LibProductCat::getAr();
        $ar = [];
        foreach ($items as $i) {
            if (isset($ar_cat[$i->cat_id]))
                $ar[$i->id] = $ar_cat[$i->cat_id].'/';
            
            $ar[$i->id] .= $i->name;
        }
        
        return $ar;
    } 

    function relOptions(){
        return $this->hasMany('App\Model\LibProductOption', 'type_id');
    }

}

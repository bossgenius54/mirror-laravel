<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class LibCompanyCat extends Model{
    protected $table = 'lib_company_cat';
    protected $fillable = ['name'];
    
    static function getAr(){
        return static::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
    }
}

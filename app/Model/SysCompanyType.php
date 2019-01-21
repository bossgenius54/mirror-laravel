<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class SysCompanyType extends Model{
    protected $table = 'sys_company_type';
    protected $fillable = ['name'];
    
    CONST FULL = 1;
    CONST HALF = 2;
    CONST EMPTY = 3;
    
    static function getAr(){
        return static::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
    }
}

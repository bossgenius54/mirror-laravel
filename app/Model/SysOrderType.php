<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class SysOrderType extends Model{
    protected $table = 'sys_order_type';
    protected $fillable = ['name'];
    
    CONST PERSON = 1;
    CONST COMPANY = 2;

}

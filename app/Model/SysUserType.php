<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class SysUserType extends Model{
    protected $table = 'sys_user_type';
    protected $fillable = ['name'];
    
    CONST ADMIN = 1;
    CONST DIRECTOR = 2;
    CONST MANAGER = 3;
    CONST DOCTOR = 4;
    CONST FIZ = 5;
    CONST ACCOUNTER = 6;
    CONST EXTERNAL_DOCTOR = 7;
    CONST STOCK_MANAGER = 8;

}

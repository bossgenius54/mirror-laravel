<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class SysIncomeType extends Model{
    protected $table = 'sys_income_type';
    protected $fillable = ['name'];
    
    CONST FROM_COMPANY = 1;
    CONST FROM_PERSON = 2;
    CONST RETURN_COMPANY = 4;
    CONST RETURN_PERSON = 5;

}

<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class SysFinanceType extends Model{
    protected $table = 'sys_finance_type';
    protected $fillable = ['name'];
    
    CONST FROM_COMPANY = 1;
    CONST FROM_PERSON = 2;
    CONST TO_COMPANY = 3;
    CONST TO_PERSON = 4;
    CONST RETURN_COMPANY = 5;
    CONST RETURN_PERSON = 6;
    CONST MOVE_FROM = 7;
    CONST MOVE_TO = 8;

}

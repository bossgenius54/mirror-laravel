<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class SysOutcomeType extends Model{
    protected $table = 'sys_outcome_type';
    protected $fillable = ['name'];
    
    CONST TO_COMPANY = 1;
    CONST TO_PERSON = 2;
    CONST RELOCATION = 3;
    CONST RETURN_COMPANY = 4;
    CONST RETURN_PERSON = 5;

}

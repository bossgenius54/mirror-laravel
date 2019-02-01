<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class SysFinanceType extends Model{
    protected $table = 'sys_finance_type';
    protected $fillable = ['name'];
    
    CONST FROM_COMPANY = 1;

}

<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class SysClientType extends Model{
    protected $table = 'sys_client_type';
    protected $fillable = ['name'];
    
    CONST PERSON = 1;
    CONST COMPANY = 2;

}

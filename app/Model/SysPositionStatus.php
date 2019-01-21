<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class SysPositionStatus extends Model{
    protected $table = 'sys_position_status';
    protected $fillable = ['name'];
    
    CONST ACTIVE = 1;
    CONST RESERVE = 2;
    CONST DELETED = 3;
    CONST PLAN = 4;
}

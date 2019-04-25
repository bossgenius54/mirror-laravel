<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class SysPositionStatus extends Model{
    protected $table = 'sys_position_status';
    protected $fillable = ['name'];
    
    CONST ACTIVE = 1;
    CONST RESERVE = 2;
    CONST IN_MOTION = 4;
    CONST DELETED = 5;
    CONST IN_INCOME = 6;
}

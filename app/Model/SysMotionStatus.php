<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class SysMotionStatus extends Model{
    protected $table = 'sys_motion_status';
    protected $fillable = ['name'];

    CONST IN_WORK = 1;
    CONST FINISH = 2;
    CONST CANCEL = 3;
    CONST CONFIRMED = 4;

}

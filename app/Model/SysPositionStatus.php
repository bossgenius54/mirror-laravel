<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class SysPositionStatus extends Model{
    protected $table = 'sys_position_status';
    protected $fillable = ['name'];

    CONST ACTIVE = 1; // В продаже
    CONST RESERVE = 2; // Забронирован
    CONST IN_MOTION = 4; // На перемещении
    CONST DELETED = 5; // Удален
    CONST IN_INCOME = 6; // В оприходовании
    CONST SOLD = 7; // Продан
}

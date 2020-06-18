<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DeletionStatus extends Model
{
    protected $table = 'deletion_statuses';
    protected $fillable = ['name'];

    CONST IN_WORK = 1;
    CONST IN_CONFIRM = 2;
    CONST CONFIRMED = 3;
    CONST RETURNED = 4;
}

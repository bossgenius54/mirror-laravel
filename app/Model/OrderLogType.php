<?php

namespace App\Model;

use App\Helper\Traits\DateHelper;
use Illuminate\Database\Eloquent\Model;

class OrderLogType extends Model
{
    protected $table = 'order_log_types';
    protected $fillable = ['name'];
    use DateHelper;

    const CREATED_ORDER = 1;
    const SERVICE_ADD = 2;
    const SERVICE_DELETED = 3;
    const PRODUCT_ADD = 4;
    const PRODUCT_DELETED = 5;
    const STATUS_CHANGED_TO = 6;
    const STATUS_GIVED = 7;
    const PREPAY = 8;
    const NOTE = 9;
    const MAY_FINISH_AT = 10;
}

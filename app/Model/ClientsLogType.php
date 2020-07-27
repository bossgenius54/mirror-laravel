<?php

namespace App\Model;

use App\Helper\Traits\DateHelper;
use Illuminate\Database\Eloquent\Model;

class ClientsLogType extends Model
{
    protected $table = 'clients_log_types';
    protected $fillable = ['name'];
    use DateHelper;

    const CREATED_CLIENT = 1;
    const RECEIPT_WRITED = 2;
    const CREATED_ORDER = 3;
    const RETURN_ORDER = 4;
}

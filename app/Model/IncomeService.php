<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class IncomeService extends Model{
    protected $table = 'income_service';
    protected $fillable = ['service_id', 'income_id', 'service_count', 'service_cost', 'total_sum'];
    use DateHelper;

}

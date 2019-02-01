<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class OutcomeService extends Model{
    protected $table = 'outcome_services';
    protected $fillable = ['outcome_id', 'service_id', 'service_count', 'service_cost', 'total_sum'];
    use DateHelper;

}

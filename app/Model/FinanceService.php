<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class FinanceService extends Model{
    protected $table = 'finance_services';
    protected $fillable = ['finance_id', 'branch_id', 'service_id', 'service_count', 'service_cost', 'total_sum'];
    use DateHelper;
    
    function relService(){
        return $this->belongsTo('App\Model\CompanyService', 'service_id');
    }

    function relBranch(){
        return $this->belongsTo('App\Model\Branch', 'branch_id');
    }

    function relFinance(){
        return $this->belongsTo('App\Model\Finance', 'finance_id');
    }
}

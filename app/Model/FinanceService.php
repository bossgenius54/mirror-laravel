<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class FinanceService extends Model{
    protected $table = 'finance_services';
    protected $fillable = ['finance_id', 'service_id', 'price_total'];
    use DateHelper;
    

}

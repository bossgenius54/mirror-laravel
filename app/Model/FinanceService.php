<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class FinanceService extends Model{
    protected $table = 'finance_services';
    protected $fillable = ['finance_id', 'service_id', 'price_total'];
    

}

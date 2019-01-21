<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class FinancePosition extends Model{
    protected $table = 'finanse_position';
    protected $fillable = ['finance_id', 'product_id', 'branch_id', 'before_id', 'price_before', 'price_after', 'price_total', 'product_date'];
    

}

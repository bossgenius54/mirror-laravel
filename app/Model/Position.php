<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Position extends Model{
    protected $table = 'positions';
    protected $fillable = ['product_id', 'branch_id', 'status_id', 'income_id', 'price_cost', 'expired_at', 'product_date'];
    

}

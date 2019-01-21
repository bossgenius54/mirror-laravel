<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Order extends Model{
    protected $table = 'orders';
    protected $fillable = ['type_id', 'status_id', 'company_id', 'from_company_id', 'from_user_id', 'name', 'note', 'before_sum', 'total_sum', 'prepay_sum', 'may_finish_at'];
    

}

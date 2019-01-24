<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class Finance extends Model{
    protected $table = 'finance';
    protected $fillable = ['company_id', 'branch_id', 'user_id', 'sum', 'type_id', 'note'];
    use DateHelper;
    

}

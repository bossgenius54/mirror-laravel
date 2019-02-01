<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class Outcome extends Model{
    protected $table = 'outcome';
    protected $fillable = ['type_id', 'company_id', 'branch_id', 'to_company_id', 'to_branch_id', 'to_user_id', 'name', 'related_cost', 'note', 'is_retail'];
    use DateHelper;
    

}

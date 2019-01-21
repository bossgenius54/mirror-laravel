<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Income extends Model{
    protected $table = 'income';
    protected $fillable = ['type_id', 'company_id', 'branch_id', 'from_company_id', 'from_branch_id', 'from_user_id', 'name', 'related_cost', 'note'];
    

}

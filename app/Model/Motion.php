<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Motion extends Model{
    protected $table = 'motion';
    protected $fillable = ['company_id', 'from_branch_id', 'to_branh_id', 'status_id', 'name', 'user_id'];
    
    
}

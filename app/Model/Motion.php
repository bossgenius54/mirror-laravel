<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class Motion extends Model{
    protected $table = 'motion';
    protected $fillable = ['company_id', 'from_branch_id', 'to_branh_id', 'status_id', 'name', 'user_id'];
    use DateHelper;
    
    function relFromBranch(){
        return $this->belongsTo('App\Model\Branch', 'from_branch_id');
    }
    
    function relToBranch(){
        return $this->belongsTo('App\Model\Branch', 'to_branh_id');
    }
}

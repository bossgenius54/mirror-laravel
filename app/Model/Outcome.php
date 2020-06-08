<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class Outcome extends Model{
    protected $table = 'outcome';
    protected $fillable = ['type_id', 'company_id', 'branch_id', 'to_company_id', 'to_branch_id', 'to_user_id', 'name', 'related_cost', 'note', 'user_id', 'is_retail'];
    use DateHelper;

    function relCompany(){
        return $this->belongsTo('App\Model\Company', 'company_id');
    }

    function relToCompany(){
        return $this->belongsTo('App\Model\Company', 'to_company_id');
    }

    function relBranch(){
        return $this->belongsTo('App\Model\Branch', 'branch_id');
    }

    function relToUser(){
        return $this->belongsTo('App\User', 'to_user_id');
    }

    function relCreatedUser(){
        return $this->belongsTo('App\User', 'user_id');
    }

}

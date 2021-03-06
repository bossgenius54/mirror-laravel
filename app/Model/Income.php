<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class Income extends Model{
    protected $table = 'income';
    protected $fillable = ['type_id', 'company_id', 'branch_id', 'from_company_id', 'from_branch_id', 'from_user_id', 'user_id', 'name', 'related_cost', 'note'];
    use DateHelper;

    function relCompany(){
        return $this->belongsTo('App\Model\Company', 'company_id');
    }

    function relFromCompany(){
        return $this->belongsTo('App\Model\Company', 'from_company_id');
    }

    function relBranch(){
        return $this->belongsTo('App\Model\Branch', 'branch_id');
    }

    function relFromUser(){
        return $this->belongsTo('App\User', 'from_user_id');
    }

    function relPositions(){
        return $this->hasMany('App\Model\Position', 'income_id');
    }

    function relCreatedUser(){
        return $this->belongsTo('App\User', 'user_id');
    }

    function relIncomePositions(){
        return $this->hasMany('App\Model\IncomePosition', 'income_id');
    }

    function relIncomeService(){
        return $this->hasMany('App\Model\IncomeService', 'income_id');
    }

    function relOrder(){
        return $this->belongsTo('App\Model\Order', 'order_id');
    }

    function relType(){
        return $this->belongsTo('App\Model\SysIncomeType', 'type_id');
    }
}

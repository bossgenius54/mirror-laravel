<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class Finance extends Model{
    protected $table = 'finance';
    protected $fillable = ['company_id', 'branch_id', 'user_id', 'type_id', 'income_id', 'outcome_id', 'motion_id', 'sum', 'note', 'is_active', 'is_retail'];
    use DateHelper;

    function relIncome(){
        return $this->belongsTo('App\Model\Income', 'income_id');
    }

    function relOutcome(){
        return $this->belongsTo('App\Model\Outcome', 'outcome_id');
    }
    
}

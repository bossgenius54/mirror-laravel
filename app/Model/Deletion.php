<?php

namespace App\Model;

use App\Helper\Traits\DateHelper;
use Illuminate\Database\Eloquent\Model;

class Deletion extends Model
{
    protected $table = 'deletions';
    protected $fillable = ['branch_id', 'company_id', 'user_id', 'name', 'note', 'status_id' ];
    use DateHelper;

    function relCreatedUser(){
        return $this->belongsTo('App\User', 'user_id');
    }

    function relDeletePosition(){
        return $this->hasMany('App\Model\DeletionPosition', 'deletion_id');
    }

    function relCompany(){
        return $this->belongsTo('App\Model\Company', 'company_id');
    }

    function relBranch(){
        return $this->belongsTo('App\Model\Branch', 'branch_id');
    }

    function relStatus(){
        return $this->belongsTo('App\Model\DeletionStatus', 'status_id');
    }

}

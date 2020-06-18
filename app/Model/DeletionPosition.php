<?php

namespace App\Model;

use App\Helper\Traits\DateHelper;
use Illuminate\Database\Eloquent\Model;

class DeletionPosition extends Model
{
    protected $table = 'deletion_positions';
    protected $fillable = ['deletion_id', 'product_id', 'position_id', 'branch_id', 'company_id'];
    use DateHelper;

    function relProduct(){
        return $this->belongsTo('App\Model\Product', 'product_id');
    }

    function relPosition(){
        return $this->belongsTo('App\Model\Position', 'position_id');
    }

    function relCompany(){
        return $this->belongsTo('App\Model\Company', 'company_id');
    }

    function relBranch(){
        return $this->belongsTo('App\Model\Branch', 'branch_id');
    }
}

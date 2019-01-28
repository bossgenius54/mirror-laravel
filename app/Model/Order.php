<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;
use App\Model\SysOrderType;

class Order extends Model{
    protected $table = 'order';
    protected $fillable = [ 'type_id', 'status_id', 'company_id', 'from_company_id', 'branch_id',
                            'from_user_id', 'name', 
                            'note', 'before_sum', 'total_sum', 
                            'prepay_sum', 'may_finish_at', 'is_retail', 'created_user_id'];
    use DateHelper;
    private $client_obj = null;
    
    function getClient(){
        if ($this->client_obj !== null)
            return $this->client_obj;

        if ($this->type_id == SysOrderType::PERSON)
            $this->client_obj = ($this->relPersonCLient ? $this->relPersonCLient : false);
        else if ($this->type_id == SysOrderType::COMPANY)
            $this->client_obj = ($this->relCompanyCLient ? $this->relCompanyCLient : false);

        return  $this->client_obj;
    }

    function relCompanyCLient(){
        return $this->belongsTo('App\Model\Company', 'from_company_id');
    }

    function relPersonCLient(){
        return $this->belongsTo('App\User', 'from_user_id');
    }

    
    function relCreatedUser(){
        return $this->belongsTo('App\User', 'created_user_id');
    }

    function relStatus(){
        return $this->belongsTo('App\Model\SysOrderStatus', 'status_id');
    }

    function relType(){
        return $this->belongsTo('App\Model\SysOrderType', 'type_id');
    }

    function relBranch(){
        return $this->belongsTo('App\Model\Branch', 'branch_id');
    }

    function relServices(){
        return $this->hasMany('App\Model\OrderService', 'order_id');
    }

    function relProducts(){
        return $this->hasMany('App\Model\OrderPosition', 'order_id');
    }

}

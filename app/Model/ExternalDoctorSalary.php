<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class ExternalDoctorSalary extends Model{
    protected $table = 'external_doctor_salary';
    protected $fillable = ['doctor_id', 'order_id', 'company_id', 'user_id', 'salary'];
    use DateHelper;

    function relDoctor(){
        return $this->belongsTo('App\Model\View\ExternalDoctor', 'doctor_id');
    }

    function relOrder(){
        return $this->belongsTo('App\Model\Order', 'order_id');
    }

    function relCreatedUser(){
        return $this->belongsTo('App\User', 'user_id');
    }
}

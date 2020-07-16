<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;
use App\Model\SysCompanyType;

class Company extends Model{
    protected $table = 'company';
    protected $fillable = ['type_id', 'cat_id', 'name', 'created_user_id', 'created_company_id'];
    use DateHelper;

    static function getAr(){
        return static::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
    }

    function relData(){
        return $this->hasOne('App\Model\CompanyData', 'company_id');
    }

    static function getArForDirectors(){
        return static::whereIn('type_id', [SysCompanyType::HALF, SysCompanyType::FULL])->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
    }

    static function getArFullPermis(){
        return static::whereIn('type_id', [SysCompanyType::HALF, SysCompanyType::FULL])->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
    }

    function relClients(){
        return $this->hasMany('App\Model\Client', 'company_id');
    }

    function relSeller(){
        return $this->hasMany('App\Model\Client', 'client_company_id');
    }

    function relOrder(){
        return $this->hasMany('App\Model\Order', 'from_company_id');
    }

}

<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Helper\Traits\DateHelper;

class Branch extends Model{
    protected $table = 'branch';
    protected $fillable = ['company_id', 'name', 'user_id', 'has_onlain'];
    use DateHelper;
    
    static function getAr(){
        return static::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
    }
    
    function relData(){
        return $this->hasOne('App\Model\BranchData', 'branch_id');
    }

    static function getArForCompany(Request $request){
        return static::where('company_id', $request->user()->company_id)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
    }

}

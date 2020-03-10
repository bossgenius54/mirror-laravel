<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Helper\Traits\DateHelper;
use Auth;
use App\Model\SysUserType;

class Branch extends Model{
    protected $table = 'branch';
    protected $fillable = ['company_id', 'name', 'user_id', 'has_onlain'];
    use DateHelper;
    
    function scopeByRole($q){
        if (Auth::user()->type_id == SysUserType::MANAGER)
            $q->where('id', Auth::user()->branch_id);
        
        return $q;
    }


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

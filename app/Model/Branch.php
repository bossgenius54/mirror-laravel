<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model{
    protected $table = 'branch';
    protected $fillable = ['company_id', 'name', 'user_id', 'has_stock', 'has_front', 'has_resseler'];
    
    static function getAr(){
        return static::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
    }
    
    function relData(){
        return $this->hasOne('App\Model\BranchData', 'branch_id');
    }



}

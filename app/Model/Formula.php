<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Formula extends Model{
    protected $table = 'formula';
    protected $fillable = ['user_id', 'created_user_id', 
                            'l_scope', 'r_scope', 'l_cil', 'r_cil', 'l_os', 'r_os', 'l_prism_01', 'l_prism_02', 'r_prism_01', 'r_prism_02', 
                            'len', 'purpose', 'note'];
    
    function relIndivid(){
        return $this->belongsTo('App\Model\View\Individ', 'user_id');
    }

    function relCreatedUser(){
        return $this->belongsTo('App\User', 'created_user_id');
    }

    static function getProposeAr(){
        return [
            'Для дали', 'Для работы', 'Для постоянного ношения'
        ];
    }
}

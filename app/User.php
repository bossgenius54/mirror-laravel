<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Helper\Traits\DateHelper;
use App\Model\SysUserType;

class User extends Authenticatable
{
    use Notifiable, DateHelper;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'iin', 'phone', 'photo', 'password', 'remember_token', 'is_active', 'type_id', 'company_id', 'branch_id', 'had_enter'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getTypeName(){
        $type = SysUserType::find( $this->type_id);
        $name = ($type ? $type->name : '');
        
        $branch = $this->relBranch;
        if ($branch)
            $name .= '<br/><small><i>'.$branch->name.'</i></small>';

        return $name;
    }

    function relCompany(){
        return $this->belongsTo('App\Model\Company', 'company_id');
    }

    function relBranch(){
        return $this->belongsTo('App\Model\Branch', 'branch_id');
    }
}

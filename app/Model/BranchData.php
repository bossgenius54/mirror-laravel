<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class BranchData extends Model{
    protected $table = 'branch_data';
    protected $fillable = ['branch_id', 'address', 'phone', 'mobile', 'note'];
    

}

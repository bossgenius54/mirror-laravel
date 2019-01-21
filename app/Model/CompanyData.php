<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class CompanyData extends Model{
    protected $table = 'company_data';
    protected $fillable = ['company_id', 'bin', 'bik', 'bank', 'account_num', 'ur_address', 'fact_address'];
    

}

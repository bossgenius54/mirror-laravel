<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class CompanyService extends Model{
    protected $table = 'company_services';
    protected $fillable = ['company_id', 'name', 'price'];
    

}

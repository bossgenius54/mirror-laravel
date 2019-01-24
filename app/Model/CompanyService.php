<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class CompanyService extends Model{
    protected $table = 'company_services';
    protected $fillable = ['company_id', 'name', 'price'];
    use DateHelper;
    

}

<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class Client extends Model{
    protected $table = 'clients';
    protected $fillable = ['company_id', 'type_id', 'client_company_id', 'client_user_id', 'sale_ball', 'sale_percent'];
    use DateHelper;
    
}

<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class ProductOption extends Model{
    protected $table = 'product_options';
    protected $fillable = ['product_id', 'option_id', 'label', 'name', 'val'];
    use DateHelper;
    

}

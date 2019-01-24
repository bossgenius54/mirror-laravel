<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class LibProductOption extends Model{
    protected $table = 'lib_product_option';
    protected $fillable = ['cat_id', 'type_id', 'label', 'option_name', 'option_val'];
    use DateHelper;
    

}

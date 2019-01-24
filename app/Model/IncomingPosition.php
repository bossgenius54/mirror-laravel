<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class IncomingPosition extends Model{
    protected $table = 'incoming_position';
    protected $fillable = ['income_id', 'position_id'];
    use DateHelper;
    

}

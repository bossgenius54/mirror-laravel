<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use App\Helper\Traits\DateHelper;

class OutcomingPosition extends Model{
    protected $table = 'outcoming_position';
    protected $fillable = ['outcome_id', 'position_id'];
    use DateHelper;
    

}

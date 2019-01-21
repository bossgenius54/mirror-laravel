<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class OutcomingPosition extends Model{
    protected $table = 'outcoming_position';
    protected $fillable = ['outcome_id', 'position_id'];
    

}

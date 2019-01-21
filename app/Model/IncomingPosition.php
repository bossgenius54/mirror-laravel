<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class IncomingPosition extends Model{
    protected $table = 'incoming_position';
    protected $fillable = ['income_id', 'position_id'];
    

}

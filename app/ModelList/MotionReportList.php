<?php

namespace App\ModelList;

use App\Model\Motion;
use App\Model\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MotionReportList extends Model
{
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new MotionReportList();
        $el->start($request);

        return  $el->getResult();
    }


    private function getItems(){
        $request = $this->request;

        $items = Motion::where('company_id', $this->user->company_id)
                        ->with(['relMotionPosition' => function($q){
                            $q->with(['relPosition' => function($j){
                                $j->with(['relProduct','relIncome','relStatus']);
                            }]);
                        }, 'relCreatedUser', 'relStatus','relToBranch']);

        $this->items = $items;
    }

    function start(Request $request){
        $this->request = $request;
        $this->user = Auth::user();

        $this->getItems();
    }

    function getResult(){
        return $this->items;
    }
}

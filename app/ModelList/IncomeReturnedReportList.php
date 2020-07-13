<?php

namespace App\ModelList;

use App\Model\Income;
use App\Model\View\IncomeReturned;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IncomeReturnedReportList extends Model
{
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new IncomeReturnedReportList();
        $el->start($request);

        return  $el->getResult();
    }


    private function getItems(){
        $request = $this->request;

        $items = IncomeReturned::where('company_id', $this->user->company_id)
                        ->with(['relIncomePositions' => function($q) use ($request) {
                            // dd($request);
                            $q->with(['relPosition' => function($rp) {
                                $rp->with('relProduct');
                            }]);

                        }, 'relIncomeService' => function($q) {
                            $q->with('relService');
                        }, 'relOrder', 'relFromUser','relFromCompany','relCreatedUser']);

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

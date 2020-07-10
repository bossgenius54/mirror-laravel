<?php

namespace App\ModelList;

use App\Model\Product;
use App\Model\SysPositionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfitProductsReportList extends Model
{
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new ProfitProductsReportList();
        $el->start($request);

        return  $el->getResult();
    }


    private function getItems(){
        $request = $this->request;

        $items = Product::where('company_id', $this->user->company_id)
                        ->with(['relOrderPosition' => function($q) use ($request) {
                            // dd($request);
                            if($request->filtered && $request->filtered == 'true') {
                                $q->whereBetween(DB::raw('DATE(created_at)'), array($request->created_at_first, $request->created_at_second) );
                            }

                            $q->whereHas('relOrder', function($query) use ($request) {

                                if($request->branch_id && $request->branch_id > 0){
                                    $query->where('branch_id', $request->branch_id);
                                }

                                $query->orderBy('branch_id', 'DESC');

                            })->with(['relOrder' => function($qu) {
                                $qu->with('relPositions');
                            }]);
                        }, 'relCategory']);

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

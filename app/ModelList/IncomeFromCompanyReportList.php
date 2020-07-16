<?php

namespace App\ModelList;

use App\Model\SysIncomeType;
use App\Model\View\IncomeFromCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeFromCompanyReportList extends Model
{
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new IncomeFromCompanyReportList();
        $el->start($request);

        return  $el->getResult();
    }


    private function getItems(){
        $request = $this->request;

        $items = IncomeFromCompany::where('company_id', $this->user->company_id)->where('type_id',SysIncomeType::FROM_COMPANY)
                                ->with(['relIncomePositions' => function($q) use ($request) {
                                    $q->with(['relPosition' => function($rp) {
                                        $rp->with('relProduct');
                                    }]);
        }, 'relFromUser','relFromCompany','relCreatedUser','relPositions']);

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


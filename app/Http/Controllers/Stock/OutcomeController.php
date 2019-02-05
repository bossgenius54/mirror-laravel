<?php
namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Outcome;
use App\ModelList\OutcomeList;
use App\Model\SysOutcomeType;

use App\Model\Finance;
use App\Model\FinancePosition;
use App\Model\FinanceService;
use App\Model\SysFinanceType;

use DB;
use Exception;

class OutcomeController extends Controller{
    private $title = 'Отгрузки';

    function getIndex (Request $request){
        $ar = array();
        $ar['title'] = 'Список елементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = OutcomeList::get($request)->latest()->paginate(24);
        $ar['ar_type'] = SysOutcomeType::pluck('name', 'id')->toArray();

        return view('page.stock.outcome.index', $ar);
    }

    function getView(Request $request, Outcome $item){
        $positions = false;
        $services = false;
        $finance = Finance::where('outcome_id', $item->id)
                            ->whereIn('type_id', [SysFinanceType::TO_COMPANY, SysFinanceType::TO_PERSON])->first();
        if ($finance){
            $positions = FinancePosition::where('finance_id', $finance->id)->with('relProduct')->get();
            $services = FinanceService::where('finance_id', $finance->id)->with('relService')->get();
        }
            
        

        $ar = array();
        $ar['title'] = 'Детализация елемента списока "'.$this->title.'"';
        $ar['ar_type'] = SysOutcomeType::pluck('name', 'id')->toArray();
        $ar['positions'] = $positions;
        $ar['services'] = $services;
        $ar['item'] = $item;

        return view('page.stock.outcome.view', $ar);
    }


}

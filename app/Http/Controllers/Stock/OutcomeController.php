<?php
namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Model\Branch;
use Illuminate\Http\Request;

use App\Model\Outcome;
use App\ModelList\OutcomeList;
use App\Model\SysOutcomeType;

use App\Model\Finance;
use App\Model\FinancePosition;
use App\Model\FinanceService;
use App\Model\SysFinanceType;

use App\ModelFilter\OutcomeFilter;

use DB;
use Exception;
use Illuminate\Support\Facades\Auth;

class OutcomeController extends Controller{
    private $title = 'Отгрузки';

    function getIndex (Request $request){
        $items = OutcomeList::get($request);
        $items = OutcomeFilter::filter($request, $items);
        $user = Auth::user();

        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['filter_block'] = OutcomeFilter::getFilterBlock($request);
        $ar['items'] = $items->latest()->paginate(24);
        $ar['user'] = $user;

        $ar['ar_type'] = SysOutcomeType::pluck('name', 'id')->toArray();
        $ar['ar_branch'] = Branch::where('company_id', $user->company_id)->pluck('name', 'id')->toArray();

        return view('page.stock.outcome.index', $ar);
    }

    function getView(Request $request, Outcome $item){
        $positions = false;
        $services = false;
        $products = false;
        $finance = Finance::where('outcome_id', $item->id)
                            ->whereIn('type_id', [SysFinanceType::TO_COMPANY, SysFinanceType::TO_PERSON])->first();
        if ($finance){
            $positions = FinancePosition::where('finance_id', $finance->id)->with('relProduct')->get();
            $services = FinanceService::where('finance_id', $finance->id)->with('relService')->get();
            $products = FinancePosition::getStatByPriceAfter($finance->id);
        }



        $ar = array();
        $ar['title'] = 'Детализация элемента списока "'.$this->title.'"';
        $ar['ar_type'] = SysOutcomeType::pluck('name', 'id')->toArray();
        $ar['positions'] = $positions;
        $ar['products'] = $products;
        $ar['services'] = $services;
        $ar['item'] = $item;

        return view('page.stock.outcome.view', $ar);
    }


}

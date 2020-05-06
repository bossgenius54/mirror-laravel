<?php
namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Model\Branch;
use Illuminate\Http\Request;

use App\Model\View\IncomeReturned;
use App\ModelList\IncomeReturnedList;
use App\Model\SysIncomeType;
use App\Model\IncomeService;

use App\Model\Finance;
use App\Model\FinancePosition;

use App\Services\Finance\CreateFinanceModel;

use App\ModelFilter\IncomeReturnedFilter;

use DB;
use Exception;
use Illuminate\Support\Facades\Auth;

class IncomeReturnedController extends Controller{
    private $title = 'Возвраты';

    function getIndex (Request $request){
        $items = IncomeReturnedList::get($request);
        $items = IncomeReturnedFilter::filter($request, $items);
        $user = Auth::user();

        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['filter_block'] = IncomeReturnedFilter::getFilterBlock($request);
        $ar['items'] = $items->latest()->paginate(24);
        $ar['ar_type'] = SysIncomeType::pluck('name', 'id')->toArray();
        $ar['user'] = $user;
        $ar['ar_branch'] = Branch::where('company_id', $user->company_id)->pluck('name', 'id')->toArray();

        return view('page.stock.income_returned.index', $ar);
    }

    function getView(Request $request, IncomeReturned $item){
        $income_position = false;
        $finance = Finance::where('income_id', $item->id)->first();
        $products = false;
        if ($finance){
            $income_position = FinancePosition::where('finance_id', $finance->id)->with('relProduct')->get();
            $products = FinancePosition::getStatByPriceBefore($finance->id);
        }



        $ar = array();
        $ar['title'] = 'Детализация элемента списока "'.$this->title.'"';
        $ar['ar_type'] = SysIncomeType::pluck('name', 'id')->toArray();
        $ar['income_position'] = $income_position;
        $ar['products'] = $products;
        $ar['income_services'] = IncomeService::where('income_id', $item->id)->get();
        $ar['item'] = $item;

        return view('page.stock.income_returned.view', $ar);
    }


}

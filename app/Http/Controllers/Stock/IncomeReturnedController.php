<?php
namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\View\IncomeReturned;
use App\ModelList\IncomeReturnedList;
use App\Model\SysIncomeType;
use App\Model\IncomeService;

use App\Model\Finance;
use App\Model\FinancePosition;

use App\Services\Finance\CreateFinanceModel;

use DB;
use Exception;

class IncomeReturnedController extends Controller{
    private $title = 'Возвраты';

    function getIndex (Request $request){
        $ar = array();
        $ar['title'] = 'Список елементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = IncomeReturnedList::get($request)->latest()->paginate(24);
        $ar['ar_type'] = SysIncomeType::pluck('name', 'id')->toArray();

        return view('page.stock.income_returned.index', $ar);
    }

    function getView(Request $request, IncomeReturned $item){
        $income_position = false;
        $finance = Finance::where('income_id', $item->id)->first();
        if ($finance)
            $income_position = FinancePosition::where('finance_id', $finance->id)->with('relProduct')->get();
        

        $ar = array();
        $ar['title'] = 'Детализация елемента списока "'.$this->title.'"';
        $ar['ar_type'] = SysIncomeType::pluck('name', 'id')->toArray();
        $ar['income_position'] = $income_position;
        $ar['income_services'] = IncomeService::where('income_id', $item->id)->get();
        $ar['item'] = $item;

        return view('page.stock.income_returned.view', $ar);
    }


}

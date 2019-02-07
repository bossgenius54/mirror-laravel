<?php
namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\FinanceService;
use App\ModelList\FinanceServiceList;

use App\ModelFilter\FinanceServiceFilter;

class FinanseServiceController extends Controller{
    private $title = 'Финансы по услугам';

    function getIndex (Request $request){
        $items = FinanceServiceList::get($request);
        $items = FinanceServiceFilter::filter($request, $items);

        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['filter_block'] = FinanceServiceFilter::getFilterBlock($request);
        $ar['items'] = $items->with('relBranch', 'relService')->latest()->paginate(24);

        return view('page.finance.service.index', $ar);
    }

}

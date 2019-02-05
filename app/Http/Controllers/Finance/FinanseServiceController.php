<?php
namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Model\FinanceService;
use App\ModelList\FinanceServiceList;

class FinanseServiceController extends Controller{
    private $title = 'Финансы по услугам';

    function getIndex (Request $request){
        $items = FinanceServiceList::get($request);

        $ar = array();
        $ar['title'] = 'Список елементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = $items->with('relBranch', 'relService')->latest()->paginate(24);

        return view('page.finance.service.index', $ar);
    }

}

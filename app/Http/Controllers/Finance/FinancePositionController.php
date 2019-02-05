<?php
namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Model\FinancePosition;
use App\ModelList\FinancePositionList;

use App\ModelFilter\FinancePositionFilter;

class FinancePositionController extends Controller{
    private $title = 'Финансы по позициям';

    function getIndex (Request $request){
        $items = FinancePositionList::get($request);
        $items = FinancePositionFilter::filter($request, $items);

        $ar = array();
        $ar['title'] = 'Список елементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['filter_block'] = FinancePositionFilter::getFilterBlock($request);
        $ar['items'] = $items->with('relBranch', 'relProduct')->latest()->paginate(24);

        return view('page.finance.position.index', $ar);
    }

}

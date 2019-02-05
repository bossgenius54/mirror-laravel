<?php
namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Model\FinancePosition;
use App\ModelList\FinancePositionList;

class FinancePositionController extends Controller{
    private $title = 'Финансы по позициям';

    function getIndex (Request $request){
        $items = FinancePositionList::get($request);

        $ar = array();
        $ar['title'] = 'Список елементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = $items->with('relBranch', 'relProduct')->latest()->paginate(24);

        return view('page.finance.position.index', $ar);
    }

}

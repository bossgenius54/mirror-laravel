<?php
namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Model\Branch;
use Illuminate\Http\Request;


use App\Model\FinancePosition;
use App\Model\Product;
use App\ModelList\FinancePositionList;

use App\ModelFilter\FinancePositionFilter;
use Illuminate\Support\Facades\Auth;

class FinancePositionController extends Controller{
    private $title = 'Финансы по позициям';

    function getIndex (Request $request){
        $items = FinancePositionList::get($request);
        $items = FinancePositionFilter::filter($request, $items);
        $user = Auth::user();

        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['filter_block'] = FinancePositionFilter::getFilterBlock($request);
        $ar['items'] = $items->with('relBranch', 'relProduct')->latest()->paginate(24);
        $ar['items_filter'] = Product::where('company_id', $user->company_id)->pluck('name', 'id')->toArray();
        $ar['ar_branch'] = Branch::where('company_id',$user->company_id)->pluck('name', 'id')->toArray();
        $ar['user'] = $user;

        return view('page.finance.position.index', $ar);
    }

}

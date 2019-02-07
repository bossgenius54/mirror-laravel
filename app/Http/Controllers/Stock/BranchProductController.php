<?php
namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\ModelList\ProductList;
use App\ModelList\BranchList;

use DB;
use Exception;

class BranchProductController extends Controller{
    private $title = 'Кол-во на складах компаниях';

    function getIndex (Request $request){
        $items = ProductList::get($request);

        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = $items->latest()->paginate(12);
        $ar['ar_branch'] = BranchList::get($request)->pluck('name', 'id')->toArray();

        return view('page.stock.branch_product.index', $ar);
    }

}

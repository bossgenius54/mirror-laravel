<?php
namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\ModelList\ProductList;
use App\ModelList\BranchList;
use App\ModelFilter\ProductFilter;
use App\Model\LibProductCat;


use DB;
use Exception;

class BranchProductController extends Controller{
    private $title = 'Кол-во на складах компаниях';

    function getIndex (Request $request){
        $items = ProductList::get($request);
        $items = ProductFilter::filter($request, $items);


        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['filter_block'] = ProductFilter::getFilterBlock($request);
        $ar['items'] = $items->latest()->paginate(12);
        $ar['ar_branch'] = BranchList::get($request)->pluck('name', 'id')->toArray();
        $ar['ar_cat'] = LibProductCat::getAr();

        return view('page.stock.branch_product.index', $ar);
    }

}

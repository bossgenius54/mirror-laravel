<?php
namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\ModelList\ProductList;
use App\ModelList\BranchList;
use App\ModelFilter\ProductFilter;
use App\Model\LibProductCat;
use App\Model\Product;
use App\Model\SysPositionStatus;
use DB;
use Exception;
use Illuminate\Support\Facades\Auth;

class BranchProductController extends Controller{
    private $title = 'Кол-во на складах компаниях';

    function getIndex (Request $request){
        $user = Auth::user();

        $items = ProductList::get($request);
        $items = ProductFilter::filter($request, $items);

        $branches = BranchList::get($request);

        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['ar_branch'] = $branches->pluck('name', 'id')->toArray();
        $ar['filter_names'] = ProductList::get($request)->latest()->get();

        $branch_array = [];
        foreach ( $ar['ar_branch'] as $id => $name )
        {
            array_push($branch_array, $id);
        }

        if ($request->hidden_null && $request->hidden_null == true)
        {
            $ar['items'] = $items->where('company_id', $user->company_id)->whereHas('relPositions', function($q){
                $q->where('status_id', SysPositionStatus::ACTIVE);
            })->latest()->paginate(12);
        } else {
            $ar['items'] = $items->latest()->paginate(12);
        }

        $ar['ar_cat'] = LibProductCat::getAr();
        // dd($ar['branch_array']);

        return view('page.stock.branch_product.index', $ar);
    }

}

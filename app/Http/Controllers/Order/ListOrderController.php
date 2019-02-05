<?php
namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\ModelList\OrderList;

use App\ModelList\BranchList;

use App\Model\SysOrderStatus;
use App\Model\SysOrderType;

use App\ModelFilter\OrderFilter;

use DB;
use Exception;

class ListOrderController extends Controller{
    private $title = 'Заказы';

    function getIndex (Request $request){
        $items = OrderList::get($request);
        $items = OrderFilter::filter($request, $items);

        $ar = array();
        $ar['title'] = 'Список елементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['filter_block'] = OrderFilter::getFilterBlock($request);
        $ar['items'] = $items->latest()->paginate(24);
        $ar['ar_status'] = SysOrderStatus::pluck('name', 'id')->toArray();
        $ar['ar_type'] = SysOrderType::pluck('name', 'id')->toArray();
        $ar['ar_branch'] = BranchList::get($request)->pluck('name', 'id')->toArray();

        return view('page.order.list.index', $ar);
    }
}

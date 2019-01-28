<?php
namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Order;
use App\ModelList\OrderList;

use App\ModelList\BranchList;
use App\ModelList\CompanyList;
use App\ModelList\IndividList;
use App\ModelList\CompanyServiceList;
use App\ModelList\ProductList;

use App\Model\SysOrderStatus;
use App\Model\SysOrderType;
use App\Model\OrderService;
use App\Model\OrderPosition;
use App\Model\SysPositionStatus;
use App\Model\Position;

use DB;
use Exception;

class ListOrderController extends Controller{
    private $title = 'Заказы';

    function getIndex (Request $request){
        $items = OrderList::get($request);

        $ar = array();
        $ar['title'] = 'Список елементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = $items->latest()->paginate(24);
        $ar['ar_status'] = SysOrderStatus::pluck('name', 'id')->toArray();
        $ar['ar_type'] = SysOrderType::pluck('name', 'id')->toArray();
        $ar['ar_branch'] = BranchList::get($request)->pluck('name', 'id')->toArray();

        return view('page.order.list.index', $ar);
    }
}

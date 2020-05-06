<?php
namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Model\Branch;
use Illuminate\Http\Request;

use App\ModelList\OrderList;

use App\ModelList\BranchList;

use App\Model\SysOrderStatus;
use App\Model\SysOrderType;
use App\Model\SysUserType;
use App\ModelFilter\OrderFilter;
use App\User;
use DB;
use Exception;
use Illuminate\Support\Facades\Auth;

class ListOrderController extends Controller{
    private $title = 'Заказы';

    function getIndex (Request $request){
        $items = OrderList::get($request);
        $items = OrderFilter::filter($request, $items);
        $user = Auth::user();

        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['filter_block'] = OrderFilter::getFilterBlock($request);
        $ar['items'] = $items->latest()->paginate(24);
        $ar['ar_status'] = SysOrderStatus::pluck('name', 'id')->toArray();
        $ar['ar_managers'] = User::where('type_id', SysUserType::MANAGER)->where('company_id', $user->company_id)->pluck('name', 'id')->toArray();
        $ar['ar_branch'] = Branch::where('company_id', $user->company_id)->pluck('name', 'id')->toArray();
        $ar['ar_type'] = SysOrderType::pluck('name', 'id')->toArray();
        $ar['ar_branch'] = BranchList::get($request)->pluck('name', 'id')->toArray();

        return view('page.order.list.index', $ar);
    }
}

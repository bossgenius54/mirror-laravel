<?php
namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\View\OfflineOrder;
use App\ModelList\OfflineOrderList;

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

class ViewController extends Controller{
    private $title = 'Заказы/Розница';

    function getView(Request $request, OfflineOrder $item){
        $ar = array();
        $ar['title'] = 'Просмотр елемента списка "'.$this->title.'"';
        $ar['item'] = $item;
        $ar['action'] = action('Order\ViewController@postUpdate', $item);
        $ar['services'] = CompanyServiceList::get($request)->get();
        $ar['order_services'] = $item->relServices()->with('relService')->get();
        $ar['products'] = ProductList::get($request)->get();
        $ar['order_products'] = $item->relProducts()->with('relProduct')->get();
        
        return view('page.order.view.index', $ar);
    }

    function postUpdate(Request $request, OfflineOrder $item){
        DB::beginTransaction();
        try {
            $ar = $request->all();
            $item->update($ar);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Изменен елемент списка "'.$this->title.'" № '.$item->id);
    }

}

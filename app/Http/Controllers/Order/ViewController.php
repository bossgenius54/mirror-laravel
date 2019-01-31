<?php
namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Order;

use App\ModelList\CompanyServiceList;
use App\ModelList\ProductList;

use App\Services\Order\CanChangeOrderStatusRules;
use App\Model\SysOrderStatus;

use DB;
use Exception;

class ViewController extends Controller{
    private $title = 'Заказы/Розница';

    function getView(Request $request, Order $item){
        $can_ar_status = CanChangeOrderStatusRules::getArStatus($request->user(), $item);

        $ar = array();
        $ar['title'] = 'Просмотр елемента списка "'.$this->title.'"';
        $ar['item'] = $item;
        $ar['action'] = action('Order\ViewController@postUpdate', $item);
        $ar['services'] = CompanyServiceList::get($request)->get();
        $ar['order_services'] = $item->relServices()->with('relService')->get();
        $ar['products'] = ProductList::get($request)->get();
        $ar['order_products'] = $item->relProducts()->with('relProduct')->get();

        $ar['can_status'] = SysOrderStatus::whereIn('id', $can_ar_status)->pluck('name', 'id')->toArray();
        $ar['can_status_class'] = SysOrderStatus::whereIn('id', $can_ar_status)->pluck('bootstrap_class', 'id')->toArray();
        $ar['user'] = $request->user();
        $ar['request'] = $request;
        
        if ($request->for_print == 1)
            return view('page.order.view.for_print', $ar);
        
        return view('page.order.view.index', $ar);
    }

    function postUpdate(Request $request, Order $item){
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

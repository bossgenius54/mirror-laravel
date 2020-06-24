<?php
namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Order;

use App\Model\CompanyService;
use App\Model\LibProductCat;
use App\Model\Position;
use App\Model\Product;

use App\Services\Order\CanChangeOrderStatusRules;
use App\Model\SysOrderStatus;
use App\Model\SysPositionStatus;
use App\ModelFilter\PositionFilter;
use App\ModelList\PositionList;
use App\ModelList\ProductList;
use App\Services\Order\GetOrderFormula;

use DB;
use Exception;

class ViewController extends Controller{
    private $title = 'Заказы/Розница';

    function getView(Request $request, Order $item){
        $can_ar_status = CanChangeOrderStatusRules::getArStatus($request->user(), $item);

        $ar = array();
        $ar['title'] = 'Просмотр элемента списка "'.$this->title.'"';
        $ar['item'] = $item;
        $ar['action'] = action('Order\ViewController@postUpdate', $item);
        $ar['get_position'] = action('Order\ViewController@getPositions', $item);
        $ar['addBasket'] = action('Order\PositionOrderController@basketAddProduct', $item);

        $ar['services'] = CompanyService::where('company_id', $item->company_id)->get();
        $ar['order_services'] = $item->relServices()->with('relService')->get();
        $ar['ar_order_service'] = $item->relServices()->pluck('service_id')->toArray();

        $ar['products'] = Product::where('company_id', $item->company_id)->orderBy('name', 'asc')->get();
        $ar['order_products'] = $item->relProducts()->with('relProduct')->get();
        $ar['ar_order_product'] = $item->relProducts()->pluck('product_id')->toArray();

        $ar['can_status'] = SysOrderStatus::whereIn('id', $can_ar_status)->pluck('name', 'id')->toArray();
        $ar['can_status_class'] = SysOrderStatus::whereIn('id', $can_ar_status)->pluck('bootstrap_class', 'id')->toArray();
        $ar['user'] = $request->user();
        $ar['request'] = $request;
        $ar['formula'] = GetOrderFormula::start($item);

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

        return redirect()->back()->with('success', 'Изменен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getPositions (Request $request, Order $item){
        $items = PositionList::get($request);
        $items = PositionFilter::filter($request, $items);

        $ar = [];

        $ar['items'] = $items->with('relProduct')->where([ 'status_id' => SysPositionStatus::ACTIVE, 'branch_id' => $item->branch_id ])
                                                ->orderByRaw("expired_at",'ASC')->get();

        return response()->json([
            'items' => $ar['items']
        ]);

    }

    function postAddByPositionId (Request $request, Order $item){
        if (OrderPosition::where(['order_id' => $item->id, 'product_id' => $request->product_id])->count() > 0)
            return redirect()->back()->with('error', 'Указанный товар уже есть');

        if ($request->pos_count > 5 && $request->is_retail)
            return redirect()->back()->with('error', 'Запрещено покупать больше 5 товаров в розницу');

        $cost = $request->pos_cost;
        if ($request->user()->type_id == SysUserType::FIZ || $request->user()->type_id == SysUserType::COMPANY_CLIENT){
            $product = Product::findOrFail($request->product_id);
            $cost = $product->price_retail;

        }

        DB::beginTransaction();
        try {
            $order_product = OrderPosition::create([
                'order_id' => $item->id,
                'product_id' => $request->product_id,
                'pos_count' => $request->pos_count,
                'pos_cost' => $cost,
                'total_sum' => ($request->pos_count * $request->pos_cost)
            ]);

            Position::where(['status_id' => SysPositionStatus::ACTIVE, 'product_id'=> $request->product_id])->where('branch_id', $item->branch_id)->orderBy('id', 'asc')->take($request->pos_count)
                    ->update(['status_id' => SysPositionStatus::RESERVE, 'order_id' => $item->id]);

            $item->update([
                'total_sum' => ($item->total_sum + $order_product->total_sum)
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Ассортимент добавлен "'.$this->title.'" № '.$item->id);

    }

}

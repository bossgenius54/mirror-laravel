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

class ListOrderController extends Controller{
    private $title = 'Заказы/Розница';

    function getIndex (Request $request){
        $items = OfflineOrderList::get($request);

        $ar = array();
        $ar['title'] = 'Список елементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = $items->latest()->paginate(24);
        $ar['ar_status'] = SysOrderStatus::pluck('name', 'id')->toArray();
        $ar['ar_type'] = SysOrderType::pluck('name', 'id')->toArray();
        $ar['ar_branch'] = BranchList::get($request)->pluck('name', 'id')->toArray();

        return view('page.order.offline.index', $ar);
    }

    function getCreate(Request $request, SysOrderType $type){
        $ar = array();
        $ar['title'] = 'Добавить елемент в список "'.$this->title.'"';
        $ar['action'] = action('Order\OfflineOrderController@postCreate', $type);
        $ar['ar_branch'] = BranchList::get($request)->pluck('name', 'id')->toArray();
        $ar['companies'] = CompanyList::get($request)->pluck('name', 'id')->toArray();
        $ar['individs'] = IndividList::get($request)->pluck('name', 'id')->toArray();
        $ar['type'] = $type;

        return view('page.order.offline.create', $ar);
    }

    function postCreate(Request $request, SysOrderType $type){
        $user = $request->user();

        DB::beginTransaction();
        try {
            $ar = $request->all();
            $ar['type_id'] = $type->id;
            $ar['status_id'] = SysOrderStatus::FORMATION;
            $ar['company_id'] = $user->company_id;
            $ar['created_user_id'] = $user->id;
            $ar['is_retail'] = 1;

            $item = OfflineOrder::create($ar);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
        
        return redirect()->action("Order\OfflineOrderController@getIndex")->with('success', 'Добавлен елемент списка "'.$this->title.'" № '.$item->id);
    }

    function getView(Request $request, OfflineOrder $item){
        $ar = array();
        $ar['title'] = 'Просмотр елемента списка "'.$this->title.'"';
        $ar['item'] = $item;
        $ar['action'] = action('Order\OfflineOrderController@postUpdate', $item);
        $ar['services'] = CompanyServiceList::get($request)->get();
        $ar['order_services'] = $item->relServices()->with('relService')->get();
        $ar['products'] = ProductList::get($request)->get();
        $ar['order_products'] = $item->relProducts()->with('relProduct')->get();
        
        return view('page.order.offline.view', $ar);
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

    function postAddService(Request $request, OfflineOrder $item){
        if (OrderService::where(['order_id' => $item->id, 'service_id' => $request->service_id])->count() > 0)
            return redirect()->back()->with('error', 'Указанная услуга уже есть ');

        DB::beginTransaction();
        try {
            $order_service = OrderService::create([
                'order_id' => $item->id, 
                'service_id' => $request->service_id, 
                'service_count' => $request->service_count, 
                'service_cost' => $request->service_cost, 
                'total_sum' => ($request->service_count * $request->service_cost)
            ]);

            $item->update([
                'total_sum' => ($item->total_sum + $order_service->total_sum)
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        } 

        return redirect()->back()->with('success', 'Услуга добавлена "'.$this->title.'" № '.$item->id);
    }

    
    function getDeleteService(Request $request, OfflineOrder $item, OrderService $order_service){
        DB::beginTransaction();
        try {
            $item->update([
                'total_sum' => ($item->total_sum - $order_service->total_sum)
            ]);

            $order_service->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        } 

        return redirect()->back()->with('success', 'Услуга удалено "'.$this->title.'" № '.$item->id);
    }

    
    function postAddProduct(Request $request, OfflineOrder $item){
        if (OrderPosition::where(['order_id' => $item->id, 'product_id' => $request->product_id])->count() > 0)
            return redirect()->back()->with('error', 'Указанный товар уже есть');

        DB::beginTransaction();
        try {
            $order_product = OrderPosition::create([
                'order_id' => $item->id, 
                'product_id' => $request->product_id, 
                'pos_count' => $request->pos_count, 
                'pos_cost' => $request->pos_cost, 
                'total_sum' => ($request->pos_count * $request->pos_cost)
            ]);

            Position::where(['status_id' => SysPositionStatus::ACTIVE, 'product_id'=> $request->product_id])->orderBy('id', 'asc')->take($request->pos_count)
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

    function getDeleteProduct(Request $request, OfflineOrder $item, OrderPosition $order_product){
        DB::beginTransaction();
        try {
            $item->update([
                'total_sum' => ($item->total_sum - $order_product->total_sum)
            ]);
            
            Position::where(['status_id' => SysPositionStatus::RESERVE, 'order_id'=> $item->id])
                    ->update(['status_id' => SysPositionStatus::ACTIVE, 'order_id' =>null]);

            $order_product->delete();
            

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        } 

        return redirect()->back()->with('success', 'Ассортимент удален "'.$this->title.'" № '.$item->id);
    }

    function getCanceled(Request $request, OfflineOrder $item){
        DB::beginTransaction();
        try {
            Position::where(['status_id' => SysPositionStatus::RESERVE, 'order_id'=> $item->id])
                    ->update(['status_id' => SysPositionStatus::ACTIVE, 'order_id' =>null]);

            $item->update([
                'status_id' => SysOrderStatus::CANCELED
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        } 

        return redirect()->back()->with('success', 'Ассортимент удален "'.$this->title.'" № '.$item->id);
    }
}

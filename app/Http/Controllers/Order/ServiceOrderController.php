<?php
namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Order;
use App\Model\OrderService;
use App\Model\SysUserType;
use App\Model\CompanyService;

use DB;
use Exception;

class ServiceOrderController extends Controller{
    private $title = 'Заказы/Розница';

    function postAddService(Request $request, Order $item){
        if (OrderService::where(['order_id' => $item->id, 'service_id' => $request->service_id])->count() > 0)
            return redirect()->back()->with('error', 'Указанная услуга уже есть ');
        
        $cost =  $request->service_cost;
        if ($request->user()->type_id == SysUserType::FIZ){
            $service = CompanyService::findOrFail($request->service_id);
            $cost = $service->price;
        }

        DB::beginTransaction();
        try {
            $order_service = OrderService::create([
                'order_id' => $item->id, 
                'service_id' => $request->service_id, 
                'service_count' => $request->service_count, 
                'service_cost' => $cost, 
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

    
    function getDeleteService(Request $request, Order $item, OrderService $order_service){
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

    
}

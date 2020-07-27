<?php
namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Order;
use App\Model\OrderService;
use App\Model\SysUserType;
use App\Model\CompanyService;
use App\Model\OrderLog;
use App\Model\OrderLogType;
use DB;
use Exception;
use Illuminate\Support\Facades\Auth;

class ServiceOrderController extends Controller{
    private $title = 'Заказы/Розница';

    function postAddService(Request $request, Order $item){
        $user = Auth::user();

        if (OrderService::where(['order_id' => $item->id, 'service_id' => $request->service_id])->count() > 0)
            return redirect()->back()->with('error', 'Указанная услуга уже есть ');

        $cost =  $request->service_cost;
        if ($request->user()->type_id == SysUserType::FIZ || $request->user()->type_id == SysUserType::COMPANY_CLIENT){
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

            if($order_service){
                $service = CompanyService::find($order_service->service_id);
                $note = '"' . $service->name . '" (Кол-во: ' . $order_service->service_count . ')(Сумма: ' . $order_service->total_sum . ')';
                $log = OrderLog::writeLog( $user, OrderLogType::SERVICE_ADD, $item, $note);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Услуга добавлена "'.$this->title.'" № '.$item->id);
    }


    function getDeleteService(Request $request, Order $item, OrderService $order_service){
        $user = Auth::user();

        DB::beginTransaction();
        try {
            $item->update([
                'total_sum' => ($item->total_sum - $order_service->total_sum)
            ]);

            if($order_service->delete()){
                $service = CompanyService::find($order_service->service_id);
                $note = '"' . $service->name . '" (Кол-во: ' . $order_service->service_count . ')(Сумма: ' . $order_service->total_sum . ')';
                $log = OrderLog::writeLog( $user, OrderLogType::SERVICE_DELETED, $item, $note);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Услуга удалено "'.$this->title.'" № '.$item->id);
    }


}

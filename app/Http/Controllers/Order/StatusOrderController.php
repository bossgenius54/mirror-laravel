<?php
namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Model\ClientsLog;
use App\Model\ClientsLogType;
use Illuminate\Http\Request;

use App\Model\Order;
use App\Model\OrderLog;
use App\Model\OrderLogType;
use App\Model\SysOrderStatus;

use App\Model\SysPositionStatus;
use App\Model\Position;
use App\User;
use DB;
use Exception;
use Illuminate\Support\Facades\Auth;

class StatusOrderController extends Controller{
    private $title = 'Заказы/Розница';

    function getChangeStatus(Request $request, Order $item, SysOrderStatus $status){
        $user = Auth::user();

        DB::beginTransaction();
        try {
            $item->update(['status_id' => $status->id]);

            if($item){
                $note = '"' . $status->name . '"';
                $log = OrderLog::writeLog( $user, OrderLogType::STATUS_CHANGED_TO, $item, $note);

                if ($status->id == SysOrderStatus::RETURNED) {
                    $vars = [];
                    $vars['user'] = $user;
                    $vars['client'] = User::find($item->from_user_id);
                    $vars['type_id'] = ClientsLogType::RETURN_ORDER;
                    $vars['order'] = $item;

                    $log = ClientsLog::writeLog($vars);
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Статус заказа изменен ');
    }
}

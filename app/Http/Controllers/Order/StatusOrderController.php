<?php
namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Order;
use App\Model\SysOrderStatus;

use App\Model\SysPositionStatus;
use App\Model\Position;


use DB;
use Exception;

class StatusOrderController extends Controller{
    private $title = 'Заказы/Розница';

    function getChangeStatus(Request $request, Order $item, SysOrderStatus $status){
        DB::beginTransaction();
        try {
            $item->update(['status_id' => $status->id]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        } 

        return redirect()->back()->with('success', 'Статус заказа изменен ');
    }
}

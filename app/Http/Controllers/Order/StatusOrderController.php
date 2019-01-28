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

class StatusOrderController extends Controller{
    private $title = 'Заказы/Розница';

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

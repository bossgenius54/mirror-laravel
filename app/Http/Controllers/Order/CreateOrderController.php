<?php
namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Model\ClientsLog;
use App\Model\ClientsLogType;
use Illuminate\Http\Request;

use App\Model\Order;
use App\Model\OrderLog;
use App\Model\OrderLogType;
use App\ModelList\BranchList;
use App\ModelList\CompanyList;
use App\ModelList\IndividList;

use App\Model\SysOrderType;
use App\Model\SysOrderStatus;
use App\User;
use DB;
use Exception;

class CreateOrderController extends Controller{
    private $title = 'Заказы';

    function getCreate(Request $request, SysOrderType $type){
        $ar = array();
        $ar['title'] = 'Добавить элемент в список "'.$this->title.'"';
        $ar['action'] = action('Order\CreateOrderController@postCreate', $type);
        $ar['ar_branch'] = BranchList::get($request)->pluck('name', 'id')->toArray();
        $ar['companies'] = CompanyList::get($request)->pluck('name', 'id')->toArray();
        $ar['individs'] = IndividList::get($request)->pluck('name', 'id')->toArray();
        $ar['type'] = $type;

        return view('page.order.create.index', $ar);
    }

    function postCreate(Request $request, SysOrderType $type){
        $user = $request->user();

        DB::beginTransaction();
        try {
            $ar = $request->all();
            $ar['type_id'] = $type->id;
            $ar['status_id'] = SysOrderStatus::CREATED;
            $ar['company_id'] = $user->company_id;
            $ar['created_user_id'] = $user->id;

            $item = Order::create($ar);

            if($item){
                $log = OrderLog::writeLog( $user, OrderLogType::CREATED_ORDER, $item, '');

                $status = SysOrderStatus::find(SysOrderStatus::CREATED);
                $note = '"' . $status->name . '"';
                $log2 = OrderLog::writeLog( $user, OrderLogType::STATUS_GIVED, $item, $note);

                $vars = [];
                $vars['user'] = $user;
                $vars['client'] = User::find($request->from_user_id);
                $vars['type_id'] = ClientsLogType::CREATED_ORDER;
                $vars['order'] = $item;

                $log = ClientsLog::writeLog($vars);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->action("Order\ViewController@getView", $item);
    }

}

<?php
namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Order;

use App\ModelList\BranchList;
use App\ModelList\CompanyList;
use App\ModelList\IndividList;

use App\Model\SysOrderType;
use App\Model\SysOrderStatus;
use App\Model\Branch;
use App\Model\OrderLog;
use App\Model\OrderLogType;
use DB;
use Exception;

class CreateFizOrderController extends Controller{
    private $title = 'Заказы';

    function getCreate(Request $request){
        $ar = array();
        $ar['title'] = 'Добавить элемент в список "'.$this->title.'"';
        $ar['action'] = action('Order\CreateFizOrderController@postCreate');
        $ar['ar_branch'] = BranchList::get($request)->where('has_onlain', 1)->pluck('name', 'id')->toArray();
        $ar['companies'] = CompanyList::get($request)->pluck('name', 'id')->toArray();
        $ar['individs'] = IndividList::get($request)->pluck('name', 'id')->toArray();

        return view('page.order.create_fiz.index', $ar);
    }

    function postCreate(Request $request){
        $user = $request->user();
        $branch = Branch::findOrFail($request->branch_id);

        DB::beginTransaction();
        try {
            $ar = $request->all();
            $ar['type_id'] = SysOrderType::PERSON;
            $ar['status_id'] = SysOrderStatus::CREATED;
            $ar['company_id'] = $branch->company_id;
            $ar['created_user_id'] = $user->id;
            $ar['from_user_id'] = $user->id;
            $ar['is_onlain'] = 1;
            $ar['is_retail'] = 1;

            $item = Order::create($ar);

            if($item){
                $log = OrderLog::writeLog( $user, OrderLogType::CREATED_ORDER, $item, '');
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->action("Order\ViewController@getView", $item)->with('success', 'Добавлен элемент списка "'.$this->title.'" № '.$item->id);
    }

}

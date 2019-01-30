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

use DB;
use Exception;

class CreateOrderController extends Controller{
    private $title = 'Заказы';

    function getCreate(Request $request, SysOrderType $type){
        $ar = array();
        $ar['title'] = 'Добавить елемент в список "'.$this->title.'"';
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
            $ar['is_retail'] = 1;

            $item = Order::create($ar);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
        
        return redirect()->action("Order\ListOrderController@getIndex")->with('success', 'Добавлен елемент списка "'.$this->title.'" № '.$item->id);
    }

}

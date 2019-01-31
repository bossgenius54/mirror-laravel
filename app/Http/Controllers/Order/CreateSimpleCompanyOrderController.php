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

use DB;
use Exception;

class CreateSimpleCompanyOrderController extends Controller{
    private $title = 'Заказы';

    function getCreate(Request $request){
        $ar = array();
        $ar['title'] = 'Добавить елемент в список "'.$this->title.'"';
        $ar['action'] = action('Order\CreateSimpleCompanyOrderController@postCreate');
        $ar['ar_branch'] = BranchList::get($request)->pluck('name', 'id')->toArray();
        $ar['companies'] = CompanyList::get($request)->pluck('name', 'id')->toArray();
        $ar['individs'] = IndividList::get($request)->pluck('name', 'id')->toArray();
        
        return view('page.order.create_simple_company.index', $ar);
    }

    function postCreate(Request $request){
        $user = $request->user();
        $branch = Branch::findOrFail($request->branch_id);

        DB::beginTransaction();
        try {
            $ar = $request->all();
            $ar['type_id'] = SysOrderType::COMPANY;
            $ar['status_id'] = SysOrderStatus::CREATED;
            $ar['company_id'] = $branch->company_id;
            $ar['created_user_id'] = $user->id;
            $ar['from_company_id'] = $user->company_id;
            $ar['is_onlain'] = 1;

            $item = Order::create($ar);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
        
        return redirect()->action("Order\ListOrderController@getIndex")->with('success', 'Добавлен елемент списка "'.$this->title.'" № '.$item->id);
    }

}

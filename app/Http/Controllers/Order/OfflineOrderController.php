<?php
namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\View\OfflineOrder;
use App\ModelList\OfflineOrderList;

use App\ModelList\BranchList;
use App\Model\SysOrderStatus;
use App\Model\SysOrderType;

use DB;
use Exception;

class OfflineOrderController extends Controller{
    private $title = 'Заказы';

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

        $ar['ar_status'] = SysOrderStatus::pluck('name', 'id')->toArray();
        $ar['ar_type'] = SysOrderType::pluck('name', 'id')->toArray();
        $ar['ar_branch'] = BranchList::get($request)->pluck('name', 'id')->toArray();

        return view('page.order.offline.create', $ar);
    }

    function postCreate(Request $request, SysOrderType $type){
        DB::beginTransaction();

        try {
            $ar = $request->all();
            $ar['user_id'] = $request->user()->id;
            
            $item = Branch::create($ar);
            $ar['branch_id'] = $item->id;
            $data = BranchData::create($ar);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
        
        return redirect()->action("Lib\BranchController@getIndex")->with('success', 'Добавлен елемент списка "'.$this->title.'" № '.$item->id);
    }

}

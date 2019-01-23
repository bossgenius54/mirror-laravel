<?php
namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\View\IncomeFromCompany;
use App\Model\Position;
use App\Model\Branch;
use App\Model\SysPositionStatus;
use App\Model\Product;
use App\Model\SysUserType;

use DB;
use Exception;

class PositionController extends Controller{
    private $title = 'Позиции/Товары';

    private function getItems(Request $request){
        $user = $request->user();
        $items = Position::where('id', '>', 0);

        if ($user->type_id != SysUserType::DIRECTOR)
            $items->where('branch_id', $user->branch_id);

        if ($request->has('branch_id') && $request->branch_id) 
            $items->where('branch_id', $request->branch_id);

        if ($request->has('status_id') && $request->status_id) 
            $items->where('status_id', $request->status_id);

        if ($request->has('product_id') && $request->product_id) 
            $items->where('product_id', $request->product_id);

        if ($request->has('income_id') && $request->income_id) 
            $items->where('income_id', $request->income_id);

        return $items;
    }

    function getIndex (Request $request){
        $ar = array();
        $ar['title'] = 'Список елементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = $this->getItems($request)->with('relProduct')->latest()->paginate(48);
        $ar['ar_status'] = SysPositionStatus::pluck('name', 'id')->toArray();
        $ar['ar_branch'] = Branch::where('company_id', $request->user()->company_id)->pluck('name', 'id')->toArray();

        return view('page.stock.position.index', $ar);
    }

    function getUpdate(Request $request, Position $item){
        $ar = array();
        $ar['title'] = 'Изменить елемент № '. $item->id.' списка "'.$this->title.'"';
        $ar['item'] = $item;
        $ar['action'] = action('Stock\PositionController@postUpdate', $item);

        return view('page.stock.position.update', $ar);
    }

    function postUpdate(Request $request, Position $item){
        DB::beginTransaction();
        try {
            $item->update($request->all());

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->action("Stock\PositionController@getIndex")->with('success', 'Изменен елемент списка "'.$this->title.'" № '.$item->id);
    }


}

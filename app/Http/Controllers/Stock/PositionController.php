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
use App\Model\LibProductCat;
use App\Model\Income;

use App\ModelList\PositionList;

use App\ModelFilter\PositionFilter;

use DB;
use Exception;

class PositionController extends Controller{
    private $title = 'Позиции/Товары';


    function getIndex (Request $request){
        $items = PositionList::get($request);
        $items = PositionFilter::filter($request, $items);

        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['filter_block'] = PositionFilter::getFilterBlock($request);
        $ar['items'] = $items->with('relProduct')->latest()->paginate(48);
        $ar['ar_cat'] = LibProductCat::pluck('name', 'id')->toArray();
        $ar['ar_status'] = SysPositionStatus::pluck('name', 'id')->toArray();
        $ar['ar_branch'] = Branch::where('company_id', $request->user()->company_id)->pluck('name', 'id')->toArray();
        $ar['incomes'] = Income::latest()->get();
        //dd($ar['filter_block']);


        return view('page.stock.position.index', $ar);
    }

    function getUpdate(Request $request, Position $item){
        $ar = array();
        $ar['title'] = 'Изменить элемент № '. $item->id.' списка "'.$this->title.'"';
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

        return redirect()->action("Stock\PositionController@getIndex")->with('success', 'Изменен элемент списка "'.$this->title.'" № '.$item->id);
    }


    function getDelete(Request $request, Position $item){
        DB::beginTransaction();
        try {
            $item->update([
                'status_id' => SysPositionStatus::DELETED
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Списан элемент списка "'.$this->title.'" № '.$item->id);
    }

}

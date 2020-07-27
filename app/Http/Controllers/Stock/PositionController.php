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
use App\Model\IncomePosition;
use App\Model\MotionPosition;
use App\Model\OutcomePosition;
use App\ModelList\PositionList;

use App\ModelFilter\PositionFilter;
use App\ModelList\ProductList;
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
        $ar['p_options'] = LibProductCat::with('relProductOptions')->get();
        $ar['filter_names'] = ProductList::get($request)->latest()->get();
        $ar['sys_nums'] = ProductList::get($request)->latest()->get();

        $ar['ar_status'] = SysPositionStatus::pluck('name', 'id')->toArray();
        // dd($ar['ar_status']);
        $ar['ar_branch'] = Branch::where('company_id', $request->user()->company_id)->pluck('name', 'id')->toArray();
        $ar['incomes'] = Income::latest()->get();
        //dd($ar['filter_block']);


        return view('page.stock.position.index', $ar);
    }

    function getUpdate(Request $request, Position $item){
        $ar = array();
        $ar['title'] = 'Изменить элемент № '. $item->id.' списка "'.$this->title.'"';
        $ar['item'] = $item;
        $ar['product'] = Product::find($item->product_id);
        $ar['action'] = action('Stock\PositionController@postUpdate', $item);

        $array = [];

        $incomes = IncomePosition::where('position_sys_num', $item->sys_num)->with(['relIncome' => function($q){
            $q->with(['relCreatedUser','relFromUser','relFromCompany','relType']);
        }])->get();
        $motions = MotionPosition::where('position_sys_num', $item->sys_num)->with(['relMotion' => function($q){
            $q->with(['relCreatedUser','relFromBranch','relToBranch']);
        }])->get();
        $outcomes = OutcomePosition::where('position_id',$item->id)->with(['relOutcome' => function($q){
            $q->with(['relCreatedUser','relToCompany','relToUser']);
        }])->get();

        foreach ($incomes as $income) {
            array_push($array, $income);
        }

        foreach ($outcomes as $outcome) {
            array_push($array, $outcome);
        }

        foreach ($motions as $motion) {
            array_push($array, $motion);
        }

        usort($array, array($this, 'merchantSort'));

        $ar['logs'] = $array;
        // dd($ar['item']);

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

    private function merchantSort($el1,$el2) {
        $datetime1 = strtotime( $el1->relIncome ? $el1->relIncome->updated_at : ($el1->relOutcome ? $el1->relOutcome->updated_at : $el1->relMotion->updated_at) );
        $datetime2 = strtotime( $el2->relIncome ? $el2->relIncome->updated_at : ($el2->relOutcome ? $el2->relOutcome->updated_at : $el2->relMotion->updated_at) );
        return $datetime1 - $datetime2;
    }

}

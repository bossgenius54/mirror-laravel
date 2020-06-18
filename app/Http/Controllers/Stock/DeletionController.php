<?php

namespace App\Http\Controllers\Stock;

use App\Model\Product;
use App\Http\Controllers\Controller;
use App\Model\Branch;
use App\Model\Deletion;
use App\Model\DeletionPosition;
use App\Model\DeletionStatus;
use App\Model\Income;
use App\Model\LibProductCat;
use App\Model\Position;
use App\Model\SysPositionStatus;
use App\ModelFilter\PositionFilter;
use App\ModelList\PositionList;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeletionController extends Controller
{
    private $title = 'Списание';

    function getIndex (Request $request){
        // $items = MotionList::get($request);
        // $items = MotionFilter::filter($request, $items);

        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['user'] = $request->user();

        $ar['items'] = Deletion::with('relCreatedUser','relBranch')->where('status_id', '<>', DeletionStatus::RETURNED)->get();

        return view('page.stock.deletion.index', $ar);
    }

    function getCreate (Request $request){
        $items = PositionList::get($request);
        $items = PositionFilter::filter($request, $items);

        $ar = array();
        $ar['title'] = 'Добавление в список списания';
        $ar['request'] = $request;
        $ar['user'] = $request->user();
        $ar['confirm_action'] = action('Stock\DeletionController@postConfirm');

        $ar['items'] = $items->with('relProduct')->where('status_id', SysPositionStatus::ACTIVE)->latest()->paginate(48);

        $ar['ar_branch'] = Branch::where('company_id', $request->user()->company_id)->pluck('name', 'id')->toArray();
        $ar['ar_incomes'] = Income::where('company_id', $request->user()->company_id)->get();
        $ar['ar_cat'] = LibProductCat::pluck('name', 'id')->toArray();
        $ar['p_options'] = LibProductCat::with('relProductOptions')->get();

        return view('page.stock.deletion.create', $ar);
    }

    function postConfirm(Request $request){

        $ar = array();

        $ar['title'] = 'Проверка товаров на списание';
        $ar['request'] = $request;

        $ar['items'] = Position::whereIn('id', $request->position_ids)->get();
        $ar['post_create'] = action('Stock\DeletionController@postCreate');

        return view('page.stock.deletion.confirm', $ar);
    }

    function postCreate(Request $request){
        $user = Auth::user();
        $pos = Position::with('relProduct')->whereIn('id', $request->position_id)->get();

        DB::beginTransaction();
        try {
            $item = new Deletion();
            $item->company_id = $user->company_id;
            $item->branch_id = $pos->first()->branch_id;
            $item->status_id = DeletionStatus::IN_WORK;
            $item->user_id = $user->id;
            $item->name = $request->name;
            $item->note = $request->note;
            $item->save();

            $positions = Position::whereIn('id', $request->position_id)
                                    ->update([ 'status_id' => SysPositionStatus::DELETED ]);

            foreach( $pos as $p ) {
                $i = new DeletionPosition();
                $i->deletion_id = $item->id;
                $i->product_id = $p->relProduct->id;
                $i->position_id = $p->id;
                $i->branch_id = $item->branch_id;
                $i->company_id = $item->company_id;
                $i->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage(), $request);
        }

        return redirect()->action("Stock\PositionController@getIndex")->with('success', 'Добавлен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getView(Request $request, Deletion $item){
        $ar = array();

        $ar['title'] = 'Список позиции на списании';
        $ar['request'] = $request;

        $ar['item'] = $item;
        $ar['positions'] = DeletionPosition::with('relProduct', 'relPosition')->where('deletion_id', $item->id)->get();
        // dd($ar);

        return view('page.stock.deletion.view', $ar);
    }

    function confirm(Request $request, Deletion $item){
        // dd($item);
        $item = Deletion::where('id', $item->id)->update(['status_id', DeletionStatus::CONFIRMED]);

        return redirect()->back()->with('msg', 'Списание подтверждено' );
    }

    function return(Request $request, Deletion $item){
        dd($item);
        $item = Deletion::where('id', $item->id)->update(['status_id', DeletionStatus::CONFIRMED]);

        return redirect()->back()->with('msg', 'Списание подтверждено' );
    }
}

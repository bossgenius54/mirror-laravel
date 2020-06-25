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
use App\ModelFilter\DeletionPositionFilter;
use App\ModelList\PositionList;
use App\ModelList\DeletionPositionList;
use Exception;
use Illuminate\Contracts\Session\Session;
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

        $ar['items'] = Deletion::with('relCreatedUser','relBranch', 'relDeletePosition')->where('status_id', '<>', DeletionStatus::RETURNED)->get();
        // dd($ar);

        return view('page.stock.deletion.index', $ar);
    }

    function getCreate (Request $request){
        $ar = array();

        if ($request->filtered && $request->filtered == 'true'){

            $items = DeletionPositionList::get($request);
            $items = DeletionPositionFilter::filter($request, $items);
            $items->with('relProduct','relStatus')->latest()->get();
            $count = $items->count();

            if ( $count > 400 ){
                $ar['items'] = $items->with('relProduct','relStatus')->latest()->take(400)->get();
                $ar['msg'] = 'Количество позиций превышает  число максимально возможное на списание. В списке показаны только 400 позиций из ' . $count;
            } else {
                $ar['msg'] = '';
                $ar['items'] = $items->with('relProduct','relStatus')->latest()->get();;
            }


        } else {
            $ar['msg'] = '';
            $ar['items'] = [];
        }

        $ar['title'] = 'Добавление в список списания';
        $ar['request'] = $request;
        $ar['user'] = $request->user();
        $ar['confirm_action'] = action('Stock\DeletionController@postConfirm');

        // Filter block elements
        $ar['ar_branch'] = Branch::where('company_id', $request->user()->company_id)->pluck('name', 'id')->toArray();
        $ar['product_names'] = Product::where('company_id', $request->user()->company_id)->get();
        $ar['product_sys_num'] = Product::where('company_id', $request->user()->company_id)->get();
        $ar['ar_incomes'] = Income::where('company_id', $request->user()->company_id)->get();
        $ar['ar_cat'] = LibProductCat::pluck('name', 'id')->toArray();
        $ar['ar_status'] = SysPositionStatus::whereIn('id', [
                                                                SysPositionStatus::ACTIVE,
                                                                SysPositionStatus::IN_MOTION,
                                                                SysPositionStatus::RESERVE,
                                                                SysPositionStatus::IN_INCOME
                                                            ])->get();
        $ar['motion_id'] = SysPositionStatus::IN_MOTION;
        $ar['reserve_id'] = SysPositionStatus::RESERVE;
        $ar['p_options'] = LibProductCat::with('relProductOptions')->get();
        // dd($ar['items']);

        return view('page.stock.deletion.create', $ar);
    }

    function postConfirm(Request $request){

        $ar = array();

        $ar['title'] = 'Проверка товаров на списание';
        $ar['request'] = $request;

        if( $request->position_ids && count($request->position_ids) > 0 ){
            $ar['items'] = Position::with('relBranch')->whereIn('id', $request->position_ids)->get();
            $ar['post_create'] = action('Stock\DeletionController@postCreate');
            $ar['back'] = action('Stock\DeletionController@getCreate');
        } else {
            return redirect()->back()->with('error', 'Выбранные элементы не найдены, перепроверьте и отправьте еще раз');
        }

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
        $ar['backList'] = action("Stock\DeletionController@getIndex");

        $ar['item'] = $item;
        $ar['creator'] = Auth::user($item->user_id);
        $ar['role'] = Auth::user($item->user_id)->getTypeName();
        // dd($ar);
        $ar['positions'] = DeletionPosition::with('relProduct', 'relPosition', 'relBranch')->where('deletion_id', $item->id)->get();
        // dd($ar);

        return view('page.stock.deletion.view', $ar);
    }

    function confirm(Request $request, Deletion $item){

        if($item->status_id == DeletionStatus::CONFIRMED)
            return redirect()->back()->with('error', 'Списание уже был подтвержден' );

        DB::beginTransaction();
        try {

            $item->update(['status_id' => DeletionStatus::CONFIRMED]);

            $del_pos = DeletionPosition::where('deletion_id', $item->id)->pluck('position_id')->toArray();
            // dd($del_pos);

            $positions = Position::whereIn('id', $del_pos)
                                    ->update([ 'status_id' => SysPositionStatus::DELETED ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage(), $request);
        }

        return redirect()->back()->with('msg', 'Списание подтверждено' );
    }

    function return(Request $request, Deletion $item){

        if($item->status_id == DeletionStatus::RETURNED)
            return redirect()->back()->with('error', 'Списание уже был возвращен в продажу' );

        DB::beginTransaction();
        try {

            $item->update(['status_id' => DeletionStatus::RETURNED]);

            $del_pos = DeletionPosition::where('deletion_id', $item->id)->pluck('position_id')->toArray();
            // dd($del_pos);

            $positions = Position::whereIn('id', $del_pos)
                                    ->update([ 'status_id' => SysPositionStatus::ACTIVE ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage(), $request);
        }

        return redirect()->action("Stock\DeletionController@getIndex")->with('msg', 'Списанные позиции возвращены на склад' );
    }
}

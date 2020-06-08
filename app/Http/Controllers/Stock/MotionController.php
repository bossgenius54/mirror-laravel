<?php
namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\ModelList\MotionList;

use App\Model\Motion;
use App\Model\SysMotionStatus;
use App\Model\MotionProduct;
use App\Model\MotionPosition;
use App\Model\Position;
use App\Model\SysPositionStatus;
use App\Model\Product;
use App\Model\Branch;

use App\Services\Finance\CreateFinanceModel;

use App\ModelFilter\MotionFilter;


use App\Model\Finance;
use App\Model\FinancePosition;
use App\Model\FinanceService;
use App\Model\SysFinanceType;
use App\Model\SysUserType;
use Illuminate\Support\Facades\Auth;

use DB;
use Exception;

class MotionController extends Controller{
    private $title = 'Перемещение';

    function getIndex (Request $request){
        $items = MotionList::get($request);
        $items = MotionFilter::filter($request, $items);

        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['user'] = $request->user();
        $ar['filter_block'] = MotionFilter::getFilterBlock($request);
        $ar['items'] = $items->with('relCreatedUser')->latest()->paginate(24);
        $user = Auth::user();

        $ar['user'] = $user;
        $ar['ar_status'] = SysMotionStatus::pluck('name', 'id')->toArray();
        $ar['ar_branch'] = Branch::where('company_id', $request->user()->company_id)->pluck('name', 'id')->toArray();

        return view('page.stock.motion.index', $ar);
    }

    function getView(Request $request, Motion $item){
        $ar = array();
        $ar['title'] = 'Изменить элемент № '. $item->id.' списка "'.$this->title.'"';
        $ar['item'] = $item;
        $ar['user'] = Auth::user();
        $ar['ar_branch'] = Branch::where('company_id', $request->user()->company_id)->pluck('name', 'id')->toArray();
        $ar['products'] = Product::where('company_id', $request->user()->company_id)
                                    ->whereHas('relPositions', function($q) use ($item){
                                        $q->where('branch_id', $item->from_branch_id)->where('status_id', SysPositionStatus::ACTIVE);
                                    })->get();
        $ar['action'] = action('Stock\MotionController@postUpdate', $item);
        $ar['pos_status'] = SysPositionStatus::ACTIVE;
        $ar['motion_products'] = MotionProduct::where('motion_id', $item->id)->with('relProduct')->get();
        // dd($ar['motion_products']);

        return view('page.stock.motion.view', $ar);
    }

    function getCreate(Request $request){
        $ar = array();
        $ar['title'] = 'Добавить элемент в список "'.$this->title.'"';
        $ar['action'] = action('Stock\MotionController@postCreate');
        $ar['ar_branch_from'] = Branch::where('company_id', $request->user()->company_id)->byRole()->pluck('name', 'id')->toArray();
        $ar['ar_branch_to'] = Branch::where('company_id', $request->user()->company_id)->pluck('name', 'id')->toArray();

        return view('page.stock.motion.create', $ar);
    }

    function postCreate(Request $request){
        $ar = $request->all();
        $ar['company_id'] = $request->user()->company_id;
        $ar['status_id'] = SysMotionStatus::IN_WORK;
        $ar['user_id'] = $request->user()->id;

        DB::beginTransaction();
        try {
            $item = Motion::create($ar);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->action('Stock\MotionController@getUpdate', $item)->with('success', 'Добавлен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getUpdate(Request $request, Motion $item){
        $ar = array();
        $ar['title'] = 'Изменить элемент № '. $item->id.' списка "'.$this->title.'"';
        $ar['item'] = $item;
        $ar['user'] = Auth::user();
        $ar['ar_branch'] = Branch::where('company_id', $request->user()->company_id)->pluck('name', 'id')->toArray();
        $ar['products'] = Product::where('company_id', $request->user()->company_id)
                                    ->whereHas('relPositions', function($q) use ($item){
                                        $q->where('branch_id', $item->from_branch_id)->where('status_id', SysPositionStatus::ACTIVE);
                                    })->get();
        $ar['action'] = action('Stock\MotionController@postUpdate', $item);
        $ar['pos_status'] = SysPositionStatus::ACTIVE;
        $ar['motion_products'] = MotionProduct::where('motion_id', $item->id)->with('relProduct')->get();

        // dd($ar['products']);

        return view('page.stock.motion.update', $ar);
    }

    function postUpdate(Request $request, Motion $item){
        if (MotionProduct::where(['motion_id'=>$item->id, 'product_id'=>$request->product_id])->count() > 0)
            return redirect()->back()->with('error', 'Указанный ассртимент в списке');

        if (Position::where('product_id', $request->product_id)->where('branch_id', $item->from_branch_id)->where('status_id', SysPositionStatus::ACTIVE)->count() < $request->count_position)
            return redirect()->back()->with('error', 'Позиции не хватает');

        DB::beginTransaction();
        try {
            // create motion product
            $motion_product = MotionProduct::create([
                'motion_id' => $item->id,
                'product_id' => $request->product_id,
                'count_position' => $request->count_position
            ]);

            // update positon status to in motion and create motion product
            $ar_position = Position::where('product_id', $request->product_id)
                                    ->where('branch_id', $item->from_branch_id)
                                    ->where('status_id', SysPositionStatus::ACTIVE)
                                    ->orderBy('id', 'asc')->take($request->count_position)->pluck('sys_num')->toArray();

            Position::whereIn('sys_num', $ar_position)->update(['status_id'=>SysPositionStatus::IN_MOTION, 'motion_id' => $item->id]);
            $insert = [];
            foreach ($ar_position as $pos_id){
                $insert[] = [
                    'motion_id' => $item->id,
                    'position_sys_num' => $pos_id,
                    'motion_product_id' => $motion_product->id
                ];
            }
            MotionPosition::insert($insert);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'У перемещения № '.$item->id.' прикрепелны товары');
    }

    function getUnsetProduct(Request $request, Motion $item, MotionProduct $motion_product){
        DB::beginTransaction();
        try {
            $ar_position = MotionPosition::where(['motion_id' => $item->id,
                                                'motion_product_id' => $motion_product->id])->pluck('position_sys_num')->toArray();

            Position::whereIn('sys_num', $ar_position)->update(['status_id'=>SysPositionStatus::ACTIVE, 'motion_id' => null]);
            $motion_product->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'У перемещения № '.$item->id.' откреплены товары');
    }

    function getConfirm(Request $request, Motion $item) {
        $item->update(['status_id' => SysMotionStatus::CONFIRMED]);

        return redirect()->action('Stock\MotionController@getIndex')->with('success', 'Подтвержден и отправлен "'.$this->title.'" № '.$item->id);
    }

    function getFinish(Request $request, Motion $item){
        DB::beginTransaction();
        try {
            CreateFinanceModel::createMove($item);

            $ar_position = MotionPosition::where(['motion_id' => $item->id])->pluck('position_sys_num')->toArray();
            Position::whereIn('sys_num', $ar_position)->update([
                'status_id' => SysPositionStatus::ACTIVE,
                'branch_id' => $item->to_branh_id,
                'motion_id' => null
            ]);

            $item->update(['status_id' => SysMotionStatus::FINISH]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->action('Stock\MotionController@getIndex')->with('success', 'Изменен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getCanceled(Request $request, Motion $item){
        DB::beginTransaction();
        try {
            $ar_position = MotionPosition::where(['motion_id' => $item->id])->pluck('position_sys_num')->toArray();
            Position::whereIn('sys_num', $ar_position)->update(['status_id'=>SysPositionStatus::ACTIVE, 'motion_id' => null]);

            MotionProduct::where([
                'motion_id' => $item->id
            ])->delete();

            $item->update(['status_id' => SysMotionStatus::CANCEL]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->action('Stock\MotionController@getIndex')->with('success', 'Отменен элемент списка "'.$this->title.'" № '.$item->id);
    }

}

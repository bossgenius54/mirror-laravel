<?php
namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Order;

use App\Model\SysPositionStatus;
use App\Model\OrderPosition;
use App\Model\Position;
use App\Model\Product;
use App\Model\SysOrderType;
use App\Model\SysUserType;
use App\ModelFilter\PositionFilter;
use App\ModelList\PositionList;
use DB;
use Exception;
use SysPositionStatusAddSold;

class PositionOrderController extends Controller{
    private $title = 'Заказы/Розница';

    function postAddProduct(Request $request, Order $item){
        if (OrderPosition::where(['order_id' => $item->id, 'product_id' => $request->product_id])->count() > 0)
            return redirect()->back()->with('error', 'Указанный товар уже есть');

        if ($request->pos_count > 5 && $request->is_retail)
            return redirect()->back()->with('error', 'Запрещено покупать больше 5 товаров в розницу');

        $cost = $request->pos_cost;
        if ($request->user()->type_id == SysUserType::FIZ || $request->user()->type_id == SysUserType::COMPANY_CLIENT){
            $product = Product::findOrFail($request->product_id);
            $cost = $product->price_retail;

        }

        DB::beginTransaction();
        try {
            $order_product = OrderPosition::create([
                'order_id' => $item->id,
                'product_id' => $request->product_id,
                'pos_count' => $request->pos_count,
                'pos_cost' => $cost,
                'total_sum' => ($request->pos_count * $request->pos_cost)
            ]);

            Position::where(['status_id' => SysPositionStatus::ACTIVE, 'product_id'=> $request->product_id])->where('branch_id', $item->branch_id)->orderBy('id', 'asc')->take($request->pos_count)
                    ->update(['status_id' => SysPositionStatus::RESERVE, 'order_id' => $item->id]);

            $item->update([
                'total_sum' => ($item->total_sum + $order_product->total_sum)
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Ассортимент добавлен "'.$this->title.'" № '.$item->id);

    }

    function getDeleteProduct(Request $request, Order $item, OrderPosition $order_product){
        DB::beginTransaction();
        try {
            $item->update([
                'total_sum' => ($item->total_sum - $order_product->total_sum)
            ]);

            Position::where(['status_id' => SysPositionStatus::RESERVE, 'order_id'=> $item->id])
                    ->update(['status_id' => SysPositionStatus::ACTIVE, 'order_id' =>null]);

            $order_product->delete();


            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Ассортимент удален "'.$this->title.'" № '.$item->id);
    }

    function basketAddProduct(Request $request, Order $item){

        if( Position::whereIn('id',$request->position_id)->where('order_id', $item->id)->where('status_id', SysPositionStatus::RESERVE)->count() > 0 ){
            return redirect()->back()->with('error', 'Указанный товар уже есть');
        }

        DB::beginTransaction();
        try {

            $positions = Position::with('relProduct')->whereIn('id', $request->position_id)->get();
            // dd($positions);

            foreach( $positions as $p )
            {
                $order_product = OrderPosition::create([
                    'order_id' => $item->id,
                    'product_id' => $p->product_id,
                    'pos_count' => 1,
                    'pos_cost' => $p->relProduct->price_retail,
                    'total_sum' => (1 * $p->relProduct->price_retail)
                ]);

                Position::where(['status_id' => SysPositionStatus::ACTIVE, 'product_id'=> $p->product_id])->where('branch_id', $item->branch_id)
                    ->where('id', $p->id)
                    ->orderBy('id', 'asc')
                    ->update(['status_id' => SysPositionStatus::RESERVE, 'order_id' => $item->id]);


                $item->update([
                    'total_sum' => ($item->total_sum + $order_product->total_sum)
                ]);
            }


            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->action('Order\ViewController@getView', $item)->with('success', 'Ассортимент добавлен "'.$this->title.'" № '.$item->id);

    }


}

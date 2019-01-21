<?php
namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Product;
use App\Model\ProductOption;
use App\Model\LibProductCat;
use App\Model\LibProductType;
use App\Model\LibProductOption;

use DB;
use Exception;

class ProductController extends Controller{
    private $title = 'Ассортимент товаров';

    function getIndex (Request $request){
        $ar = array();
        $ar['title'] = 'Список елементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = Product::where('company_id', $request->user()->company_id)->latest()->paginate(24);
        $ar['ar_cat'] = LibProductCat::getAr();

        return view('page.stock.product.index', $ar);
    }

    function getCreate(Request $request, LibProductCat $cat){
        $ar = array();
        $ar['title'] = 'Добавить елемент в список "'.$this->title.'", категория "'.$cat->name.'"';
        $ar['action'] = action('Stock\ProductController@postCreate', $cat);
        $ar['types'] = LibProductType::where('cat_id', $cat->id)->with('relOptions')->orderBy('id', 'asc')->get();

        return view('page.stock.product.create', $ar);
    }

    function postCreate(Request $request, LibProductCat $cat){
        $this->generateSysName($request, $cat);

        $ar = $request->all();
        $ar['company_id'] = $request->user()->company_id;
        $ar['cat_id'] = $cat->id;
        $ar['sys_num'] = $this->sys_name;

        if (Product::where([    'company_id' => $request->user()->company_id,
                                'cat_id' => $cat->id,
                                'sys_num' => $this->sys_name])->count() > 0)
            return redirect()->back()->with('error', 'Указанный ассортимент уже присутствует');

        DB::beginTransaction();
        try {
            $item = Product::create($ar);
            $lib_options = LibProductOption::whereIn('id', $this->ar_option)->where('cat_id', $cat->id)->get();
            foreach ($lib_options as $o) {
                $option = ProductOption::create([
                    'product_id' => $item->id, 
                    'option_id' => $o->id, 
                    'label' => $o->label, 
                    'name' => $o->option_name, 
                    'val' => $o->option_val 
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
        
        return redirect()->action("Stock\ProductController@getIndex")->with('success', 'Добавлен елемент списка "'.$this->title.'" № '.$item->id);
    }

    function getUpdate(Request $request, Product $item){
        $cat = LibProductCat::findOrFail($item->cat_id);

        $ar = array();
        $ar['title'] = 'Изменить елемент № '. $item->id.' списка "'.$this->title.'"';
        $ar['item'] = $item;
        $ar['ar_sel_option'] = $item->relOptions()->pluck('option_id')->toArray();
        $ar['types'] = LibProductType::where('cat_id', $cat->id)->with('relOptions')->orderBy('id', 'asc')->get();
        $ar['action'] = action('Stock\ProductController@postUpdate', $item);

        return view('page.stock.product.update', $ar);
    }

    function postUpdate(Request $request, Product $item){
        $cat = LibProductCat::findOrFail($item->cat_id);
        $this->generateSysName($request, $cat);

        $ar = $request->all();
        $ar['company_id'] = $request->user()->company_id;
        $ar['cat_id'] = $cat->id;
        $ar['sys_num'] = $this->sys_name;

        if (Product::where([    'company_id' => $request->user()->company_id,
                                'cat_id' => $cat->id,
                                'sys_num' => $this->sys_name])->where('id', '<>', $item->id)->count() > 0)
            return redirect()->back()->with('error', 'Указанный ассортимент уже присутствует');
        
        DB::beginTransaction();
        try {
            $item->update($ar);
            ProductOption::where('product_id', $item->id)->delete();

            $lib_options = LibProductOption::whereIn('id', $this->ar_option)->where('cat_id', $cat->id)->get();
            foreach ($lib_options as $o) {
                $option = ProductOption::create([
                    'product_id' => $item->id, 
                    'option_id' => $o->id, 
                    'label' => $o->label, 
                    'name' => $o->option_name, 
                    'val' => $o->option_val 
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->action("Stock\ProductController@getIndex")->with('success', 'Изменен елемент списка "'.$this->title.'" № '.$item->id);
    }

    function getDelete(Request $request, Product $item){
        $id = $item->id;
        $item->delete();

        return redirect()->back()->with('success', 'Удален елемент списка "'.$this->title.'" № '.$id);
    }

    private function generateSysName(Request $request, LibProductCat $cat){
        $ar = $request->all();
        $this->ar_option = [];

        $this->sys_name = $cat->id;
        if (isset($ar['option']) && count($ar['option'])) {
            $this->sys_name .= '/';

            foreach ($ar['option'] as $type_id => $option_id){
                $this->sys_name .= $option_id.'-';
                if ($option_id > 0)
                    $this->ar_option[] = $option_id;
            }
            $this->sys_name = mb_substr($this->sys_name, 0, -1);
        }
        

    }
}

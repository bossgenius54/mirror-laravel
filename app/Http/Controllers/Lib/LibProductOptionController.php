<?php
namespace App\Http\Controllers\Lib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\LibProductOption;
use App\Model\LibProductCat;
use App\Model\LibProductType;

class LibProductOptionController extends Controller{
    private $title = 'Опции товаров';

    function getIndex (Request $request){
        $items = LibProductOption::where('id', '>', 0);

        if ($request->cat_name)
            $items->whereHas('relCat', function($q) use ($request){
                $q->where('name', 'like', '%'.$request->cat_name.'%');
            });
        if ($request->type_name)
            $items->whereHas('relType', function($q) use ($request){
                $q->where('name', 'like', '%'.$request->type_name.'%');
            });
        if ($request->option_name)
            $items->where('option_name', 'like', '%'.$request->option_name.'%');
        if ($request->option_val)
            $items->where('option_val', 'like', '%'.$request->option_val.'%');
         

        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = $items->latest()->paginate(24);
        $ar['ar_cat'] = LibProductCat::getAr();

        return view('page.lib.product_option.index', $ar);
    }

    function getCreate(Request $request){
        $ar = array();
        $ar['title'] = 'Добавить элемент в список "'.$this->title.'"';
        $ar['action'] = action('Lib\LibProductOptionController@postCreate');
        $ar['ar_type'] = LibProductType::getArWithCat();

        return view('page.lib.product_option.create', $ar);
    }

    function postCreate(Request $request){
        $ar = $request->all();
        
        $type = LibProductType::findOrFail($request->type_id);
        $ar['cat_id'] = $type->cat_id;
        $ar['label'] = $type->name;

        $item = LibProductOption::create($ar);
        
        return redirect()->action("Lib\LibProductOptionController@getIndex")->with('success', 'Добавлен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getUpdate(Request $request, LibProductOption $item){
        $ar = array();
        $ar['title'] = 'Изменить элемент № '. $item->id.' списка "'.$this->title.'"';
        $ar['item'] = $item;
        $ar['ar_type'] = LibProductType::getArWithCat();
        $ar['action'] = action('Lib\LibProductOptionController@postUpdate', $item);

        return view('page.lib.product_option.update', $ar);
    }

    function postUpdate(Request $request, LibProductOption $item){
        $ar = $request->all();
        if ($request->type_id){
            $type = LibProductType::findOrFail($request->type_id);
            $ar['cat_id'] = $type->cat_id;
            $ar['label'] = $type->name;
        }
        elseif (isset($ar['cat_id'] ))
            unset($ar['cat_id'] );
       

        $item->update($ar);

        return redirect()->action("Lib\LibProductOptionController@getIndex")->with('success', 'Изменен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getDelete(Request $request, LibProductOption $item){
        $id = $item->id;
        $item->delete();

        return redirect()->back()->with('success', 'Удален элемент списка "'.$this->title.'" № '.$id);
    }
}

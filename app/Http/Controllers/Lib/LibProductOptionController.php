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
        $ar = array();
        $ar['title'] = 'Список елементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = LibProductOption::latest()->paginate(24);
        $ar['ar_cat'] = LibProductCat::getAr();

        return view('page.lib.product_option.index', $ar);
    }

    function getCreate(Request $request){
        $ar = array();
        $ar['title'] = 'Добавить елемент в список "'.$this->title.'"';
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
        
        return redirect()->action("Lib\LibProductOptionController@getIndex")->with('success', 'Добавлен елемент списка "'.$this->title.'" № '.$item->id);
    }

    function getUpdate(Request $request, LibProductOption $item){
        $ar = array();
        $ar['title'] = 'Изменить елемент № '. $item->id.' списка "'.$this->title.'"';
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

        return redirect()->action("Lib\LibProductOptionController@getIndex")->with('success', 'Изменен елемент списка "'.$this->title.'" № '.$item->id);
    }

    function getDelete(Request $request, LibProductOption $item){
        $id = $item->id;
        $item->delete();

        return redirect()->back()->with('success', 'Удален елемент списка "'.$this->title.'" № '.$id);
    }
}

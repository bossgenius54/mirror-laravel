<?php
namespace App\Http\Controllers\Lib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\LibProductType;
use App\Model\LibProductCat;

class LibProductTypeController extends Controller{
    private $title = 'Виды опций товаров';

    function getIndex (Request $request){
        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = LibProductType::latest()->paginate(24);
        $ar['ar_cat'] = LibProductCat::getAr();

        return view('page.lib.product_type.index', $ar);
    }

    function getCreate(Request $request){
        $ar = array();
        $ar['title'] = 'Добавить элемент в список "'.$this->title.'"';
        $ar['action'] = action('Lib\LibProductTypeController@postCreate');
        $ar['ar_cat'] = LibProductCat::getAr();

        return view('page.lib.product_type.create', $ar);
    }

    function postCreate(Request $request){
        $item = LibProductType::create($request->all());
        
        return redirect()->action("Lib\LibProductTypeController@getIndex")->with('success', 'Добавлен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getUpdate(Request $request, LibProductType $item){
        $ar = array();
        $ar['title'] = 'Изменить элемент № '. $item->id.' списка "'.$this->title.'"';
        $ar['item'] = $item;
        $ar['ar_cat'] = LibProductCat::getAr();
        $ar['action'] = action('Lib\LibProductTypeController@postUpdate', $item);

        return view('page.lib.product_type.update', $ar);
    }

    function postUpdate(Request $request, LibProductType $item){
        $item->update($request->all());

        return redirect()->action("Lib\LibProductTypeController@getIndex")->with('success', 'Изменен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getDelete(Request $request, LibProductType $item){
        $id = $item->id;
        $item->delete();

        return redirect()->back()->with('success', 'Удален элемент списка "'.$this->title.'" № '.$id);
    }
}

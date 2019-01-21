<?php
namespace App\Http\Controllers\Lib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\LibProductCat;

class LibProductCatController extends Controller{
    private $title = 'Категории товаров';

    function getIndex (Request $request){
        $ar = array();
        $ar['title'] = 'Список елементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = LibProductCat::latest()->paginate(24);

        return view('page.lib.product_cat.index', $ar);
    }

    function getCreate(Request $request){
        $ar = array();
        $ar['title'] = 'Добавить елемент в список "'.$this->title.'"';
        $ar['action'] = action('Lib\LibProductCatController@postCreate');

        return view('page.lib.product_cat.create', $ar);
    }

    function postCreate(Request $request){
        $item = LibProductCat::create($request->all());
        
        return redirect()->action("Lib\LibProductCatController@getIndex")->with('success', 'Добавлен елемент списка "'.$this->title.'" № '.$item->id);
    }

    function getUpdate(Request $request, LibProductCat $item){
        $ar = array();
        $ar['title'] = 'Изменить елемент № '. $item->id.' списка "'.$this->title.'"';
        $ar['item'] = $item;
        $ar['action'] = action('Lib\LibProductCatController@postUpdate', $item);

        return view('page.lib.product_cat.update', $ar);
    }

    function postUpdate(Request $request, LibProductCat $item){
        $item->update($request->all());

        return redirect()->action("Lib\LibProductCatController@getIndex")->with('success', 'Изменен елемент списка "'.$this->title.'" № '.$item->id);
    }

    function getDelete(Request $request, LibProductCat $item){
        $id = $item->id;
        $item->delete();

        return redirect()->back()->with('success', 'Удален елемент списка "'.$this->title.'" № '.$id);
    }
}

<?php
namespace App\Http\Controllers\Lib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\LibCompanyCat;

class LibCompanyCatController extends Controller{
    private $title = 'Формы собственности';

    function getIndex (Request $request){
        $ar = array();
        $ar['title'] = 'Список елементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = LibCompanyCat::latest()->paginate(24);

        return view('page.lib.company_cat.index', $ar);
    }

    function getCreate(Request $request){
        $ar = array();
        $ar['title'] = 'Добавить елемент в список "'.$this->title.'"';
        $ar['action'] = action('Lib\LibCompanyCatController@postCreate');

        return view('page.lib.company_cat.create', $ar);
    }

    function postCreate(Request $request){
        $item = LibCompanyCat::create($request->all());
        
        return redirect()->action("Lib\LibCompanyCatController@getIndex")->with('success', 'Добавлен елемент списка "'.$this->title.'" № '.$item->id);
    }

    function getUpdate(Request $request, LibCompanyCat $item){
        $ar = array();
        $ar['title'] = 'Изменить елемент № '. $item->id.' списка "'.$this->title.'"';
        $ar['item'] = $item;
        $ar['action'] = action('Lib\LibCompanyCatController@postUpdate', $item);

        return view('page.lib.company_cat.update', $ar);
    }

    function postUpdate(Request $request, LibCompanyCat $item){
        $item->update($request->all());

        return redirect()->action("Lib\LibCompanyCatController@getIndex")->with('success', 'Изменен елемент списка "'.$this->title.'" № '.$item->id);
    }

    function getDelete(Request $request, LibCompanyCat $item){
        $id = $item->id;
        $item->delete();

        return redirect()->back()->with('success', 'Удален елемент списка "'.$this->title.'" № '.$id);
    }
}

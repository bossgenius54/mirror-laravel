<?php
namespace App\Http\Controllers\Lib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\CompanyService;
use App\ModelList\CompanyServiceList;

class CompanyServiceController extends Controller{
    private $title = 'Услуги';

    function getIndex (Request $request){
        $ar = array();
        $ar['title'] = 'Список елементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = CompanyServiceList::get($request)->latest()->paginate(24);

        return view('page.lib.company_service.index', $ar);
    }

    function getCreate(Request $request){
        $ar = array();
        $ar['title'] = 'Добавить елемент в список "'.$this->title.'"';
        $ar['action'] = action('Lib\CompanyServiceController@postCreate');

        return view('page.lib.company_service.create', $ar);
    }

    function postCreate(Request $request){
        $ar = $request->all();
        $ar['company_id'] = $request->user()->company_id;
        $item = CompanyService::create($ar);
        
        return redirect()->action("Lib\CompanyServiceController@getIndex")->with('success', 'Добавлен елемент списка "'.$this->title.'" № '.$item->id);
    }

    function getUpdate(Request $request, CompanyService $item){
        $ar = array();
        $ar['title'] = 'Изменить елемент № '. $item->id.' списка "'.$this->title.'"';
        $ar['item'] = $item;
        $ar['action'] = action('Lib\CompanyServiceController@postUpdate', $item);

        return view('page.lib.company_service.update', $ar);
    }

    function postUpdate(Request $request, CompanyService $item){
        $ar = $request->all();
        $ar['company_id'] = $request->user()->company_id;

        $item->update($ar);

        return redirect()->action("Lib\CompanyServiceController@getIndex")->with('success', 'Изменен елемент списка "'.$this->title.'" № '.$item->id);
    }

    function getDelete(Request $request, CompanyService $item){
        $id = $item->id;
        $item->delete();

        return redirect()->back()->with('success', 'Удален елемент списка "'.$this->title.'" № '.$id);
    }
}

<?php
namespace App\Http\Controllers\Lib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\CompanyService;
use App\ModelList\CompanyServiceList;

use App\ModelFilter\CompanyServiceFilter;

class CompanyServiceController extends Controller{
    private $title = 'Услуги';

    function getIndex (Request $request){
        $items = CompanyServiceList::get($request);
        $items = CompanyServiceFilter::filter($request, $items);

        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['filter_block'] = CompanyServiceFilter::getFilterBlock($request);
        $ar['items'] = $items->latest()->paginate(24);

        return view('page.lib.company_service.index', $ar);
    }

    function getCreate(Request $request){
        $ar = array();
        $ar['title'] = 'Добавить элемент в список "'.$this->title.'"';
        $ar['action'] = action('Lib\CompanyServiceController@postCreate');

        return view('page.lib.company_service.create', $ar);
    }

    function postCreate(Request $request){
        $ar = $request->all();
        $ar['company_id'] = $request->user()->company_id;
        $item = CompanyService::create($ar);
        
        return redirect()->action("Lib\CompanyServiceController@getIndex")->with('success', 'Добавлен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getUpdate(Request $request, CompanyService $item){
        $ar = array();
        $ar['title'] = 'Изменить элемент № '. $item->id.' списка "'.$this->title.'"';
        $ar['item'] = $item;
        $ar['action'] = action('Lib\CompanyServiceController@postUpdate', $item);

        return view('page.lib.company_service.update', $ar);
    }

    function postUpdate(Request $request, CompanyService $item){
        $ar = $request->all();
        $ar['company_id'] = $request->user()->company_id;

        $item->update($ar);

        return redirect()->action("Lib\CompanyServiceController@getIndex")->with('success', 'Изменен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getDelete(Request $request, CompanyService $item){
        $id = $item->id;
        $item->delete();

        return redirect()->back()->with('success', 'Удален элемент списка "'.$this->title.'" № '.$id);
    }
}

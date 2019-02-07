<?php
namespace App\Http\Controllers\Lib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Branch;
use App\Model\BranchData;
use App\ModelList\BranchList;

use DB;
use Exception;

class BranchController extends Controller{
    private $title = 'Филиалы';

    function getIndex (Request $request){
        $items = BranchList::get($request);

        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = $items->latest()->paginate(24);
        $ar['ar_lib'] = BranchList::getLibAr();

        return view('page.lib.branch.index', $ar);
    }

    function getCreate(Request $request){
        $ar = array();
        $ar['title'] = 'Добавить элемент в список "'.$this->title.'"';
        $ar['action'] = action('Lib\BranchController@postCreate');
        $ar['ar_lib'] = BranchList::getLibAr();

        return view('page.lib.branch.create', $ar);
    }

    function postCreate(Request $request){
        DB::beginTransaction();

        try {
            $ar = $request->all();
            $ar['user_id'] = $request->user()->id;
            
            $item = Branch::create($ar);
            $ar['branch_id'] = $item->id;
            $data = BranchData::create($ar);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
       
        
        return redirect()->action("Lib\BranchController@getIndex")->with('success', 'Добавлен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getUpdate(Request $request, Branch $item){
        $ar = array();
        $ar['title'] = 'Изменить элемент № '. $item->id.' списка "'.$this->title.'"';
        $ar['item'] = $item;
        $ar['data'] = $item->relData;
        $ar['ar_lib'] = BranchList::getLibAr();
        $ar['action'] = action('Lib\BranchController@postUpdate', $item);

        return view('page.lib.branch.update', $ar);
    }

    function postUpdate(Request $request, Branch $item){
        DB::beginTransaction();

        try {
            $ar = $request->all();
            $item->update($ar);
            
            $data = $item->relData;
            $data->update($ar);
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->action("Lib\BranchController@getIndex")->with('success', 'Изменен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getDelete(Request $request, Branch $item){
        $id = $item->id;
        $item->delete();

        return redirect()->back()->with('success', 'Удален элемент списка "'.$this->title.'" № '.$id);
    }

}

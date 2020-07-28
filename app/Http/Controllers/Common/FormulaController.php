<?php
namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Model\ClientsLog;
use App\Model\ClientsLogType;
use Illuminate\Http\Request;

use App\Model\Formula;
use App\Model\View\Individ;
use App\Model\SysUserType;
use App\ModelFilter\FormulaFilter;
use App\ModelList\FormulaList;
use App\User;
use Illuminate\Support\Facades\Auth;

class FormulaController extends Controller{
    private $title = 'Рецепты';

    function getIndex (Request $request){
        $ar = array();

        $items = FormulaList::get($request);
        $item = FormulaFilter::filter($request,$items);

        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = $items->latest()->paginate(24);
        $ar['doctors'] = User::where('type_id',SysUserType::DOCTOR)->get();
        $ar['ar_propose'] = Formula::getProposeAr();
        $ar['simple_type_id'] = Formula::SIMPLE_TYPE_ID;
        $ar['contact_type_id'] = Formula::CONTACT_TYPE_ID;

        return view('page.common.formula.index', $ar);
    }

    function getCreate(Request $request, Individ $user){
        $type_id = Formula::SIMPLE_TYPE_ID;
        if ($request->type_id == Formula::CONTACT_TYPE_ID)
            $type_id = Formula::CONTACT_TYPE_ID;

        $ar = array();
        $ar['title'] = 'Добавить элемент в список "'.$this->title.'"';
        $ar['action'] = action('Common\FormulaController@postCreate', $user);
        $ar['ar_propose'] = Formula::getProposeAr();
        $ar['type_id'] = $type_id;
        $ar['user'] = $user;
        $ar['contact_type_id'] = Formula::CONTACT_TYPE_ID;

        return view('page.common.formula.create', $ar);
    }

    function postCreate(Request $request, Individ $user){
        $ar = $request->all();
        $ar['user_id'] = $user->id;
        $ar['created_user_id'] = $request->user()->id;
        $item = Formula::create($ar);

        if($item){
            $vars = [];
            $vars['user'] = Auth::user();
            $vars['client'] = $user;
            $vars['type_id'] = ClientsLogType::RECEIPT_WRITED;
            $vars['receipt_id'] = $item->id;

            $log = ClientsLog::writeLog($vars);
        }

        // $user->update(['name' => $request->user_name]);

        return redirect()->action("Common\FormulaController@getIndex", ['user_id'=> $user->id])->with('success', 'Добавлен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getUpdate(Request $request, Individ $user, Formula $item){
        $ar = array();
        $ar['title'] = 'Изменить элемент в список "'.$this->title.'"';
        $ar['action'] = action('Common\FormulaController@postUpdate', [$user, $item]);
        $ar['ar_propose'] = Formula::getProposeAr();
        $ar['user'] = $user;
        $ar['item'] = $item;

        return view('page.common.formula.update', $ar);
    }

    function postUpdate(Request $request, Individ $user, Formula $item){
        $ar = $request->all();
        $item->update($ar);

        $user->update(['name' => $request->user_name]);

        return redirect()->action("Common\FormulaController@getIndex", ['user_id'=> $user->id])->with('success', 'Изменен элемент списка "'.$this->title.'" № '.$item->id);
    }


    function getDelete(Request $request, Formula $item){
        $id = $item->id;
        $item->delete();

        return redirect()->back()->with('success', 'Удален элемент списка "'.$this->title.'" № '.$id);
    }
}

<?php
namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Formula;
use App\Model\View\Individ;
use App\Model\SysUserType;
use App\ModelList\FormulaList;

class FormulaController extends Controller{
    private $title = 'Рецепты';

    function getIndex (Request $request){
        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = FormulaList::get($request)->latest()->paginate(24);
        $ar['ar_propose'] = Formula::getProposeAr();
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

        $user->update(['name' => $request->user_name]);
        
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

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
    
    private function getItems(Request $request){
        $user = $request->user();
        
        $items = Formula::where('id', '>', 0);
        if ($user->type_id == SysUserType::FIZ)
            $items->where('user_id', $user->id);
        else if (in_array($user->type_id, [SysUserType::DIRECTOR, SysUserType::MANAGER, SysUserType::DOCTOR, SysUserType::EXTERNAL_DOCTOR]))
            $items->whereHas('relIndivid', function($q) use ($user){
                $q->whereHas('relSeller', function($b) use ($user){
                    $b->where('company_id', $user->company_id);
                });
            });
        
        if ($request->has('user_id') && $request->user_id){
            $items->where('user_id', $request->user_id);
        }
            
        return $items;
    }

    function getIndex (Request $request){
        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = FormulaList::get($request)->latest()->paginate(24);
        $ar['ar_propose'] = Formula::getProposeAr();

        return view('page.common.formula.index', $ar);
    }

    function getCreate(Request $request, Individ $user){
        $ar = array();
        $ar['title'] = 'Добавить элемент в список "'.$this->title.'"';
        $ar['action'] = action('Common\FormulaController@postCreate', $user);
        $ar['ar_propose'] = Formula::getProposeAr();

        return view('page.common.formula.create', $ar);
    }

    function postCreate(Request $request, Individ $user){
        $ar = $request->all();
        $ar['user_id'] = $user->id;
        $ar['created_user_id'] = $request->user()->id;
        $item = Formula::create($ar);
        
        return redirect()->action("Common\FormulaController@getIndex", ['user_id'=> $user->id])->with('success', 'Добавлен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getDelete(Request $request, Formula $item){
        $id = $item->id;
        $item->delete();

        return redirect()->back()->with('success', 'Удален элемент списка "'.$this->title.'" № '.$id);
    }
}

<?php
namespace App\Http\Controllers\Lib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use App\Helper\UploadPhoto;

use App\Model\View\Manager;
use App\Model\Branch;
use App\Model\SysUserType;
use App\ModelList\ManagerList;

use App\ModelFilter\UserFilter;

class ManagerController extends Controller{
    private $title = 'Менеджеры';

    function getIndex (Request $request){
        $items = ManagerList::get($request);
        $items = UserFilter::filter($request, $items);

        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['filter_block'] = UserFilter::getFilterBlock($request);
        $ar['items'] = $items->latest()->paginate(24);
        $ar['ar_branch'] = Branch::getArForCompany($request);

        return view('page.lib.manager.index', $ar);
    }

    function getCreate(Request $request){
        $ar = array();
        $ar['title'] = 'Добавить элемент в список "'.$this->title.'"';
        $ar['action'] = action('Lib\ManagerController@postCreate');
        $ar['ar_branch'] = Branch::getArForCompany($request);

        return view('page.lib.manager.create', $ar);
    }

    function postCreate(Request $request){
        if (Manager::where(['email' => $request->email])->count() > 0)
            return redirect()->back()->with('error', 'Указанный почтовый адрес уже используется');

        $ar = $request->all();
        $ar['type_id'] = SysUserType::MANAGER;
        $ar['is_active'] = 1;
        $ar['password'] = Hash::make($ar['password']);
        $ar['company_id'] = $request->user()->company_id;
        
        $ar['photo'] = UploadPhoto::upload($request->photo);
        if (!$ar['photo'])
            unset($ar['photo']);

        $item = Manager::create($ar);
        
        return redirect()->action("Lib\ManagerController@getIndex")->with('success', 'Добавлен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getUpdate(Request $request, Manager $item){
        $ar = array();
        $ar['title'] = 'Изменить элемент № '. $item->id.' списка "'.$this->title.'"';
        $ar['item'] = $item;
        $ar['ar_branch'] = Branch::getArForCompany($request);
        $ar['action'] = action('Lib\ManagerController@postUpdate', $item);

        return view('page.lib.manager.update', $ar);
    }

    function postUpdate(Request $request, Manager $item){
        $ar = $request->all();
        if ($request->has('email'))
            unset($ar['email']);

        if ($request->has('password') && $request->password)
            $ar['password'] = Hash::make($ar['password']);
        else 
            unset($ar['password']);  
        
        $ar['photo'] = UploadPhoto::upload($request->photo);
        if (!$ar['photo'])
            unset($ar['photo']);
        
        $item->update($ar);

        return redirect()->action("Lib\ManagerController@getIndex")->with('success', 'Изменен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getDelete(Request $request, Manager $item){
        $id = $item->id;
        $item->update(['is_active' => 0]);

        return redirect()->back()->with('success', 'Удален элемент списка "'.$this->title.'" № '.$id);
    }

}

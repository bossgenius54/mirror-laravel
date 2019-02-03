<?php
namespace App\Http\Controllers\Lib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use App\Helper\UploadPhoto;

use App\Model\View\Accounter;
use App\Model\SysUserType;
use App\ModelList\AccounterList;

use App\ModelFilter\UserFilter;

class AccounterController extends Controller{
    private $title = 'Бухгалтера';

    function getIndex (Request $request){
        $items = AccounterList::get($request);
        $items = UserFilter::filter($request, $items);
        
        $ar = array();
        $ar['title'] = 'Список елементов "'.$this->title.'"';
        $ar['filter_block'] = UserFilter::getFilterBlock($request);
        $ar['request'] = $request;
        $ar['items'] = $items->latest()->paginate(24);


        return view('page.lib.accounter.index', $ar);
    }

    function getCreate(Request $request){
        $ar = array();
        $ar['title'] = 'Добавить елемент в список "'.$this->title.'"';
        $ar['action'] = action('Lib\AccounterController@postCreate');

        return view('page.lib.accounter.create', $ar);
    }

    function postCreate(Request $request){
        if (Accounter::where(['email' => $request->email])->count() > 0)
            return redirect()->back()->with('error', 'Указанный почтовый адрес уже используется');

        $ar = $request->all();
        $ar['type_id'] = SysUserType::ACCOUNTER;
        $ar['is_active'] = 1;
        $ar['password'] = Hash::make($ar['password']);
        $ar['company_id'] = $request->user()->company_id;
        
        $ar['photo'] = UploadPhoto::upload($request->photo);
        if (!$ar['photo'])
            unset($ar['photo']);

        $item = Accounter::create($ar);
        
        return redirect()->action("Lib\AccounterController@getIndex")->with('success', 'Добавлен елемент списка "'.$this->title.'" № '.$item->id);
    }

    function getUpdate(Request $request, Accounter $item){
        $ar = array();
        $ar['title'] = 'Изменить елемент № '. $item->id.' списка "'.$this->title.'"';
        $ar['item'] = $item;
        $ar['action'] = action('Lib\AccounterController@postUpdate', $item);

        return view('page.lib.accounter.update', $ar);
    }

    function postUpdate(Request $request, Accounter $item){
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

        return redirect()->action("Lib\AccounterController@getIndex")->with('success', 'Изменен елемент списка "'.$this->title.'" № '.$item->id);
    }

    function getDelete(Request $request, Accounter $item){
        $id = $item->id;
        $item->update(['is_active' => 0]);

        return redirect()->back()->with('success', 'Удален елемент списка "'.$this->title.'" № '.$id);
    }

}

<?php
namespace App\Http\Controllers\Lib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use App\Helper\UploadPhoto;

use App\Model\View\Director;
use App\Model\Company;
use App\Model\SysUserType;

use App\ModelFilter\UserFilter;

class DirectorController extends Controller{
    private $title = 'Директора';

    function getIndex (Request $request){
        $items = Director::where('type_id', SysUserType::DIRECTOR)->where('is_active', 1);
        $items = UserFilter::filter($request, $items);

        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['filter_block'] = UserFilter::getFilterBlock($request);
        $ar['items'] = $items->latest()->paginate(24);
        $ar['ar_company'] = Company::getArForDirectors();

        return view('page.lib.director.index', $ar);
    }

    function getCreate(Request $request){
        $ar = array();
        $ar['title'] = 'Добавить элемент в список "'.$this->title.'"';
        $ar['action'] = action('Lib\DirectorController@postCreate');
        $ar['ar_company'] = Company::getArForDirectors();

        return view('page.lib.director.create', $ar);
    }

    function postCreate(Request $request){
        if (Director::where(['email' => $request->email])->count() > 0)
            return redirect()->back()->with('error', 'Указанный почтовый адрес уже используется');

        $ar = $request->all();
        $ar['type_id'] = SysUserType::DIRECTOR;
        $ar['is_active'] = 1;
        $ar['password'] = Hash::make($ar['password']);
        
        $ar['photo'] = UploadPhoto::upload($request->photo);
        if (!$ar['photo'])
            unset($ar['photo']);

        $item = Director::create($ar);
        
        return redirect()->action("Lib\DirectorController@getIndex")->with('success', 'Добавлен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getUpdate(Request $request, Director $item){
        $ar = array();
        $ar['title'] = 'Изменить элемент № '. $item->id.' списка "'.$this->title.'"';
        $ar['item'] = $item;
        $ar['ar_company'] = Company::getArForDirectors();
        $ar['action'] = action('Lib\DirectorController@postUpdate', $item);

        return view('page.lib.director.update', $ar);
    }

    function postUpdate(Request $request, Director $item){
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

        return redirect()->action("Lib\DirectorController@getIndex")->with('success', 'Изменен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getDelete(Request $request, Director $item){
        $id = $item->id;
        $item->update(['is_active' => 0]);

        return redirect()->back()->with('success', 'Удален элемент списка "'.$this->title.'" № '.$id);
    }

}

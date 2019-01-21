<?php
namespace App\Http\Controllers\Lib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use App\Helper\UploadPhoto;

use App\Model\View\Director;
use App\Model\Company;
use App\Model\SysUserType;

class DirectorController extends Controller{
    private $title = 'Директора';

    function getIndex (Request $request){
        $ar = array();
        $ar['title'] = 'Список елементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = Director::where('type_id', SysUserType::DIRECTOR)->latest()->paginate(24);
        $ar['ar_company'] = Company::getArForDirectors();

        return view('page.lib.director.index', $ar);
    }

    function getCreate(Request $request){
        $ar = array();
        $ar['title'] = 'Добавить елемент в список "'.$this->title.'"';
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
        
        return redirect()->action("Lib\DirectorController@getIndex")->with('success', 'Добавлен елемент списка "'.$this->title.'" № '.$item->id);
    }

    function getUpdate(Request $request, Director $item){
        $ar = array();
        $ar['title'] = 'Изменить елемент № '. $item->id.' списка "'.$this->title.'"';
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

        return redirect()->action("Lib\DirectorController@getIndex")->with('success', 'Изменен елемент списка "'.$this->title.'" № '.$item->id);
    }

    function getDelete(Request $request, Director $item){
        $id = $item->id;
        $item->delete();

        return redirect()->back()->with('success', 'Удален елемент списка "'.$this->title.'" № '.$id);
    }

}

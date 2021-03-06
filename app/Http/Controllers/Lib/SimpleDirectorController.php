<?php
namespace App\Http\Controllers\Lib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use App\Helper\UploadPhoto;

use App\Model\View\SimpleDirector;
use App\Model\SysUserType;
use App\Model\Company;

use App\ModelFilter\UserFilter;
use App\Services\SenderMail;

class SimpleDirectorController extends Controller{
    private $title = 'Клиент/Юр лица';

    function getIndex (Request $request, Company $company){
        $items = SimpleDirector::where('company_id', $company->id)->where('is_active', 1)->where('type_id', SysUserType::COMPANY_CLIENT);
        $items = UserFilter::filter($request, $items);

        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['filter_block'] = UserFilter::getFilterBlock($request);
        $ar['items'] = $items->latest()->paginate(24);
        $ar['company'] = $company;

        return view('page.lib.simple_director.index', $ar);
    }

    function getCreate(Request $request, Company $company){
        $ar = array();
        $ar['title'] = 'Добавить элемент в список "'.$this->title.'"';
        $ar['action'] = action('Lib\SimpleDirectorController@postCreate', $company);

        return view('page.lib.simple_director.create', $ar);
    }

    function postCreate(Request $request, Company $company){
        if (SimpleDirector::where(['email' => $request->email])->count() > 0)
            return redirect()->back()->with('error', 'Указанный почтовый адрес уже используется');

        $ar = $request->all();
        $ar['type_id'] = SysUserType::COMPANY_CLIENT;
        $ar['is_active'] = 1;
        $ar['password'] = Hash::make($ar['password']);
        $ar['company_id'] = $company->id;
        
        $ar['photo'] = UploadPhoto::upload($request->photo);
        if (!$ar['photo'])
            unset($ar['photo']);

        $item = SimpleDirector::create($ar);

        $title = 'У Вас появился личный кабинет в системе OptiCRM';
        $note = '<p>Ваш логин - '.$request->email.'</p>';
        $note .= '<p>Ваш пароль - '.$request->password.'</p>';
        SenderMail::send( $request->email, $title, $note);
        
        return redirect()->back()->with('success', 'Добавлен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getUpdate(Request $request, SimpleDirector $item){
        $ar = array();
        $ar['title'] = 'Изменить элемент № '. $item->id.' списка "'.$this->title.'"';
        $ar['item'] = $item;
        $ar['action'] = action('Lib\SimpleDirectorController@postUpdate', $item);

        return view('page.lib.simple_director.update', $ar);
    }

    function postUpdate(Request $request, SimpleDirector $item){
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

        return redirect()->action("Lib\SimpleDirectorController@getIndex", $item->company_id)->with('success', 'Изменен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getDelete(Request $request, SimpleDirector $item){
        $company_id = $item->company_id;
        $id = $item->id;
        $item->delete();

        return redirect()->action("Lib\SimpleDirectorController@getIndex", $company_id)->with('success', 'Удален элемент списка "'.$this->title.'" № '.$id);
    }


}

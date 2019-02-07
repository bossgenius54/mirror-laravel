<?php
namespace App\Http\Controllers\Lib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use App\Helper\UploadPhoto;

use App\Model\View\ExternalDoctor;
use App\Model\SysUserType;
use App\ModelList\ExternalDoctorList;

use App\ModelFilter\UserFilter;

class ExternalDoctorController extends Controller{
    private $title = 'Внешние врачи';

    function getIndex (Request $request){
        $items = ExternalDoctorList::get($request);
        $items = UserFilter::filter($request, $items);

        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['filter_block'] = UserFilter::getFilterBlock($request);
        $ar['request'] = $request;
        $ar['items'] = $items->latest()->paginate(24);
        
        return view('page.lib.external_doctor.index', $ar);
    }

    function getCreate(Request $request){
        $ar = array();
        $ar['title'] = 'Добавить элемент в список "'.$this->title.'"';
        $ar['action'] = action('Lib\ExternalDoctorController@postCreate');

        return view('page.lib.external_doctor.create', $ar);
    }

    function postCreate(Request $request){
        if (ExternalDoctor::where(['email' => $request->email])->count() > 0)
            return redirect()->back()->with('error', 'Указанный почтовый адрес уже используется');

        $ar = $request->all();
        $ar['type_id'] = SysUserType::EXTERNAL_DOCTOR;
        $ar['is_active'] = 1;
        $ar['password'] = Hash::make($ar['password']);
        $ar['company_id'] = $request->user()->company_id;
        
        $ar['photo'] = UploadPhoto::upload($request->photo);
        if (!$ar['photo'])
            unset($ar['photo']);

        $item = ExternalDoctor::create($ar);
        
        return redirect()->action("Lib\ExternalDoctorController@getIndex")->with('success', 'Добавлен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getUpdate(Request $request, ExternalDoctor $item){
        $ar = array();
        $ar['title'] = 'Изменить элемент № '. $item->id.' списка "'.$this->title.'"';
        $ar['item'] = $item;
        $ar['action'] = action('Lib\ExternalDoctorController@postUpdate', $item);

        return view('page.lib.external_doctor.update', $ar);
    }

    function postUpdate(Request $request, ExternalDoctor $item){
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

        return redirect()->action("Lib\ExternalDoctorController@getIndex")->with('success', 'Изменен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getDelete(Request $request, ExternalDoctor $item){
        $id = $item->id;
        $item->update(['is_active' => 0]);

        return redirect()->back()->with('success', 'Удален элемент списка "'.$this->title.'" № '.$id);
    }

}

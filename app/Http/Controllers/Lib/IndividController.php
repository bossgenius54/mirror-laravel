<?php
namespace App\Http\Controllers\Lib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use App\Helper\UploadPhoto;
use App\Model\ClientsLog;
use App\Model\ClientsLogType;
use App\Model\View\Individ;
use App\Model\SysUserType;
use App\ModelList\IndividList;

use App\ModelFilter\UserFilter;
use App\Services\SenderMail;
use Illuminate\Support\Facades\Auth;

class IndividController extends Controller{
    private $title = 'База клиентов';

    function getIndex (Request $request){

        // dd($request->phone);

        $items = IndividList::get($request);
        $items = UserFilter::filter($request, $items);

        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['filter_block'] = UserFilter::getFilterBlock($request);
        $ar['items'] = $items->latest()->paginate(24);

        return view('page.lib.individ.index', $ar);
    }

    function getCreate(Request $request){
        $ar = array();
        $ar['title'] = 'Добавить элемент в список "'.$this->title.'"';
        $ar['action'] = action('Lib\IndividController@postCreate');

        return view('page.lib.individ.create', $ar);
    }

    function postCreate(Request $request){
        $email = $request->email;
        if (!$email)
            $email = time().'@crm.qlt.kz';

        if (Individ::where(['email' => $email])->count() > 0)
            return redirect()->back()->with('error', 'Указанный почтовый адрес уже используется');

        $ar = $request->all();
        $ar['type_id'] = SysUserType::FIZ;
        $ar['is_active'] = 1;
        $ar['email'] = $email;
        //$ar['password'] = Hash::make(rand(1000, 9999));
        $ar['password'] = Hash::make(346488);
        $ar['photo'] = UploadPhoto::upload($request->photo);
        if (!$ar['photo'])
            unset($ar['photo']);

        $item = Individ::create($ar);

        if($item){
            $vars = [];
            $vars['user'] = Auth::user();
            $vars['client'] = $item;
            $vars['type_id'] = ClientsLogType::CREATED_CLIENT;

            $log = ClientsLog::writeLog($vars);
        }

        return redirect()->action("Lib\IndividController@getIndex")->with('success', 'Добавлен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getUpdate(Request $request, Individ $item){
        $ar = array();
        $ar['title'] = 'Изменить элемент № '. $item->id.' списка "'.$this->title.'"';
        $ar['item'] = $item;

        // log elems
        $ar['logs'] = ClientsLog::where('client_id', $item->id)->with(['relCreatedUser','relOrder','relClient','relClientsLogType'])->get();
        // ___

        $ar['action'] = action('Lib\IndividController@postUpdate', $item);

        return view('page.lib.individ.update', $ar);
    }

    function postUpdate(Request $request, Individ $item){
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

        return redirect()->action("Lib\IndividController@getIndex")->with('success', 'Изменен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getDelete(Request $request, Individ $item){
        $id = $item->id;
        $item->delete();

        return redirect()->back()->with('success', 'Удален элемент списка "'.$this->title.'" № '.$id);
    }

}

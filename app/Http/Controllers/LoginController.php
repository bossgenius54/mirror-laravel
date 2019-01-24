<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Hash;
use Auth;
use App\Model\SysAuthLog;

class LoginController extends Controller{

    function getLogin (){
        //$user = User::find(1)->update(['password'=>Hash::make('346488')]);
        /*
        $user = new User();
        $user->email = 'admin@mail.ru';
        $user->password = Hash::make('346488');
        $user->type_id = 1;
        $user->save();
        */

        $ar = array();
        $ar['title'] = 'Форма входа';
        $ar['action'] = action('LoginController@postLogin');

        return view('login', $ar);
    }

    function postLogin(Request $request){
        if (!Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'is_active'=>1]))
            return back()->with('error', 'Не правильный email/пароль');

        $user = Auth::user();
        $user->update(['had_enter' => 1]);
        SysAuthLog::createNote($user);

        return redirect()->to('/');
    }  

    function getLogout(){
        Auth::logout();

        return redirect()->to('/');
    }
}

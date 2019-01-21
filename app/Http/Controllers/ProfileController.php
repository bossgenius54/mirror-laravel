<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Hash;
use Auth;
use App\Helper\UploadPhoto;

class ProfileController extends Controller{

    function getIndex (Request $request){
        $ar = array();
        $ar['title'] = 'Профиль';
        $ar['user'] = $request->user();
        $ar['action'] = action('ProfileController@postIndex');

        return view('page.profile', $ar);
    }

    function postIndex(Request $request){
        $user = $request->user();
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

        $user->update($ar);

        return redirect()->back()->with('success', 'Сохранено');
    }  
}

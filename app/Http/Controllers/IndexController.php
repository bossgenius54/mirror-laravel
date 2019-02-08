<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\SysUserType;

class IndexController extends Controller{

    function getIndex(Request $request){
        $user = $request->user();
        if ($user->type_id == SysUserType::DIRECTOR)
            return redirect()->action('Lib\IndividController@getIndex');
        if ($user->type_id == SysUserType::MANAGER)
            return redirect()->action('Lib\IndividController@getIndex');
        if ($user->type_id == SysUserType::FIZ)
            return redirect()->action('Order\ListOrderController@getIndex');
        if ($user->type_id == SysUserType::DOCTOR)
            return redirect()->action('Lib\IndividController@getIndex');
        if ($user->type_id == SysUserType::ACCOUNTER)
            return redirect()->action('Order\ListOrderController@getIndex');
        if ($user->type_id == SysUserType::COMPANY_CLIENT)
            return redirect()->action('Order\ListOrderController@getIndex');
        if ($user->type_id == SysUserType::STOCK_MANAGER)
            return redirect()->action('Stock\BranchProductController@getIndex');
            
        return redirect()->action('/');
    }  

}

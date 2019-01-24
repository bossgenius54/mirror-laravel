<?php
namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\SysAuthLog;

class AuthLogController extends Controller{

    function getIndex(Request $request){
        $items = SysAuthLog::latest();
        if ($request->has('user_id') && $request->user_id) 
            $items->where('user_id', $request->user_id);
        if ($request->has('user_name') && $request->user_name) 
            $items->whereHas('relUser', function($q) use ($request){
                $q->where('name', 'like', '%'.$request->user_name.'%');
            });

        $ar = array();
        $ar['title'] = 'Логи авторизации';
        $ar['items'] = $items->paginate(24);
        $ar['request'] = $request;

        return view('page.system.auth_log.index', $ar);

    }
}
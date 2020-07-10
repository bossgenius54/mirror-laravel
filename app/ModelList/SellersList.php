<?php

namespace App\ModelList;

use App\Model\SysUserType;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SellersList extends Model
{
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new SellersList();
        $el->start($request);

        return  $el->getResult();
    }


    private function getItems(){
        $items = User::whereIn('type_id', [SysUserType::MANAGER, SysUserType::DIRECTOR])->where('is_active', 1);
        if ($this->user->company_id)
            $items->where('company_id', $this->user->company_id)->with('relCompany');

        $this->items = $items;
    }

    function start(Request $request){
        $this->request = $request;
        $this->user = $request->user();

        $this->getItems();
    }

    function getResult(){
        return $this->items;
    }


}

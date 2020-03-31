<?php
namespace App\ModelList;

use Illuminate\Http\Request;

use App\Model\Company;
use App\Model\SysUserType;

class CompanyList {
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new CompanyList();
        $el->start($request);

        return  $el->getResult();
    }


    private function getItems(){
        $items = Company::where('id', '>', 0);
//        if (in_array($this->user->type_id, [SysUserType::DIRECTOR, SysUserType::MANAGER, SysUserType::ACCOUNTER])){
//            $user = $this->user;
//            $items->whereHas('relSeller', function($q) use ($user){
//                $q->where('company_id', $user->company_id);
//            });
//        }

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

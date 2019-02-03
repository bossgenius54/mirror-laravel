<?php
namespace App\ModelList;

use Illuminate\Http\Request;

use App\Model\View\Manager;
use App\Model\SysUserType;

class ManagerList {
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new ManagerList();
        $el->start($request);

        return  $el->getResult();
    }


    private function getItems(){
        $items = Manager::where('type_id', SysUserType::MANAGER)->where('is_active', 1);
        if ($this->user->company_id)
            $items->where('company_id', $this->user->company_id);

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
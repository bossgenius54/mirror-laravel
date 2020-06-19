<?php
namespace App\ModelList;

use Illuminate\Http\Request;

use App\Model\Position;
use App\Model\SysUserType;

class DeletionPositionList {
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new DeletionPositionList();
        $el->start($request);

        return  $el->getResult();
    }


    private function getItems(){
        $user = $this->user;

        $items = Position::where('id', '>', 0);
        if ($this->user->company_id)
            $items->whereHas('relProduct', function($q) use ($user){
                $q->where('company_id', $user->company_id);
            });

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

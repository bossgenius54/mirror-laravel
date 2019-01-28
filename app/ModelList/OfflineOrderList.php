<?php
namespace App\ModelList;

use Illuminate\Http\Request;

use App\Model\View\OfflineOrder;
use App\Model\SysUserType;

class OfflineOrderList {
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new OfflineOrderList();
        $el->start($request);

        return  $el->getResult();
    }


    private function getItems(){
        $user = $this->user;

        $items = OfflineOrder::where('is_retail', 1);
        if ($this->user->company_id)
            $items->where('company_id', $user->company_id);

        if ($this->user->branch_id)
            $items->where('branch_id', $user->branch_id);

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
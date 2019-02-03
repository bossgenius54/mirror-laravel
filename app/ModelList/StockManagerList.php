<?php
namespace App\ModelList;

use Illuminate\Http\Request;

use App\Model\View\StockManager;
use App\Model\SysUserType;

class StockManagerList {
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new StockManagerList();
        $el->start($request);

        return  $el->getResult();
    }


    private function getItems(){
        $items = StockManager::where('type_id', SysUserType::STOCK_MANAGER)->where('is_active', 1);
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
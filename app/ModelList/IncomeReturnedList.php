<?php
namespace App\ModelList;

use Illuminate\Http\Request;

use App\Model\View\IncomeReturned;
use App\Model\SysIncomeType;
use App\Model\SysUserType;
use App\Model\Branch;

class IncomeReturnedList {
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new IncomeReturnedList();
        $el->start($request);

        return  $el->getResult();
    }

    private function getItems(){
        $items = IncomeReturned::whereIn('type_id', [SysIncomeType::RETURN_COMPANY, SysIncomeType::RETURN_PERSON]);

        if ($this->request->user()->company_id)
            $items->where('company_id', $this->request->user()->company_id);
        if (in_array($this->request->user()->type_id, [SysUserType::MANAGER]))
            $items->where('branch_id', $this->request->user()->branch_id);

        $this->items = $items;
    }

    function start(Request $request){
        $this->request = $request;

        $this->getItems();
    }

    function getResult(){
        return $this->items;
    }


}
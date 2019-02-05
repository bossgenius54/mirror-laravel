<?php
namespace App\ModelList;

use Illuminate\Http\Request;

use App\Model\FinanceService;
use App\Model\SysUserType;
use App\Model\Branch;

class FinanceServiceList {
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new FinanceServiceList();
        $el->start($request);

        return  $el->getResult();
    }

    private function getItems(){
        $items = FinanceService::where('id', '>', 0);

        if ($this->request->user()->company_id){
            $ar_branch = Branch::where('company_id', $this->request->user()->company_id)->pluck('id')->toArray();
            $items->whereIn('branch_id', $ar_branch);
        }
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
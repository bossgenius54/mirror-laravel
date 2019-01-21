<?php
namespace App\ModelFilters;

use Illuminate\Http\Request;

use App\Model\View\IncomeFromCompany;
use App\Model\SysIncomeType;
use App\Model\SysUserType;
use App\Model\Branch;

class FilterIncomeFromCompany {
    private $items = null;
    private $request = null;

    static function filter(Request $request){
        $el = new FilterIncomeFromCompany();
        $el->start($request);

        return  $el->getResult();
    }

    private function getItems(){
        $items = IncomeFromCompany::where('type_id', SysIncomeType::FROM_COMPANY);
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
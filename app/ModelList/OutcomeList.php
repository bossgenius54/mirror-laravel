<?php
namespace App\ModelList;

use Illuminate\Http\Request;

use App\Model\Outcome;
use App\Model\SysOutcomeType;
use App\Model\SysUserType;
use App\Model\Branch;

class OutcomeList {
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new OutcomeList();
        $el->start($request);

        return  $el->getResult();
    }

    private function getItems(){
        $items = Outcome::whereIn('type_id', [SysOutcomeType::TO_COMPANY, SysOutcomeType::TO_PERSON]);

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
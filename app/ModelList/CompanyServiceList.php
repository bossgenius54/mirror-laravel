<?php
namespace App\ModelList;

use Illuminate\Http\Request;

use App\Model\CompanyService;
use App\Model\SysUserType;

class CompanyServiceList {
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new CompanyServiceList();
        $el->start($request);
        
        return  $el->getResult();
    }


    private function getItems(){
        $items = CompanyService::where('id', '>', 0);
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
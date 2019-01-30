<?php
namespace App\ModelList;

use Illuminate\Http\Request;

use App\Model\Branch;
use App\Model\Company;
use App\Model\SysUserType;

class BranchList {
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new BranchList();
        $el->start($request);

        return  $el->getResult();
    }
    
    private function getItems(){
        $items = Branch::where('id', '>', 0);
        if ($this->user->company_id)
            $items->where('company_id', $this->user->company_id);
        
        if ($this->user->branch_id)
            $items->where('id', $this->user->branch_id);

        $this->items = $items;
    }

    function start(Request $request){
        $this->request = $request;
        $this->user = $request->user();

        $this->getItems();

        
            $this->filterName();
            $this->filterCompany();
       
    }

    function getResult(){
        return $this->items;
    }


    private  function filterName(){
        if (!$this->request->has('name') || !$this->request->name)
            return;

        $this->items->where('name', 'like', '%'.$this->request->name.'%');
    }

    private  function filterCompany(){
        if (!$this->request->has('company_id') || !$this->request->company_id)
            return;

        $this->items->where('company_id', $this->request->company_id);
    }

    static function getLibAr(){
        return [
            'ar_company' => Company::getArFullPermis(),
            'ar_bool' => [0 => 'Нет', 1 => 'Да'],
        ];
    }

}
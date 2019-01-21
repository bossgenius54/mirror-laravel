<?php
namespace App\ModelFilters;

use Illuminate\Http\Request;

use App\Model\Branch;
use App\Model\BranchData;
use App\Model\Company;

class FilterBranch {
    private $items = null;
    private $request = null;

    static function filter(Request $request){
        $el = new FilterBranch();
        $el->start($request);

        return  $el->getResult();
    }

    static function getLibAr(){
        return [
            'ar_company' => Company::getArFullPermis(),
            'ar_bool' => [0 => 'Нет', 1 => 'Да'],
        ];
    }

    private function getItems(){
        $this->items = Branch::where('id', '>', 0);
    }

    function start(Request $request){
        $this->getItems();
        
        $this->request = $request;

        $this->filterCompany();
        $this->filterName();
    }

    function getResult(){
        return $this->items;
    }


    private  function filterCompany(){
        if (!$this->request->has('company_id') || !$this->request->company_id)
            return;

        $this->items->where('company_id', $this->request->company_id);
    }

    private  function filterName(){
        if (!$this->request->has('name') || !$this->request->name)
            return;

        $this->items->where('name', 'like', '%'.$this->request->name.'%');
    }


}
<?php
namespace App\ModelFilter;

use Illuminate\Http\Request;

use App\Model\SysUserType;

class IncomeFromCompanyFilter {
    private $items = null;
    private $request = null;

    static function getFilterBlock(){
        return 'page.__filter.income_from_company';
    }

    static function filter(Request $request, $items){
        $el = new IncomeFromCompanyFilter();
        $el->start($request, $items);
        
        return  $el->getResult();
    }

    function start(Request $request, $items){
        $this->request = $request;
        $this->items = $items;

        $this->filterName();
        $this->filterInBranch();
        $this->filterFromCompany();
    }

    function getResult(){
        return $this->items;
    }
    
    private  function filterName(){
        if (!$this->request->has('name') || !$this->request->name)
            return;

        $this->items->where('name', 'like', '%'.$this->request->name.'%');
    }

    
    private  function filterInBranch(){
        if (!$this->request->has('in_branch') || !$this->request->in_branch)
            return;

        $request = $this->request;
        $this->items->whereHas('relBranch', function($q) use ($request){
            $q->where('name', 'like', '%'.$request->in_branch.'%');
        });
    }

    
    private  function filterFromCompany(){
        if (!$this->request->has('from_company') || !$this->request->from_company)
            return;

        $request = $this->request;
        $this->items->whereHas('relFromCompany', function($q) use ($request){
            $q->where('name', 'like', '%'.$request->from_company.'%');
        });
    }

   

}
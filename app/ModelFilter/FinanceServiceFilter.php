<?php
namespace App\ModelFilter;

use Illuminate\Http\Request;

use App\Model\SysUserType;

class FinanceServiceFilter {
    private $items = null;
    private $request = null;

    static function getFilterBlock(){
        return 'page.__filter.finance_services';
    }

    static function filter(Request $request, $items){
        $el = new FinanceServiceFilter();
        $el->start($request, $items);
        
        return  $el->getResult();
    }

    function start(Request $request, $items){
        $this->request = $request;
        $this->items = $items;

        $this->filterBranch();
        $this->filterService();
    }

    function getResult(){
        return $this->items;
    }
    
    private  function filterBranch(){
        if (!$this->request->has('b_name') || !$this->request->b_name)
            return;

        $request = $this->request;
        $this->items->whereHas('relBranch', function($q) use ($request){
            $q->where('name', 'like', '%'.$request->b_name.'%');
        });
    }

    private  function filterService(){
        if (!$this->request->has('s_name') || !$this->request->s_name)
            return;

        $request = $this->request;
        $this->items->whereHas('relService', function($q) use ($request){
            $q->where('name', 'like', '%'.$request->s_name.'%');
        });
    }

    

   

}
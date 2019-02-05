<?php
namespace App\ModelFilter;

use Illuminate\Http\Request;

use App\Model\SysUserType;

class FinancePositionFilter {
    private $items = null;
    private $request = null;

    static function getFilterBlock(){
        return 'page.__filter.finanse_position';
    }

    static function filter(Request $request, $items){
        $el = new FinancePositionFilter();
        $el->start($request, $items);
        
        return  $el->getResult();
    }

    function start(Request $request, $items){
        $this->request = $request;
        $this->items = $items;

        $this->filterBranch();
        $this->filterProduct();
        $this->filterSysname();
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

    private  function filterProduct(){
        if (!$this->request->has('p_name') || !$this->request->p_name)
            return;

        $request = $this->request;
        $this->items->whereHas('relProduct', function($q) use ($request){
            $q->where('name', 'like', '%'.$request->p_name.'%');
        });
    }
    
    private function filterSysname(){
        if (!$this->request->has('position_sys_num') || !$this->request->position_sys_num)
            return;

        $this->items->where('position_sys_num', 'like', '%'.$this->request->position_sys_num.'%');
    }

    

   

}
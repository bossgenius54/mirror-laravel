<?php
namespace App\ModelFilter;

use Illuminate\Http\Request;

use App\Model\SysUserType;

class OutcomeFilter {
    private $items = null;
    private $request = null;

    static function getFilterBlock(){
        return 'page.__filter.outcome';
    }

    static function filter(Request $request, $items){
        $el = new OutcomeFilter();
        $el->start($request, $items);
        
        return  $el->getResult();
    }

    function start(Request $request, $items){
        $this->request = $request;
        $this->items = $items;

        $this->filterName();
        $this->filterInBranch();
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


   

}
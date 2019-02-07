<?php
namespace App\ModelFilter;

use Illuminate\Http\Request;

use App\Model\SysUserType;

class OrderFilter {
    private $items = null;
    private $request = null;

    static function getFilterBlock(){
        return 'page.__filter.order';
    }

    static function filter(Request $request, $items){
        $el = new OrderFilter();
        $el->start($request, $items);
        
        return  $el->getResult();
    }

    function start(Request $request, $items){
        $this->request = $request;
        $this->items = $items;

        $this->filterName();
        $this->filterStatus();
        $this->filterOnlain();
        $this->filterRetail();
        $this->filterType();
        $this->filterFromCompany();
        $this->filterFromUser();
        $this->filterBranch();
    }

    function getResult(){
        return $this->items;
    }

    private  function filterBranch(){
        if (!$this->request->has('branch') || !$this->request->branch)
            return;

        $request = $this->request;
        $this->items->whereHas('relBranch', function($q) use ($request){
            $q->where('name', 'like', '%'.$request->branch.'%');
        });
    }


    private  function filterName(){
        if (!$this->request->has('name') || !$this->request->name)
            return;

        $this->items->where('name', 'like', '%'.$this->request->name.'%');
    }
 
    private  function filterStatus(){
        if (!$this->request->has('status_id') || !$this->request->status_id)
            return;

        $this->items->where('status_id',  $this->request->status_id);
    }

    private  function filterOnlain(){
        if (!$this->request->has('is_onlain') || !$this->request->is_onlain)
            return;

        $this->items->where('is_onlain',  $this->request->is_onlain);
    }
    
    private  function filterRetail(){
        if (!$this->request->has('is_retail') )
            return;

        $this->items->where('is_retail',  $this->request->is_retail);
    }
 
    private  function filterType(){
        if (!$this->request->has('type_id') || !$this->request->type_id)
            return;

        $this->items->where('type_id',  $this->request->type_id);
    }
    
    private  function filterFromCompany(){
        if (!$this->request->has('from_company') || !$this->request->from_company)
            return;

        $request = $this->request;
        $this->items->whereHas('relCompanyCLient', function($q) use ($request){
            $q->where('name', 'like', '%'.$request->from_company.'%');
        });
    }

    private  function filterFromUser(){
        if (!$this->request->has('from_user') || !$this->request->from_user)
            return;

        $request = $this->request;
        $this->items->whereHas('relPersonCLient', function($q) use ($request){
            $q->where('name', 'like', '%'.$request->from_user.'%');
        });
    }
}
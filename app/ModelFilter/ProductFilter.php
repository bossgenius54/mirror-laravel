<?php
namespace App\ModelFilter;

use Illuminate\Http\Request;

use App\Model\SysUserType;

class ProductFilter {
    private $items = null;
    private $request = null;

    static function getFilterBlock(){
        return 'page.__filter.product';
    }

    static function filter(Request $request, $items){
        $el = new ProductFilter();
        $el->start($request, $items);
        
        return  $el->getResult();
    }

    function start(Request $request, $items){
        $this->request = $request;
        $this->items = $items;

        $this->filterName();
        $this->filterSysNum();
        $this->filterCatId();
    }

    function getResult(){
        return $this->items;
    }


    private  function filterName(){
        if (!$this->request->has('name') || !$this->request->name)
            return;

        $this->items->where('name', 'like', '%'.$this->request->name.'%');
    }

    private  function filterSysNum(){
        if (!$this->request->has('sys_num') || !$this->request->sys_num)
            return;
        
        $this->items->where('sys_num', 'like', '%'.$this->request->sys_num.'%');
    }

    private  function filterCatId(){
        if (!$this->request->has('cat_id') || !$this->request->cat_id)
            return;
        
        $this->items->where('cat_id', $this->request->cat_id);
    }

   

}
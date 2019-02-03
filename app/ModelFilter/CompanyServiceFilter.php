<?php
namespace App\ModelFilter;

use Illuminate\Http\Request;

use App\Model\SysUserType;

class CompanyServiceFilter {
    private $items = null;
    private $request = null;

    static function getFilterBlock(){
        return 'page.__filter.company_service';
    }

    static function filter(Request $request, $items){
        $el = new CompanyServiceFilter();
        $el->start($request, $items);
        
        return  $el->getResult();
    }

    function start(Request $request, $items){
        $this->request = $request;
        $this->items = $items;

        $this->filterName();
        $this->filterPrice();

    }

    function getResult(){
        return $this->items;
    }


    private  function filterName(){
        if (!$this->request->has('name') || !$this->request->name)
            return;

        $this->items->where('name', 'like', '%'.$this->request->name.'%');
    }

    private  function filterPrice(){
        if (!$this->request->has('price') || !$this->request->price)
            return;
        
        $this->items->where('price', $this->request->price);
    }


}
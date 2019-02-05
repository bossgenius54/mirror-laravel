<?php
namespace App\ModelFilter;

use Illuminate\Http\Request;

use App\Model\SysUserType;

class ExternalDoctorSalaryFilter {
    private $items = null;
    private $request = null;

    static function getFilterBlock(){
        return 'page.__filter.external_doctor_salary';
    }

    static function filter(Request $request, $items){
        $el = new ExternalDoctorSalaryFilter();
        $el->start($request, $items);
        
        return  $el->getResult();
    }

    function start(Request $request, $items){
        $this->request = $request;
        $this->items = $items;

        $this->filterName();
        $this->filterOrderNum();
        $this->filterOrderName();
    }

    function getResult(){
        return $this->items;
    }
    
    private  function filterName(){
        if (!$this->request->has('name') || !$this->request->name)
            return;

        $request = $this->request;
        $this->items->whereHas('relDoctor', function($q) use ($request){
            $q->where('name', 'like', '%'.$request->name.'%');
        });
    }

    
    private  function filterOrderNum(){
        if (!$this->request->has('order_num') || !$this->request->order_num)
            return;

        $request = $this->request;
        $this->items->whereHas('relOrder', function($q) use ($request){
            $q->where('id', $request->order_num);
        });
    }

    
    private  function filterOrderName(){
        if (!$this->request->has('order_name') || !$this->request->order_name)
            return;

        $request = $this->request;
        $this->items->whereHas('relOrder', function($q) use ($request){
            $q->where('name', 'like', '%'.$request->order_name.'%');
        });
    }

   

}
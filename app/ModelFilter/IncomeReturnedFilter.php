<?php
namespace App\ModelFilter;

use Illuminate\Http\Request;

use App\Model\SysUserType;

class IncomeReturnedFilter {
    private $items = null;
    private $request = null;

    static function getFilterBlock(){
        return 'page.__filter.income_returned';
    }

    static function filter(Request $request, $items){
        $el = new IncomeReturnedFilter();
        $el->start($request, $items);

        return  $el->getResult();
    }

    function start(Request $request, $items){
        $this->request = $request;
        $this->items = $items;

        $this->filterName();
        $this->filterToBranch();
        $this->filterFromCompany();
        $this->filterDate();
    }

    function getResult(){
        return $this->items;
    }

    private  function filterName(){
        if (!$this->request->has('name') || !$this->request->name)
            return;

        $this->items->where('name', 'like', '%'.$this->request->name.'%');
    }


    private  function filterToBranch(){
        if (!$this->request->has('branch_id') || !$this->request->in_branch)
            return;

        $request = $this->request;
        $this->items->where('branch_id',$this->request->branch_id);
    }

    private  function filterFromCompany(){
        if (!$this->request->has('from_company') || !$this->request->from_company)
            return;

        $request = $this->request;
        $this->items->whereHas('relFromCompany', function($q) use ($request){
            $q->where('name', 'like', '%'.$request->from_company.'%');
        });
    }

    private function filterDate(){
        if (!$this->request->has('first_date') || !$this->request->first_date)
            return;

        if(!$this->request->has('second_date') || !$this->request->second_date)
        {
            $this->items->where('created_at', 'like', $this->request->first_date.'%');
        } else {
            $this->items->whereBetween(DB::raw('DATE(created_at)'), array($this->request->first_date, $this->request->second_date));
        }
    }



}

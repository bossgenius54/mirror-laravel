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
        $this->filterDate();
    }

    function getResult(){
        return $this->items;
    }

    private  function filterBranch(){
        if (!$this->request->has('branch_id') || !$this->request->branch_id)
            return;

        $request = $this->request;
        $this->items->where('branch_id', $this->request->branch_id);
    }

    private  function filterService(){
        if (!$this->request->has('service_id') || !$this->request->service_id)
            return;

        $this->items->where('service_id', $this->request->service_id);
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

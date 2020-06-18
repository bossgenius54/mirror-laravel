<?php
namespace App\ModelFilter;

use Illuminate\Http\Request;

use App\Model\SysUserType;
use Illuminate\Support\Facades\DB;

class PositionFilter {
    private $items = null;
    private $request = null;

    static function getFilterBlock(){
        return 'page.__filter.position';
    }

    static function filter(Request $request, $items){
        $el = new PositionFilter();
        $el->start($request, $items);

        return  $el->getResult();
    }

    function start(Request $request, $items){
        $this->request = $request;
        $this->items = $items;

        $this->filterName();
        $this->filterSysNum();
        $this->filterCatId();
        $this->filterByOption();
        $this->filterStatusId();
        $this->filterbBranchId();
        $this->filterIncomeId();
        $this->filterDate();
        $this->filterExpired();
    }

    function getResult(){
        return $this->items;
    }


    private  function filterName(){
        if (!$this->request->has('name') || !$this->request->name)
            return;

        $request = $this->request;
        $this->items->whereHas('relProduct', function($q) use ($request){
            $q->where('name', 'like', '%'.$request->name.'%');
        });
    }

    private  function filterSysNum(){
        if (!$this->request->has('sys_num') || !$this->request->sys_num)
            return;

        $request = $this->request;
        $this->items->whereHas('relProduct', function($q) use ($request){
            $q->where('sys_num', 'like', '%'.$request->sys_num.'%');
        });
    }

    private  function filterCatId(){
        if (!$this->request->has('cat_id') || !$this->request->cat_id)
            return;

        $request = $this->request;
        $this->items->whereHas('relProduct', function($q) use ($request){
            $q->where('cat_id', $request->cat_id);
        });
    }

    private  function filterByOption(){
        if (!$this->request->has('option') || !$this->request->option)
            return;

        $request = $this->request;
        $this->items->whereHas('relProduct', function($q) use ($request){
            $q->whereHas('relOptions', function($q) use ($request){
                $q->where('option_id', $request->option);
            });
        });
    }

    private  function filterStatusId(){
        if (!$this->request->has('status_id') || !$this->request->status_id)
            return;

        $this->items->where('status_id',  $this->request->status_id);
    }

    private  function filterbBranchId(){
        if (!$this->request->has('branch_id') || !$this->request->branch_id)
            return;

        $this->items->where('branch_id',  $this->request->branch_id);
    }

    private function filterIncomeId(){
        if (!$this->request->has('income_id') || !$this->request->income_id)
            return;

        $this->items->where('income_id',  $this->request->income_id);

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

    private function filterExpired(){
        if (!$this->request->has('expired_first') || !$this->request->expired_first)
            return;

        if(!$this->request->has('expired_second') || !$this->request->second)
        {
            $this->items->where('expired_at', $this->request->expired_first);
        } else {
            $this->items->whereBetween(DB::raw('DATE(expired_at)'), array($this->request->first_date, $this->request->second_date));
        }
    }

}

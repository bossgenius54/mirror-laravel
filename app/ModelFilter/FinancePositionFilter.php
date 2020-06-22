<?php
namespace App\ModelFilter;

use Illuminate\Http\Request;

use App\Model\SysUserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $this->filterName();
        $this->filterSysNum();
        $this->filterBranch();
        $this->filterCatId();
        $this->filterByOption();
        $this->filterDate();
        $this->filterForManager();
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

    private  function filterForManager(){
        if (Auth::user()->type_id != SysUserType::MANAGER)
            return;

        $request = $this->request;
        $this->items->where('branch_id', Auth::user()->branch_id);
    }

    private  function filterByOption(){
        if (!$this->request->has('option') || !$this->request->option)
            return;

        foreach($this->request->option as $i){
            $this->items->whereHas('relProduct', function($q) use ($i){
                $q->whereHas('relOptions', function($q) use ($i){
                    $q->where('option_id', $i);
                });
            });
        }
    }

    private  function filterBranch(){
        if (!$this->request->has('branch_id') || !$this->request->branch_id)
            return;

        $request = $this->request;
        $this->items->where('branch_id',$this->request->branch_id);
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

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

        $this->filterBranch();
        $this->filterProduct();
        $this->filterSysname();
        $this->filterByOption();
        $this->filterDate();
        $this->filterForManager();
    }

    function getResult(){
        return $this->items;
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

        $request = $this->request;
        $this->items->whereHas('relProduct', function($q) use ($request){
            $q->whereHas('relOptions', function($q) use ($request){
                $q->where('option_id', $request->option);
            });
        });
    }

    private  function filterBranch(){
        if (!$this->request->has('branch_id') || !$this->request->branch_id)
            return;

        $request = $this->request;
        $this->items->where('branch_id',$this->request->branch_id);
    }

    private  function filterProduct(){
        if (!$this->request->has('product_id') || !$this->request->product_id)
            return;

        $request = $this->request;
        $this->items->whereHas('relProduct', function($q) use ($request){
            $q->where('id', $request->product_id);
        });
    }

    private function filterSysname(){
        if (!$this->request->has('position_sys_num') || !$this->request->position_sys_num)
            return;

        $this->items->where('position_sys_num', 'like', '%'.$this->request->position_sys_num.'%');
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

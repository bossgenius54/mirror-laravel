<?php
namespace App\ModelFilter;

use Illuminate\Http\Request;

use App\Model\SysUserType;
use Illuminate\Support\Facades\DB;

class MotionFilter {
    private $items = null;
    private $request = null;

    static function getFilterBlock(){
        return 'page.__filter.motion';
    }

    static function filter(Request $request, $items){
        $el = new MotionFilter();
        $el->start($request, $items);

        return  $el->getResult();
    }

    function start(Request $request, $items){
        $this->request = $request;
        $this->items = $items;

        $this->filterName();
        $this->filterStatusId();
        $this->filterFromBranchId();
        $this->filterToBranchId();
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

    private  function filterStatusId(){
        if (!$this->request->has('status_id') || !$this->request->status_id)
            return;

        $this->items->where('status_id', $this->request->status_id);
    }

    private  function filterFromBranchId(){
        if (!$this->request->has('from_branch_id') || !$this->request->from_branch_id)
            return;

        $this->items->where('from_branch_id', $this->request->from_branch_id);
    }

    private  function filterToBranchId(){
        if (!$this->request->has('to_branh_id') || !$this->request->to_branh_id)
            return;

        $this->items->where('to_branh_id', $this->request->to_branh_id);
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

<?php
namespace App\ModelFilter;

use Illuminate\Http\Request;

use App\Model\SysUserType;
use Illuminate\Support\Facades\DB;

class OutcomeFilter {
    private $items = null;
    private $request = null;

    static function getFilterBlock(){
        return 'page.__filter.outcome';
    }

    static function filter(Request $request, $items){
        $el = new OutcomeFilter();
        $el->start($request, $items);

        return  $el->getResult();
    }

    function start(Request $request, $items){
        $this->request = $request;
        $this->items = $items;

        $this->filterNote();
        $this->filterToBranch();
        $this->filterDate();
    }

    function getResult(){
        return $this->items;
    }

    private  function filterNote(){
        if (!$this->request->has('note') || !$this->request->note)
            return;

        $this->items->where('note', 'like', '%'.$this->request->note.'%');
    }

    private  function filterToBranch(){
        if (!$this->request->has('branch_id') || !$this->request->branch_id)
            return;

        $this->items->where('branch_id', $this->request->branch_id);
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

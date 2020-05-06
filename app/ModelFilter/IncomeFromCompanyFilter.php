<?php
namespace App\ModelFilter;

use App\Model\SysPositionStatus;
use Illuminate\Http\Request;

use App\Model\SysUserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IncomeFromCompanyFilter {
    private $items = null;
    private $request = null;

    static function getFilterBlock(){
        return 'page.__filter.income_from_company';
    }

    static function filter(Request $request, $items){
        $el = new IncomeFromCompanyFilter();
        $el->start($request, $items);

        return  $el->getResult();
    }

    function start(Request $request, $items){
        $this->request = $request;
        $this->items = $items;

        $this->filterName();
        $this->filterInBranch();
        $this->filterFromCompany();
        $this->filterStatus();
        $this->filterForManager();
        $this->filterDate();
        $this->filterNote();
    }

    function getResult(){
        return $this->items;
    }

    private  function filterName(){
        if (!$this->request->has('name') || !$this->request->name)
            return;

        $this->items->where('name', 'like', '%'.$this->request->name.'%');
    }


    private  function filterInBranch(){
        if (!$this->request->has('branch_id') || !$this->request->branch_id)
            return;

        $this->items->where('branch_id',$this->request->branch_id);
    }

    private  function filterFromCompany(){
        if (!$this->request->has('company_id') || !$this->request->company_id)
            return;

        $this->items->where('from_company_id', $this->request->company_id);
    }

    private  function filterStatus(){
        if (!$this->request->has('status') || !$this->request->status)
            return;

        $request = $this->request;
        $this->items->whereHas('relPositions', function($q) use ($request){
            $q->where('status_id', $request->status);
        });
    }

    private  function filterForManager(){
        if (Auth::user()->type_id != SysUserType::MANAGER)
            return;

        $request = $this->request;
        $this->items->whereHas('relPositions', function($q) use ($request){
            $q->where('status_id', SysPositionStatus::ACTIVE);
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

    private  function filterNote(){
        if (!$this->request->has('note') || !$this->request->note)
            return;

        $request = $this->request;
        $this->items->where('note','like','%'.$this->request->note.'%');
    }


}

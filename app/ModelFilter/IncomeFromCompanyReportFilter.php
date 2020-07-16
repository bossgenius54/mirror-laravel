<?php

namespace App\ModelFilter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeFromCompanyReportFilter extends Model
{
    private $items = null;
    private $request = null;

    static function getFilterBlock(){
        return 'page.report.income_from_company.filter';
    }

    static function filter(Request $request, $items){
        $el = new IncomeFromCompanyReportFilter();
        $el->start($request, $items);

        return  $el->getResult();
    }

    function start(Request $request, $items){
        $this->request = $request;
        $this->items = $items;

        $this->filterName();
        $this->filterCatId();
        $this->filterBranch();
        $this->filterCreatedAt();
    }

    function getResult(){
        return $this->items;
    }

    private  function filterName(){
        if (!$this->request->has('name') || !$this->request->name)
            return;

        $this->items->where('name', 'like', '%'.$this->request->name.'%');
    }

    private  function filterBranch(){
        if (!$this->request->has('branch_id') || !$this->request->branch_id)
            return;

        $request = $this->request;
        $this->items->where('branch_id', $request->branch_id);
    }

    private  function filterCatId(){
        if (!$this->request->has('cat_id') || !$this->request->cat_id)
            return;
        $request = $this->request;
        $this->items->whereHas('relIncomePosition', function($q) use ($request){
            $q->whereHas('relPosition', function($r) use ($request){
                $r->whereHas('relProduct',function($e) use ($request){
                    $e->where('cat_id', $request->cat_id);
                });
            });
        });;
    }

    private  function filterCreatedAt(){
        if (!$this->request->has('created_at_first') || !$this->request->created_at_first)
            return;

        $request = $this->request;
        $this->items->whereBetween(DB::raw('DATE(created_at)'), array($request->created_at_first, $request->created_at_second) );
    }
}


<?php

namespace App\ModelFilter;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SaleReportFilter extends Model
{
    private $items = null;
    private $request = null;

    static function getFilterBlock(){
        return 'page.report.sale.filter';
    }

    static function filter(Request $request, $items){
        $el = new SaleReportFilter();
        $el->start($request, $items);

        return  $el->getResult();
    }

    function start(Request $request, $items){
        $this->request = $request;
        $this->items = $items;

        $this->filterName();
        $this->filterCatId();
        $this->filterBranch();
        $this->filterCreatedOrderPosition();
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
        $this->items->whereHas('relOrderPosition', function($q) use ($request) {
            $q->whereHas('relOrder', function($query) use ($request){
                $query->where('branch_id', $request->branch_id);
            });
        });
    }

    private  function filterCatId(){
        if (!$this->request->has('cat_id') || !$this->request->cat_id)
            return;

        $this->items->where('cat_id', $this->request->cat_id);
    }

    private  function filterCreatedOrderPosition(){
        if (!$this->request->has('created_at_first') || !$this->request->created_at_first)
            return;

        $request = $this->request;
        $this->items->whereHas('relOrderPosition', function($q) use ($request){
            $q->whereBetween(DB::raw('DATE(created_at)'), array($request->created_at_first, $request->created_at_second) );
        });
    }

}

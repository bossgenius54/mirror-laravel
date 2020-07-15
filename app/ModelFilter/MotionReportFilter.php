<?php

namespace App\ModelFilter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MotionReportFilter extends Model
{
    private $items = null;
    private $request = null;

    static function getFilterBlock(){
        return 'page.report.motion.filter';
    }

    static function filter(Request $request, $items){
        $el = new MotionReportFilter();
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

        $request = $this->request;
        $this->items->whereHas('relMotionPosition', function($qu) use ($request){
            $qu->with(['relPosition' => function($q) use ($request){
                $q->whereHas('relProduct',function($e) use ($request){
                    $e->where('name', 'like', '%'.$request->name.'%');
                });
            }]);
        });
    }

    private  function filterBranch(){
        if (!$this->request->has('branch_id') || !$this->request->branch_id)
            return;

        $request = $this->request;
        $this->items->where('from_branch_id', $request->branch_id);
    }

    private  function filterCatId(){
        if (!$this->request->has('cat_id') || !$this->request->cat_id)
            return;

        $request = $this->request;
        $this->items->whereHas('relMotionPosition', function($qu) use ($request){
            $qu->with(['relPosition' => function($q) use ($request){
                $q->whereHas('relProduct',function($e) use ($request){
                    $e->where('cat_id', $request->cat_id);
                });
            }]);
        });
    }

    private  function filterCreatedAt(){
        if (!$this->request->has('created_at_first') || !$this->request->created_at_first)
            return;

        $request = $this->request;
        $this->items->whereBetween(DB::raw('DATE(updated_at)'), array($request->created_at_first, $request->created_at_second) );
    }
}


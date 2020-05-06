<?php
namespace App\ModelFilter;

use Illuminate\Http\Request;

use App\Model\SysUserType;

class FormulaFilter {
    private $items = null;
    private $request = null;

    static function getFilterBlock(){
        return 'page.__filter.filter';
    }

    static function filter(Request $request, $items){
        $el = new FormulaFilter();
        $el->start($request, $items);

        return  $el->getResult();
    }

    function start(Request $request, $items){
        $this->request = $request;
        $this->items = $items;

        $this->filterId();
        $this->filterClientName();
        $this->filterType();
        $this->filterDoctor();
        $this->filterDate();
    }

    function getResult(){
        return $this->items;
    }

    private  function filterId(){
        if (!$this->request->has('formula_id') || !$this->request->formula_id)
            return;

        $this->items->where('id', 'like', '%'.$this->request->formula_id.'%');
    }

    private  function filterClientName(){
        if (!$this->request->has('client_name') || !$this->request->client_name)
            return;

        $this->items->whereHas('relIndivid', function($q){
            $q->where( 'name', 'like', '%' . $this->request->client_name . '%');
        });
    }

    private  function filterType(){
        if (!$this->request->has('type_id') || !$this->request->type_id)
            return;

        $this->items->where('type_id',$this->request->type_id);
    }

    private  function filterDoctor(){
        if (!$this->request->has('created_user_id') || !$this->request->created_user_id)
            return;

        $this->items->where('created_user_id', $this->request->created_user_id);
    }

    private function filterDate(){
        if (!$this->request->has('first_date') || !$this->request->first_date)
            return;

        if(!$this->request->has('second_date') || !$this->request->second_date)
        {
            $this->items->where('created_at', $this->request->first_date);
        } else {
            $this->items->whereBetween('created_at', [$this->request->first_date,$this->request->second_date]);
        }
    }

}

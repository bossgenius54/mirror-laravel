<?php
namespace App\ModelFilter;

use Illuminate\Http\Request;

use App\Model\SysUserType;

class UserFilter {
    private $items = null;
    private $request = null;

    static function get(Request $request, $items){
        $el = new UserFilter();
        $el->start($request, $items);

        return  $el->getResult();
    }

    function start(Request $request, $items){
        $this->request = $request;
        $this->items = $items;

        $this->filterName();
        $this->filterEmail();
        $this->filterIin();
        $this->filterBranch();

    }

    function getResult(){
        return $this->items;
    }


    private  function filterName(){
        if (!$this->request->has('name') || !$this->request->name)
            return;

        $this->items->where('name', 'like', '%'.$this->request->name.'%');
    }

    private  function filterEmail(){
        if (!$this->request->has('email') || !$this->request->email)
            return;

        $this->items->where('email', 'like', '%'.$this->request->email.'%');
    }

    private  function filterIin(){
        if (!$this->request->has('iin') || !$this->request->iin)
            return;

        $this->items->where('iin', 'like', '%'.$this->request->iin.'%');
    }

    
    private  function filterBranch(){
        if (!$this->request->has('branch_id') || !$this->request->branch_id)
            return;

        $this->items->where('branch_id', 'like', '%'.$this->request->branch_id.'%');
    }

}
<?php
namespace App\ModelList;

use Illuminate\Http\Request;

use App\Model\View\Doctor;
use App\Model\SysUserType;

class DoctorList {
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new DoctorList();
        $el->start($request);

        return  $el->getResult();
    }


    private function getItems(){
        $items = Doctor::where('type_id', SysUserType::DOCTOR)->where('is_active', 1);
        if ($this->user->company_id)
            $items->where('company_id', $this->user->company_id);

        $this->items = $items;
    }

    function start(Request $request){
        $this->request = $request;
        $this->user = $request->user();

        $this->getItems();

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
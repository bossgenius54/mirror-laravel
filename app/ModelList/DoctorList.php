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
    }
    
    function getResult(){
        return $this->items;
    }



}
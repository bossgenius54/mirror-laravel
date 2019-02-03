<?php
namespace App\ModelList;

use Illuminate\Http\Request;

use App\Model\ExternalDoctorSalary;
use App\Model\SysUserType;

class ExternalDoctorSalaryList {
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new ExternalDoctorSalaryList();
        $el->start($request);

        return  $el->getResult();
    }


    private function getItems(){
        $items = ExternalDoctorSalary::where('id', '>', 0);
        if ($this->user->type_id == SysUserType::EXTERNAL_DOCTOR)
            $items->where('doctor_id', $this->user->id);
        else if ($this->user->company_id)
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
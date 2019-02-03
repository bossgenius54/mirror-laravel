<?php
namespace App\ModelList;

use Illuminate\Http\Request;

use App\Model\View\ExternalDoctor;
use App\Model\SysUserType;

class ExternalDoctorList {
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new ExternalDoctorList();
        $el->start($request);

        return  $el->getResult();
    }


    private function getItems(){
        $items = ExternalDoctor::where('type_id', SysUserType::EXTERNAL_DOCTOR)->where('is_active', 1);
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
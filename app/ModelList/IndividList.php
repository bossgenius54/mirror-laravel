<?php
namespace App\ModelList;

use Illuminate\Http\Request;

use App\Model\View\Individ;
use App\Model\SysUserType;

class IndividList {
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new IndividList();
        $el->start($request);

        return  $el->getResult();
    }


    private function getItems(){
        $items = Individ::where('type_id', SysUserType::FIZ)->where('is_active', 1);
        if ($this->user->company_id){
            $user = $this->user;
            $items->whereHas('relSeller', function($q) use ($user){
                $q->where('company_id', $user->company_id);
            });
        }

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
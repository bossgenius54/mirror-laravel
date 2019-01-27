<?php
namespace App\ModelList;

use Illuminate\Http\Request;

use App\Model\Formula;
use App\Model\SysUserType;

class FormulaList {
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new FormulaList();
        $el->start($request);
        
        return  $el->getResult();
    }


    private function getItems(){
        $user = $this->user;

        $items = Formula::where('id', '>', 0);
        if ($this->user->type_id == SysUserType::FIZ)
            $items->where('user_id', $user->id);
        else if (in_array($this->user->type_id, [SysUserType::DIRECTOR, SysUserType::MANAGER, SysUserType::DOCTOR]))
            $items->whereHas('relIndivid', function($q) use ($user){
                $q->whereHas('relSeller', function($b) use ($user){
                    $b->where('company_id', $user->company_id);
                });
            });
        else if ($this->user->type_id == SysUserType::EXTERNAL_DOCTOR)
            $items->where('created_user_id', $this->user->id);
            
        $this->items = $items;
    }

    function start(Request $request){
        $this->request = $request;
        $this->user = $request->user();

        $this->getItems();

        $this->filterUser();
    }

    function getResult(){
        return $this->items;
    }


    private  function filterUser(){
        if (!$this->request->has('user_id') || !$this->request->user_id)
            return;

        $this->items->where('user_id', $this->request->user_id);
    }
}
<?php
namespace App\ModelList;

use Illuminate\Http\Request;

use App\Model\Branch;
use App\Model\Company;
use App\Model\SysUserType;
use App\Model\Client;

class BranchList {
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new BranchList();
        $el->start($request);

        return  $el->getResult();
    }
    
    private function getItems(){
        $items = Branch::where('id', '>', 0);
        if ($this->user->company_id && $this->user->type_id != SysUserType::COMPANY_CLIENT)
            $items->where('company_id', $this->user->company_id);
        
        if ($this->user->branch_id)
            $items->where('id', $this->user->branch_id);
        
        if ($this->user->type_id == SysUserType::FIZ){
            $ar_company = Client::where('client_user_id', $this->user->id)->pluck('company_id')->toArray();
            $items->whereIn('company_id', $ar_company);
        }

        if ($this->user->type_id == SysUserType::COMPANY_CLIENT){
            $ar_company = Client::where('client_company_id', $this->user->company_id)->pluck('company_id')->toArray();
            $items->whereIn('company_id', $ar_company);
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

    static function getLibAr(){
        return [
            'ar_company' => Company::getArFullPermis(),
            'ar_bool' => [0 => 'Нет', 1 => 'Да'],
        ];
    }

}
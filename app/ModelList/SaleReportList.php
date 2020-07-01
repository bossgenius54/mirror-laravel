<?php

namespace App\ModelList;

use App\Model\Product;
use App\Model\SysUserType;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SaleReportList extends Model
{
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new SaleReportList();
        $el->start($request);

        return  $el->getResult();
    }


    private function getItems(){
        $items = Product::where('company_id', $this->user->company_id);

        $this->items = $items;
    }

    function start(Request $request){
        $this->request = $request;
        $this->user = Auth::user();

        $this->getItems();
    }

    function getResult(){
        return $this->items;
    }
}

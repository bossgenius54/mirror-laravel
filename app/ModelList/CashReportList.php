<?php

namespace App\ModelList;

use App\Model\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashReportList extends Model
{
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new CashReportList();
        $el->start($request);

        return  $el->getResult();
    }


    private function getItems(){
        $request = $this->request;

        $items = Order::where('company_id', $this->user->company_id)
                        ->with(['relPositions', 'relServices', 'relCreatedUser', 'relStatus', 'relPersonCLient', 'relCompanyCLient']);

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

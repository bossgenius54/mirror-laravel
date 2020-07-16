<?php

namespace App\ModelList;

use App\Model\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientReportList extends Model
{
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new ClientReportList();
        $el->start($request);

        return  $el->getResult();
    }


    private function getItems(){
        $request = $this->request;

        $clients = IndividList::get($request);
        $items = $clients->with(['relOrder' => function($q){
            $q->with('relBranch')->orderBy('branch_id','ASC');
        }]);

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


<?php
namespace App\ModelList;

use Illuminate\Http\Request;

use App\Model\Product;
use App\Model\SysUserType;

class ProductList {
    private $items = null;
    private $request = null;

    static function get(Request $request){
        $el = new ProductList();
        $el->start($request);

        return  $el->getResult();
    }


    private function getItems(){
        $items = Product::where('id', '>', 0);
        if ($this->user->company_id)
            $items->where('company_id', $this->user->company_id);

        $this->items = $items;
    }

    function start(Request $request){
        $this->request = $request;
        $this->user = $request->user();

        $this->getItems();

        $this->filterName();
    }

    function getResult(){
        return $this->items;
    }


    private  function filterName(){
        if (!$this->request->has('name') || !$this->request->name)
            return;

        $this->items->where('name', 'like', '%'.$this->request->name.'%');
    }


}
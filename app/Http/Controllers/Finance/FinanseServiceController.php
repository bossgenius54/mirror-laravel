<?php
namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Model\Branch;
use App\Model\CompanyService;
use Illuminate\Http\Request;

use App\Model\FinanceService;
use App\Model\Product;
use App\ModelList\FinanceServiceList;

use App\ModelFilter\FinanceServiceFilter;
use Illuminate\Support\Facades\Auth;

class FinanseServiceController extends Controller{
    private $title = 'Финансы по услугам';

    function getIndex (Request $request){
        $items = FinanceServiceList::get($request);
        $items = FinanceServiceFilter::filter($request, $items);
        $user = Auth::user();

        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['filter_block'] = FinanceServiceFilter::getFilterBlock($request);
        $ar['items'] = $items->with('relBranch', 'relService')->latest()->paginate(24);
        $ar['items_service'] = CompanyService::where('company_id', $user->company_id)->pluck('name', 'id')->toArray();
        $ar['ar_branch'] = Branch::where('company_id',$user->company_id)->pluck('name', 'id')->toArray();
        $ar['user'] = $user;

        return view('page.finance.service.index', $ar);
    }

}

<?php

namespace App\Exports;

use App\Model\Branch;
use App\Model\LibProductCat;
use App\Model\SysOrderStatus;
use App\Model\SysOrderType;
use App\Model\SysPositionStatus;
use App\Model\SysUserType;
use App\ModelFilter\CashReportFilter;
use App\ModelFilter\IncomeReturnedReportFilter;
use App\ModelFilter\ProductFilter;
use App\ModelList\CashReportList;
use App\ModelList\IncomeReturnedReportList;
use App\ModelList\ProductList;
use App\ModelList\SellersList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ProductCountExport implements FromView
{
    public function  __construct(Request $request)
    {
        $this->request = $request;
        $this->title = 'Отчет о количествах на складе';
    }

    public function view(): View
    {
        $user = Auth::user();
        $ar = array();
        $request = $this->request;
        $ar['user_roles'] = SysUserType::pluck('name','id')->toArray();

        $items = ProductList::get($request);
        $items = ProductFilter::filter($request, $items);

        $ar = array();
        $ar['title'] = $this->title;
        $ar['request'] = $request;
        $ar['user'] = $user;

        $ar['ar_cat'] = LibProductCat::getAr();
        $ar['p_options'] = LibProductCat::with('relProductOptions')->get();

        $ar['filter_names'] = ProductList::get($request)->latest()->get();
        $ar['sys_nums'] = ProductList::get($request)->latest()->get();
        $ar['ar_branch'] = Branch::where('company_id', $user->company_id)->pluck('name', 'id')->toArray();

        $branch_array = [];
        foreach ( $ar['ar_branch'] as $id => $name )
        {
            array_push($branch_array, $id);
        }

        if ($request->hidden_null && $request->hidden_null == true)
        {
            $ar['items'] = $items->where('company_id', $user->company_id)->whereHas('relPositions', function($q){
                $q->where('status_id', SysPositionStatus::ACTIVE);
            })->get();
        } else {
            $ar['items'] = $items->get();
        }

        return view('page.report.product_count.excel', $ar);
    }

}

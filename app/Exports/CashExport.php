<?php

namespace App\Exports;

use App\Model\Branch;
use App\Model\LibProductCat;
use App\Model\SysOrderStatus;
use App\Model\SysOrderType;
use App\Model\SysUserType;
use App\ModelFilter\CashReportFilter;
use App\ModelFilter\IncomeReturnedReportFilter;
use App\ModelList\CashReportList;
use App\ModelList\IncomeReturnedReportList;
use App\ModelList\SellersList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class CashExport implements FromView
{
    public function  __construct(Request $request)
    {
        $this->request = $request;
        $this->title = 'Отчет о прибыли';
    }

    public function view(): View
    {
        $user = Auth::user();
        $ar = array();
        $request = $this->request;
        $ar['user_roles'] = SysUserType::pluck('name','id')->toArray();

        $items = CashReportList::get($request);
        $items = CashReportFilter::filter($request, $items);

        $ar['title'] = $this->title;
        $ar['request'] = $request;
        $ar['msg'] = '';
        $ar['user'] = $user;

        // Filter block elements
        $ar['ar_branch'] = Branch::where('company_id', $request->user()->company_id)->pluck('name', 'id')->toArray();
        $ar['ar_cat'] = LibProductCat::pluck('name', 'id')->toArray();

        $ar['managers'] = SellersList::get($request)->orderBy('branch_id', 'ASC')->get();
        $ar['order_types'] = SysOrderType::pluck('name', 'id')->toArray();
        $ar['status_end'] = SysOrderStatus::CLOSED;

        $ar['order_items'] = $items->get();

        return view('page.report.cash.excel', $ar);
    }


}


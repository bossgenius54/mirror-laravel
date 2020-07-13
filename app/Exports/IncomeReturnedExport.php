<?php

namespace App\Exports;

use App\IncomeReturned;
use App\Model\Branch;
use App\Model\LibProductCat;
use App\Model\SysOrderType;
use App\Model\SysUserType;
use App\ModelFilter\IncomeReturnedReportFilter;
use App\ModelList\IncomeReturnedReportList;
use App\ModelList\SellersList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class IncomeReturnedExport implements FromView
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

        $items = IncomeReturnedReportList::get($request);
        $items = IncomeReturnedReportFilter::filter($request, $items);

        $ar['title'] = $this->title;
        $ar['request'] = $request;
        $ar['msg'] = '';
        $ar['user'] = $user;

        // Filter block elements
        $ar['ar_branch'] = Branch::where('company_id', $request->user()->company_id)->pluck('name', 'id')->toArray();
        $ar['ar_cat'] = LibProductCat::pluck('name', 'id')->toArray();

        $ar['managers'] = SellersList::get($request)->orderBy('branch_id', 'ASC')->get();
        $ar['order_types'] = SysOrderType::pluck('name', 'id')->toArray();

        $ar['income_items'] = $items->get();

        return view('page.report.income_returned.excel', $ar);
    }


}


<?php

namespace App\Exports;

use App\Model\Branch;
use App\Model\LibProductCat;
use App\Model\SysOrderStatus;
use App\Model\SysOrderType;
use App\Model\SysPositionStatus;
use App\Model\SysUserType;
use App\ModelFilter\ClientReportFilter;
use App\ModelFilter\IncomeFromCompanyReportFilter;
use App\ModelFilter\StaffReportFilter;
use App\ModelList\ClientReportList;
use App\ModelList\IncomeFromCompanyReportList;
use App\ModelList\StaffReportList;
use App\ModelList\SellersList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class IncomeFromCompanyExport implements FromView
{
    public function  __construct(Request $request)
    {
        $this->request = $request;
        $this->title = 'Отчет по клиентам';
    }

    public function view(): View
    {
        $user = Auth::user();
        $ar = array();
        $request = $this->request;
        $ar['user_roles'] = SysUserType::pluck('name','id')->toArray();

        $items = IncomeFromCompanyReportList::get($request);
        $items = IncomeFromCompanyReportFilter::filter($request, $items);

        $ar['title'] = $this->title;
        $ar['request'] = $request;
        $ar['msg'] = '';
        $ar['ar_branch'] = Branch::where('company_id', $request->user()->company_id)->pluck('name', 'id')->toArray();
        $ar['user'] = $user;

        $ar['ar_cat'] = LibProductCat::pluck('name', 'id')->toArray();

        $ar['managers'] = SellersList::get($request)->orderBy('branch_id', 'ASC')->get();
        $ar['ar_status'] = SysPositionStatus::pluck('name', 'id')->toArray();

        $ar['income_items'] = $items->get();

        return view('page.report.income_from_company.excel', $ar);
    }


}

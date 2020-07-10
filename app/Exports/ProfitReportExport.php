<?php

namespace App\Exports;

use App\Model\Branch;
use App\Model\SysUserType;
use App\ModelFilter\ProfitProductsReportFilter;
use App\ModelList\ProfitProductsReportList;
use App\ModelList\SellersList;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class ProfitReportExport implements FromView
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

        $items = ProfitProductsReportList::get($request);
        $items = ProfitProductsReportFilter::filter($request, $items);

        $ar['title'] = $this->title;
        $ar['request'] = $request;
        $ar['msg'] = '';
        $ar['user'] = $user;

        // Filter block elements
        $ar['ar_branch'] = Branch::where('company_id', $request->user()->company_id)->pluck('name', 'id')->toArray();

        $ar['managers'] = SellersList::get($request)->orderBy('branch_id', 'ASC')->get();
        // dd($ar['managers']);

        $ar['p_items'] = $items->get();


        // dd($ar['p_items']->first());

        return view('page.report.profit.excel', $ar);
    }

}

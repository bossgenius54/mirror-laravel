<?php

namespace App\Exports;

use App\Model\Branch;
use App\Model\LibProductCat;
use App\Model\SysOrderStatus;
use App\Model\SysOrderType;
use App\Model\SysUserType;
use App\ModelFilter\ClientReportFilter;
use App\ModelFilter\StaffReportFilter;
use App\ModelList\ClientReportList;
use App\ModelList\StaffReportList;
use App\ModelList\SellersList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ClientExport implements FromView
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

        $items = ClientReportList::get($request);
        $items = ClientReportFilter::filter($request, $items);

        $ar['title'] = $this->title;
        $ar['request'] = $request;
        $ar['msg'] = '';
        $ar['ar_branch'] = Branch::where('company_id', $request->user()->company_id)->pluck('name', 'id')->toArray();
        $ar['user'] = $user;

        $ar['clients'] = $items->get();

        return view('page.report.client.excel', $ar);
    }


}

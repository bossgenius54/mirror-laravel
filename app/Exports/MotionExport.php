<?php

namespace App\Exports;

use App\Model\Branch;
use App\Model\LibProductCat;
use App\Model\SysOrderStatus;
use App\Model\SysOrderType;
use App\Model\SysUserType;
use App\ModelFilter\CashReportFilter;
use App\ModelFilter\MotionReportFilter;
use App\ModelList\CashReportList;
use App\ModelList\MotionReportList;
use App\ModelList\SellersList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class MotionExport implements FromView
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

        $items = MotionReportList::get($request);
        $items = MotionReportFilter::filter($request, $items);

        $ar['title'] = $this->title;
        $ar['request'] = $request;
        $ar['msg'] = '';
        $ar['user'] = $user;

        // Filter block elements
        $ar['ar_branch'] = Branch::where('company_id', $request->user()->company_id)->pluck('name', 'id')->toArray();
        $ar['ar_cat'] = LibProductCat::pluck('name', 'id')->toArray();

        $ar['motion_items'] = $items->get();

        return view('page.report.motion.excel', $ar);
    }


}

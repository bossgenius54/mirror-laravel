<?php

namespace App\Exports;

use App\Model\Branch;
use App\Model\CompanyService;
use App\Model\SysUserType;
use App\ModelFilter\SaleReportFilter;
use App\ModelList\SaleReportList;
use App\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class SalesReportExportView implements FromView
{
    private $title = 'Выгрузка отчета по продажам';

    public function  __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $user = Auth::user();
        $ar = array();
        $request = $this->request;

        $items = SaleReportList::get($request);
        $items = SaleReportFilter::filter($request, $items);

        $ar['title'] = $this->title;
        $ar['request'] = $request;
        $ar['msg'] = '';
        $ar['user'] = $user;
        $ar['user_roles'] = SysUserType::pluck('name','id')->toArray();

        // Filter block elements
        $ar['ar_branch'] = Branch::where('company_id', $request->user()->company_id)->pluck('name', 'id')->toArray();

        $ar['p_items'] = $items->with(['relOrderPosition' => function($q) use ($request) {
            // dd($request);
            $q->whereHas('relOrder', function($query) use ($request) {

                if($request->branch_id && $request->branch_id > 0){
                    $query->where('branch_id', $request->branch_id);
                }

                $query->orderBy('branch_id', 'DESC');

            })->with('relOrder');
        }, 'relCategory'])->get();

        $ar['s_items'] = CompanyService::where('company_id', $request->user()->company_id)
                                        ->whereHas('relOrderService', function($query) use ($request) {
                                            $query->whereBetween(DB::raw('DATE(created_at)'), array($request->created_at_first, $request->created_at_second) )
                                                ->whereHas('relOrder', function($query) use ($request) {

                                                    if($request->branch_id && $request->branch_id > 0){
                                                        $query->where('branch_id', $request->branch_id);
                                                    }

                                                    $query->orderBy('branch_id', 'DESC');
                                                });

                                        })
                                        ->with(['relOrderService' => function($q) {
                                            $q->with('relOrder');
                                        }])->get();

        return view('page.report.sale.excel', $ar);
    }
}

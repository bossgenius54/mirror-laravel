<?php

namespace App\Http\Controllers\Report;

use App\Exports\IncomeFromCompanyExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Branch;
use App\Model\LibProductCat;
use App\Model\Product;
use App\Model\SysPositionStatus;
use App\ModelFilter\IncomeFromCompanyReportFilter;
use App\ModelList\IncomeFromCompanyReportList;
use App\ModelList\SellersList;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Date\Date;
use Maatwebsite\Excel\Facades\Excel;


class IncomeFromCompanyReportController extends Controller
{
    private $title = 'Отчет по оприходованию';

    function getIndex (Request $request){
        $user = Auth::user();

        $ar = array();

        $items = IncomeFromCompanyReportList::get($request);
        $items = IncomeFromCompanyReportFilter::filter($request, $items);

        $ar['title'] = $this->title;
        $ar['request'] = $request;
        $ar['msg'] = '';
        $ar['user'] = $user;

        // Filter block elements
        $ar['filter_block'] = IncomeFromCompanyReportFilter::getFilterBlock();
        $ar['ar_branch'] = Branch::where('company_id', $request->user()->company_id)->pluck('name', 'id')->toArray();
        $ar['product_names'] = Product::where('company_id', $request->user()->company_id)->get();
        $ar['product_sys_num'] = Product::where('company_id', $request->user()->company_id)->get();
        $ar['ar_cat'] = LibProductCat::pluck('name', 'id')->toArray();

        $ar['managers'] = SellersList::get($request)->orderBy('branch_id', 'ASC')->get();
        $ar['ar_status'] = SysPositionStatus::pluck('name', 'id')->toArray();

        if ( !$request->filtered && $request->filtered != 'true' ){
            $ar['msg'] = 'Вам нужно отфильтровать элементы перед показом, как минимум укажите период даты возврата';
            $ar['items'] = [];
            return view('page.report.income_from_company.index', $ar);
        }

        $ar['income_items'] = $items->get();

        // dd($ar['income_items']);

        return view('page.report.income_from_company.index', $ar);
    }

    function getExcel (Request $request){
        $user = Auth::user();
        $ar = array();

        $ar['title'] = $this->title;

        // dd(!isset($request->filtered));
        if ( !isset($request->filtered) && $request->filtered != 'true' ){
            return redirect()->action('Report\IncomeFromCompanyReportController@getIndex')->with('error', 'Перед загрузкой, отфильтруйте элементы!');
        } else {
            $date1 = new Date($request->created_at_first);
            $date1 = $date1->format('d.m.Y');

            $date2 = new Date($request->created_at_second);
            $date2 = $date2->format('d.m.Y');

            $date = $date1 . '-' . $date2;
            return Excel::download(new IncomeFromCompanyExport($request), $this->title . ' ' . $date .'.xlsx');
        }

    }
}

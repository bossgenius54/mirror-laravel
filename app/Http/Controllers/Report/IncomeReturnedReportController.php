<?php

namespace App\Http\Controllers\Report;

use App\Exports\IncomeReturnedExport;
use App\Exports\ProfitReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Branch;
use App\Model\LibProductCat;
use App\Model\Product;
use App\Model\SysOrderType;
use App\ModelFilter\IncomeReturnedReportFilter;
use App\ModelFilter\ProfitProductsReportFilter;
use App\ModelList\IncomeReturnedReportList;
use App\ModelList\ProfitProductsReportList;
use App\ModelList\SellersList;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Date\Date;
use Maatwebsite\Excel\Facades\Excel;

class IncomeReturnedReportController extends Controller
{
    private $title = 'Отчет по возвратам';

    function getIndex (Request $request){
        $user = Auth::user();

        $ar = array();

        $items = IncomeReturnedReportList::get($request);
        $items = IncomeReturnedReportFilter::filter($request, $items);

        $ar['title'] = $this->title;
        $ar['request'] = $request;
        $ar['msg'] = '';
        $ar['user'] = $user;

        // Filter block elements
        $ar['filter_block'] = ProfitProductsReportFilter::getFilterBlock();
        $ar['ar_branch'] = Branch::where('company_id', $request->user()->company_id)->pluck('name', 'id')->toArray();
        $ar['product_names'] = Product::where('company_id', $request->user()->company_id)->get();
        $ar['product_sys_num'] = Product::where('company_id', $request->user()->company_id)->get();
        $ar['ar_cat'] = LibProductCat::pluck('name', 'id')->toArray();


        $ar['managers'] = SellersList::get($request)->orderBy('branch_id', 'ASC')->get();
        $ar['order_types'] = SysOrderType::pluck('name', 'id')->toArray();
        // dd($ar['managers']);

        if ( !$request->filtered && $request->filtered != 'true' ){
            $ar['msg'] = 'Вам нужно отфильтровать элементы перед показом, как минимум укажите период даты возврата';
            $ar['items'] = [];
            return view('page.report.profit.index', $ar);
        }

        $ar['income_items'] = $items->get();


        // dd($ar['income_items']->first());

        return view('page.report.income_returned.index', $ar);
    }

    function getExcel (Request $request){
        $user = Auth::user();
        $ar = array();

        $ar['title'] = $this->title;

        // dd(!isset($request->filtered));
        if ( !isset($request->filtered) && $request->filtered != 'true' ){
            return redirect()->action('Report\IncomeReturnedReportController@getIndex')->with('error', 'Перед загрузкой, отфильтруйте элементы!');
        } else {
            $date1 = new Date($request->created_at_first);
            $date1 = $date1->format('d.m.Y');

            $date2 = new Date($request->created_at_second);
            $date2 = $date2->format('d.m.Y');

            $date = $date1 . '-' . $date2;
            return Excel::download(new IncomeReturnedExport($request), 'Отчет_по_возвратам_'. $date .'.xlsx');
        }

    }
}

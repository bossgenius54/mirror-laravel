<?php

namespace App\Http\Controllers\Report;

use App\Exports\ProfitReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Branch;
use App\Model\LibProductCat;
use App\Model\Product;
use App\ModelFilter\ProfitProductsReportFilter;
use App\ModelList\ProfitProductsReportList;
use App\ModelList\SellersList;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Date\Date;
use Maatwebsite\Excel\Facades\Excel;

class ProfitReportController extends Controller
{
    private $title = 'Отчет о прибыли';

    function getIndex (Request $request){
        $user = Auth::user();
        $ar = array();

        $items = ProfitProductsReportList::get($request);
        $items = ProfitProductsReportFilter::filter($request, $items);

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
        // dd($ar['managers']);

        if ( !$request->filtered && $request->filtered != 'true' ){
            $ar['msg'] = 'Вам нужно отфильтровать элементы перед показом, как минимум укажите период продажи позиции';
            $ar['items'] = [];
            return view('page.report.profit.index', $ar);
        }

        $ar['p_items'] = $items->get();


        // dd($ar['p_items']->first());

        return view('page.report.profit.index', $ar);
    }

    function getExcel (Request $request){
        $user = Auth::user();
        $ar = array();

        $ar['title'] = $this->title;

        // dd(!isset($request->filtered));
        if ( !isset($request->filtered) && $request->filtered != 'true' ){
            return redirect()->action('Report\ProfitReportController@getIndex')->with('error', 'Перед загрузкой, отфильтруйте элементы!');
        } else {
            $date1 = new Date($request->created_at_first);
            $date1 = $date1->format('d.m.Y');

            $date2 = new Date($request->created_at_second);
            $date2 = $date2->format('d.m.Y');

            $date = $date1 . '-' . $date2;
            return Excel::download(new ProfitReportExport($request), 'Отчет_о_прибыли_'. $date .'.xlsx');
        }

    }
}

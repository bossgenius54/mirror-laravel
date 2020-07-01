<?php

namespace App\Http\Controllers\Report;

use App\Exports\SalesReportExportView;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Branch;
use App\Model\CompanyService;
use App\Model\LibProductCat;
use App\Model\Product;
use App\ModelFilter\SaleReportFilter;
use App\ModelList\SaleReportList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jenssegers\Date\Date;
use Maatwebsite\Excel\Facades\Excel;

class SaleReportController extends Controller
{
    private $title = 'Отчет по продажам';

    function getIndex (Request $request){
        $user = Auth::user();
        $ar = array();

        $items = SaleReportList::get($request);
        $items = SaleReportFilter::filter($request, $items);

        $ar['title'] = $this->title;
        $ar['request'] = $request;
        $ar['msg'] = '';
        $ar['user'] = $user;

        // Filter block elements
        $ar['filter_block'] = SaleReportFilter::getFilterBlock();
        $ar['ar_branch'] = Branch::where('company_id', $request->user()->company_id)->pluck('name', 'id')->toArray();
        $ar['product_names'] = Product::where('company_id', $request->user()->company_id)->get();
        $ar['product_sys_num'] = Product::where('company_id', $request->user()->company_id)->get();
        $ar['ar_cat'] = LibProductCat::pluck('name', 'id')->toArray();

        if ( !$request->filtered && $request->filtered != 'true' ){
            $ar['msg'] = 'Вам нужно отфильтровать элементы перед показом, как минимум укажите период продажи позиции';
            $ar['items'] = [];
            return view('page.report.sale.index', $ar);
        }

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

        // dd($ar['s_items']);

        return view('page.report.sale.index', $ar);
    }

    function getExcel (Request $request){
        $user = Auth::user();
        $ar = array();

        $ar['title'] = $this->title;

        if ( !$request->filtered && $request->filtered != 'true' ){
            return redirect()->action('Report\SaleReportController@getExcel')->with('error', 'Перед загрузкой, отфильтруйте элементы!');
        }

        $date1 = new Date($request->created_at_first);
        $date1 = $date1->format('d.m.Y');

        $date2 = new Date($request->created_at_second);
        $date2 = $date2->format('d.m.Y');

        $date = $date1 . '-' . $date2;
        return Excel::download(new SalesReportExportView($request), 'Отчет_по_продажам_'. $date .'.xlsx');
    }
}

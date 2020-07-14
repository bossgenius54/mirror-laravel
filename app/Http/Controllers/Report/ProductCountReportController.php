<?php

namespace App\Http\Controllers\Report;

use App\Exports\ProductCountExport;
use App\Http\Controllers\Controller;
use App\Model\Branch;
use Illuminate\Http\Request;
use App\ModelList\ProductList;
use App\ModelFilter\ProductFilter;
use App\Model\LibProductCat;
use App\Model\SysPositionStatus;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Date\Date;
use Maatwebsite\Excel\Facades\Excel;

class ProductCountReportController extends Controller
{
    private $title = 'Отчет по кол-вам на складах компаниях';

    function getIndex (Request $request){
        $user = Auth::user();

        $items = ProductList::get($request);
        $items = ProductFilter::filter($request, $items);

        $ar = array();
        $ar['title'] = $this->title;
        $ar['request'] = $request;

        $ar['ar_cat'] = LibProductCat::getAr();
        $ar['p_options'] = LibProductCat::with('relProductOptions')->get();

        $ar['filter_names'] = ProductList::get($request)->latest()->get();
        $ar['sys_nums'] = ProductList::get($request)->latest()->get();
        $ar['ar_branch'] = Branch::where('company_id', $user->company_id)->pluck('name', 'id')->toArray();

        $branch_array = [];
        foreach ( $ar['ar_branch'] as $id => $name )
        {
            array_push($branch_array, $id);
        }

        if ($request->hidden_null && $request->hidden_null == true)
        {
            $ar['items'] = $items->where('company_id', $user->company_id)->whereHas('relPositions', function($q){
                $q->where('status_id', SysPositionStatus::ACTIVE);
            })->latest()->paginate(12);
        } else {
            $ar['items'] = $items->latest()->paginate(12);
        }

        return view('page.report.product_count.index', $ar);
    }

    function getExcel (Request $request){
        $user = Auth::user();
        $ar = array();

        $ar['title'] = $this->title;

        // dd(!isset($request->filtered));
        if ( !isset($request->filtered) && $request->filtered != 'true' ){
            return redirect()->action('Report\CashReportController@getIndex')->with('error', 'Перед загрузкой, отфильтруйте элементы!');
        } else {

            return Excel::download(new ProductCountExport($request), $this->title .'.xlsx');
        }

    }
}

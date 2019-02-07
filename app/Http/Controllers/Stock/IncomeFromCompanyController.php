<?php
namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\View\IncomeFromCompany;
use App\ModelList\IncomeFromCompanyList;
use App\Model\Company;
use App\Model\Branch;
use App\Model\Product;
use App\Model\SysUserType;
use App\Model\SysIncomeType;
use App\Model\SysPositionStatus;
use App\Model\Position;
use App\Model\IncomePosition;


use App\Model\Finance;
use App\Model\FinancePosition;
use App\Model\FinanceService;

use App\Services\Finance\CreateFinanceModel;

use App\ModelFilter\IncomeFromCompanyFilter;

use DB;
use Exception;

class IncomeFromCompanyController extends Controller{
    private $title = 'Оприходование';

    function getIndex (Request $request){
        $items = IncomeFromCompanyList::get($request);
        $items = IncomeFromCompanyFilter::filter($request, $items);

        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['filter_block'] = IncomeFromCompanyFilter::getFilterBlock($request);
        $ar['items'] = $items->latest()->paginate(24);

        return view('page.stock.income_from_company.index', $ar);
    }

    function getView(Request $request, IncomeFromCompany $item){
        $positions = false;
        $services = false;
        $finance = Finance::where('income_id', $item->id)->first();
        if ($finance){
            $positions = FinancePosition::where('finance_id', $finance->id)->with('relProduct')->get();
            $services = FinanceService::where('finance_id', $finance->id)->with('relService')->get();
        }
            
        

        $ar = array();
        $ar['title'] = 'Детализация элемента списока "'.$this->title.'"';
        $ar['ar_type'] = SysIncomeType::pluck('name', 'id')->toArray();
        $ar['positions'] = $positions;
        $ar['services'] = $services;
        $ar['item'] = $item;

        return view('page.stock.income_from_company.view', $ar);
    }

    function getCreate(Request $request){
        $user = $request->user();
        $products = Product::where('company_id', $user->company_id)->select('id', 'sys_num', 'name')->get();

        $ar_company = Company::whereHas('relSeller', function($q) use ($user){
                            $q->where('company_id', $user->company_id);
                        })->pluck('name', 'id')->toArray();

        $branches = Branch::where('company_id', $request->user()->company_id);
        if (in_array($user->type_id, [SysUserType::MANAGER]))
            $branches->where('id', $request->user()->branch_id);

        $ar = array();
        $ar['title'] = 'Добавить элемент в список "'.$this->title.'"';
        $ar['action'] = action('Stock\IncomeFromCompanyController@postCreate');
        $ar['ar_branch'] = $branches->pluck('name', 'id')->toArray();
        $ar['products'] = $products;
        $ar['ar_company'] = $ar_company;

        return view('page.stock.income_from_company.create', $ar);
    }

    function postCreate(Request $request){
        $ar = $request->all();
        $ar['type_id'] = SysIncomeType::FROM_COMPANY;
        $ar['company_id'] = $request->user()->company_id;

        
        if (!isset($ar['product_id']) && count($ar['product_id']) > 0)
            return redirect()->back()->with('error', 'Не указаны товары для оприходования');
      

        DB::beginTransaction();
        try {
            $income = IncomeFromCompany::create($ar);
            $max_id = Position::max('id');

            
            $ar_income_position = [];
            $ar_posiiton = [];

            $ar_el = [];
            $ar_el['branch_id'] = $income->branch_id;
            $ar_el['status_id'] = SysPositionStatus::ACTIVE;
            $ar_el['income_id'] = $income->id;

            foreach ($ar['product_id'] as $k => $product_id) {
                $ar_el['product_id'] = $product_id;
                $ar_el['price_cost'] =  $ar['product_cost'][$k];
                $ar_el['expired_at'] =  $ar['product_date'][$k];
                for ($i = 1; $i <= $ar['product_count'][$k]; $i++) {
                    $max_id++;
                    $ar_el['sys_num'] = $max_id; 

                    $ar_posiiton[] = $ar_el;

                    $ar_income_position[] = [
                        'income_id' => $income->id,
                        'position_sys_num' => $ar_el['sys_num']
                    ];

                    $income->related_cost += $ar['product_cost'][$k];
                }
            }
            $income->save();

            Position::insert($ar_posiiton); 

            IncomePosition::insert($ar_income_position); 

            Position::where('income_id', $income->id)->update([
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ]);

            CreateFinanceModel::createBeginIncome($income);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
        
        return redirect()->action("Stock\IncomeFromCompanyController@getIndex")->with('success', 'Добавлен элемент списка "'.$this->title.'" № '.$income->id);
    }

    function getDelete(Request $request, IncomeFromCompany $item){
        if (Position::where('income_id', $item->id)->where('status_id', '<>', SysPositionStatus::ACTIVE)->count() > 0)
            return redirect()->back()->with('error', 'У указанного оприходования позиции в обороте');

        $id = $item->id;
        $item->delete();

        return redirect()->back()->with('success', 'Удален элемент списка "'.$this->title.'" № '.$id);
    }

}

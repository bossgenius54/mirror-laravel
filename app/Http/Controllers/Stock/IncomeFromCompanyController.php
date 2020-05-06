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
        $products = false;
        $finance = Finance::where('income_id', $item->id)->first();
        if ($finance){
            $positions = FinancePosition::where('finance_id', $finance->id)->with('relProduct')->paginate(24);
            $services = FinanceService::where('finance_id', $finance->id)->with('relService')->get();
            $products = Position::getStatByIncome($item->id);
        }
            
        $user = $request->user();

        $ar = array();
        $ar['title'] = 'Детализация элемента списока "'.$this->title.'"';
        $ar['ar_type'] = SysIncomeType::pluck('name', 'id')->toArray();
        $ar['positions'] = $positions;
        $ar['services'] = $services;
        $ar['products'] = $products;
        $ar['item'] = $item;
        $ar['prods'] = Product::where('company_id', $user->company_id)->select('id', 'sys_num', 'name', 'artikul')->get();

        //dd($products);

        return view('page.stock.income_from_company.view', $ar);
    }

    function getCreate(Request $request){
        $user = $request->user();
        $products = Product::where('company_id', $user->company_id)->select('id', 'sys_num', 'name', 'artikul')->get();

        $ar_company = Company::where('id', '<>', $request->user()->company_id)->pluck('name', 'id')->toArray();

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
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $ar = $request->all();
        $ar['type_id'] = SysIncomeType::FROM_COMPANY;
        $ar['company_id'] = $request->user()->company_id;

        
        if (!isset($ar['product_id']))
            return redirect()->back()->with('error', 'Не указаны товары для оприходования');
      

        DB::beginTransaction();
        try {
            $income = IncomeFromCompany::create($ar);
            $max_id = Position::max('id');

            
            $ar_income_position = [];
            $ar_posiiton = [];

            $ar_el = [];
            $ar_el['branch_id'] = $income->branch_id;
            $ar_el['status_id'] = SysPositionStatus::IN_INCOME;
            $ar_el['income_id'] = $income->id;

            foreach ($ar['product_id'] as $k => $product_id) {
                $ar_el['product_id'] = $product_id;
                $ar_el['price_cost'] =  $ar['product_cost'][$k];
                $ar_el['expired_at'] =  $ar['product_date'][$k];
                $ar_el['group_num'] = $k.rand(100, 999);
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

            //dd($ar, count($ar_posiiton));
            $ar_posiiton = collect($ar_posiiton);
            $ar_posiiton = $ar_posiiton->chunk(500);

            foreach ($ar_posiiton as $ar_pos){
                Position::insert($ar_pos->toArray()); 
            }

            $ar_income_position = collect($ar_income_position);
            $ar_income_position = $ar_income_position->chunk(500);
            
            foreach ($ar_income_position as $ar_income){
                IncomePosition::insert($ar_income->toArray()); 
            }

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

    function getActiveProduct(Request $request, IncomeFromCompany $item){
        Position::where('income_id', $item->id)->where(['status_id' => SysPositionStatus::IN_INCOME])->update(
            [
                'status_id' => SysPositionStatus::ACTIVE
            ]
        );

        return redirect()->back()->with('success', 'Позиции  продукции № '.$item->id.' активны');
    }

    function getDelete(Request $request, IncomeFromCompany $item){
        if (Position::where('income_id', $item->id)->where('status_id', '<>', SysPositionStatus::ACTIVE)->count() > 0)
            return redirect()->back()->with('error', 'У указанного оприходования позиции в обороте');

        $id = $item->id;
        $item->delete();

        return redirect()->back()->with('success', 'Удален элемент списка "'.$this->title.'" № '.$id);
    }

    function postChange(Request $request, IncomeFromCompany $item){
        ini_set('memory_limit', '512M');
        set_time_limit(300);
        //dd($request->all(), $item);

        $income = $item;
        DB::beginTransaction();
        try {
            Position::where([
                'income_id' => $item->id,
                'group_num' => $request->position_group_num
            ])->delete();
            
            Finance::where('income_id', $item->id)->delete();

            if (!$request->need_delete){
                $max_id = Position::max('id');

                $ar_income_position = [];
                $ar_posiiton = [];
    
                $ar_el = [];
                $ar_el['branch_id'] = $income->branch_id;
                $ar_el['status_id'] = SysPositionStatus::IN_INCOME;
                $ar_el['income_id'] = $income->id;
                $ar_el['product_id'] = $request->product_id;
                $ar_el['price_cost'] =  $request->price_cost;
                $ar_el['expired_at'] =  $request->expired_at;
                $ar_el['group_num'] =  $request->position_group_num;

    
            
                for ($i = 1; $i <= $request->product_count; $i++) {
                    $max_id++;
                    $ar_el['sys_num'] = $max_id; 

                    $ar_posiiton[] = $ar_el;

                    $ar_income_position[] = [
                        'income_id' => $income->id,
                        'position_sys_num' => $ar_el['sys_num']
                    ];
                }
               
                $ar_posiiton = collect($ar_posiiton);
                $ar_posiiton = $ar_posiiton->chunk(500);
    
                foreach ($ar_posiiton as $ar_pos){
                    Position::insert($ar_pos->toArray()); 
                }
    
                $ar_income_position = collect($ar_income_position);
                $ar_income_position = $ar_income_position->chunk(500);
                
                foreach ($ar_income_position as $ar_income){
                    IncomePosition::insert($ar_income->toArray()); 
                }
    
                Position::where('income_id', $income->id)->where('group_num', $request->position_group_num)->update([
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                ]);

                
                $income->related_cost = Position::where('income_id', $item->id)->sum('price_cost');
                $income->save();
    
            }
            
            CreateFinanceModel::createBeginIncome($item);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }


        return redirect()->back()->with('success', 'Позиции  продукции № '.$item->id.' изменены');
    }


    function postAdd(Request $request, IncomeFromCompany $item){
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $income = $item;
        DB::beginTransaction();
        try {
            
            Finance::where('income_id', $item->id)->delete();

          
            $max_id = Position::max('id');

            $ar_income_position = [];
            $ar_posiiton = [];
            $group_num = $max_id.rand(100, 999); // creating group num before init to use it later for setting datestamp

            $ar_el = [];
            $ar_el['branch_id'] = $income->branch_id;
            $ar_el['status_id'] = SysPositionStatus::IN_INCOME;
            $ar_el['income_id'] = $income->id;
            $ar_el['product_id'] = $request->product_id;
            $ar_el['price_cost'] =  $request->price_cost;
            $ar_el['group_num'] =  $group_num;
            
        
            for ($i = 1; $i <= $request->product_count; $i++) {
                $max_id++;
                $ar_el['sys_num'] = $max_id; 

                $ar_posiiton[] = $ar_el;

                $ar_income_position[] = [
                    'income_id' => $income->id,
                    'position_sys_num' => $ar_el['sys_num']
                ];
            }

            $ar_posiiton = collect($ar_posiiton);
            $ar_posiiton = $ar_posiiton->chunk(500);

            foreach ($ar_posiiton as $ar_pos){
                Position::insert($ar_pos->toArray()); 
            }

            $ar_income_position = collect($ar_income_position);
            $ar_income_position = $ar_income_position->chunk(500);
            
            foreach ($ar_income_position as $ar_income){
                IncomePosition::insert($ar_income->toArray()); 
            }

            // following sql request adding current datestamp for last updates
            Position::where('income_id', $income->id)->where('group_num', $group_num)->update([
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ]);
            
            $income->related_cost = Position::where('income_id', $item->id)->sum('price_cost');
            $income->save();

            
            
            CreateFinanceModel::createBeginIncome($item);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Позиции  продукции № '.$item->id.' добавлены');
    }
}

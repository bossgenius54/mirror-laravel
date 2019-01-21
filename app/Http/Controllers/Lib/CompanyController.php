<?php
namespace App\Http\Controllers\Lib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Company;
use App\Model\CompanyData;
use App\Model\LibCompanyCat;
use App\Model\SysCompanyType;
use App\Model\SysUserType;

use DB;
use Exception;

class CompanyController extends Controller{
    private $title = 'Компании';

    private function getItems(Request $request){
        $user = $request->user();

        $items = Company::where('id', '>', 0);
        if (in_array($user->type_id, [SysUserType::DIRECTOR, SysUserType::MANAGER, SysUserType::ACCOUNTER]))
            $items->whereHas('relSeller', function($q) use ($user){
                $q->where('company_id', $user->company_id);
            });

        return $items;
    }

    function getIndex (Request $request){
        $ar = array();
        $ar['title'] = 'Список елементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = $this->getItems($request)->latest()->paginate(24);
        $ar['ar_cat'] = LibCompanyCat::getAr();
        $ar['ar_type'] = SysCompanyType::getAr();

        return view('page.lib.company.index', $ar);
    }

    function getCreate(Request $request){
        $ar = array();
        $ar['title'] = 'Добавить елемент в список "'.$this->title.'"';
        $ar['action'] = action('Lib\CompanyController@postCreate');
        $ar['ar_cat'] = LibCompanyCat::getAr();
        $ar['ar_type'] = SysCompanyType::getAr();

        return view('page.lib.company.create', $ar);
    }

    function postCreate(Request $request){
        DB::beginTransaction();

        try {
            $ar = $request->all();
            $ar['type_id'] = SysCompanyType::EMPTY;
            $ar['created_user_id'] = $request->user()->id;
            
            $item = Company::create($ar);
            $ar['company_id'] = $item->id;
            $data = CompanyData::create($ar);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
       
        
        return redirect()->action("Lib\CompanyController@getIndex")->with('success', 'Добавлен елемент списка "'.$this->title.'" № '.$item->id);
    }

    function getUpdate(Request $request, Company $item){
        $ar = array();
        $ar['title'] = 'Изменить елемент № '. $item->id.' списка "'.$this->title.'"';
        $ar['item'] = $item;
        $ar['data'] = $item->relData;
        $ar['ar_cat'] = LibCompanyCat::getAr();
        $ar['ar_type'] = SysCompanyType::getAr();
        $ar['action'] = action('Lib\CompanyController@postUpdate', $item);

        return view('page.lib.company.update', $ar);
    }

    function postUpdate(Request $request, Company $item){
        DB::beginTransaction();

        try {
            $ar = $request->all();
            $item->update($ar);
            $data = $item->relData;
            $data->update($ar);
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->action("Lib\CompanyController@getIndex")->with('success', 'Изменен елемент списка "'.$this->title.'" № '.$item->id);
    }

    function getDelete(Request $request, Company $item){
        $id = $item->id;
        $item->delete();

        return redirect()->back()->with('success', 'Удален елемент списка "'.$this->title.'" № '.$id);
    }

    function getUpgradeToHalfPermission(Request $request, Company $item){
        $item->update([
            'type_id' => SysCompanyType::HALF
        ]);

        return redirect()->back()->with('success', 'Изменены права доступа елемента из списка "'.$this->title.'" № '.$item->id);

    }

    function getUpgradeToFullPermission(Request $request, Company $item){
        $item->update([
            'type_id' => SysCompanyType::FULL
        ]);

        return redirect()->back()->with('success', 'Изменены права доступа елемента из списка "'.$this->title.'" № '.$item->id);
    }
}

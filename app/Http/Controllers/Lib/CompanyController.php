<?php
namespace App\Http\Controllers\Lib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Company;
use App\Model\CompanyData;
use App\Model\LibCompanyCat;
use App\Model\SysCompanyType;
use App\Model\SysUserType;
use App\ModelList\CompanyList;

use DB;
use Exception;

class CompanyController extends Controller{
    private $title = 'Компании';

    function getIndex (Request $request){
        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = CompanyList::get($request)->latest()->paginate(24);

        $ar['ar_cat'] = LibCompanyCat::getAr();
        $ar['ar_type'] = SysCompanyType::getAr();

        return view('page.lib.company.index', $ar);
    }

    function getCreate(Request $request){
        $ar = array();
        $ar['title'] = 'Добавить элемент в список "'.$this->title.'"';
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
            $ar['created_company_id'] = $request->user()->company_id;

            $item = Company::create($ar);
            $ar['company_id'] = $item->id;
            $data = CompanyData::create($ar);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }


        return redirect()->action("Lib\CompanyController@getIndex")->with('success', 'Добавлен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getUpdate(Request $request, Company $item){
        $ar = array();
        $ar['title'] = 'Изменить элемент № '. $item->id.' списка "'.$this->title.'"';
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

        return redirect()->action("Lib\CompanyController@getIndex")->with('success', 'Изменен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getDelete(Request $request, Company $item){
        $id = $item->id;
        $item->delete();

        return redirect()->back()->with('success', 'Удален элемент списка "'.$this->title.'" № '.$id);
    }

    function getUpgradeToHalfPermission(Request $request, Company $item){
        $item->update([
            'type_id' => SysCompanyType::HALF
        ]);

        return redirect()->back()->with('success', 'Изменены права доступа элемента из списка "'.$this->title.'" № '.$item->id);

    }

    function getUpgradeToFullPermission(Request $request, Company $item){
        $item->update([
            'type_id' => SysCompanyType::FULL
        ]);

        return redirect()->back()->with('success', 'Изменены права доступа элемента из списка "'.$this->title.'" № '.$item->id);
    }
}

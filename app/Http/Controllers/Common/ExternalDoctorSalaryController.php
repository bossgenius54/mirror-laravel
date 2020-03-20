<?php
namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use App\Helper\UploadPhoto;

use App\ModelList\ExternalDoctorSalaryList;
use App\Model\ExternalDoctorSalary;
use App\Model\SysUserType;

use App\ModelList\OrderList;
use App\ModelList\ExternalDoctorList;
use App\ModelFilter\ExternalDoctorSalaryFilter;

class ExternalDoctorSalaryController  extends Controller{
    private $title = 'Комиссионные внешнего врача';

    function getIndex (Request $request){
        $user = $request->user();
        $items = ExternalDoctorSalaryList::get($request);
        $items = ExternalDoctorSalaryFilter::filter($request, $items);

        $ar = array();
        $ar['title'] = 'Список элементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['filter_block'] = ExternalDoctorSalaryFilter::getFilterBlock($request);
        $ar['items'] = $items->latest()->paginate(24);

        return view('page.common.external_doctor_salary.index', $ar);
    }

    function getCreate(Request $request){
        $ar = array();
        $ar['title'] = 'Добавить элемент в список "'.$this->title.'"';
        $ar['action'] = action('Common\ExternalDoctorSalaryController@postCreate');

        $ar['orders'] = OrderList::get($request)->pluck('name', 'id')->toArray();
        $ar['doctors'] = ExternalDoctorList::get($request)->pluck('name', 'id')->toArray();

        return view('page.common.external_doctor_salary.create', $ar);
    }

    function postCreate(Request $request){
        $ar = $request->all();
        $ar['company_id'] = $request->user()->company_id;

        $item = ExternalDoctorSalary::create($ar);

        return redirect()->action("Common\ExternalDoctorSalaryController@getIndex")->with('success', 'Добавлен элемент списка "'.$this->title.'" № '.$item->id);
    }

    function getDelete(Request $request, ExternalDoctorSalary $item){
        $id = $item->id;
        $item->delete();

        return redirect()->back()->with('success', 'Удален элемент списка "'.$this->title.'" № '.$id);
    }

}

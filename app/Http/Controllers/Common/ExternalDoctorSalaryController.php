<?php
namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use App\Helper\UploadPhoto;

use App\ModelList\ExternalDoctorSalaryList;
use App\Model\ExternalDoctorSalary;
use App\Model\SysUserType;

class ExternalDoctorSalaryController  extends Controller{
    private $title = 'Комисионные внешнего врача';

    function getIndex (Request $request){
        $user = $request->user();

        $ar = array();
        $ar['title'] = 'Список елементов "'.$this->title.'"';
        $ar['request'] = $request;
        $ar['items'] = ExternalDoctorSalaryList::get($request)->paginate(24);

        return view('page.common.external_doctor_salary.index', $ar);
    }

}

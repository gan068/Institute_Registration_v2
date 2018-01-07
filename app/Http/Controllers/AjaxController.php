<?php

namespace App\Http\Controllers;

use App\Http\Model\Address;
use App\Http\Model\NTCUDepartment;
use App\Http\Model\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AjaxController extends Controller
{
    //$school_department
    public function schoolDepartment(Request $request)
    {
        $schoolDepartment = new School();
        $schoolDepartmentData = $schoolDepartment->schoolDepartment($request->input('schoolName'));
        $departmen = array();

        foreach ($schoolDepartmentData as $value) {
            $departmen[$value->school_id] = $value->school_department;//轉成array存放
        }
        echo json_encode($departmen);// 回傳 Ajax

    }

    public function areaName(Request $request)
    {
        $areaName = new Address();
        $areaNameSearch = $areaName->areaName($request->input('cityName'));
        $areaNameData = array();
        foreach ($areaNameSearch as $value) {
            $areaNameData[$value->ZipCode] = $value->AreaName;//轉成array存放
        }
        echo json_encode($areaNameData);
    }

    public function zipCode(Request $request)
    {
        $zipCode = new Address();
        $zipCodeSearch = $zipCode->zipCode($request->input('areaName'));
        echo $zipCodeSearch->ZipCode;
    }

    // admin ajax
    public function addNTCUDepartment(Request $request)
    {
        $NTCUDepartment = new NTCUDepartment();
        $NTCUDepartmentID = $NTCUDepartment->searchDepartmentID(
            $request->input('addName'),
            $request->input('addDegree'),
            $request->input('addClass'));
        //
        dd($NTCUDepartmentID)  ;
//        if ($NTCUDepartmentID == null) {
//            $NTCUDepartment->insertDepartment(
//                $request->input('addName'),
//                $request->input('addDegree'),
//                $request->input('addClass'));
//            //
//            echo  "新增科系成功";
//        } else {
//            echo "此科系已存在";
//        }
    }
}

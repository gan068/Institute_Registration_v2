<?php

namespace App\Http\Controllers;

use App\Http\Model\Address;
use App\Http\Model\NTCUDepartment;
use App\Http\Model\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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


        if ($NTCUDepartmentID === null) {
            $NTCUDepartment->insertDepartment(
                $request->input('addName'),
                $request->input('addDegree'),
                $request->input('addClass'));
            echo '新增成功';

        } else {
            echo '此科系以存在';
        }

    }

    public function updateNTCUDepartment(Request $request)
    {
        $NTCUDepartment = new NTCUDepartment();
        $NTCUDepartmentID = $NTCUDepartment->searchDepartmentID(
            $request->input('updateDepartmenName'),
            $request->input('updateDepartmenDegree'),
            $request->input('updateDepartmenClass'));


        if ($NTCUDepartmentID === null) {
            $NTCUDepartment->updateDepartment(
                $request->input('updateDepartmentID'),
                $request->input('updateDepartmenName'),
                $request->input('updateDepartmenDegree'),
                $request->input('updateDepartmenClass'));
            echo '更新成功';
        } else {
            echo '此科系以存在';
        }
    }

    public function deleteNTCUDepartment(Request $request)
    {
        $NTCUDepartment = new NTCUDepartment();
        $NTCUDepartment->deleteDepartment($request->input('deleteDepartmentID'));
        echo "刪除科系成功";
    }

    public function department(Request $request)
    {
        $statistics_data = DB::table('Institute_Registration_information')
            ->join('candidates_information', 'candidates_information_candidates_information_id', '=', 'candidates_information_id')
            ->join('school', 'school_school_id', '=', 'school_id')
            ->select(DB::raw("
            candidates_information.candidates_information_gender as gender,
    candidates_information.candidates_information_birthday as birthday,
    school.school_id,
    concat(
    school.school_name,'_',
    school.school_department)as school"))
            ->where('Institute_Registration_information.ntcu_department_department_id', $request->input('department_id'))
            ->orderBy('school_id', 'asc')
            ->get();
        $male = 0;
        $female = 0;

        $age20 = 0;
        $age25 = 0;
        $age30 = 0;
        $age35 = 0;
        $age40 = 0;
        $age45 = 0;
        $gender = array();
        $data = array();
        $age_range = array();
        $school_department = array();
        $school_count = array();
        $age_value = array();
        $age_name = array();

        foreach ($statistics_data as $statistics) {

            // 統計報考科系男女人數
            if ($statistics->gender === '男') {
                $male = $male + 1;
            } else {
                $female = $female + 1;
            }
            // 統計報考科系年齡區間
            $age = date("Y") - substr($statistics->birthday, 0, 4);
            if ($age <= 22) {
                $age20 = $age20 + 1;
            } elseif ($age > 22 && $age <= 25) {
                $age25 = $age25 + 1;
            } elseif ($age > 25 && $age <= 30) {
                $age30 = $age30 + 1;
            } elseif ($age > 30 && $age <= 35) {
                $age35 = $age35 + 1;
            } elseif ($age > 35 && $age <= 40) {
                $age40 = $age40 + 1;
            } else {
                $age45 = $age45 + 1;
            }
            // 統計報考學校畢業學校和科系的人數
//
            $school_data = DB::table('Institute_Registration_information')
                ->join('school', 'school_school_id', '=', 'school_id')
                ->select(DB::raw("count(school.school_id) as counts,school.school_name,school.school_department"))
                ->where('Institute_Registration_information.ntcu_department_department_id', $request->input('department_id'))
                ->groupBy('school.school_id','school.school_name','school.school_department')
                ->get();

            foreach ($school_data as $key => $school) {
                $school_department[$key] = $school->school_name . ' ' . $school->school_department;
                $school_count[$key] = $school->counts;
            }

        }
        $gender['male'] = $male;
        $gender['female'] = $female;

        $age_value[0] = $age20;
        $age_value[1] = $age25;
        $age_value[2] = $age30;
        $age_value[3] = $age35;
        $age_value[4] = $age40;
        $age_value[5] = $age45;

        $age_name[0] = "小於21歲" . $age_value[0] . "人";
        $age_name[1] = "介於22歲到25歲之間$age_value[1]人";
        $age_name[2] = "介於26歲到30歲之間$age_value[2]人";
        $age_name[3] = "介於31歲到35歲之間$age_value[3]人";
        $age_name[4] = "介於36歲到40歲之間$age_value[4]人";
        $age_name[5] = "大於41歲$age_value[5]人";

        $age = array();
        foreach ($age_value as $key => $value) {
            $age[$key]["value"] = $age_value[$key];
            $age[$key]["name"] = $age_name[$key];
        }
        $data['gender'] = $gender;
        $data['age_range_name'] = $age_name;
        $data['age_range'] = $age;
        $data['school_department'] = $school_department;
        $data['school_count'] = $school_count;
        echo json_encode($data, true);
    }


}

<?php

namespace App\Http\Controllers;

use App\Http\Model\Address;
use App\Http\Model\NTCUDepartment;
use App\Http\Model\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\Repository;

class AjaxController extends Controller
{
    protected $repo;

    public function __construct()
    {
        $this->repo = new Repository();
    }

    public function schoolDepartment(Request $request)
    {
        $school_name = $request->get('schoolName');
        $school_department_data = School::where('school_name', $school_name)
            ->pluck('school_department', 'school_id')
            ->get();

        return Response::json($school_department_data);
    }

    public function areaName(Request $request)
    {
        $city_name = $request->get('cityName');
        $area_data = Address::where('CityName', $city_name)
            ->orderBy('id', 'ASC')
            ->pluck('AreaName', 'ZipCode')
            ->get();

        return Response::json($area_data);
    }

    public function zipCode(Request $request)
    {
        $area_name = $request->get('areaName');
        $zip_code = Address::where('AreaName', $area_name)
            ->value('ZipCode');

        return Response::json($zip_code);
    }

    public function addNTCUDepartment(Request $request)
    {
        $name = $request->get('addName');
        $degree = $request->get('addDegree');
        $class = $request->get('addClass');
        $department = $this->repo->fetchDepartment($name, $degree, $class);

        if ($department) {
            return Response::json('此科系以存在');
        } else {
            $department = $this->repo->insertDepartment($name, $degree, $class);
            if ($department) {
                return Response::json('新增成功');
            } else {
                return Response::json('新增失敗');
            }
        }
    }

    public function updateNTCUDepartment(Request $request)
    {
        $id = $request->get('updateDepartmentID');
        $name = $request->get('addName');
        $degree = $request->get('addDegree');
        $class = $request->get('addClass');
        $department = $this->repo->updateDepartment($id, $name, $degree, $class);

        if ($department) {
            return Response::json('更新成功');
        } else {
            return Response::json('更新失敗');
        }
    }

    public function deleteNTCUDepartment(Request $request)
    {
        $id = $request->get('updateDepartmentID');
        $department = NTCUDepartment::where('department_id', $id)->first();
        if (!$department) {
            return Response::json('科系不存在');
        } else {
            $department->delete();
            return Response::json('刪除科系成功');
        }
    }

    public function department(Request $request)
    {
        $data = collect();
        $gender = collect();
        $department_id = $request->get('department_id');
        $candidates_information_data = $this->getCandidatesInformationData($department_id);
        $male = $candidates_information_data->where('candidates_information_gender', '男')->count();
        $female = $candidates_information_data->where('candidates_information_gender', '女')->count();
        $gender->put('male', $male);
        $gender->put('female', $female);

        $age_count = $this->getAgeCount($candidates_information_data);
        $age_name = $this->getAgeName($age_count);
        foreach ($age_name as $key => $val) {
            $age[$key] = [
                'value' => $age_count[$key],
                'name' => $age_name[$key],
            ];
        }
        $data->put('age_range_name', $age_name);
        $data->put('age_range', $age);

        // 統計報考學校畢業學校和科系的人數
        $school_data = $this->getSchoolData($department_id);
        foreach ($school_data as $key => $val) {
            $school_department[$val->school_id] = $val->school_name . ' ' . $val->school_department;
            $school_count[$val->school_id] = $val->counts;
        }
        $data->put('gender', $gender);
        $data->put('school_department', $school_department);
        $data->put('school_count', $school_count);

        return Response::json($data);
    }

    protected function getCandidatesInformationData($department_id)
    {
        return CandidatesInformation::with('InstituteRegistration')->whereHas('InstituteRegistration',
            function ($query) use ($department_id) {
                $query->where('ntcu_department_department_id', $department_id);
            })
            ->select(
                DB::raw('DATE_FORMAT(candidates_information_birthday, "%Y") as birthday_year'),
                'candidates_information_gender');
    }

    protected function getSchoolData($department_id)
    {
        return School::with('InstituteRegistration')->whereHas('InstituteRegistration',
            function ($query) use ($department_id) {
                $query->where('ntcu_department_department_id', $department_id);
            })
            ->groupBy('school_id', 'school_name', 'school_department')
            ->get();
    }

    protected function getAgeCount($candidates_information_data)
    {
        $age_count[0] = $candidates_information_data->where('birthday_year', '<=', '22')->count();
        $age_count[1] = $candidates_information_data->where('birthday_year', '>', '22')
            ->Where('birthday_year', '<=', '25')->count();
        $age_count[2] = $candidates_information_data->where('birthday_year', '>', '25')
            ->Where('birthday_year', '<=', '30')->count();
        $age_count[3] = $candidates_information_data->where('birthday_year', '>', '30')
            ->Where('birthday_year', '<=', '35')->count();
        $age_count[4] = $candidates_information_data->where('birthday_year', '>', '35')
            ->Where('birthday_year', '<=', '40')->count();
        $age_count[5] = $candidates_information_data->where('birthday_year', '>', '40')->count();

        return $age_count;
    }

    protected function getAgeName($age_count)
    {
        $age_name[0] = "小於21歲" . $age_count[0] . "人";
        $age_name[1] = "介於22歲到25歲之間" . $age_count[1] . "人";
        $age_name[2] = "介於26歲到30歲之間" . $age_count[2] . "人";
        $age_name[3] = "介於31歲到35歲之間" . $age_count[3] . "人";
        $age_name[4] = "介於36歲到40歲之間" . $age_count[4] . "人";
        $age_name[5] = "大於41歲" . $age_count[5] . "人";

        return $age_name;
    }
}

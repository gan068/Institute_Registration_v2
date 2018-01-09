<?php

namespace App\Http\Controllers;

use App\Http\Model\Address;
use App\Http\Model\InstituteRegistration;
use App\Http\Model\NTCUDepartment;
use App\Http\Model\School;
use App\Http\Model\CandidatesInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //
    public function index()
    {
        $NTCUDepartment = new NTCUDepartment();
        $schoolName = new School();
        $cityName = new Address();

        $NTCUDepartmentSearch = $NTCUDepartment->searchNTCUDepartment();
        $schoolNameSearch = $schoolName->schoolName();
        $cityNameSearch = $cityName->cityName();
        //
        return view('index')->with(
            ['NTCUDepartment' => $NTCUDepartmentSearch,
                'schoolName' => $schoolNameSearch,
                'cityName' => $cityNameSearch
            ]);
    }

    public function upload(Request $request)
    {
        $candidatesInformation = new CandidatesInformation();
        $instituteRegistration = new InstituteRegistration();
        $searchID = $candidatesInformation->searchID($request->input('id'));

        $destinationPath = '';
        if ($searchID == null) {
            if ($request->file('photo') != null) {
                $destinationPath = $_SERVER['DOCUMENT_ROOT'] . 'uploads';
                $filename = $request->file('photo')->getClientOriginalName();
                $upload_success = $request->file('photo')->move($destinationPath, $filename);
            }
            // 考上基本資料寫入DB
            $candidatesInformation->insertCandidatesInformation(
                $request->input('id'),
                $request->input('name'),
                $destinationPath,
                $request->input('gender'),
                $request->input('birthday'),
                $request->input('zip_code') . $request->input('city_name') . $request->input('area_name') . $request->input('address'),
                $request->input('phone'),
                $request->input('email')
            );
            // 報名資料寫入DB
            $instituteRegistration->insertInstituteRegistrationInformation(
                $request->input('school_department'),
                $request->input('ntcu_department'),
                $request->input('id')
            );
            echo "<script>alert('報名成功')</script>";
            return redirect('/');
        } else {
            echo "<script>alert('已報名')</script>";
            return redirect('/');
        }

    }

    public function testDB()
    {
        $NTCUDepartment = new NTCUDepartment();
        dd($NTCUDepartment->searchNTCUDepartment());
//        $connection = DB::connection()->getPdo();
//        dd($connection);
    }

    public function test()
    {

        $school_data = DB::table('Institute_Registration_information')
            ->join('school', 'school_school_id', '=', 'school_id')
            ->select(DB::raw("count(school.school_id) as counts,school.school_name,school.school_department"))
            ->where('Institute_Registration_information.ntcu_department_department_id', 1)
            ->groupBy('school.school_id','school.school_name','school_department')
            ->get();
//        $school_data = DB::select("
//SELECT
//    COUNT(school_id) AS counts,
//    school_id,school_name,school_department
//FROM
//    Institute_Registration.Institute_Registration_information
//    inner JOIN school  ON Institute_Registration_information.school_school_id = school.school_id
//WHERE
//    ntcu_department_department_id = 1
//    group By school_id,school_name,school_department;
//    ");
        dd($school_data);
    }
}

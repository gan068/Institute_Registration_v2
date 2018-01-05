<?php

namespace App\Http\Controllers;

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
}

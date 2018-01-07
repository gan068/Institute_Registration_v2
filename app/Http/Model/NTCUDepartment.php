<?php
/**
 * Created by PhpStorm.
 * User: riitei
 * Date: 2018/1/4
 * Time: 22:42
 */

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NTCUDepartment extends Model
{
    protected $table = 'ntcu_department';
    protected $primaryKey = 'department_id';
    public $timestamps = false;

    public function searchNTCUDepartment()
    {
        $search = DB::select("SELECT department_id, concat(department_name,'_',department_degree,'(',department_class,')')
                  as department_name FROM  Institute_Registration.ntcu_department");
        return $search;
    }

    public function searchDepartmentID($addName, $addDegree, $addClass)
    {
        $departmentID = DB::table('ntcu_department')
            ->select(
                "SELECT department_id FROM Institute_Registration.ntcu_department where department_name = '" . $addName . "'anddepartment_degree='" . $addDegree . "'and department_class= '" . $addClass . "'")
        ->first();
//
//        $departmentID = DB::table('ntcu_department')
//            ->whereColumn([
//                ['department_name', '=', $addName],
//                ['department_degree', '=', $addDegree],
//                ['department_class', '=', $addClass]
//            ])->get();
        return $departmentID;
    }

    public function insertDepartment($addName, $addDegree, $addClass)
    {
        DB::table('ntcu_department')->insert([
            'department_name' => $addName,
            'department_degree' => $addDegree,
            'department_class' => $addClass
        ]);
    }
}
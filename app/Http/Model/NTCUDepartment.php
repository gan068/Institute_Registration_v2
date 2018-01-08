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
        $NTCUDepartment = DB::table('ntcu_department')
            ->where('department_name', $addName)
            ->where('department_degree', $addDegree)
            ->where('department_class', $addClass)
            ->first();
        return $NTCUDepartment;
    }

    public function insertDepartment($addName, $addDegree, $addClass)
    {
        DB::table('ntcu_department')->insert([
            'department_name' => $addName,
            'department_degree' => $addDegree,
            'department_class' => $addClass
        ]);
    }

    public function updateDepartment($updateID,$updateName, $updateDegree, $updateClass)
    {
        NTCUDepartment::where('department_id',$updateID)->update(
            ['department_name' => $updateName],
            ['department_degree' => $updateDegree],
            ['department_class' => $updateClass]
        );
    }

    public function deleteDepartment($updateID){
        NTCUDepartment::where('department_id',$updateID)->delete();
    }
}
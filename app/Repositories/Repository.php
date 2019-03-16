<?php

namespace App\Repositories;

use App\Http\Model\NTCUDepartment;
use App\Http\Model\Address;
use App\Http\Model\School;

class Repository
{
    public function searchNTCUDepartment()
    {
        $departments = NTCUDepartment::select(
            DB::raw('department_id',
                'CONCAT(department_name, "_" , department_degree, "(", department_class, ")") 
                        AS department_name')
        )->get();

        return $departments;
    }

    public function getCities()
    {
        return Address::orderBy('id', 'ASC')
            ->pluck('CityName', 'id')
            ->get();
    }

    public function getSchools()
    {
        return School::distinct('school_name')
            ->orderBy('school_id', 'ASC')
            ->pluck('school_name', 'school_id')
            ->get();
    }

    public function fetchDepartment($name, $degree, $class)
    {
        $department = NTCUDepartment::where('department_name', $name)
            ->where('department_degree', $degree)
            ->where('department_class', $class)
            ->first();

        return $department;
    }

    public function insertDepartment($name, $degree, $class)
    {
        $department = new NTCUDepartment();
        $department->department_name = $name;
        $department->department_degree = $degree;
        $department->department_class = $class;
        $department->save();

        return $department;
    }

    public function updateDepartment($id, $name, $degree, $class)
    {
        $department = NTCUDepartment::where('department_id', $id)->first();
        $department->department_name = $name;
        $department->department_degree = $degree;
        $department->department_class = $class;
        $department->save();

        return $department;
    }
}

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
}

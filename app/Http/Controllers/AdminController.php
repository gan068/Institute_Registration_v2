<?php

namespace App\Http\Controllers;

use App\Http\Model\NTCUDepartment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $NTCUDepartment = new NTCUDepartment();
//
        $NTCUDepartmentSearch = $NTCUDepartment->searchNTCUDepartment();

        return view('admin')->with(
            ['NTCUDepartment' => $NTCUDepartmentSearch
            ]);
    }
}

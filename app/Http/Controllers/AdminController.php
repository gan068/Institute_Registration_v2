<?php

namespace App\Http\Controllers;

use App\Repositories\Repository;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $repo = new Repository();
        $departments = $repo->searchNTCUDepartment();

        return view('admin')->with([
            'NTCUDepartment' => $departments
        ]);
    }
}

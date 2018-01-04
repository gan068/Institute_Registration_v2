<?php

namespace App\Http\Controllers;

use App\Http\Model\NTCUDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //
    public function index()
    {
        $NTCUDepartment = new NTCUDepartment();
        $NTCUDepartmentData = $NTCUDepartment->searchNTCUDepartment();
        return view('index')->with(['NTCUDepartment'=>$NTCUDepartmentData]);
    }

    public function upload(Request $request)
    {
        $name = $request->input('name');
        //
        if ($request->file('photo')->isValid()) {
            $path = $request->photo->path();
            $extension = $request->photo->extension();
            $destinationPath = $_SERVER['DOCUMENT_ROOT'] . 'uploads';
            $filename = $request->file('photo')->getClientOriginalName();
            $upload_success = $request->file('photo')->move($destinationPath, $filename);
            dd($upload_success);
        }
    }

    public function testDB()
    {
        $NTCUDepartment = new NTCUDepartment();
        dd($NTCUDepartment->searchNTCUDepartment());
//        $connection = DB::connection()->getPdo();
//        dd($connection);
    }

}

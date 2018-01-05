<?php

namespace App\Http\Controllers;

use App\Http\Model\Address;
use App\Http\Model\NTCUDepartment;
use App\Http\Model\School;
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
                'cityName'=>$cityNameSearch
            ]);
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //
    public function upload(Request $request)
    {
        $name = $request->input('name');
        //
        if ($request->file('photo')->isValid()) {
            $path = $request->photo->path();
            $extension = $request->photo->extension();
            $destinationPath = $_SERVER['DOCUMENT_ROOT'].'uploads';
            $filename  = $request->file('photo')->getClientOriginalName();
            $upload_success = $request->file('photo')->move($destinationPath, $filename);
            dd($upload_success);
        }
    }

    public function testDB()
    {
        $connection = DB::connection()->getPdo();
        dd($connection);
    }

}

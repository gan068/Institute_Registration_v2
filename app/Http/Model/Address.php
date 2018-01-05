<?php
/**
 * Created by PhpStorm.
 * User: riitei
 * Date: 2018/1/5
 * Time: 20:54
 */

namespace App\Http\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Address extends Model
{
    protected $table = 'address';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function cityName()
    {
//        $cityName = DB::select("select distinct CityName From address order by id asc");
//        $cityName = DB::table('address')->select('CityName')
//            ->distinct()->orderBy('id','asc')->get();
        $cityName = Address::select('CityName')->distinct()->orderBy('id', 'asc')->get();
        //
        return $cityName;
    }

    public function areaName($cityName)
    {
        $areaName = DB::select("SELECT ZipCode,AreaName 
FROM Institute_Registration.address 
where CityName='" . $cityName . "' order by id asc");
        //
        return $areaName;
    }

    public function zipCode($area_name)
    {
//        $zipCode = DB::select("SELECT ZipCode
//FROM Institute_Registration.address
//where AreaName='" . $area_name . "'");





        $zipCode=  Address::select('ZipCode')->where('AreaName',$area_name)->first();

        return $zipCode;

    }
}
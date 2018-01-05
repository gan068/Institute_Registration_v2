<?php
/**
 * Created by PhpStorm.
 * User: riitei
 * Date: 2018/1/5
 * Time: 19:23
 */

namespace App\Http\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class School extends Model
{
    protected $table = 'school';
    protected $primaryKey = 'school_id';
    public $timestamps = false;

    public function schoolName()
    {
        $schoolName =
            DB::select('SELECT distinct school_name FROM Institute_Registration.school');
        return $schoolName;

    }

    public function schoolDepartment($schoolName)
    {
        $schoolDepartment =
            DB::select("SELECT school_id,school_department 
FROM Institute_Registration.school 
where school_name='" . $schoolName . "'");
        return $schoolDepartment;
    }
}
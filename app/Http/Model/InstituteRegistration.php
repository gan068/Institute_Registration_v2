<?php
/**
 * Created by PhpStorm.
 * User: riitei
 * Date: 2018/1/6
 * Time: 20:30
 */

namespace App\Http\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InstituteRegistration extends Model
{
    protected $table = 'Institute_Registration_information';
    protected $primaryKey = 'Institute_Registration_information_id';
    public $timestamps = false;

    public function insertInstituteRegistrationInformation(
        $school_department,$ntcu_department,$id
    ){
        DB::table('Institute_Registration_information')->insert([
            'school_school_id'=>$school_department,
            'ntcu_department_department_id'=>$ntcu_department,
            'candidates_information_candidates_information_id'=>$id
        ]);
    }
}
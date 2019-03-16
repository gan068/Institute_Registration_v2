<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Model\School;
use App\Http\Model\candidatesInformation;

class InstituteRegistration extends Model
{
    protected $table = 'Institute_Registration_information';
    protected $primaryKey = 'Institute_Registration_information_id';
    public $timestamps = false;

    protected $fillable = [
        'Institute_Registration_information_id',
        'ntcu_department_department_id',
        'candidates_information_candidates_information_id',
        'school_school_id',
    ];

    public function ntcuDepartment()
    {
        return $this->belongsTo(NTCUDepartment::class, 'ntcu_department_department_id', 'department_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_school_id', 'school_id');
    }

    public function candidatesInformation()
    {
        return $this->belongsTo(CandidatesInformation::class,
            'candidates_information_candidates_information_id', 'candidates_information_id');
    }

    public function insertInstituteRegistrationInformation
    (
        $school_department, $ntcu_department, $id
    )

    {
        DB::table('Institute_Registration_information')->insert([
            'school_school_id' => $school_department,
            'ntcu_department_department_id' => $ntcu_department,
            'candidates_information_candidates_information_id' => $id
        ]);
    }
}
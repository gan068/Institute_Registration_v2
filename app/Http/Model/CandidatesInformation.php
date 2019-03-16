<?php
/**
 * Created by PhpStorm.
 * User: riitei
 * Date: 2018/1/6
 * Time: 17:13
 */

namespace App\Http\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CandidatesInformation extends Model
{
    protected $table = 'candidates_information';
    protected $primaryKey = 'candidates_information_id';
    public $timestamps = false;

    protected $fillable = [
        'candidates_information_id',
        'candidates_information_name',
        'candidates_information_photo_path',
        'candidates_information_gender',
        'candidates_information_birthday',
        'candidates_information_address',
        'candidates_information_phone',
        'candidates_information_email'
    ];

    public function InstituteRegistration()
    {
        return $this->hasMany(InstituteRegistration::class,
            'candidates_information_candidates_information_id', 'candidates_information_id');
    }

    public function searchID($searchID)
    {
        $id =
            candidatesInformation::select("candidates_information_id")
                ->where('candidates_information_id', $searchID)->first();
        return $id;
    }

    public function insertCandidatesInformation($id, $name, $path, $gender, $birthday, $address, $phone, $email)
    {
        DB::table('candidates_information')->insert([
            'candidates_information_id' => $id,
            'candidates_information_name' => $name,
            'candidates_information_photo_path' => $path,
            'candidates_information_gender' => $gender,
            'candidates_information_birthday' => $birthday,
            'candidates_information_address' => $address,
            'candidates_information_phone' => $phone,
            'candidates_information_email' => $email
        ]);
    }
}
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

class candidatesInformation extends Model
{
    protected $table = 'candidates_information';
    protected $primaryKey = 'candidates_information_id';
    public $timestamps = false;

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
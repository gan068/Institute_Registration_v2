<?php
/**
 * Created by PhpStorm.
 * User: riitei
 * Date: 2018/1/4
 * Time: 22:42
 */
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;

class NTCUDepartment extends Model
{
    protected $table = 'ntcu_department';
    protected $primaryKey='department_id';
    public $timestamps=false;

    public function searchNTCUDepartment(){
        $search = NTCUDepartment::all();
        return $search;
    }
}
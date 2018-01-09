<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('index');
//});
Route::any('/','IndexController@index');
// index ajax
Route::any('SchoolDepartment','AjaxController@schoolDepartment');
Route::any('AreaName','AjaxController@areaName');
Route::any('ZipCode','AjaxController@zipCode');
Route::post('upload','IndexController@upload');
Route::any('test','IndexController@test');
// admin
Route::any('admin','AdminController@index');
// admin ajax
Route::any('AddNTCUDepartment','AjaxController@addNTCUDepartment');
Route::any('UpdateNTCUDepartment','AjaxController@updateNTCUDepartment');
Route::any('DeleteNTCUDepartment','AjaxController@deleteNTCUDepartment');
Route::any('Department','AjaxController@department');
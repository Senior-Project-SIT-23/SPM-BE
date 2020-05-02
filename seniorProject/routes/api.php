<?php

use App\Http\Controllers\SPMConfigController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//UserManagement
Route::post('/projects','UserManagementController@storeProject'); //สร้าง project
Route::post('/projects/delete','UserManagementController@deleteProject'); //ลบ project
Route::post('/student/edit/profile','UserManagementController@editProfileStudent'); //แก้ไข profile

Route::put('/projects/edit/{project_id}','UserManagementController@editProject'); //เลือกแก้ไขข้อมูล project

Route::get('/projects/{project_id}','UserManagementController@getProject'); //เลือกดูข้อมูล project
Route::get('/projects','UserManagementController@getAllProject'); //ดูข้อมูล project ทั้งหมด
Route::get('/students','UserManagementController@indexStudent'); //ดูข้อมูล student ทั้งหมด
Route::get('/teachers','UserManagementController@indexTeacher'); //ดูข้อมูล teacher ทั้งหมด 
Route::get('/students/nogroup','UserManagementController@getStudentNoGroup'); //ดู student ที่ยังไม่มีกลุ่ม
Route::get('/group/{student_id}','UserManagementController@getGroupProject'); //ดู student ว่ามีกลุ่มรึยัง
Route::get('/projects/response/teacher/{teacher_id}', 'UserManagementController@getProjectTeacherResponse'); //ดูข้อมูล project ที่ teacher รับผิดชอบ
Route::get('/projects/response/aa/{aa_id}', 'UserManagementController@getProjectAAResponse'); //ดูข้อมูล project ที่ aa รับผิดชอบ

//SPMConfig
Route::post('/config','SPMConfigController@storeConfig'); //สร้าง config

Route::get('/config','SPMConfigController@indexConfig'); //ดูข้อมูล config ทั้งหมด
Route::get('/config/{year_of_study}','SPMConfigController@indexConfigByYear'); //ดูข้อมูล config ตามปี

//get => ใช้สำหรับขอข้อมูล
//post => ใช้สำหรับส่งข้อมูลเพื่อเพิ่มข้อมูล
//put => ใช้สำหรับแก้ไขหรือเปลี่ยนแปลงข้อมูลที่มีอยู่แล้ว
//delete => ใช้สำหรับลบข้อมูล
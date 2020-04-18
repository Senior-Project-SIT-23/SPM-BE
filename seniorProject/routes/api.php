<?php

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

Route::post('/projects','UserManagementController@storeProject');
Route::post('/projects/delete','UserManagementController@deleteProject');

Route::put('/projects/edit/{project_id}','UserManagementController@editProject');

Route::get('/projects/{project_id}','UserManagementController@getProject');
Route::get('/projects','UserManagementController@getAllProject');
Route::get('/students','UserManagementController@indexStudent');
Route::get('/teachers','UserManagementController@indexTeacher');
Route::get('/projects/response/{teacher_id}', 'UserManagementController@getProjectResponse');

//get => ใช้สำหรับขอข้อมูล
//post => ใช้สำหรับส่งข้อมูลเพื่อเพิ่มข้อมูล
//put => ใช้สำหรับแก้ไขหรือเปลี่ยนแปลงข้อมูลที่มีอยู่แล้ว
//delete => ใช้สำหรับลบข้อมูล
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
Route::post('/projects', 'UserManagementController@storeProject'); //สร้าง project
Route::post('/projects/delete', 'UserManagementController@deleteProject'); //ลบ project
Route::post('/student/edit/profile/student', 'UserManagementController@editProfileStudent'); //แก้ไข profile student
Route::post('/student/edit/profile/teacher', 'UserManagementController@editProfileTeacher'); //แก้ไข profile teacher
Route::post('/student/edit/profile/aa', 'UserManagementController@editProfileAA'); //แก้ไข profile AA
Route::put('/projects/edit/{project_id}', 'UserManagementController@editProject'); //เลือกแก้ไขข้อมูล project
Route::get('/projects/{project_id}', 'UserManagementController@getProject'); //เลือกดูข้อมูล project
Route::get('/projects', 'UserManagementController@getAllProject'); //ดูข้อมูล project ทั้งหมด
Route::get('/students', 'UserManagementController@indexStudent'); //ดูข้อมูล student ทั้งหมด
Route::get('/teachers', 'UserManagementController@indexTeacher'); //ดูข้อมูล teacher ทั้งหมด
Route::get('/aas', 'UserManagementController@indexAA'); //ดูข้อมูล aa ทั้งหมด
Route::get('/students/nogroup', 'UserManagementController@getStudentNoGroup'); //ดู student ที่ยังไม่มีกลุ่ม
Route::get('/group/{student_id}', 'UserManagementController@getGroupProject'); //ดู student ว่ามีกลุ่มรึยัง
Route::get('/projects/response/teacher/{teacher_id}', 'UserManagementController@getProjectTeacherResponse'); //ดูข้อมูล project ที่ teacher รับผิดชอบ
Route::get('/projects/response/aa/{aa_id}', 'UserManagementController@getProjectAAResponse'); //ดูข้อมูล project ที่ aa รับผิดชอบ

//SPMConfig
Route::post('/config', 'SPMConfigController@storeConfig'); //สร้าง config
Route::get('/config', 'SPMConfigController@indexConfig'); //ดูข้อมูล config ทั้งหมด
Route::get('/config/{year_of_study}', 'SPMConfigController@indexConfigByYear'); //ดูข้อมูล config ตามปี

//Assignment
    //->Teacher
Route::post('/assignments', 'AssignmentController@storeAssignment');//สร้าง Assignment
Route::post('/assignments/delete', 'AssignmentController@deleteAssignment'); //ลบ Assignment
Route::post('/rubric', 'AssignmentController@storeRubric');//สร้าง Rubric
Route::post('/rubric/delete', 'AssignmentController@deleteRubric');//ลบ Rubric
Route::post('/attachments/delete', 'AssignmentController@deleteAttachment');//ลบ Attachment
Route::put('/assignments/edit/{assignment_id}', 'AssignmentController@editAssignment'); //แก้ไข assignment
Route::put('/rubric/edit/{rubric_id}', 'AssignmentController@editRubric'); //แก้ไข Rubric
Route::get('/assignments', 'AssignmentController@indexAllAssignment');//ดู Assignment ทั้งหมด
Route::get('/assignments/{assignment_id}', 'AssignmentController@indexAssignment');//ดู Assignment ที่เลือก
Route::get('/rubric','AssignmentController@indexAllRubric');//ดู Rubric ทั้งหมด
Route::get('/rubric/{rubric_id}','AssignmentController@indexRubric');//ดู Rubric ที่เลือก
Route::get('/attachments','AssignmentController@indexAllAttachment');//ดู Attachment ทั้งหมด
Route::get('/attachments/{assignment_id}','AssignmentController@indexAttachment');//ดู Attachment ที่อยู่ใน Assignment ที่เลือก
    //->Student


//Test
Route::post('/attachments', 'AssignmentController@storeAttachment');//สร้าง Attachment



//get => ใช้สำหรับขอข้อมูล
//post => ใช้สำหรับส่งข้อมูลเพื่อเพิ่มข้อมูล
//put => ใช้สำหรับแก้ไขหรือเปลี่ยนแปลงข้อมูลที่มีอยู่แล้ว
//delete => ใช้สำหรับลบข้อมูล
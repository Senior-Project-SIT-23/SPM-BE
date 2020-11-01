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

Route::group(['middleware' => ['checkauth']], function () {

    // Route::post('generatetoken', array('middleware' => 'cors', 'uses' => 'Api\SurveyController@generateTokenApi'));ของจิว
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

    //Assignment
    Route::post('/assignments', 'AssignmentController@storeAssignment'); //สร้าง Assignment
    Route::post('/assignments/delete', 'AssignmentController@deleteAssignment'); //ลบ Assignment
    Route::post('/rubric', 'AssignmentController@storeRubric'); //สร้าง Rubric
    Route::post('/rubric/delete', 'AssignmentController@deleteRubric'); //ลบ Rubric
    Route::post('/attachments/delete', 'AssignmentController@deleteAttachment'); //ลบ Attachment
    Route::post('/send_assignment', 'AssignmentController@storeSendAssignment'); //นศ ส่ง assignment
    Route::post('/rubric/edit', 'AssignmentController@editRubric'); //แก้ไข Rubric
    Route::post('/assignments/edit', 'AssignmentController@editAssignment'); //แก้ไข assignment
    Route::post('/assessment', 'AssignmentController@storeAssessment'); // ให้คะแนน assignment

    Route::get('/assignments', 'AssignmentController@indexAllAssignment'); //ดู Assignment ทั้งหมด
    Route::get('/assignments/{assignment_id}/{student_id}', 'AssignmentController@indexStudentAssignment'); //ดู Assignment ที่ student เลือก 
    Route::get('/assignments/{assignment_id}', 'AssignmentController@indexAssignment'); //ดู Assignment ที่เลือก id
    Route::get('/assignments/responsible/teacher/{teacher_id}', 'AssignmentController@indexResponsibleAssignment'); //ดู assignment ที่รับผิดชอบ
    Route::get('/rubric', 'AssignmentController@indexAllRubric'); //ดู Rubric ทั้งหมด
    Route::get('/rubric/{rubric_id}', 'AssignmentController@indexRubric'); //ดู Rubric ที่เลือก
    Route::get('/attachments', 'AssignmentController@indexAllAttachment'); //ดู Attachment ทั้งหมด
    Route::get('/attachments/{assignment_id}', 'AssignmentController@indexAttachment'); //ดู Attachment ที่อยู่ใน Assignment ที่เลือก
    Route::get('/send_assignment/{assignment_id}', 'AssignmentController@indexSendAssignment'); // ดู assignment ตามที่เลือก
    Route::get('/send_assignment/{assignment_id}/teacher/{teacher_id}', 'AssignmentController@indexSendAssignmentByProjecdIdAndTeacherId'); // ดู assignment ตาม Id (Teacher ใช้) 
    Route::get('/assessment/{assignment_id}/{project_id}', 'AssignmentController@indexSendAssignmentByProjecdId'); // ดู assignment ตาม Id (Teacher, AA ใช้) 

    //Announcement
    Route::post('/announcement', 'AnnouncementController@storeAnnoucement'); // สร้าง Announcement
    Route::post('/announcement/edit', 'AnnouncementController@editAnnoucement'); // แก้ไข Announcement
    Route::post('/announcement/delete', 'AnnouncementController@deleteAnnoucement'); // ลบ Announcement

    Route::get('/announcement', 'AnnouncementController@indexAllAnnoucement'); // ดูAnnouncement
    Route::get('/announcement/{announcement_id}', 'AnnouncementController@indexAnnoucement'); // ดูAnnouncement

    //Notification
    Route::post('/notification/student', 'SPMConfigController@storeStudentNotification'); //กดดู Notification ของ Student 
    Route::post('/notification/teacher', 'SPMConfigController@storeTeacherNotification'); //กดดู Notification ของ Teacher
    Route::post('/notification/aa', 'SPMConfigController@storeAANotification'); //กดดู Notification ของ Teacher

    Route::group(array('prefix' => 'notification'), function () {
        Route::get('/student/{student_id}', 'SPMConfigController@indexStudentNotification'); // ดู Notification ของ Student ทั้งหมด
        Route::get('/teacher/{teacher_id}', 'SPMConfigController@indexTeacherNotification'); //ดู Notification ของ Teacher ทั้งหมด
        Route::get('/aa/{aa_id}', 'SPMConfigController@indexAANotification'); //ดู Notification ของ AA ทั้งหมด
    });
});

//SPM Config
Route::get('/config/{year_of_study}', 'SPMConfigController@indexConfigByYear'); //ดูข้อมูล config ตามปี

//SSO
Route::group(array('prefix' => 'sso'), function () {
    Route::post('/check-authentication', 'LoginController@checkAuthentication'); //ยิง Auth code เพื่อ check
    Route::get('/check-me', 'LoginController@checkMe'); //ยืนยันตัวตน
});

//Test
Route::post('/attachments', 'AssignmentController@storeAttachment'); //สร้าง Attachment


//get => ใช้สำหรับขอข้อมูล
//post => ใช้สำหรับส่งข้อมูลเพื่อเพิ่มข้อมูล
//put => ใช้สำหรับแก้ไขหรือเปลี่ยนแปลงข้อมูลที่มีอยู่แล้ว
//delete => ใช้สำหรับลบข้อมูล
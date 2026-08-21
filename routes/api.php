<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\PrescriptionController;
use App\Http\Controllers\Api\ConsultationController;
use App\Http\Controllers\Api\MedicalFileController;
use App\Http\Controllers\Api\ProfileController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);



Route::middleware('auth:sanctum')->group(function () {

    /*
    Route::get('/user', function (Request $request) {

        return $request->user();
    });

*/
    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    Route::get(
        '/admin/stats',
        [AdminController::class, 'stats']
    );*/

    Route::apiResource('departments', DepartmentController::class)->only(['index', 'show']);
    Route::apiResource('doctors', DoctorController::class)->only(['index', 'show']);
    Route::get('/departments/{department_id}/doctors', [DoctorController::class, 'getDoctorByDepartment']); //عرض الاطباء حسب القسم

    Route::controller(AppointmentController::class)->group(function () {
        Route::get('/doctors/{doctor_id}/appointments/available', 'getAvailableAppointments'); //المواعيد المتاحة
        Route::get('/appointments', 'index'); //مواعيدي
        Route::post('/appointments', 'store'); //موعد جديد انشاء
        Route::put('/appointments/{id}/cancel', 'cancel'); //الغاء موعد
        Route::get('/appointments/{id}', 'show'); //تفاصيل موعد
    });

    Route::apiResource('prescriptions', PrescriptionController::class)->only(['index', 'show']);

    Route::post('/doctors/{doctor_id}/consultations', [ConsultationController::class, 'store']); //انشاء رسالة استشارة
    Route::get('/consultations', [ConsultationController::class, 'index']); //عرض جميع الاستشارات الخاصة بالمريض

    Route::get('/medical-file', [MedicalFileController::class, 'index']); //عرض الملف الطبي للمريض

    Route::get('/profile', [ProfileController::class, 'show']); //عرض الملف الشخصي للمريض
    Route::put('/profile', [ProfileController::class, 'update']); //تحديث الملف الشخصي للمريض
});

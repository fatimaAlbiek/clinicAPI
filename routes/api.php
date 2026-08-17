<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\PrescriptionController;

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

    Route::controller(AppointmentController::class)->group(function () {
        Route::get('/appointments/available', 'getAvailableAppointments'); //المواعيد المتاحة
        Route::get('/appointments', 'index'); //مواعيدي
        Route::post('/appointments', 'store'); //موعد جديد انشاء
        Route::put('/appointments/{id}/cancel', 'cancel'); //الغاء موعد
        Route::get('/appointments/{id}', 'show'); //تفاصيل موعد
    });

    Route::apiResource('prescriptions', PrescriptionController::class)->only(['index', 'show']);
});

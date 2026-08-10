<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\DoctorController;

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
});

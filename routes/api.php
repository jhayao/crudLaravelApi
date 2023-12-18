<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(StudentController::class)->group(function () {
    Route::get('/students', [StudentController::class, 'index']);
    Route::post('/student-create', [StudentController::class, 'store']);
    Route::get('/students-details', [StudentController::class, 'edit']);
    Route::post('/student-update', [StudentController::class, 'update']);
    Route::post('/student-delete', [StudentController::class, 'destroy']);
});

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/login', [AuthController::class, 'notLogin'])->name('login');
    Route::middleware('auth:sanctum')->get('/checkAuth', [AuthController::class, 'checkAuth'])->name('checkAuth');
    Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'user'])->name('user');
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('event')->group(function () {
    Route::post('/create', [EventController::class, 'store']);
    Route::get('/list', [EventController::class, 'index']);
    Route::get('/details', [EventController::class, 'edit']);
    Route::post('/update', [EventController::class, 'update']);
    Route::post('/delete', [EventController::class, 'destroy']);
});


Route::prefix('attendance')->group(function () {
    Route::post('/create', [AttendanceController::class, 'store']);
    Route::get('/list', [AttendanceController::class, 'index']);
    Route::get('/details', [AttendanceController::class, 'edit']);
    Route::post('/update', [AttendanceController::class, 'update']);
    Route::post('/delete', [AttendanceController::class, 'destroy']);
    Route::post('/checkin', [AttendanceController::class, 'checkIn']);
}
);

Route::prefix('user')->group(function () {
    Route::get('/userdetails', [UserController::class, 'index']);
    Route::post('/change-password', [UserController::class, 'updatePassword']);
});

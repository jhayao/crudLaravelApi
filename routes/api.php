<?php

use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student;
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
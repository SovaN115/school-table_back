<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\CallController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\AdminController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth', [AdminController::class, 'auth']);

Route::post('/template', [TemplateController::class, 'create']);
Route::get('/template/selected', [TemplateController::class, 'getSelected']);
Route::get('/template/{id}', [TemplateController::class, 'show']);
Route::patch('/template/{id}', [TemplateController::class, 'apply']);
Route::get('/template', [TemplateController::class, 'index']);
Route::delete('/template/{id}', [TemplateController::class, 'delete']);

Route::post('/call', [CallController::class, 'create']);
Route::patch('/call/{id}', [CallController::class, 'update']);
Route::get('/call/{id}', [CallController::class, 'index']);

Route::post('/cabinet', [CabinetController::class, 'create']);
Route::patch('/cabinet/{id}', [CabinetController::class, 'update']);
Route::get('/cabinet/{id}', [CabinetController::class, 'index']);
Route::delete('/cabinet/{id}', [CabinetController::class, 'delete']);

Route::post('/group', [GroupController::class, 'create']);
Route::patch('/group/{id}', [GroupController::class, 'update']);
Route::get('/group/{id}', [GroupController::class, 'index']);
Route::delete('/group/{id}', [GroupController::class, 'delete']);

Route::post('/lesson', [LessonController::class, 'create']);
Route::patch('/lesson/{id}', [LessonController::class, 'update']);
Route::get('/lesson/{id}', [LessonController::class, 'index']);
Route::get('/lessonn/{id}', [LessonController::class, 'show']);
Route::delete('/lesson/{id}', [LessonController::class, 'delete']);

Route::post('/teacher', [TeacherController::class, 'create']);
Route::patch('/teacher/{id}', [TeacherController::class, 'update']);
Route::get('/teacher/{id}', [TeacherController::class, 'index']);
Route::delete('/teacher/{id}', [TeacherController::class, 'delete']);

Route::post('/table', [TableController::class, 'create']);
Route::patch('/table/{id}', [TableController::class, 'update']);
Route::get('/table/{id}', [TableController::class, 'index']);
Route::delete('/table/{id}', [TableController::class, 'delete']);
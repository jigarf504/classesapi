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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//--------------Branch---------------------------
Route::get('branch',[App\Http\Controllers\BranchController::class,'index'])->name('branch.list');
Route::get('branch/{branch}',[App\Http\Controllers\BranchController::class,'show'])->name('branch.show');
Route::post('branch',[App\Http\Controllers\BranchController::class,'store'])->name('branch.save');
Route::put('branch/{branch}',[App\Http\Controllers\BranchController::class,'update'])->name('branch.update');
Route::delete('branch/{branch}',[App\Http\Controllers\BranchController::class,'destroy'])->name('branch.destroy');
//--------------Course---------------------------
Route::get('course',[App\Http\Controllers\CourseController::class,'index'])->name('course.list');
Route::get('course/{course}',[App\Http\Controllers\CourseController::class,'show'])->name('course.show');
Route::post('course',[App\Http\Controllers\CourseController::class,'store'])->name('course.save');
Route::put('course/{course}',[App\Http\Controllers\CourseController::class,'update'])->name('course.update');
Route::delete('course/{course}',[App\Http\Controllers\CourseController::class,'destory'])->name('course.destroy');
//--------------Qualification---------------------------
Route::get('qualification',[App\Http\Controllers\QualificationController::class,'index'])->name('qualification.list');
Route::get('qualification/{qualification}',[App\Http\Controllers\QualificationController::class,'show'])->name('qualification.show');
Route::post('qualification',[App\Http\Controllers\QualificationController::class,'store'])->name('qualification.save');
Route::put('qualification/{qualification}',[App\Http\Controllers\QualificationController::class,'update'])->name('qualification.update');
Route::delete('qualification/{qualification}',[App\Http\Controllers\QualificationController::class,'destory'])->name('qualification.destroy');

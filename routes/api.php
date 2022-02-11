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

Route::post('branch',[App\Http\Controllers\BranchController::class,'store'])->name('branch.save');
Route::get('branch',[App\Http\Controllers\BranchController::class,'index'])->name('branch.list');
Route::get('branch/{id}',[App\Http\Controllers\BranchController::class,'show'])->name('branch.show');
Route::get('branch/{id}/edit',[App\Http\Controllers\BranchController::class,'edit'])->name('branch.edit');
Route::put('branch/{id}',[App\Http\Controllers\BranchController::class,'update'])->name('branch.update');
Route::delete('branch/{id}',[App\Http\Controllers\BranchController::class,'delete'])->name('branch.destroy');

<?php

use App\Http\Controllers\api\v1\TaskController;
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

Route::group(['prefix'=>'task'],function (){
    Route::get('/get/{perPage}',[TaskController::class,'index'])->name('task.index');
    Route::post('/store',[TaskController::class,'store'])->name('task.store');
    Route::patch('/update/{id}',[TaskController::class,'update'])->name('task.update');
    Route::get('/filter',[TaskController::class,'filter'])->name('task.filter');
    Route::delete('/delete/{task}',[TaskController::class,'destroy'])->name('task.delete');
});

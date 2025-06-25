<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::Post('/register',[LoginController::class,'register']);
Route::Post('/login',[LoginController::class,'login']);

Route::middleware(['auth:sanctum'])->group(function () {
Route::Post('/logout',[LoginController::class, 'logout']);
Route::Post('/add-bill',[MainController::class,'add_bill']);
Route::get('/user-bills',[MainController::class,'view_user_bills']);

Route::get('/view-bills',[AdminController::class,'view_bills']);
Route::Post('/update/{id}',[AdminController::class,'update']);
});

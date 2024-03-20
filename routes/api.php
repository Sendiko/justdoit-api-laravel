<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::post("register", [UserController::class, "register"]);
Route::post("login", [UserController::class, "login"]);
Route::post("logout", [UserController::class, "logout"]);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource("/task", TaskController::class);
    Route::resource("/user", UserController::class);
    Route::resource('/category', CategoryController::class);
});

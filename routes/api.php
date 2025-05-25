<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PlatformController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;


Route::post("register", [AuthController::class, "register"]);
Route::post("login", [AuthController::class, "login"]);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get("logout", [AuthController::class, "logout"]);
    Route::get("get_user", [AuthController::class, "getUser"]);
    Route::PUT("update_user", [AuthController::class, "updateUser"]);


    //    ------------------------- posts -------------------------
    Route::resource("posts", PostController::class);

    //    ------------------------- platforms -------------------------
    Route::get("platforms", [PlatformController::class, "index"]);
    Route::get("platforms_active/{platform}", [PlatformController::class, "toggleActive"]);
});

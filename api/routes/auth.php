<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get("/login", function () {
    redirect("http://api.driving-school/api/documentation/#/auth");
})->name("login");

Route::post("/login", [AuthController::class, "authenticate"])->middleware('guest');
Route::get("/logout", [AuthController::class, "destroy"])->middleware("auth");

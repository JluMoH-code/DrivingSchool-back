<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SlotController;

Route::get('/profile', [ProfileController::class, 'profile'])->middleware('auth');
Route::get('/slots', [SlotController::class, 'list'])->middleware('auth');

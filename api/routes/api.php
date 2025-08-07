<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/profile', [ProfileController::class, 'profile'])->middleware('auth');

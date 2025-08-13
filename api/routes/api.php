<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\ReservationSlotController;

Route::get('/profile', [ProfileController::class, 'profile'])->middleware('auth');
Route::get('/slots', [SlotController::class, 'list'])->middleware('auth');

Route::post('/slots/{slotId}/reserve', [ReservationSlotController::class, 'reserveSlotForSelf'])->middleware('auth');
Route::put('/slots/{slotId}/cancel', [ReservationSlotController::class, 'cancelReservation'])->middleware('auth');

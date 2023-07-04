<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PagesController;

Route::get('password-recuperacion',[PagesController::class,'passwordRecovery'])->name('password.recovery');
Route::get('restablecer-password',[PagesController::class,'updatePassword'])->name('update.password');

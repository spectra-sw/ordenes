<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('login',[AuthController::class,'login'])->name('login');
Route::get('send-email-recovery',[AuthController::class,'sendEmailRecovery'])->name('send.email.recovery');
Route::get('password-update',[AuthController::class,'passwordUpdate'])->name('password.update');

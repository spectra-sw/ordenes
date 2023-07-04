<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TurnoController;

// turnos
Route::get('/modal-turno-acciones',[TurnoController::class,'modalTurnoAcciones'])->name('modal.acciones');
Route::get('/update',[TurnoController::class,'update'])->name('update');
Route::get('/show-table',[TurnoController::class,'showTable'])->name('show.table');

<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CargoController;

Route::get('modal-cargo-acciones',[CargoController::class,'modalCargoAcciones'])->name('modal.acciones');;
Route::get('create',[CargoController::class,'create'])->name('create');;
Route::get('update',[CargoController::class,'update'])->name('update');;
Route::get('toggle-estado',[CargoController::class,'toggleEstado'])->name('toggleEstado');;
Route::get('show-table',[CargoController::class,'showTable'])->name('show.table');;

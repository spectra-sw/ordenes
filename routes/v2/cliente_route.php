<?php

use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PagesController;

Route::get('/modal-cliente-acciones', [ClienteController::class, 'modalClienteAcciones'])->name('modal-cliente-acciones');
Route::get('/create', [ClienteController::class, 'create'])->name('create');
Route::get('/update', [ClienteController::class, 'update'])->name('update');
Route::get('/show-table', [ClienteController::class, 'showTable'])->name('show-table');
Route::get('/destroy', [ClienteController::class, 'destroy'])->name('destroy');

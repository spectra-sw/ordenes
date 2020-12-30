<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PagesController;
use App\Http\Controllers\LoadController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\ExcelController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});
Route::get('/', function () {
    return view('ordenes');
});
*/

//Pages
Route::get('/',[PagesController::class, 'inicio']);
Route::get('/ordenes',[PagesController::class, 'ordenes']);
Route::get('/getConsec',[PagesController::class, 'getConsec']);
Route::get('/agregarp',[PagesController::class, 'agregarp']);
Route::get('/agregare',[PagesController::class, 'agregare']);
Route::get('/agregarh',[PagesController::class, 'agregarh']);
Route::get('/agregardia',[PagesController::class, 'agregardia']);
Route::get('/almdia',[PagesController::class, 'almdia']);
Route::get('/admin',[PagesController::class, 'admin']);
Route::get('/bases',[PagesController::class, 'bases']);
Route::get('/consultas',[PagesController::class, 'consultas']);
Route::get('/saveorden',[PagesController::class, 'saveorden']);
Route::get('/verorden/{id}',[PagesController::class,'verorden']);

//Load
Route::get('/load/{tipo}',[LoadController::class,'load']);

//Search
Route::get('autocomplete', [SearchController::class, 'autocomplete'])->name('autocomplete');
Route::get('autoemp', [SearchController::class, 'autoemp'])->name('autoemp');
Route::get('consproyecto',[SearchController::class, 'consproyecto'])->name('consproyecto');
Route::get('getordenes',[SearchController::class,'getordenes'])->name("getordenes");
Route::get('archivon',[FilesController::class,'archivon'])->name("archivon");

//utilities
Route::get('autorizadas',[PagesController::class, 'autorizadas'])->name('autorizadas');
Route::get('delete',[PagesController::class,'del'])->name('del');

//Excel
Route::get('exportReporte', [ExcelController::class, 'export'])->name('export');

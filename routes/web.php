<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PagesController;
use App\Http\Controllers\LoadController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\AuthController;
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
Route::get('/',[PagesController::class, 'inicio'])->name('inicio');
Route::get('/menu',[PagesController::class, 'menu'])->name('menu');
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
Route::get('/updateorden',[PagesController::class, 'saveorden']);
Route::get('/verorden/{id}',[PagesController::class,'verorden']);
Route::get('/ordenese/{id}',[PagesController::class,'editorden']);
Route::get('/getdia',[PagesController::class,'getdia']);
Route::get('/editDia',[PagesController::class,'editDia']);
Route::get('/login',[PagesController::class,'login']);
Route::get('/logout',[PagesController::class,'login']);
//emp
Route::get('/nuevoemp',[PagesController::class,'nuevoemp']);
Route::get('/buscaremp',[PagesController::class,'buscaremp']);
Route::get('/editaremp',[PagesController::class,'editaremp']);
Route::get('/tablaemp',[PagesController::class,'tablaemp']);
Route::get('/eliminaremp',[PagesController::class,'eliminaremp']);

//cdc
Route::get('/nuevocdc',[PagesController::class,'nuevocdc']);
Route::get('/buscarcdc',[PagesController::class,'buscarcdc']);
Route::get('/editarcdc',[PagesController::class,'editarcdc']);
Route::get('/tablacdc',[PagesController::class,'tablacdc']);
Route::get('/eliminarcdc',[PagesController::class,'eliminarcdc']);
Route::get('/nuevaprog',[PagesController::class,'nuevaprog']);

//programacion
Route::get('/programacion',[PagesController::class,'programacion']);
Route::get('/tablaprog',[PagesController::class,'tablaprog']);

//Load
Route::get('/load/{tipo}',[LoadController::class,'load']);

//Search
Route::get('autocomplete', [SearchController::class, 'autocomplete'])->name('autocomplete');
Route::get('autoemp', [SearchController::class, 'autoemp'])->name('autoemp');
Route::get('consproyecto',[SearchController::class, 'consproyecto'])->name('consproyecto');
Route::get('getordenes',[SearchController::class,'getordenes'])->name("getordenes");
Route::get('buscarcontactos',[SearchController::class,'buscarcontactos'])->name("buscarcontactos");
Route::get('archivon',[FilesController::class,'archivon'])->name("archivon");

//utilities
Route::get('autorizadas',[PagesController::class, 'autorizadas'])->name('autorizadas');
Route::get('eliminar',[PagesController::class,'delete'])->name('eliminar');
Route::get('updatepwd',[PagesController::class,'updatepwd'])->name('updatepwd');
Route::get('updatep',[PagesController::class,'updatep'])->name('updatep');

//Excel
Route::get('exportReporte', [ExcelController::class, 'export'])->name('export');

//Auth
Route::get('validar',[AuthController::class,'validar'])->name('validar');
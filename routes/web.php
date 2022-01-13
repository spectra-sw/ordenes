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
Route::get('/deleteDia',[PagesController::class,'deleteDia']);
Route::get('/login',[PagesController::class,'login']);
Route::get('/logout',[PagesController::class,'login']);
Route::get('/ocupacion',[PagesController::class,'ocupacion']);
Route::get('/rocupacion',[PagesController::class,'rocupacion']);


//emp
Route::get('/nuevoemp',[PagesController::class,'nuevoemp']);
Route::get('/buscaremp',[PagesController::class,'buscaremp']);
Route::get('/editaremp',[PagesController::class,'editaremp']);
Route::get('/tablaemp',[PagesController::class,'tablaemp']);
Route::get('/eliminaremp',[PagesController::class,'eliminaremp']);

//cliente
Route::get('/nuevocliente',[PagesController::class,'nuevocliente']);
Route::get('/buscarcliente',[PagesController::class,'buscarcliente']);
Route::get('/editarcliente',[PagesController::class,'editarcliente']);
Route::get('/tablacliente',[PagesController::class,'tablacliente']);
Route::get('/eliminarcliente',[PagesController::class,'eliminarcliente']);
Route::get('/filtrarcliente',[PagesController::class,'filtrarcliente']);

//proyectos
Route::get('/nuevoproy',[PagesController::class,'nuevoproy']);
Route::get('/buscarproy',[PagesController::class,'buscarproy']);
Route::get('/editarproy',[PagesController::class,'editarproy']);
Route::get('/tablaproy',[PagesController::class,'tablaproy']);
Route::get('/eliminarproy',[PagesController::class,'eliminarproy']);
Route::get('/filtrarproy',[PagesController::class,'filtrarproy']);


//cdc
Route::get('/nuevocdc',[PagesController::class,'nuevocdc']);
Route::get('/buscarcdc',[PagesController::class,'buscarcdc']);
Route::get('/editarcdc',[PagesController::class,'editarcdc']);
Route::get('/tablacdc',[PagesController::class,'tablacdc']);
Route::get('/eliminarcdc',[PagesController::class,'eliminarcdc']);
Route::get('/filtrarcentro',[PagesController::class,'filtrarcentro']);


//programacion
Route::get('/nuevaprog',[PagesController::class,'nuevaprog']);
Route::get('/programacion',[PagesController::class,'programacion']);
Route::get('/tablaprog',[PagesController::class,'tablaprog']);
Route::get('/buscarprog',[PagesController::class,'buscarprog']);
Route::get('/editarprog',[PagesController::class,'editarprog']);
Route::get('/eliminarprog',[PagesController::class,'eliminarprog']);
Route::get('/filtrarprog',[PagesController::class,'filtrarprog']);
Route::get('/calendarioprog',[PagesController::class,'calendarioprog']);
Route::get('/calendariooc',[PagesController::class,'calendariooc']);
Route::get('/cargarprog',[PagesController::class,'cargarprog']);
Route::get('/actgprog',[PagesController::class,'actgprog']);



//Load
Route::get('/load/{tipo}',[LoadController::class,'load']);

//Search
Route::get('autocomplete', [SearchController::class, 'autocomplete'])->name('autocomplete');
Route::get('autoemp', [SearchController::class, 'autoemp'])->name('autoemp');
Route::get('consproyecto',[SearchController::class, 'consproyecto'])->name('consproyecto');
Route::get('getordenes',[SearchController::class,'getordenes'])->name("getordenes");
Route::get('buscarcontactos',[SearchController::class,'buscarcontactos'])->name("buscarcontactos");
Route::get('archivon',[FilesController::class,'archivon'])->name("archivon");
Route::get('reportep',[FilesController::class,'reportep'])->name("reportep");

//utilities
Route::get('autorizadas',[PagesController::class, 'autorizadas'])->name('autorizadas');
Route::get('eliminar',[PagesController::class,'delete'])->name('eliminar');
Route::get('updatepwd',[PagesController::class,'updatepwd'])->name('updatepwd');
Route::get('updatep',[PagesController::class,'updatep'])->name('updatep');
Route::get('consfestivo',[PagesController::class,'consfestivo'])->name('consfestivo');

//Excel
Route::get('exportReporte', [ExcelController::class, 'export'])->name('export');
Route::get('exportReporteO', [ExcelController::class, 'exporto'])->name('exporto');

//Auth
Route::get('validar',[AuthController::class,'validar'])->name('validar');

Route::get('yoursix',[PagesController::class,'yoursix'])->name('yoursix');


//ocupación
Route::get('/seguimiento',[PagesController::class,'seguimiento']);
Route::get('/generalo',[PagesController::class,'generalo']);
Route::get('/distribuciono',[PagesController::class,'distribuciono']);
Route::get('/buscarinfooc',[PagesController::class,'buscarinfooc']);
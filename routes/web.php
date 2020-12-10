<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PagesController;
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
Route::get('/ordenes',[PagesController::class, 'ordenes']);
Route::get('/getConsec',[PagesController::class, 'getConsec']);
Route::get('/agregarp',[PagesController::class, 'agregarp']);
Route::get('/agregare',[PagesController::class, 'agregare']);
Route::get('/agregarh',[PagesController::class, 'agregarh']);
Route::get('/agregardia',[PagesController::class, 'agregardia']);
Route::get('/almdia',[PagesController::class, 'almdia']);
Route::get('/admin',[PagesController::class, 'admin']);
Route::get('/consultas',[PagesController::class, 'consultas']);



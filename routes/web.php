<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PagesController;
use App\Http\Controllers\LoadController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProyectosController;
use App\Http\Controllers\OrdenesController;
use App\Http\Controllers\MensajesController;
use App\Http\Controllers\ConsultasController;
use App\Http\Controllers\DistribucionController;
use  App\Http\Controllers\TurnoController;
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
Route::get('/test', [PagesController::class, 'test']);
Route::get('/', [PagesController::class, 'inicio'])->name('inicio');
Route::get('/menu', [PagesController::class, 'menu'])->name('menu');
Route::get('/ordenes', [OrdenesController::class, 'ordenes']);
Route::get('/getConsec', [PagesController::class, 'getConsec']);
Route::get('/agregarp', [PagesController::class, 'agregarp']);
Route::get('/agregare', [PagesController::class, 'agregare']);
Route::get('/agregarh', [PagesController::class, 'agregarh']);
Route::get('/agregardia', [PagesController::class, 'agregardia']);
Route::get('/almdia', [PagesController::class, 'almdia']);
Route::get('/admin', [PagesController::class, 'admin']);
Route::get('/bases', [PagesController::class, 'bases']);
//Route::get('/consultas',[PagesController::class, 'consultas']);
Route::get('/consultas', [ConsultasController::class, 'consultas']);
Route::get('/saveorden', [PagesController::class, 'saveorden']);
Route::get('/updateorden', [PagesController::class, 'saveorden']);
Route::get('/verorden/{id}', [PagesController::class, 'verorden']);
Route::get('/ordenese/{id}', [PagesController::class, 'editorden']);
Route::get('/getdia', [PagesController::class, 'getdia']);
Route::get('/editDia', [PagesController::class, 'editDia']);
Route::get('/deleteDia', [PagesController::class, 'deleteDia']);
Route::get('/login', [PagesController::class, 'login']);
Route::get('/logout', [PagesController::class, 'login']);
Route::get('/ocupacion', [PagesController::class, 'ocupacion']);
Route::get('/extra', [PagesController::class, 'consextra']);
Route::get('/rocupacion', [PagesController::class, 'rocupacion']);


//emp
Route::get('/nuevoemp', [PagesController::class, 'nuevoemp']);
Route::get('/editaremp', [PagesController::class, 'editaremp']);
Route::get('/tablaemp', [PagesController::class, 'tablaemp']);
Route::get('/eliminaremp', [PagesController::class, 'eliminaremp']);
Route::get('/modal-empleado-acciones', [PagesController::class, 'modalEmpleadoAcciones']);

//proyectos
Route::get('/nuevoproy', [ProyectosController::class, 'nuevoproy']);
Route::get('/togle-habilitar-proyecto', [ProyectosController::class, 'togleHabilitarProyecto']);
Route::get('/editarproy', [ProyectosController::class, 'editarproy']);
Route::get('/tablaproy', [ProyectosController::class, 'tablaproy']);
Route::get('/eliminarproy', [ProyectosController::class, 'eliminarproy']);
Route::get('/filtrarproy', [ProyectosController::class, 'filtrarproy']);
Route::get('/autorizadosproy', [ProyectosController::class, 'autorizadosproy']);
Route::get('/agautorizadoproy', [ProyectosController::class, 'agautorizadoproy']);
Route::get('/borrarautorizado', [ProyectosController::class, 'borrarautorizado']);
Route::get('/modal-proyecto-acciones', [PagesController::class, 'modalProyectoAcciones']);

//cdc
Route::get('/nuevocdc', [PagesController::class, 'nuevocdc']);
Route::get('/buscarcdc', [PagesController::class, 'buscarcdc']);
Route::get('/editarcdc', [PagesController::class, 'editarcdc']);
Route::get('/tablacdc', [PagesController::class, 'tablacdc']);
Route::get('/eliminarcdc', [PagesController::class, 'eliminarcdc']);
Route::get('/filtrarcentro', [PagesController::class, 'filtrarcentro']);
Route::get('/modal-corte-acciones', [PagesController::class, 'modalCortesAcciones']);
Route::get('/togle-habilitar-corte', [PagesController::class, 'togleHabilitarCorte']);

//programacion
Route::get('/nuevaprog', [PagesController::class, 'nuevaprog']);
Route::get('/programacion', [PagesController::class, 'programacion']);
Route::get('/tablaprog', [PagesController::class, 'tablaprog']);
Route::get('/buscarprog', [PagesController::class, 'buscarprog']);
Route::get('/consprog', [PagesController::class, 'consprog']);
Route::get('/editarprog', [PagesController::class, 'editarprog']);
Route::get('/eliminarprog', [PagesController::class, 'eliminarprog']);
Route::get('/filtrarprog', [PagesController::class, 'filtrarprog']);
Route::get('/calendarioprog', [PagesController::class, 'calendarioprog']);
Route::get('/calendariooc', [PagesController::class, 'calendariooc']);
Route::get('/cargarprog', [PagesController::class, 'cargarprog']);
Route::get('/actgprog', [PagesController::class, 'actgprog']);

//Load
Route::get('/load/{tipo}', [LoadController::class, 'load']);

//Search
Route::get('autocomplete', [SearchController::class, 'autocomplete'])->name('autocomplete');
Route::get('autoemp', [SearchController::class, 'autoemp'])->name('autoemp');
Route::get('consproyecto', [SearchController::class, 'consproyecto'])->name('consproyecto');
Route::get('getordenes', [SearchController::class, 'getordenes'])->name("getordenes");
Route::get('buscarcontactos', [SearchController::class, 'buscarcontactos'])->name("buscarcontactos");
Route::get('archivon', [FilesController::class, 'archivon'])->name("archivon");
Route::get('archivoc', [FilesController::class, 'archivoc'])->name("archivoc");
Route::get('reportep', [FilesController::class, 'reportep'])->name("reportep");

//utilities
Route::get('autorizadas', [PagesController::class, 'autorizadas'])->name('autorizadas');
Route::get('eliminar', [PagesController::class, 'delete'])->name('eliminar');
Route::get('updatepwd', [PagesController::class, 'updatepwd'])->name('updatepwd');
Route::get('updatep', [PagesController::class, 'updatep'])->name('updatep');
Route::get('consfestivo', [PagesController::class, 'consfestivo'])->name('consfestivo');

//Excel export
//Route::get('exportReporte', [ExcelController::class, 'export'])->name('export');
Route::get('exportReporte', [ExcelController::class, 'exportt'])->name('exporttt');
Route::get('exportReporteO', [ExcelController::class, 'exporto'])->name('exporto');
Route::get('exportAnaliticas', [ExcelController::class, 'exporta'])->name('exporta');
Route::get('exportExtra', [ExcelController::class, 'exportextra'])->name('exportextra');
Route::get('exportProyectos', [ExcelController::class, 'exportProyectos'])->name('exportProyectos');
Route::get('export-consultas', [ExcelController::class, 'exportConsultas'])->name('exportConsultas');

// Excel import
Route::post('importHoras', [ExcelController::class, 'importHoras'])->name('importHoras');
Route::post('importTurnos', [ExcelController::class, 'importTurnos'])->name('importTurnos');

//ocupación
Route::get('/seguimiento', [PagesController::class, 'seguimiento']);
Route::get('/generalo', [PagesController::class, 'generalo']);
Route::get('/distribuciono', [PagesController::class, 'distribuciono']);
Route::get('/buscarinfooc', [PagesController::class, 'buscarinfooc']);
Route::get('/deleteOcupacion', [PagesController::class, 'deleteOcupacion']);

//extra
Route::get('/authextra', [PagesController::class, 'authextra']);
Route::get('/nuevaextra', [PagesController::class, 'nuevaextra']);
Route::get('/saveextra', [PagesController::class, 'saveextra']);
Route::get('/voboextra', [PagesController::class, 'voboextra']);
Route::get('/rechazarextra', [PagesController::class, 'rechazarextra']);
Route::get('/editarextra', [PagesController::class, 'editarextra']);
Route::get('/eliminarextra', [PagesController::class, 'eliminarextra']);
Route::get('/actextra', [PagesController::class, 'actextra']);


Route::get('send-mail', function () {

    $details = [
        'title' => 'Solicitud de horas extras',
        'body' => 'This is for testing email using smtp'
    ];

    \Mail::to('dguerra@spectra.com.co')->send(new \App\Mail\MailSolicitudExtra($details));

    dd("Email is Sent.");
});


//jornada
Route::get('/jornada', [OrdenesController::class, 'jornada']);
Route::get('/registrarJornada', [OrdenesController::class, 'registrarJornada']);
Route::get('/consecJornada', [OrdenesController::class, 'consecJornada']);
Route::get('/deleteJornada', [OrdenesController::class, 'deleteJornada']);
Route::get('/solapeJornada', [OrdenesController::class, 'solapeJornada']);
Route::get('/consultaJornada', [OrdenesController::class, 'consultaJornada']);
Route::get('/consultaJornadaAdmin', [OrdenesController::class, 'consultaJornadaAdmin']);
Route::get('/accionesJornada', [OrdenesController::class, 'accionesJornada']);
Route::get('/misjornadas', [OrdenesController::class, 'misjornadas']);

Route::get('/distribucion', [DistribucionController::class, 'distribucion']);
Route::get('/validarCorte', [OrdenesController::class, 'validarCorte']);

//mensajes
Route::get('/mensaje/error', [MensajesController::class, 'error']);
Route::get('/mensaje/exito', [MensajesController::class, 'exito']);
Route::get('/mensaje/info', [MensajesController::class, 'info']);

//corte
Route::get('/nuevocorte', [PagesController::class, 'nuevocorte']);
Route::get('/tablacorte', [PagesController::class, 'tablacorte']);


// new routes v2
Route::name('v2.')->group(function () {
    // AUTH
    Route::prefix('auth')->name('auth.')->group(function () {
        require __DIR__ . '/v2/auth_route.php';
    });
    // CARGOS
    Route::prefix('cargo')->name('cargo.')->group(function () {
        require __DIR__ . '/v2/cargos_route.php';
    });
    // CLIENTES
    Route::prefix('cliente')->name('cliente.')->group(function () {
        require __DIR__ . '/v2/cliente_route.php';
    });
    // Pages
    Route::name('page.')->group(function () {
        require __DIR__ . '/v2/pages_route.php';
    });
    // TURNOS
    Route::prefix('turno')->name('turno.')->group(function () {
        require __DIR__ . '/v2/turnos_route.php';
    });
});

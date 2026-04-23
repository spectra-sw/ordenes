<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
//use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\Orden;
use App\Models\Planificacion;
use App\Models\Ejecucion;
use App\Models\Hora;
use App\Models\Dia;
use App\Models\Empleado;
use App\Models\Cdc;
use App\Models\Cliente;
use App\Models\Proyecto;
use App\Models\Programacion;
use App\Models\Horario;
use App\Models\Area;
use App\Models\Actividad;
use App\Models\ocupacion;
use App\Models\Festivo;
use App\Models\Novedad;
use App\Models\Autorizacion;
use App\Models\Cargo;
use App\Models\Autorizados;
use App\Models\Jornada;
use App\Models\Corte;
use App\Models\Notification;
use App\Models\EvidenciaJornada;
use App\Models\Turno;
use Log;

use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrdenesController extends Controller
{
    public function ordenes()
    {
        //$proyectos = Proyecto::orderBy('codigo','asc')->get();
        $proyectos = collect([]);
        $user = session('user');
        if ($user == "") {
            return redirect()->route('inicio');
        }
        //$user = 108;
        $cc = Empleado::where('id', $user)->first()->cc;
        $ciudad = Empleado::where('id', $user)->first()->ciudad;
        $ps = Programacion::where('cc', $cc)->get()->unique('proyecto');
        foreach ($ps as $p) {
            $proyectos->push($p->proyecto);
        }
        //dd($proyectos->count());
        if ($proyectos->count() == 0) {
            $ps = Proyecto::where('ciudad', $ciudad)->orderBy('codigo', 'asc')->get();
            foreach ($ps as $p) {
                $proyectos->push($p->codigo);
            }
        }
        $ps = Proyecto::where('director', $user)->orWhere('lider', $user)->get();
        foreach ($ps as $p) {
            $proyectos->push($p->codigo);
        }
        //dd($proyectos);
        $proyectosf = collect([]);
        foreach ($proyectos as $p) {
            if (Proyecto::where('codigo', $p)->first()->registro == 1) {
                $proyectosf->push($p);
            }
        }
        //dd($proyectosf);
        return view('ordenes', [
            'proyectos' => $proyectos

        ]);
    }

    public function jornada()
    {
        $user = session('user');

        if ($user == "") {
            return redirect()->route('inicio');
        }

        $aut = Autorizados::where('empleado_id', $user)->get();
        $ultimo_corte = Corte::where('estado', 1)->limit(1)->orderBy('id', 'desc')->first();

        if (!$ultimo_corte) {
            return view('jornada', [
                'proyectos' => $aut,
                'jornadas_rechazadas' => [],
                'jornadas_pendientes' => [],
            ]);
        }

        $fecha_incio_corte = new DateTime($ultimo_corte->fecha_inicio);
        $fecha_fin_corte = new DateTime($ultimo_corte->fecha_fin) > Carbon::now()->format('Y-m-d') ? new DateTime(Carbon::now()->format('Y-m-d')) : new DateTime($ultimo_corte->fecha_fin);

        $jornadas_rechazadas = Jornada::where('user_id', $user)->where('estado', 3)->where('fecha', '>=', $fecha_incio_corte)->where('fecha', '<=', $fecha_fin_corte)->get();
        $jornadas_group_by_fecha = Jornada::where('user_id', $user)->get()->groupBy('fecha');
        $jornadas_pendientes = [];

        for ($i = $fecha_incio_corte; $i < $fecha_fin_corte; $i->add(new DateInterval('P1D'))) {
            if (!isset($jornadas_group_by_fecha[$i->format('Y-m-d')])) {
                array_push($jornadas_pendientes, $i->format('Y-m-d'));
            }
        }

        return view('jornada', [
            'proyectos' => $aut,
            'jornadas_rechazadas' => $jornadas_rechazadas,
            'jornadas_pendientes' => $jornadas_pendientes,
        ]);
    }

    public function registrarJornada(Request $request)
    {
        // Verifica si el request contiene las imágenes
    /*if ($request->hasFile('imagenes')) {
        dd($request->file('imagenes')); // Muestra información sobre las imágenes subidas
    } else {
        dd('No se recibieron imágenes');
    }*/

        $request->validate([
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif', // only allow this type extension file.
        ]);
        $fecha = $request->fecha;
        $hours = $request->horaInicio;
        $minutes = $request->minInicio;

        $fecha = Carbon::create($fecha, $hours, $minutes);
        $fecha->addHours($hours);
        $fecha->addMinutes($minutes);
        //$formatted_date_time = $fecha->format('Y-m-d H:i:s');

        //dd( $formatted_date_time );

        $fechaf = $fecha;
        $fechaf->addHours($request->duracionh);
        $fechaf->addMinutes($request->duracionm);
        //$formatted_fechaf  = $fechaf->format('H:i');

        //dd($formatted_fechaf);

        $user_id = session()->get('user');

        $hi = strval($request->horaInicio) . ":" . strval($request->minInicio);
        //$hf = strval($request->horaFin) . ":" . strval($request->minFin);
        $duracion = strval($request->duracionh) . ":" . strval($request->duracionm);
        $request->merge([
            'user_id' => $user_id, 'hi' => $hi, 'hf' => $fechaf->format('H:i'), 'fechaf' => $fechaf->format('Y-m-d'), 'estado' => 1,
            'duracion' => $duracion, 'almuerzo' => 0
        ]);
        $data = $request->all();

        $j = Jornada::create($data);

        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                // Almacenar la imagen en S3 y obtener la URL
                $path = Storage::disk('s3')->put('evidencias_jornadas', $imagen);
                $url = Storage::disk('s3')->url($path);
    
                // Aquí puedes guardar la URL en la base de datos si es necesario
                // Por ejemplo, podrías tener una tabla 'evidencias_jornadas' asociada a cada jornada
                EvidenciaJornada::create([
                    'jornada_id' => $j->id,
                    'url_imagen' => $url
                ]);
            }
        }    

        $datosJornada = Jornada::where('jornada_id', $data['jornada_id'])->where('user_id', $user_id)->get();
        return view('tablaJornada', [
            'jornada' => $datosJornada
        ]);
    }

    public function consecJornada(Request $request)
    {
        $user = session()->get('user');
        //$next = Jornada::max('id')+ 1;
        if (Jornada::where('user_id', $user)->latest()->first()) {
            $jornada_id = Jornada::where('user_id', $user)->latest()->first()->jornada_id + 1;
        } else {
            $jornada_id = 1;
        }
        return $jornada_id;
    }

    public function deleteJornada(Request $request)
    {
        $datos = Jornada::where('id', $request->id)->first();
        $cortes = Corte::all();
        $fecha = $request->fecha;
        foreach ($cortes as $c) {
            if (($datos->fecha >= $c->fecha_inicio) && ($datos->fecha <= $c->fecha_fin)) {
                $estado =$c->estado;
            }
        }
       
        //dd($estado);
        if($estado ==0){
            return 'no';
        }
        else{
            Jornada::where('id', $request->id)->delete();
            $datosJornada = Jornada::where('jornada_id', $datos->jornada_id)->where('user_id', $datos->user_id)->get();
            return view('tablaJornada', [
                'jornada' => $datosJornada
            ]);
        }
    }

    public function solapeJornada(Request $request)
    {
        $user = session()->get('user');
        $fecha = $request->fecha;
        // $fecha = "2023-02-06";
        //$jornadas = Jornada::where('user_id',$user)
        //->where('fecha','>=',$fecha)->orWhere('fechaf','>=',$fecha)->get();

        $jornadas = Jornada::where('user_id', $user)
            ->where('estado', '<>', 3)
            ->where(function ($query) use ($fecha) {
                $query->where('fecha', '>=', $fecha)
                    ->orWhere('fechaf', '>=', $fecha);
            })
            ->get();

        //dd($jornadas);
        //$hi = intval($request->horaInicio) + floatval($request->minInicio);
        //$hf = intval($request->horaFin) + floatval($request->minFin);
        $fecha = $request->fecha;
        $hours = $request->horaInicio;
        $minutes = $request->minInicio;

        $fecha = Carbon::create($fecha);
        $fecha->addHours($hours);
        $fecha->addMinutes($minutes);
        $formatted_date_time = $fecha->format('Y-m-d H:i:s');
        $timestamp2_start = $fecha->getTimestamp();
        // dd($fecha);
        //dd( $formatted_date_time );

        $fechaf = Carbon::create($request->fecha);
        $fechaf->addHours($hours + $request->duracionh);
        $fechaf->addMinutes($minutes + $request->duracionm);
        $formatted_date_time = $fechaf->format('Y-m-d H:i:s');
        //    dd( $formatted_date_time );
        $timestamp2_end = $fechaf->getTimestamp();
        // dd($fechaf);

        // dd( $timestamp2_start ." ".$timestamp2_end);

        $solape = "false";
        foreach ($jornadas as $j) {
            $inicio = explode(":", $j->hi);
            $fin = explode(":", $j->duracion);

            $fecha3 = $j->fecha;
            $hours = intval($inicio[0]);
            $minutes = floatval($inicio[1]);

            $fecha3 = Carbon::create($fecha3);
            $fecha3->addHours($hours);
            $fecha3->addMinutes($minutes);
            // dd($fecha3, );

            $hoursf = intval($fin[0]);
            $minutesf = floatval($fin[1]);

            $fecha4 = $j->fecha;
            $fecha4 = Carbon::create($fecha4);
            $fecha4->addHours($hours + $hoursf);
            $fecha4->addMinutes($minutes + $minutesf);

            //dd($fecha4);
            /* if (($fecha >= $fecha4 || $fechaf <= $fecha3) ) {
                $solape= "false";
            } else {
                $solape= "true";
                if($j->estado == 3){
                    $solape= "false";
                }
            }*/
            if (($fecha < $fecha3 && $fechaf > $fecha3) || ($fecha >= $fecha3 && $fechaf <= $fecha4) || ($fecha >= $fecha3 && $fechaf >= $fecha4 && $fecha < $fecha4)) {
                $solape = "true";
                return $solape;
            }
        }
        return $solape;
    }

    public function misjornadas()
    {
        return view('misjornadas');
    }

    public function consultaJornada(Request $request)
    {
        $user = session()->get('user');
        $jornadas = Jornada::where('user_id', $user)->where('fecha', '>=', $request->inicio)->where('fecha', '<=', $request->fin)->orderBy('fecha', 'asc')->get();
        $users = DB::table('users')->distinct()->select('email')->where('name', 'John')->get();
        $total_jornadas = DB::table('jornada')->distinct()->select('jornada_id')->where('user_id', $user)->where('fecha', '>=', $request->inicio)->where('fecha', '<=', $request->fin)->count();

        $request = new Request();
        $request->merge(['fecha' => Carbon::now()->format('Y-m-d')]);
        $estado = $this->validarCorte($request);



        return view('timetracker.consultaJornadas', [
            'jornadas' => $jornadas,
            'total_jornadas' => $total_jornadas,
            'estado' => $estado
        ]);
    }

    public function consultaJornadaAdmin(Request $request)
    {
        $jornadas = $this->getJornadasConAnalisis($request);

        return view('timetracker.consultaJornadasAdmin', [
            'jornadas' => $jornadas,
            'total_jornadas' => $jornadas->count()
        ]);
    }

    public function getJornadasConAnalisis(Request $request)
    {
        $jornadas = Jornada::query();
        $cortes   = Corte::query();

        if ($request->proyecto) {
            $jornadas->where('proyecto', $request->proyecto);
        }
        if ($request->trabajador) {
            $jornadas->where('user_id', $request->trabajador);
        }
        if ($request->cliente) {
            $clientId = $request->cliente;
            $jornadas->whereHas('proyectoinfo', function ($query) use ($clientId) {
                $query->where('cliente_id', $clientId);
            });
        }
        if ($request->inicio && $request->fin) {
            $jornadas->whereBetween('fecha', [$request->inicio, $request->fin]);
            $cortes->whereDate('fecha_inicio', '<=', $request->inicio)
                ->whereDate('fecha_fin', '>=', $request->inicio)
                ->orWhereDate('fecha_inicio', '<=', $request->fin)
                ->whereDate('fecha_fin', '>=', $request->fin)
                ->orWhereDate('fecha_inicio', '>=', $request->inicio)
                ->whereDate('fecha_fin', '<=', $request->fin);
        }
        if ($request->estado) {
            $jornadas->where('estado', $request->estado);
        }

        $cortes   = $cortes->get();
        $jornadas = $jornadas->orderBy('fecha', 'asc')->orderBy('id', 'asc')->get();

        // --- Batch load para enriquecimiento ---
        $userIds  = $jornadas->pluck('user_id')->unique();
        $minFecha = $jornadas->min('fecha') ?? now()->format('Y-m-d');
        $maxFecha = $jornadas->max('fecha') ?? now()->format('Y-m-d');

        $turnosPorUser = Turno::whereIn('user_id', $userIds)
            ->where('fecha_inicio', '<=', $maxFecha)
            ->where('fecha_fin', '>=', $minFecha)
            ->get()->groupBy('user_id');

        $empleados = Empleado::with('horario')
            ->whereIn('id', $userIds)
            ->get()->keyBy('id');

        $festivosSet = Festivo::whereBetween('fecha', [$minFecha, $maxFecha])
            ->pluck('fecha')->flip()->toArray();

        foreach ($jornadas as $jornada) {
            // Corte status
            $jornada->corte_status = 1;
            foreach ($cortes as $corte) {
                if ($jornada->fecha >= $corte->fecha_inicio && $jornada->fecha <= $corte->fecha_fin && $corte->estado == 0) {
                    $jornada->corte_status = 0;
                    break;
                }
            }

            // Festivo / domingo
            $carbon = new Carbon($jornada->fecha);
            $numdia = $carbon->dayOfWeek;
            $jornada->es_festivo = isset($festivosSet[$jornada->fecha]);
            $jornada->es_domingo = ($numdia === 0);

            // Resolver horario de referencia
            $turnoActivo = null;
            if (isset($turnosPorUser[$jornada->user_id])) {
                // El turno debe iniciar en la misma fecha de la jornada y cubrir hasta su fecha final
                $turnoActivo = $turnosPorUser[$jornada->user_id]->first(fn($t) =>
                    $t->fecha_inicio == $jornada->fecha && $t->fecha_fin >= $jornada->fecha
                );
            }

            $empleado    = $empleados[$jornada->user_id] ?? null;
            $horarioBase = $empleado?->horario;

            if ($turnoActivo) {
                $ref = $turnoActivo;
                $jornada->horario_label  = 'T';
                $jornada->horario_nombre = $turnoActivo->fecha_inicio . ' / ' . $turnoActivo->fecha_fin;
                $laborales = ($turnoActivo->fecha_inicio == $turnoActivo->fecha_fin)
                    ? $turnoActivo->hora_fin - $turnoActivo->hora_inicio - $turnoActivo->almuerzo
                    : (24 - $turnoActivo->hora_inicio) + $turnoActivo->hora_fin - $turnoActivo->almuerzo;
            } elseif ($horarioBase) {
                $ref = clone $horarioBase;
                if ($empleado->horario_id == 5 && $numdia == 5) $ref->hora_fin = 15.5;
                $jornada->horario_label  = 'H';
                $jornada->horario_nombre = $horarioBase->nombre;
                $fueraDias = ($numdia < $horarioBase->dia_inicio || $numdia > $horarioBase->dia_fin);
                $laborales = $fueraDias ? 0 : max(0, $ref->hora_fin - $ref->hora_inicio - $ref->almuerzo);
            } else {
                $ref = null;
                $jornada->horario_label  = '?';
                $jornada->horario_nombre = 'Sin horario';
                $laborales = 0;
            }

            $jornada->laborales_ref = $laborales;
            $jornada->horario_rango = $ref
                ? number_format($ref->hora_inicio, 1) . '-' . number_format($ref->hora_fin, 1) . ' (' . $ref->almuerzo . 'h)'
                : '-';

            // Parsear hi / hf / duracion
            $hi      = intval(explode(':', $jornada->hi)[0])       + round(floatval(explode(':', $jornada->hi)[1] / 60), 2);
            $hf      = intval(explode(':', $jornada->hf)[0])       + round(floatval(explode(':', $jornada->hf)[1] / 60), 2);
            $durReal = intval(explode(':', $jornada->duracion)[0])  + round(floatval(explode(':', $jornada->duracion)[1] / 60), 2)
                       - $jornada->almuerzo;

            // Detectar extras y recargos
            $tieneExtra   = false;
            $tipoExtra    = [];
            $tieneRecargo = false;
            $finDiurno    = $this->getFinDiurno(\Carbon\Carbon::parse($jornada->fecha));
            $heno         = $this->calcularHenoHoras($hi, $hf, $finDiurno);

            if ($jornada->es_festivo || $jornada->es_domingo) {
                if ($durReal > 0) {
                    $tieneExtra  = true;
                    $tipoExtra[] = $jornada->es_festivo ? 'Festivo' : 'Dom';
                    if ($heno > 0) $tipoExtra[] = 'Noc';
                }
                if ($heno > 0) $tieneRecargo = true;
            } else {
                if ($laborales > 0 && $durReal > $laborales) {
                    $tieneExtra  = true;
                    $tipoExtra[] = 'Extra';
                    if ($ref && $this->calcularHenoHoras($ref->hora_fin, $hf, $finDiurno) > 0) $tipoExtra[] = 'Noc';
                }
                if ($heno > 0) $tieneRecargo = true;
            }

            $jornada->tiene_extra      = $tieneExtra;
            $jornada->tipo_extra       = $tipoExtra;
            $jornada->tiene_recargo    = $tieneRecargo;
            $jornada->turno_incompleto = $laborales > 0 && $durReal < $laborales
                ? round($laborales - $durReal, 2)
                : 0;
        }

        // Filtro por tipo de concepto
        $tipoConcepto = $request->tipo_concepto;
        if ($tipoConcepto === 'extras') {
            $jornadas = $jornadas->filter(fn($j) => $j->tiene_extra || $j->tiene_recargo)->values();
        } elseif ($tipoConcepto === 'normales') {
            $jornadas = $jornadas->filter(fn($j) => !$j->tiene_extra && !$j->tiene_recargo)->values();
        }

        return $jornadas;
    }

    public function accionesJornada(Request $request)
    {
        // validate $request
        $validate = $request->validate([
            'obs' => 'required',
        ]);


        $user = session()->get('user');

        if ($user == "") {
            return  "Debe loguearse para realizar la acción";
        }
        //dd($request->obs);
        $jornada = Jornada::find($request->id);

        if ($request->op == "1") {
            $jornada->estado = 2;
            $result = "Aprobación realizada";
        } elseif ($request->op == "2") {
            $jornada->estado = 3;
            $result = "Registro rechazado";
            $content = "Su registro de jornada del día " . $jornada->fecha . " ha sido rechazado";
            $this->create_notification($content, $jornada->user_id);
            $this->send_whatsapp_by_rejected_jornada($jornada->fecha);
        }

        // dd($request->hi, $request->hf, $request->duracion, $request->all(), $jornada);

        // calcular duracion
        $fecha_inicio = Carbon::create($jornada->fecha);
        $fecha_fin = Carbon::create($jornada->fechaf);

        $hi = explode(":", $request->hi);
        $hf = explode(":", $request->hf);

        $hi = intval($hi[0]) + floatval($hi[1]) / 60;
        $hf = intval($hf[0]) + floatval($hf[1]) / 60;

        if ($fecha_fin > $fecha_inicio) {
            $duracion = ((24 + $hf) - $hi);
        } else {
            $duracion = ($hf - $hi);
        }

        $duracion = strval(intval($duracion)) . ":" . strval(intval(($duracion - intval($duracion)) * 60));

        $jornada->observacion = $request->obs;
        $jornada->hi = $request->hi;
        $jornada->hf = $request->hf;
        $jornada->duracion = $duracion;
        $jornada->almuerzo = $request->almuerzo;
        $jornada->revisado_por = $user;
        $jornada->fecha_revision = Carbon::now()->format('Y-m-d');
        $jornada->save();

        return $result;
    }

    public function validarCorte(Request $request)
    {
        $cortes = Corte::all();
        $fecha = $request->fecha;
        foreach ($cortes as $c) {
            if (($fecha >= $c->fecha_inicio) && ($fecha <= $c->fecha_fin)) {
                return $c->estado;
            }
        }
        return 1;
    }

    // methos for ordenes
    private function create_notification($content, $empleado_id)
    {
        Notification::create([
            'content' => $content,
            'empleado_id' => $empleado_id
        ]);
    }

    private function send_whatsapp_by_rejected_jornada($date)
    {
        try {
            $token = "EAAEPDh9XIZA8BOZByQUbePA8G2GsQkqKkvvQEgIJtA0sdGqLsh7pqZAhknU9ishZAAHRisH9QMQ1dZC2tOoQkDI43NEBEMRHFZBXIqqceF3wOcqOSo6axWEtouIQWlgW4HXTD4KMXW45WbZCta43LJPZCQflEQphq7ZBQkCHhjavDhCMn6nVdccisn5ehUHEtdpWQDp8Ere7j9MxGtYYataAZD";
            $telefono = "+584120529358";
            $url = "https://graph.facebook.com/v17.0/151331474733577/messages";

            $mensaje = "
            {
                'messaging_product': 'whatsapp',
                'to': '$telefono',
                'type': 'template',
                'template': {
                    'name': 'working_day_reject',
                    'language':{'code': 'en_US'},
                    'components': [
                        {
                            'type': 'body',
                            'parameters': [
                                {
                                    'type': 'text',
                                    'text': '$date'
                                }
                            ]
                        },
                    ]
                }
            }
            ";

            $header = array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            );
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $mensaje);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_exec($curl);
        } catch (\Throwable $th) {
        }
    }

    public function iniciojornada(){
        $user = session('user');
        $aut = Autorizados::where('empleado_id', $user)->get();

        return view('iniciojornada', [
            'proyectos' => $aut,
        ]);
    }
    public function registrarInicioJornada(Request $request)
    {
        $request->validate([
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif', // only allow this type extension file.
        ]);

        $user_id = session()->get('user');
        $duracion = "0:0";
        $hf ="0";
        // Fusionar datos adicionales en la solicitud
        $request->merge([
            'jornada_id' => 0,
            'user_id' => $user_id,
            'hf' => $hf,
            'fechaf' => '1900-01-01',
            'estado' => 1,
            'duracion' => $duracion,
            'almuerzo' => 0
        ]);
        
        $j = Jornada::create($request->all());
        //Log::info($request->all());
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                // Almacenar la imagen en S3 y obtener la URL
                $path = Storage::disk('s3')->put('evidencias_jornadas', $imagen);
                $url = Storage::disk('s3')->url($path);
    
                // Aquí puedes guardar la URL en la base de datos si es necesario
                // Por ejemplo, podrías tener una tabla 'evidencias_jornadas' asociada a cada jornada
                EvidenciaJornada::create([
                    'jornada_id' => $j->id,
                    'url_imagen' => $url,
                    'latitud' => $request->latitude,   // Almacena la latitud
                    'longitud' => $request->longitude  // Almacena la longitud
                ]);
            }
        }    

        return response()->json("Inicio de jornada registrado con éxito.");
    }
    public function finjornada($id)
    {
        // Buscar la jornada por su ID
        $jornada = Jornada::findOrFail($id);

        // Retornar la vista 'finjornada' con los datos de la jornada
        return view('finjornada', compact('jornada'));
    }
    public function registrarFinJornada(Request $request)
    {
        // Buscar la jornada por ID
        $jornada = Jornada::findOrFail($request->input('jornada_id'));

        // Obtener las fechas y horas
        $fechaInicio = $jornada->fecha; // Fecha de inicio de la jornada
        $horaInicio = $jornada->hi;     // Hora de inicio de la jornada
        $fechaFin = $request->input('fechaf'); // Fecha de fin de la jornada (puede ser diferente)
        $horaFin = $request->input('hf');      // Hora de fin de la jornada

        // Combinar fecha y hora para crear las instancias de Carbon
        $inicio = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $fechaInicio . ' ' . $horaInicio);
        $fin = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $fechaFin . ' ' . $horaFin);

        // Calcular la diferencia en minutos entre el inicio y el fin
        $diferenciaMinutos = $inicio->diffInMinutes($fin);
        $horas = floor($diferenciaMinutos / 60);
        $minutos = $diferenciaMinutos % 60;

        // Formatear la duración como h:m (por ejemplo, 9:30)
        $duracion = sprintf('%02d:%02d', $horas, $minutos);

        // Actualizar los campos de fin de jornada
        $jornada->fechaf = $fechaFin; // Actualiza la fecha de fin
        $jornada->hf = $horaFin;      // Actualiza la hora de fin
        $jornada->duracion = $duracion; // Actualiza la duración calculada
    
        $jornada->save();

        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                // Almacenar la imagen en S3 y obtener la URL
                $path = Storage::disk('s3')->put('evidencias_jornadas', $imagen);
                $url = Storage::disk('s3')->url($path);
    
                // Aquí puedes guardar la URL en la base de datos si es necesario
                // Por ejemplo, podrías tener una tabla 'evidencias_jornadas' asociada a cada jornada
                EvidenciaJornada::create([
                    'jornada_id' => $jornada->id,
                    'url_imagen' => $url,
                    'latitud' => $request->latitude,   // Almacena la latitud
                    'longitud' => $request->longitude  // Almacena la longitud
                ]);
            }
        }    


        return response()->json('Jornada finalizada correctamente');
    }
    public function getEvidencias($jornadaId)
    {
        // Obtener las evidencias para la jornada específica
        $evidencias = EvidenciaJornada::where('jornada_id', $jornadaId)->get();
        return response()->json($evidencias);
    }

    private function calcularHenoHoras($hi, $hf, $finDiurno = 19)
    {
        $heno = 0;
        // Franja nocturna 1: después del límite diurno (19:00 desde Jul 2024)
        if ($hi < $finDiurno && $hf > $finDiurno) {
            $heno = $hf - $finDiurno;
        } elseif ($hi >= $finDiurno && $hf > $finDiurno) {
            $heno = abs($hf - $hi);
        } elseif ($hi >= $finDiurno && $hf < $hi) {
            $heno += 24 - $hi;
        }
        // Franja nocturna 2: antes de las 6:00
        if ($hi >= 0 && $hf <= 6) {
            $heno = $hf - $hi;
        } elseif ($hi >= 0 && $hi <= 6 && $hf > 6) {
            $heno = 6 - $hi;
        }
        return $heno;
    }

    private function getFinDiurno(\Carbon\Carbon $fecha): float
    {
        if ($fecha->greaterThanOrEqualTo('2024-07-15')) return 19.0;
        if ($fecha->greaterThanOrEqualTo('2023-07-15')) return 20.0;
        return 21.0;
    }
}

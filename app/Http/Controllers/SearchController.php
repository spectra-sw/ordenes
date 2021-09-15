<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\Cdc;
use App\Models\Empleado;
use App\Models\Orden;
use App\Models\Cliente;
use App\Models\Proyecto;
use App\Models\Programacion;
use App\Models\Hora;
use DB;
class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        //dd($request->q);
        $q = "%".$request->q."%";
        /*
        $datas = Cdc::select("codigo")
                ->where("codigo","LIKE","%".$request->q."%")
                ->get();
        
                $dataModified = array();
                foreach ($datas as $data)
                {
                  $dataModified[] = $data->codigo;
                }
        */
        $datas = Proyecto::select("codigo")
                ->where("codigo","LIKE","%".$request->q."%")
                ->get();
        
                $dataModified = array();
                foreach ($datas as $data)
                {
                  $dataModified[] = $data->codigo;
                }
          // echo json_encode($datas);
        return response()->json($dataModified);
        //return $data;
    }
    public function autoemp(Request $request)
    {
        //dd($request->q);
        $q = "%".$request->q."%";
        $datas = Empleado::where("apellido1","LIKE","%".$request->q."%")
                ->get();
        
                $dataModified = array();
                foreach ($datas as $data)
                {
                  $d = array();
                  $d["value"] = $data->cc;
                  $d["text"] = $data->apellido1 . " " . $data->apellido2 . " ". $data->nombre;
                  $dataModified[] = $d;
                }
          // echo json_encode($datas);
        
        return response()->json($dataModified);
        //return $data;
    }
    public function consproyecto(Request $request){
        $codigo = $request->codigo;
        $data = Proyecto::where("codigo",$codigo)->first();
        $data['cliente'] = $data->cliente->cliente;
        $data['director'] = $data->ndirector->nombre." ".$data->ndirector->apellido1;
        $data['lider'] = $data->nlider->nombre." ".$data->nlider->apellido1;

        $ps = Programacion::where('proyecto',$request->codigo)->get();
        $ts = collect([]);
        foreach ($ps as $p){
            $ts->put($p->empleado->cc,$p->empleado->nombre . " ". $p->empleado->apellido1);
        }
        $data['trabajadores'] = $ts;

        return response()->json($data);
    }
    public function getordenes(Request $request){
        //$o=Orden::orderBy('created_at','desc')->get();
        $inicio= $request->fechaInicio." 00:00:00";
        $fin =$request->fechaFinal." 23:59:59";
        $proyecto = $request->proyecto;
        $responsable = $request->responsable;
        $cliente = $request->cliente;
        //dd($fin);

        //$o = Orden::where('id','>',0);
        $o = DB::table('ordenes')->join('dias','ordenes.id','=','dias.ordenes_id')->where('ordenes.cliente','<>',NULL)->where('dias.fecha','<>','1900-01-01');
        if ($proyecto!=""){
            $o=$o->where('ordenes.proyecto',$proyecto);
        }
        if($responsable!=""){
            $o=$o->where('ordenes.responsable',$responsable);
        }
        if($cliente!=""){
          $o=$o->where('ordenes.cliente','like','%'.$cliente.'%');
        }
        if(($inicio!=" 00:00:00")&&($fin!=" 11:59:59")){
                $o=$o->where('dias.fecha','>=',$inicio)->where('dias.fecha','<=',$fin);
        }
        $o=$o->distinct()->orderBy('ordenes.created_at','desc')->get();
        //dd($o);

        foreach ($o as $or){
          //dd($or);
          if( Hora::where('ordenes_id',$or->ordenes_id)->where('ha',0)->count() > 0){
            Orden::where('id',$or->ordenes_id)->update(['autorizada_por' => 0]);
          }
          $field="nresponsable";
          $e = Empleado::where('cc',$or->responsable)->first();
          $nresponsable = $e->nombre." ".$e->apellido1;
          $or->{$field} = $nresponsable;         
        }
        //dd($o);
        return view('tablao',[
            'datos' => $o
        ]);
    }
    public function buscarcontactos(Request $request){
      $cliente = $request->cliente;
      $c=Cliente::where("cliente","LIKE","%".$cliente."%")->first();
      return $c->contactos;
    }
}

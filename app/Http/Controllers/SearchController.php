<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\Cdc;
use App\Models\Empleado;
use App\Models\Orden;
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
        $datas = Cdc::select("codigo")
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
        $data = Cdc::where("codigo",$codigo)->first();
        return response()->json($data);
    }
    public function getordenes(Request $request){
        $o=Orden::orderBy('created_at','desc')->get();
        return view('tablao',[
            'datos' => $o
        ]);
    }
}

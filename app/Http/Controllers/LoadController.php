<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cdc;
use App\Models\Empleado;

class LoadController extends Controller
{
    //
    public function load($tipo){
        if ($tipo== "cdc"){ 
            $this->loadCdc(); 
        }
        if ($tipo== "empleados"){ 
            $this->loadEmpleados(); 
        }
        return 'Datos cargados';
    }
    private function loadCdc(){
        $file = public_path('csv/cdc.csv');
        $customerArr = $this->csvToArray($file);
        //dd($customerArr);
        for ($i = 0; $i < count($customerArr); $i ++){  
            Cdc::firstOrCreate($customerArr[$i]);
        }   
     
    }
    private function loadEmpleados(){
        $file = public_path('csv/empleados.csv');
        $customerArr = $this->csvToArray($file);
        //dd($customerArr);
        for ($i = 0; $i < count($customerArr); $i ++){  
            Empleado::firstOrCreate($customerArr[$i]);
        }   
     
    }
    private function csvToArray($filename = '', $delimiter = ';'){
        if (!file_exists($filename) || !is_readable($filename))
            return false;
    
        $header = null;
        $data = array();
        
        if (($handle = fopen($filename, 'r')) !== false)
        {
            
            while (($row = fgetcsv($handle, 0, $delimiter)) !== false)
            {
                //array_push($data,$row);
                
                if (!$header)
                    $header = $row;
                else
                    //dd(count($row));
                    $data[] = array_combine($header, $row);
                    //dd($data);
                
            }
            fclose($handle);
        }
    
        return $data;
    }
}

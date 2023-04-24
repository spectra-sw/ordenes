<?php

namespace App\Imports;

use App\Models\Turno;
use App\Models\Empleado;
use Maatwebsite\Excel\Concerns\ToModel;

class importTurnos implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if ($row[0] != 'cc'){
            dd($row);
            $user_id = Empleado::where('cc',$row[0])->first()->id;
            return new Turno([
                //
                'user_id' => $user_id,
                'fecha_inicio' => $row[1],
                'fecha_fin' => $row[2],
                'hora_inicio' => $row[3],
                'hora_fin' => $row[4],
                'almuerzo' => $row[5],
            ]);
        }
    }
}

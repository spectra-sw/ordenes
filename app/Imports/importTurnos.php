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

            try {
                $user_id = Empleado::where('cc',$row[0])->first()->id;
            } catch (\Exception $e) {
                dd($e);
            }

            $fecha_inicio = date('Y-m-d', (int) ($row[1] +1 - 25569) * 86400);
            $fecha_fin = date('Y-m-d', (int) ($row[2] + 1 - 25569) * 86400);
            return new Turno([
                //
                'user_id' => $user_id,
                'fecha_inicio' => $fecha_inicio ,
                'fecha_fin' => $fecha_fin,
                'hora_inicio' => $row[3],
                'hora_fin' => $row[4],
                'almuerzo' => $row[5],
            ]);
        }
    }
}

<?php

namespace App\Imports;
use App\Models\Novedad;

use Maatwebsite\Excel\Concerns\ToModel;

class ImportNovedad implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Novedad([
            //
            
                'cc' => $row[0],
                'horas' => $row[1],
                'periodo' => $row[2]
            
        ]);
    }
}

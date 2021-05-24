<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;
    protected $table = 'horarios';
  
    protected $fillable = [
       'nombre','observacion'
    ];
    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'horario_id', 'id');
    }
}

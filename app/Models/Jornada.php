<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jornada extends Model
{
    use HasFactory;
    protected $table = 'jornada';
    public $timestamps = true;
    protected $fillable = [
        'id','jornada_id','user_id','proyecto','fecha','hi','hf','duracion','fechaf','almuerzo','observacion','tipo','revisado_por','fecha_revision','estado'
    ];
    public function trabajador()
    {
    return $this->belongsTo(Empleado::class, 'user_id', 'id');
    }
    public function proyectoinfo()
    {
    return $this->belongsTo(Proyecto::class, 'proyecto', 'codigo');
    }
    public function cdcinfo()
    {
    return $this->belongsTo(Cdc::class, 'proyecto', 'codigo');
    }
}

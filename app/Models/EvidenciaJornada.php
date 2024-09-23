<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidenciaJornada extends Model
{
    use HasFactory;
    protected $table = 'evidencias_jornadas';

    // Campos que se pueden llenar mediante asignación masiva
    protected $fillable = [
        'jornada_id', 
        'url_imagen'
    ];

    // Si tienes alguna relación, puedes definirla aquí
    public function jornada()
    {
        return $this->belongsTo(Jornada::class);
    }
}

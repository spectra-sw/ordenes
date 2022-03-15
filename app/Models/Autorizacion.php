<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autorizacion extends Model
{
    use HasFactory;
    protected $table = 'autorizaciones';
    public $timestamps = false;
    protected $fillable = [
        'id', 'proyecto','trabajador','motivo','horario','fecha_habitual','hora_inicio',
        'hora_fin','observaciones','autorizado_por','vobo_director','vobo_talento','created_at'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cdc extends Model
{
    use HasFactory;
    protected $table = 'cdc';
    public $timestamps = false;
    protected $fillable = [
        'codigo','descripcion','centro_operacion','unidad_negocio','responsable',
        'mayor','grupo','observaciones'
    ];
    
}

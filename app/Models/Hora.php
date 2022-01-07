<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hora extends Model
{
    use HasFactory;
    protected $table = 'horas';
    public $timestamps = false;
    protected $fillable = [
        'ordenes_id', 'dias_id','hi','hf','ht','trabajador','ha'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'trabajador', 'cc');
    }
}

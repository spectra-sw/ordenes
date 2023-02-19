<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corte extends Model
{
    use HasFactory;
    protected $table = 'cortes';
    public $timestamps = false;
    protected $fillable = [
        'fecha_inicio', 'fecha_fin','estado',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;
    protected $table = 'cargos';
    public $timestamps = false;
    protected $fillable = [
        'id', 'cargo', 'extra', 'estado'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BetaTester extends Model
{
    use HasFactory;
    protected $fillable = ['cc'];

    // Relación con el modelo User
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'cc', 'cc');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Festivo extends Model
{
    use HasFactory;
    protected $table = 'festivos';
    public $timestamps = false;
    protected $fillable = [
       'fecha'
    ];
}

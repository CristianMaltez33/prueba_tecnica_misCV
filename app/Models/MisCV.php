<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class MisCV extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'misCV';
    protected $fillable = [
        'id',
        'correo',
        'nombre_completo',
        'telefono',
        'departamento',
        'municipio',
        'vehiculo',
        'licencia',
        'idiomas',
        'facademica',
        'exlaboral'
    ];
}

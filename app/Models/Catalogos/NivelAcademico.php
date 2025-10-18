<?php

namespace App\Models\Catalogos;

use MongoDB\Laravel\Eloquent\Model;

class NivelAcademico extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'nivel_academico';
    protected $fillable = [
        "id",
        'estado',
    ];
}

<?php

namespace App\Models\catalogos;

use MongoDB\Laravel\Eloquent\Model;

class DepartamentoPais extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'departamentos';
    protected $fillable = [
        "id",
        'nombre',
    ];
}

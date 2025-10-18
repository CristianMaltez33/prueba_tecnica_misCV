<?php

namespace App\Helpers;

use App\Models\catalogos\DepartamentoPais;
use App\Models\Catalogos\NivelAcademico;

class HomePageHelper
{
    public static function getCatalogos()
    {

        $nivelAcademico = NivelAcademico::get()->all();
        $departamentos = DepartamentoPais::get()->all();

        return compact(
            'nivelAcademico',
            'departamentos',
        );
    }
}

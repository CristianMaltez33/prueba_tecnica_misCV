<?php

namespace App\Queries;

use App\Models\MisCV;


class MisCvQueryBuilder
{
    public static function search(array $filters)
    {
        $query = MisCV::query();


        if (!empty($filters['facademica_estado']) && self::validator($filters['facademica_estado'])) {
            $query->where('facademica.estado', $filters['facademica_estado']);
        }

        if (!empty($filters['facademica_especialidad']) && self::validator($filters['facademica_especialidad'])) {
            $query->where('facademica.especialidad', $filters['facademica_especialidad']);
        }

        if (!empty($filters['departamento']) && self::validator($filters['departamento'])) {
            $query->where('departamento', strtolower($filters['departamento']));
        }

        if (!empty($filters['licencia']) && self::validator($filters['licencia'])) {
            $query->where('licencia', $filters['licencia']);
        }

        if (!empty($filters['vehiculo']) && self::validator($filters['vehiculo'])) {
            $query->where('vehiculo', $filters['vehiculo']);
        }

        if (!empty($filters['salario']) && self::validator($filters['salario'])) {
            $salarioMinimo = (float) $filters['salario'];

            $query->whereRaw([
                '$expr' => [
                    '$gte' => [
                        [
                            '$toDouble' => [
                                '$getField' => [
                                    'field' => 'salario',
                                    'input' => [
                                        '$arrayElemAt' => [
                                            [
                                                '$sortArray' => [
                                                    'input' => '$exlaboral',
                                                    'sortBy' => ['fechaingreso' => -1]
                                                ]
                                            ],
                                            0
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        $salarioMinimo
                    ]
                ]
            ]);
        }

        return $query;
    }

    private static function validator($value):bool {
        return !is_null($value) && $value !== '';
    }
}

